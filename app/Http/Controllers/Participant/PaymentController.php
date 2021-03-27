<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

use App\Models\Elective;
use App\Models\ElectiveBatch;
use App\Models\Program;
use App\Models\Batch;
use App\Models\UserElective;
use App\Models\BatchUser;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\BatchJourney;

class PaymentController extends Controller
{
    public function index(Request $request)
    {     
        $request->validate([
            'program_id' => 'required|exists:App\Models\Program,id',
            'program_batch_id' => 'required|exists:App\Models\Batch,id',
        ]);

        $user = Auth::guard('web')->user();
        
        $batch = Batch::with([
            'program',
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            $query->whereDoesntHave('users', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->whereDate('start_date', '>', Carbon::now())->find($request->input('program_batch_id'));
        
        if($user->batches()->where(['program_id' => $batch->program->id, 'batches.id' => $batch->id, 'batches.status' => 'active'])->count() > 0){
            return back()->with('error', __('strings.already_enroled_the_program'));
        }

        $payment = new Payment();
        $payment->payment_mode = "online";
        $payment->for = "program";
        $payment->program_id = $batch->program->id;
        $payment->batch_id = $batch->id;
        $payment->status = "inactive";
        $payment->currency_id = $batch->program->currency_id;
        $payment->amount = $batch->program->amount;
        
        if($user->payments()->save($payment)){
            if(!$payment->payment_uid){
                $payment->payment_uid = "CTT-TEST-".str_pad($payment->id, 8, "0", STR_PAD_LEFT);
                $payment->save();
            }
            $title = "Proceed to Payment";
            return view(config('app.p_slug').'.payment', compact('title', 'user', 'payment', 'batch'));
        } else {
            return back()->with('error', __('strings.something_wrong'));
        }

    }
    
    public function success(Request $request)
    {
        $user = Auth::guard('web')->user();

        //get API Configuration 
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        //Fetch payment information by razorpay_payment_id
        $razorpayPayment = $api->payment->fetch($request->input('razorpay_payment_id'));
        $paymentUid = $request->input('payment_uid');
        
        $payment = Payment::where(['payment_uid' => $paymentUid, 'status' => 'inactive', 'pg_payment_status' => null])->first();
        
        if($payment && $request->input('razorpay_payment_id')) {
            try {
                $response = $api->payment->fetch($request->input('razorpay_payment_id'))->capture(array('amount'=>$razorpayPayment['amount'])); 
            } catch (\Exception $e) {
                // return  $e->getMessage();
                return redirect()->route(config('app.p_slug').'.programs.batches.show', [$payment->program_id, $payment->batch_id])->with('error', $e->getMessage());
            }

            // Do something here for store payment details in database...
            $invoice = new Invoice();
            $invoice->invoice_no = $payment->payment_uid;
            $invoice->invoice_date = Carbon::now();
            $invoice->currency_id = $payment->currency_id;
            $invoice->amount = $payment->amount;
            $invoice->paid_at = Carbon::now();
            $invoice->status = "paid";
            
            if($payment->invoices()->save($invoice)){

                $payment->pg_payment_status = 'success';
                $payment->status = 'active';
                $payment->pg_response = $request->only('razorpay_payment_id');
                $payment->update();
    
                $batchUser = new BatchUser();
                $batchUser->batch_id = $payment->batch_id;
                $batchUser->status = "active";
                
                if($user->batchUsers()->save($batchUser)){

                    $user->batchJourneys()->save(new BatchJourney(['batch_id' => $payment->batch_id, 'message' => 'Program Enrolled']));

                    return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$payment->program_id, $payment->batch_id])->with('success', __('strings.successfully_opted_the_program'));
                }
            }
                
        }
        return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$payment->program_id, $payment->batch_id])->with('error', __('strings.something_wrong'));
    }
}
