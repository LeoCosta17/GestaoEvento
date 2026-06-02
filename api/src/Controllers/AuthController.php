<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\Response;

class AuthController {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['email']) || !isset($data['password'])) {
            Response::json(400, null, 'Email and password are required');
        }

        $this->authService->login($data['email'], $data['password']);
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"), true);
        $this->authService->register($data);
    }
}
