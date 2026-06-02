<?php
// Start Session if needed for basic state, but since we use JWT, we rely on LocalStorage in JS.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventosPro - Gestão de Eventos</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles to augment Tailwind */
        [x-cloak] { display: none !important; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <!-- Container do Toast / Notificações -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <!-- View de Autenticação (Login/Register) -->
    <div id="auth-view" class="w-full flex items-center justify-center min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <?php include 'components/login.php'; ?>
        <?php include 'components/register.php'; ?>
    </div>

    <!-- View da Aplicação (Escondida até o login) -->
    <div id="app-view" class="hidden w-full flex min-h-screen bg-slate-50">
        <?php include 'components/sidebar.php'; ?>
        
        <main class="flex-1 p-8 overflow-y-auto w-full">
            <div class="max-w-6xl mx-auto w-full">
                <!-- Header dinâmico -->
                <header class="flex justify-between items-center mb-8">
                    <div>
                        <h1 id="page-title" class="text-3xl font-bold text-slate-800">Dashboard</h1>
                        <p id="page-subtitle" class="text-slate-500">Bem-vindo de volta, <span id="user-greeting-name" class="font-semibold text-indigo-600"></span></p>
                    </div>
                </header>

                <!-- Containers de Dashboard injetados/alternados via JS -->
                <div id="dashboard-pj-container" class="hidden">
                    <?php include 'components/dashboard_pj.php'; ?>
                </div>

                <div id="dashboard-pf-container" class="hidden">
                    <?php include 'components/dashboard_pf.php'; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <!-- Define the Base API URL. Change this if the API is running on a different port/host -->
    <script>
        // Apontando para o nosso roteador unificado que intercepta /api
        const API_URL = '/api'; 
    </script>
    <script src="assets/js/api.js"></script>
    <script src="assets/js/ui.js"></script>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/dashboard_pj.js"></script>
    <script src="assets/js/dashboard_pf.js"></script>
</body>
</html>
