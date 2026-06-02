<?php

namespace App\Utils;

class Response {
    public static function json($status, $data = null, $message = '') {
        http_response_code($status);
        header('Content-Type: application/json');

        $response = [];
        
        if ($message !== '') {
            $response['message'] = $message;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        echo json_encode($response);
        exit;
    }
}
