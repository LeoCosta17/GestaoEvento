// dashboard_pf.js - Logic for Common User

const DashboardPF = {
    allEvents: [],
    subscribedEventIds: new Set(),

    loadFutureEvents: async () => {
        document.getElementById('pf-section-search').classList.remove('hidden');
        document.getElementById('pf-section-subscriptions').classList.add('hidden');
        
        // Fetch subscriptions to know which events the user is already subscribed to
        const subsRes = await API.get('/subscriptions');
        if (subsRes.ok && subsRes.data.data) {
            DashboardPF.subscribedEventIds = new Set(subsRes.data.data.map(e => e.id));
        }

        const res = await API.get('/events');
        if (res.ok && res.data.data) {
            DashboardPF.allEvents = res.data.data;
            DashboardPF.renderEvents(DashboardPF.allEvents);
        }
    },

    renderEvents: (eventsToRender) => {
        const grid = document.getElementById('pf-all-events-grid');
        grid.innerHTML = '';

        if (eventsToRender.length === 0) {
            grid.innerHTML = '<p class="text-slate-500 col-span-full">Nenhum evento encontrado.</p>';
            return;
        }

        eventsToRender.forEach(event => {
            const isSubscribed = DashboardPF.subscribedEventIds.has(event.id);
            const buttonHtml = isSubscribed 
                ? `<button disabled class="w-full py-2 bg-slate-100 text-slate-500 font-medium rounded-lg cursor-not-allowed">Inscrito</button>`
                : `<button onclick="DashboardPF.subscribe(${event.id})" class="w-full py-2 bg-indigo-50 text-indigo-700 font-medium rounded-lg hover:bg-indigo-100 transition-colors">Inscrever-se</button>`;

            grid.innerHTML += `
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">${UI.escapeHTML(event.name)}</h3>
                        <div class="text-sm text-slate-600 mb-4 space-y-1">
                            <p><span class="font-medium text-indigo-600">Início:</span> ${UI.formatDate(event.start_time)}</p>
                        </div>
                        <p class="text-slate-500 text-sm line-clamp-2 mb-4">${UI.escapeHTML(event.description) || 'Sem descrição'}</p>
                    </div>
                    ${buttonHtml}
                </div>
            `;
        });
    },

    filterEvents: (query) => {
        const q = query.toLowerCase();
        const filtered = DashboardPF.allEvents.filter(e => e.name.toLowerCase().includes(q));
        DashboardPF.renderEvents(filtered);
    },

    loadMySubscriptions: async () => {
        document.getElementById('pf-section-search').classList.add('hidden');
        document.getElementById('pf-section-subscriptions').classList.remove('hidden');

        const res = await API.get('/subscriptions');
        const grid = document.getElementById('pf-subs-events-grid');
        grid.innerHTML = '';

        if (res.ok && res.data.data) {
            const events = res.data.data;
            if (events.length === 0) {
                grid.innerHTML = '<p class="text-slate-500 col-span-full">Você não está inscrito em nenhum evento.</p>';
                return;
            }

            // Update our local set just in case
            DashboardPF.subscribedEventIds = new Set(events.map(e => e.id));

            events.forEach(event => {
                grid.innerHTML += `
                    <div class="bg-indigo-600 rounded-2xl p-6 shadow-lg text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">${UI.escapeHTML(event.name)}</h3>
                            <div class="text-indigo-100 text-sm mb-4 space-y-1">
                                <p><span class="font-medium">Data:</span> ${UI.formatDate(event.start_time)}</p>
                            </div>
                        </div>
                        <button onclick="DashboardPF.unsubscribe(${event.id})" class="w-full py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg transition-colors border border-indigo-400">
                            Cancelar Inscrição
                        </button>
                    </div>
                `;
            });
        }
    },

    subscribe: async (eventId) => {
        const res = await API.post(`/events/${eventId}/subscribe`);
        if (res.ok) {
            UI.showToast('Inscrição realizada com sucesso!');
            DashboardPF.subscribedEventIds.add(eventId);
            // Re-render to update the button status
            const searchInput = document.getElementById('search-events-input');
            if (searchInput && searchInput.value) {
                DashboardPF.filterEvents(searchInput.value);
            } else {
                DashboardPF.renderEvents(DashboardPF.allEvents);
            }
        } else {
            UI.showToast(res.error, 'error');
        }
    },

    unsubscribe: async (eventId) => {
        if(confirm('Tem certeza que deseja cancelar sua inscrição?')) {
            const res = await API.post(`/events/${eventId}/unsubscribe`);
            if (res.ok) {
                UI.showToast('Inscrição cancelada.');
                DashboardPF.subscribedEventIds.delete(eventId);
                DashboardPF.loadMySubscriptions();
            } else {
                UI.showToast(res.error, 'error');
            }
        }
    }
};
