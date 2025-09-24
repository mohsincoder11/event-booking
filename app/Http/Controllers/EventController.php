<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use ApiResponse;

    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $events = $this->eventService->listEvents($request->all());
        return $this->successResponse($events, 'Events fetched successfully');
    }

    public function show($id)
    {
        $event = $this->eventService->getEvent($id);
        if (!$event) return $this->errorResponse('Event not found', 404);
        return $this->successResponse($event);
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->createEvent($request->validated());
        return $this->successResponse($event, 'Event created successfully', 201);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = $this->eventService->updateEvent($id, $request->validated());
        if (!$event) return $this->errorResponse('Event not found', 404);
        return $this->successResponse($event, 'Event updated successfully');
    }

    public function destroy($id)
    {
        $deleted = $this->eventService->deleteEvent($id);
        if (!$deleted) return $this->errorResponse('Event not found', 404);
        return $this->successResponse(null, 'Event deleted successfully');
    }
}
