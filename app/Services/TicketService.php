<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function createTicket($event_id, array $data)
    {
        $data['event_id'] = $event_id;
        return Ticket::create($data);
    }

    public function updateTicket($id, array $data)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) return null;
        $ticket->update($data);
        return $ticket;
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) return false;
        $ticket->delete();
        return true;
    }
}
