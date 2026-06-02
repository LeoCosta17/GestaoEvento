<?php
// router.php - Roteador unificado para o servidor embutido do PHP

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Se for um arquivo estático existente na pasta public (CSS, JS, imagens), o PHP serve diretamente
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Se a rota começar com /api, encaminha para o backend
if (strpos($uri, '/api') === 0) {
    // Removemos o '/api' da requisição para que o roteador do backend entenda
    $_SERVER['REQUEST_URI'] = substr($uri, 4);
    if (empty($_SERVER['REQUEST_URI'])) $_SERVER['REQUEST_URI'] = '/';
    
    // O backend tem seu próprio index.php que lida com as rotas REST
    require __DIR__ . '/../api/public/index.php';
} else {
    // Caso contrário, carrega a interface frontend
    require __DIR__ . '/index.php';
}
