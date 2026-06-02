<!-- Register Component (Initially Hidden) -->
<div id="register-component" class="hidden glass w-full max-w-lg p-8 rounded-2xl shadow-2xl transition-all duration-300 transform scale-95 opacity-0 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="relative z-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Criar Conta</h2>
            <p class="text-slate-600 mt-2">Junte-se ao EventosPro hoje</p>
        </div>

        <form id="register-form" class="space-y-4">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tipo de Conta</label>
                    <select id="reg-type" name="type" required
                            class="block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm bg-white"
                            onchange="UI.handleRegisterTypeChange(this.value)">
                        <option value="PF">Usuário Comum (PF)</option>
                        <option value="PJ">Organizador (PJ)</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label id="lbl-document" for="reg-document" class="block text-sm font-medium text-slate-700 mb-1">CPF</label>
                    <input id="reg-document" name="document" type="text" required 
                           class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm" 
                           placeholder="000.000.000-00">
                </div>
            </div>

            <div>
                <label id="lbl-name" for="reg-name" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                <input id="reg-name" name="name" type="text" required 
                       class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm" 
                       placeholder="Seu nome">
            </div>

            <div>
                <label for="reg-email" class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                <input id="reg-email" name="email" type="email" required 
                       class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm" 
                       placeholder="seu@email.com">
            </div>

            <div>
                <label for="reg-password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                <input id="reg-password" name="password" type="password" required minlength="6"
                       class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm" 
                       placeholder="Mínimo 6 caracteres">
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                    Cadastrar
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-600">
                Já possui uma conta? 
                <button type="button" onclick="UI.toggleAuth('login')" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors focus:outline-none underline">Fazer Login</button>
            </p>
        </div>
    </div>
</div>
