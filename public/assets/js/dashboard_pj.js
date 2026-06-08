// dashboard_pj.js - Logic for Organizer

const DashboardPJ = {
    events: [],

    loadMyEvents: async () => {
        const res = await API.get('/my-events');
        const grid = document.getElementById('pj-events-grid');
        grid.innerHTML = '';

        if (res.ok && res.data.data) {
            DashboardPJ.events = res.data.data;
            const events = res.data.data;
            if (events.length === 0) {
                grid.innerHTML = '<p class="text-slate-500 col-span-full">Você ainda não criou nenhum evento.</p>';
                return;
            }

            events.forEach(event => {
                grid.innerHTML += `
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 pb-12 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-bl-lg">
                            ${event.subscriptions_count} inscritos
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2 mt-2">${UI.escapeHTML(event.name)}</h3>
                        <div class="text-sm text-slate-600 mb-4 space-y-1">
                            <p><span class="font-medium">Início:</span> ${UI.formatDate(event.start_time)}</p>
                            <p><span class="font-medium">Término:</span> ${UI.formatDate(event.end_time)}</p>
                        </div>
                        ${event.category ? `<span class="inline-block bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-md mb-4">${UI.escapeHTML(event.category)}</span>` : ''}
                        <p class="text-slate-500 text-sm line-clamp-3">${UI.escapeHTML(event.description) || 'Sem descrição'}</p>
                        
                        <div class="absolute bottom-4 right-6 flex gap-3">
                            <button onclick="DashboardPJ.deleteEvent(${event.id})" class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors">
                                Excluir
                            </button>
                            <button onclick="DashboardPJ.openEditModal(${event.id})" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors">
                                Editar
                            </button>
                        </div>
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
    },

    openEditModal: (id) => {
        const event = DashboardPJ.events.find(e => e.id == id);
        if (!event) return;

        const form = document.getElementById('form-edit-event');
        form.id.value = event.id;
        form.name.value = event.name;
        // datetime-local requires format YYYY-MM-DDThh:mm
        form.start_time.value = event.start_time.replace(' ', 'T').substring(0, 16);
        form.end_time.value = event.end_time.replace(' ', 'T').substring(0, 16);
        form.category.value = event.category || '';
        form.description.value = event.description || '';

        UI.showModal('modal-edit-event');
    },

    updateEvent: async (e) => {
        e.preventDefault();
        const form = e.target;
        const eventId = form.id.value;
        const payload = {
            name: form.name.value,
            start_time: form.start_time.value,
            end_time: form.end_time.value,
            category: form.category.value,
            description: form.description.value
        };

        const res = await API.put('/events/' + eventId, payload);
        if (res.ok) {
            UI.showToast('Evento atualizado com sucesso!');
            UI.hideModal('modal-edit-event');
            form.reset();
            DashboardPJ.loadMyEvents();
        } else {
            UI.showToast(res.error, 'error');
        }
    },

    deleteEvent: async (id) => {
        if (!confirm("Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.")) {
            return;
        }

        const res = await API.delete('/events/' + id);
        if (res.ok) {
            UI.showToast('Evento excluído com sucesso!');
            DashboardPJ.loadMyEvents();
        } else {
            UI.showToast(res.error, 'error');
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const formCreate = document.getElementById('form-create-event');
    if (formCreate) formCreate.addEventListener('submit', DashboardPJ.createEvent);

    const formEdit = document.getElementById('form-edit-event');
    if (formEdit) formEdit.addEventListener('submit', DashboardPJ.updateEvent);
});
