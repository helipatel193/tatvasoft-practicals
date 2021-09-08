<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Yajra\Datatables\Datatables;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $events = Event::latest()->get();

            if ($request->ajax()) {
                return Datatables::of($events)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href=' . URL::to('/events/' . $row->id) . ' data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="View" class="view btn btn-primary btn-sm viewEvent">View</a>  ';
                        $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editEvent">Edit</a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteEvent">Delete</a>';
                        return $btn;
                    })
                    ->editColumn('start_date', function ($row) {
                        return date('d-m-Y', strtotime($row->start_date))  . ' to ' . date('d-m-Y', strtotime($row->end_date));
                    })
                    ->editColumn('recurrence_1', function ($row) {
                        return $row->recurrence_1 . ' ' . $row->recurrence_2;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('events.list', compact('events'));
        } catch (\Exception $e) {
            Log::error(get_called_class(), ['line' => $e->getLine(), 'message'  => $e->getMessage(), 'exception' => $e->getFile()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        $recurrence1 = $event->recurrence_1;
        $startDate = $event->start_date;
        $endDate = $event->end_date;
        $startRecurrence = 1;

        $getDates = CarbonPeriod::create($startDate, $endDate);

        $createDateFormat = new Carbon('next day');
    
        return view('events.show', compact('event'));
    }

    /**
     * Update or Create new event in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate event data
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'unique:events', 'max:150'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'recurrence_1' => ['required'],
            'recurrence_2' => ['required'],
        ]);

        // Validate the input and return correct response
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        $event = App::make(Event::class);
        $updateEventData = $event->updateEventData($request->all());

        return response()->json(['success' => 'Event saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::find($id)->delete();

        return response()->json(['success' => 'Event deleted successfully.']);
    }
}
