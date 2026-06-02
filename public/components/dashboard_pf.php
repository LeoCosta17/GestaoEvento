<!-- Dashboard PF: Buscar Eventos & Minhas Inscrições -->
<div class="w-full">
    
    <!-- Seção: Buscar Eventos -->
    <div id="pf-section-search">
        <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Encontre seu próximo evento</h2>
                <p class="text-slate-500 text-sm">Descubra shows, palestras e muito mais.</p>
            </div>
            <div class="w-full sm:w-72 relative">
                <input type="text" id="search-events-input" placeholder="Buscar por nome..." onkeyup="DashboardPF.filterEvents(this.value)"
                       class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div id="pf-all-events-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Renderizado via JS -->
        </div>
    </div>

    <!-- Seção: Minhas Inscrições (Oculto por padrão) -->
    <div id="pf-section-subscriptions" class="hidden">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-800">Eventos Confirmados</h2>
            <p class="text-slate-500 text-sm">Você está inscrito nos seguintes eventos:</p>
        </div>

        <div id="pf-subs-events-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Renderizado via JS -->
        </div>
    </div>

</div>
