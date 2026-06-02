<!-- Sidebar Component -->
<aside class="w-64 bg-white border-r border-slate-200 min-h-screen flex flex-col hidden sm:flex transition-all duration-300">
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Eventos<span class="text-indigo-600">Pro</span></h2>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        
        <!-- PF Menu -->
        <div id="menu-pf" class="hidden space-y-1">
            <button onclick="DashboardPF.loadFutureEvents()" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                <svg class="w-5 h-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Buscar Eventos
            </button>
            <button onclick="DashboardPF.loadMySubscriptions()" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-slate-700 hover:text-indigo-700 hover:bg-indigo-50 transition-colors">
                <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Minhas Inscrições
            </button>
        </div>

        <!-- PJ Menu -->
        <div id="menu-pj" class="hidden space-y-1">
            <button onclick="DashboardPJ.loadMyEvents()" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                <svg class="w-5 h-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Meus Eventos
            </button>
            <button onclick="UI.showModal('modal-create-event')" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-slate-700 hover:text-indigo-700 hover:bg-indigo-50 transition-colors mt-4 border border-dashed border-slate-300">
                <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Criar Novo Evento
            </button>
        </div>

    </div>

    <div class="p-4 border-t border-slate-200">
        <button onclick="Auth.logout()" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-red-600 hover:bg-red-50 transition-colors">
            <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Sair da conta
        </button>
    </div>
</aside>
