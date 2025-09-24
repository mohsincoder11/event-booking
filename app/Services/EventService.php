<?php

namespace App\Services;

use App\Models\Event;
use App\Traits\CommonQueryScopes;
use Illuminate\Support\Facades\Cache;


class EventService
{
    use CommonQueryScopes;

    public function listEvents(array $filters)
    {
        $cacheKey = 'events_' . md5(json_encode($filters));

        return Cache::remember($cacheKey, 60, function () use ($filters) {
            $query = Event::query();

            if (isset($filters['date'])) {
                $query = $query->filterByDate($filters['date']);
            }

            if (isset($filters['title'])) {
                $query = $query->searchByTitle($filters['title']);
            }

            if (isset($filters['location'])) {
                $query->where('location', 'like', '%' . $filters['location'] . '%');
            }

            return $query->with('tickets')->paginate($filters['per_page'] ?? 10);
        });
    }

    public function getEvent($id)
    {
        return Event::with('tickets')->find($id);
    }

    public function createEvent(array $data)
    {
        $data['created_by'] = auth()->id();
        return Event::create($data);
    }

    public function updateEvent($id, array $data)
    {
        $event = Event::find($id);
        if (!$event) return null;
        $event->update($data);
        return $event;
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if (!$event) return false;
        $event->delete();
        return true;
    }
}
