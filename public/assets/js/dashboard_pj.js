// dashboard_pj.js - Logic for Organizer

const DashboardPJ = {
    loadMyEvents: async () => {
        const res = await API.get('/my-events');
        const grid = document.getElementById('pj-events-grid');
        grid.innerHTML = '';

        if (res.ok && res.data.data) {
            const events = res.data.data;
            if (events.length === 0) {
                grid.innerHTML = '<p class="text-slate-500 col-span-full">Você ainda não criou nenhum evento.</p>';
                return;
            }

            events.forEach(event => {
                grid.innerHTML += `
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-bl-lg">
                            ${event.subscriptions_count} inscritos
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2 mt-2">${event.name}</h3>
                        <div class="text-sm text-slate-600 mb-4 space-y-1">
                            <p><span class="font-medium">Início:</span> ${UI.formatDate(event.start_time)}</p>
                            <p><span class="font-medium">Término:</span> ${UI.formatDate(event.end_time)}</p>
                        </div>
                        ${event.category ? `<span class="inline-block bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-md mb-4">${event.category}</span>` : ''}
                        <p class="text-slate-500 text-sm line-clamp-3">${event.description || 'Sem descrição'}</p>
                    </div>
                `;
            });
        }
    },

    createEvent: async (e) => {
        e.preventDefault();
        const form = e.target;
        const payload = {
            name: form.name.value,
            start_time: form.start_time.value,
            end_time: form.end_time.value,
            category: form.category.value,
            description: form.description.value
        };

        const res = await API.post('/events', payload);
        if (res.ok) {
            UI.showToast('Evento criado com sucesso!');
            UI.hideModal('modal-create-event');
            form.reset();
            DashboardPJ.loadMyEvents();
        } else {
            UI.showToast(res.error, 'error');
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.getElementById('form-create-event');
    if (formCreate) formCreate.addEventListener('submit', DashboardPJ.createEvent);
});
