<!-- Login Component -->
<div id="login-component" class="glass w-full max-w-md p-8 rounded-2xl shadow-2xl transition-all duration-300 transform scale-100 opacity-100 relative overflow-hidden">
    <!-- Decorative background shape -->
    <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
    <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-pink-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>

    <div class="relative z-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Eventos<span class="text-indigo-600">Pro</span></h2>
            <p class="text-slate-600 mt-2">Acesse sua conta para continuar</p>
        </div>

        <form id="login-form" class="space-y-6">
            <div>
                <label for="login-email" class="block text-sm font-medium text-slate-700">E-mail</label>
                <div class="mt-1">
                    <input id="login-email" name="email" type="email" required 
                           class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm" 
                           placeholder="seu@email.com">
                </div>
            </div>

            <div>
                <label for="login-password" class="block text-sm font-medium text-slate-700">Senha</label>
                <div class="mt-1">
                    <input id="login-password" name="password" type="password" required 
                           class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors sm:text-sm" 
                           placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 relative group overflow-hidden">
                    <span class="absolute inset-0 w-full h-full bg-white opacity-0 group-hover:opacity-10 transition-opacity"></span>
                    Entrar na plataforma
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-600">
                Não tem uma conta? 
                <button type="button" onclick="UI.toggleAuth('register')" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors focus:outline-none underline">Criar agora</button>
            </p>
        </div>
    </div>
</div>
