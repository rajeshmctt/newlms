<?php

namespace App\Exports;

use App\Models\BatchUser;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class ListOfParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BatchUser::select('id', 'batch_id', 'parent_batch_id', 'user_id', 'status')->with([
            'user' => function($q){
                $q->with([
                    'country',
                    'location',
                    'currentRole',
                    'currentFunction',
                ]);
            },
            'batch' => function($q){
                $q->with([
                    'program'
                ]);
            }
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Participant Name',
            'Program',
            'Batch',
            'Mobile #',
            'Country',
            'Location',
            'Current Credentials',
            'Role',
            'Function',
            'Current Org',
            'Website',
            'Social Media Links',
            'Electives',
        ];
    }

    public function map($batchUser): array
    {

        $electivesArray = [];
        $electiveBatchUsers = $batchUser->user->electiveBatchUsers()->where('parent_batch_id', $batchUser->batch->id)->get();
        if(count($electiveBatchUsers)){
            foreach($electiveBatchUsers as $electiveBatchUser){
                $electivesArray[] = $electiveBatchUser->batch->program->name;
            }
        }
          
        return [
            $batchUser->user->first_name.' '.$batchUser->user->last_name,
            $batchUser->batch->program->name,
            $batchUser->batch->name,
            $batchUser->user->phone,
            $batchUser->user->country->name ?? '',
            $batchUser->user->location->name ?? '',
            implode(', ', $batchUser->user->currentCredentials()->pluck('current_credential_id')->toArray()),
            $batchUser->user->currentRole->name ?? '',
            $batchUser->user->currentFunction->name ?? '',
            $batchUser->user->current_organisation_name,
            $batchUser->user->current_organisation_website,
            $batchUser->user->facebook_profile_url."\n".
            $batchUser->user->linkedin_profile_url."\n".
            $batchUser->user->instagram_profile_url."\n".
            $batchUser->user->twitter_profile_url,
            implode(', ', $electivesArray),
        ];
    }
}
