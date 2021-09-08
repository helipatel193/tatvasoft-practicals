<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'recurrence_1',
        'recurrence_2',
    ];

    public function updateEventData(){
        Event::updateOrCreate(
            [
                'id' => $request->Event_id
            ],
            [
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'recurrence_1' => $request->recurrence_1,
                'recurrence_2' => $request->recurrence_2,
            ]
        );
    }

    
}
