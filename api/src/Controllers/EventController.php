<?php

namespace App\Controllers;

use App\Services\EventService;
use App\Utils\Response;

class EventController {
    private $eventService;

    public function __construct(EventService $eventService) {
        $this->eventService = $eventService;
    }

    public function index() {
        // Public route: List future events
        $this->eventService->listFutureEvents();
    }

    public function myEvents($user) {
        if ($user['type'] !== 'PJ') {
            Response::json(403, null, 'Access denied. Only organizers can view their events.');
        }
        $this->eventService->listOrganizerEvents($user['id']);
    }

    public function create($user) {
        if ($user['type'] !== 'PJ') {
            Response::json(403, null, 'Access denied. Only organizers can create events.');
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $this->eventService->createEvent($user['id'], $data);
    }
}
