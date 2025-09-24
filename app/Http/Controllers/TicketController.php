<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Services\TicketService;
use App\Traits\ApiResponse;

class TicketController extends Controller
{
    use ApiResponse;

    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function store(StoreTicketRequest $request, $event_id)
    {
        $ticket = $this->ticketService->createTicket($event_id, $request->validated());
        return $this->successResponse($ticket, 'Ticket created successfully', 201);
    }

    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = $this->ticketService->updateTicket($id, $request->validated());
        if (!$ticket) return $this->errorResponse('Ticket not found', 404);
        return $this->successResponse($ticket, 'Ticket updated successfully');
    }

    public function destroy($id)
    {
        $deleted = $this->ticketService->deleteTicket($id);
        if (!$deleted) return $this->errorResponse('Ticket not found', 404);
        return $this->successResponse(null, 'Ticket deleted successfully');
    }
}
