<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventCategory;

class EventController extends Controller
{
    // function untuk mendapatkan semua events
    public function index(Request $request)
    {
        // event by category_id
        
        // dd($request);
        // dd($categoryId);
        // dd($request->input('category_id'));
        $categoryId = $request->input('category_id');
        $event = [];
        // if category id all
        if ($categoryId == 'all') {
            $events = Event::all();
        } else {
            $events = Event::where('event_category_id', $categoryId)->get();
        }

        // get all events
        $events = Event::all();

        // load the events
        $events->load('eventCategory', 'vendor');

        // return the events
        return response()->json([
            'status' => 'success',
            'message' => 'Events retrieved successfully',
            'data' => $events,
        ], 200);
    }

    // get all event categories
    public function eventCategories()
    {
        // get all event categories
        $eventCategories = EventCategory::all();

        // return the event categories
        return response()->json([
            'status' => 'success',
            'message' => 'Event categories retrieved successfully',
            'data' => $eventCategories,
        ], 200);
    }

    //detail event and sku by event_id
    public function detail(Request $request)
    {
        // get the event
        $event = Event::find($request->event_id);

        // load the event
        $event->load('eventCategory', 'vendor');

        $skus = $event->skus;
        $event['skus'] = $skus;

        // return the event
        return response()->json([
            'status' => 'success',
            'message' => 'Event fetched successfully',
            'data' => $event,
        ], 200);
    }

}