<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Utils\JwtHandler;
use App\Utils\Response;

class AuthService {
    private $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function login($email, $password) {
        $user = $this->userRepo->findByEmail($email);

        if (!$user) {
            Response::json(404, null, 'User not found');
        }

        if (password_verify($password, $user['password'])) {
            $token = JwtHandler::encode([
                'id' => $user['id'],
                'type' => $user['type'],
                'email' => $user['email']
            ]);

            Response::json(200, [
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'type' => $user['type']
                ]
            ], 'Login successful');
        } else {
            Response::json(401, null, 'Invalid credentials');
        }
    }
    
    public function register($data) {
        if (!isset($data['type'], $data['name'], $data['document'], $data['email'], $data['password'])) {
            Response::json(400, null, 'Missing required fields');
        }
        
        if ($data['type'] !== 'PF' && $data['type'] !== 'PJ') {
            Response::json(400, null, 'Invalid user type');
        }

        if ($this->userRepo->findByEmail($data['email'])) {
            Response::json(400, null, 'Email already registered');
        }
        
        if ($this->userRepo->findByDocument($data['document'])) {
            Response::json(400, null, 'Document (CPF/CNPJ) already registered');
        }

        $created = $this->userRepo->create($data['type'], $data['name'], $data['document'], $data['email'], $data['password']);

        if ($created) {
            Response::json(201, null, 'User registered successfully');
        } else {
            Response::json(500, null, 'Failed to register user');
        }
    }
}
