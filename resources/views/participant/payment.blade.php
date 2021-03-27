@extends('layouts.participant')

@section('script')
    {{-- @include('app.parts.cart_scripts') --}}


    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
      <script>
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 

        $(function(e){
          var totalAmount = {{ $payment->amount }};
          // console.log(totalAmount);
          var payment_uid =  '{{ $payment->payment_uid }}';
          var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": (totalAmount*100), // 2000 paise = INR 20
            "name": "Program - {{ $batch->program->name }}",
            "description": "{{ config('app.name') }}",
            "image": "",
            "handler": function (response){
                $('#paymentSuccessForm').find('input[name="razorpay_payment_id"]').val(response.razorpay_payment_id);
                $('#paymentSuccessForm').find('input[name="payment_uid"]').val(payment_uid);
                $('#paymentSuccessForm').submit();
            },
            "prefill": {
                "contact": '{{ $user->phone }}',
                "email":   '{{ $user->email }}',
            },
            "theme": {
                "color": "#528FF0"
            }
          };
          var rzp1 = new Razorpay(options);
          rzp1.open();
          e.preventDefault();
        });
      </script>

@endsection

@section('content')

<div class="row mt-5 mb-5">
  <div class="col-12">
    @if(session()->get('error'))
        <div class="alert alert-danger">
        {{ session()->get('error') }}  
        </div>
    @endif  

    <div class="text-center">Please wait... Payment is in progress...</div>

    
  {{ Form::open(array('route' => [Config::get('app.p_slug').'.payment.success'], 'method' => 'post', 'id' => 'paymentSuccessForm')) }}
        <input type="hidden" name="razorpay_payment_id" value="" />
        <input type="hidden" name="payment_uid" value="" />
  </form>
  </div>  
</div>



@endsection