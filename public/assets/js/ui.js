// ui.js - DOM Manipulation & State

const UI = {
    toastTimeout: null,

    showToast: (message, type = 'success') => {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        const bgColor = type === 'success' ? 'bg-green-500' : (type === 'error' ? 'bg-red-500' : 'bg-indigo-500');
        
        toast.className = `flex items-center p-4 mb-4 text-white rounded-lg shadow-lg ${bgColor} transform transition-all duration-300 translate-y-[-100%] opacity-0`;
        toast.innerHTML = `<span class="text-sm font-medium">${message}</span>`;
        
        container.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-y-[-100%]', 'opacity-0');
        }, 10);

        // Remove after 3s
        setTimeout(() => {
            toast.classList.add('translate-y-[-100%]', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    },

    toggleAuth: (view) => {
        const login = document.getElementById('login-component');
        const register = document.getElementById('register-component');
        
        if (view === 'register') {
            login.classList.add('hidden');
            register.classList.remove('hidden');
            setTimeout(() => register.classList.remove('scale-95', 'opacity-0'), 10);
        } else {
            register.classList.add('hidden');
            login.classList.remove('hidden');
            setTimeout(() => login.classList.remove('scale-95', 'opacity-0'), 10);
        }
    },

    handleRegisterTypeChange: (type) => {
        const lblDocument = document.getElementById('lbl-document');
        const inputDocument = document.getElementById('reg-document');
        if (type === 'PJ') {
            lblDocument.innerText = 'CNPJ';
            inputDocument.placeholder = '00.000.000/0000-00';
        } else {
            lblDocument.innerText = 'CPF';
            inputDocument.placeholder = '000.000.000-00';
        }
    },

    initApp: () => {
        const user = JSON.parse(localStorage.getItem('user'));
        if (!user) {
            UI.showLoginView();
            return;
        }

        document.getElementById('auth-view').classList.add('hidden');
        document.getElementById('app-view').classList.remove('hidden');
        
        document.getElementById('user-greeting-name').innerText = user.name;

        if (user.type === 'PJ') {
            document.getElementById('menu-pj').classList.remove('hidden');
            document.getElementById('dashboard-pj-container').classList.remove('hidden');
            DashboardPJ.loadMyEvents();
        } else {
            document.getElementById('menu-pf').classList.remove('hidden');
            document.getElementById('dashboard-pf-container').classList.remove('hidden');
            DashboardPF.loadFutureEvents();
        }
    },

    showLoginView: () => {
        document.getElementById('auth-view').classList.remove('hidden');
        document.getElementById('app-view').classList.add('hidden');
        document.getElementById('menu-pj').classList.add('hidden');
        document.getElementById('menu-pf').classList.add('hidden');
        document.getElementById('dashboard-pj-container').classList.add('hidden');
        document.getElementById('dashboard-pf-container').classList.add('hidden');
    },

    showModal: (id) => {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => modal.children[0].classList.remove('scale-95', 'opacity-0'), 10);
    },

    hideModal: (id) => {
        const modal = document.getElementById(id);
        modal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    },
    
    formatDate: (dateString) => {
        const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('pt-BR', options);
    }
};

// Check login status on page load
document.addEventListener('DOMContentLoaded', () => {
    UI.initApp();
});
