<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Repositories\SubscriptionRepository;
use App\Utils\Response;

class EventService {
    private $eventRepo;
    private $subscriptionRepo;

    public function __construct(EventRepository $eventRepo, SubscriptionRepository $subscriptionRepo) {
        $this->eventRepo = $eventRepo;
        $this->subscriptionRepo = $subscriptionRepo;
    }

    public function createEvent($organizer_id, $data) {
        if (!isset($data['name'], $data['start_time'], $data['end_time'])) {
            Response::json(400, null, 'Missing required fields');
        }

        if (strtotime($data['start_time']) > strtotime($data['end_time'])) {
            Response::json(400, null, 'O horário de término deve ser posterior ao horário de início.');
        }

        $created = $this->eventRepo->create(
            $organizer_id, 
            $data['name'], 
            $data['start_time'], 
            $data['end_time'], 
            $data['description'] ?? null, 
            $data['category'] ?? null
        );

        if ($created) {
            Response::json(201, null, 'Event created successfully');
        } else {
            Response::json(500, null, 'Failed to create event');
        }
    }

    public function listFutureEvents() {
        $events = $this->eventRepo->findAllFutureEvents();
        Response::json(200, $events);
    }

    public function listOrganizerEvents($organizer_id) {
        $events = $this->eventRepo->findByOrganizer($organizer_id);
        
        // Add subscriptions count for each event
        foreach ($events as &$event) {
            $event['subscriptions_count'] = $this->subscriptionRepo->countByEvent($event['id']);
        }
        
        Response::json(200, $events);
    }

    public function updateEvent($organizer_id, $event_id, $data) {
        if (!isset($data['name'], $data['start_time'], $data['end_time'])) {
            Response::json(400, null, 'Missing required fields');
        }

        if (strtotime($data['start_time']) > strtotime($data['end_time'])) {
            Response::json(400, null, 'O horário de término deve ser posterior ao horário de início.');
        }

        // Check if event has subscriptions
        $subscriptions_count = $this->subscriptionRepo->countByEvent($event_id);
        if ($subscriptions_count > 0) {
            Response::json(400, null, 'Não é possível editar um evento que já possui inscrições.');
        }

        $updated = $this->eventRepo->update(
            $event_id,
            $organizer_id,
            $data['name'],
            $data['start_time'],
            $data['end_time'],
            $data['description'] ?? null,
            $data['category'] ?? null
        );

        if ($updated) {
            Response::json(200, null, 'Event updated successfully');
        } else {
            Response::json(500, null, 'Failed to update event or you do not have permission');
        }
    }

    public function deleteEvent($organizer_id, $event_id) {
        // Check if event has subscriptions
        $subscriptions_count = $this->subscriptionRepo->countByEvent($event_id);
        if ($subscriptions_count > 0) {
            Response::json(400, null, 'Não é possível excluir um evento que já possui inscrições.');
        }

        $deleted = $this->eventRepo->delete($event_id, $organizer_id);

        if ($deleted) {
            Response::json(200, null, 'Event deleted successfully');
        } else {
            Response::json(500, null, 'Failed to delete event or you do not have permission');
        }
    }
}
