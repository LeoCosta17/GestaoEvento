<?php

namespace App\Controllers;

use App\Repositories\SubscriptionRepository;
use App\Utils\Response;

class SubscriptionController {
    private $subscriptionRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo) {
        $this->subscriptionRepo = $subscriptionRepo;
    }

    public function index($user) {
        if ($user['type'] !== 'PF') {
            Response::json(403, null, 'Access denied. Only common users can have subscriptions.');
        }
        $events = $this->subscriptionRepo->findByUser($user['id']);
        Response::json(200, $events);
    }

    public function subscribe($user, $event_id) {
        if ($user['type'] !== 'PF') {
            Response::json(403, null, 'Access denied. Only common users can subscribe to events.');
        }

        $success = $this->subscriptionRepo->subscribe($user['id'], $event_id);
        
        if ($success) {
            Response::json(201, null, 'Subscribed successfully');
        } else {
            Response::json(400, null, 'You are already subscribed to this event or event does not exist');
        }
    }

    public function unsubscribe($user, $event_id) {
        if ($user['type'] !== 'PF') {
            Response::json(403, null, 'Access denied.');
        }

        $this->subscriptionRepo->unsubscribe($user['id'], $event_id);
        Response::json(200, null, 'Unsubscribed successfully');
    }
}
