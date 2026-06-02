// auth.js - Authentication Logic

const Auth = {
    login: async (e) => {
        e.preventDefault();
        const form = e.target;
        const payload = {
            email: form.email.value,
            password: form.password.value
        };

        const res = await API.post('/login', payload);
        
        if (res.ok) {
            localStorage.setItem('token', res.data.data.token);
            localStorage.setItem('user', JSON.stringify(res.data.data.user));
            UI.showToast('Login realizado com sucesso!');
            form.reset();
            UI.initApp();
        } else {
            UI.showToast(res.error, 'error');
        }
    },

    register: async (e) => {
        e.preventDefault();
        const form = e.target;
        const payload = {
            type: form.type.value,
            document: form.document.value,
            name: form.name.value,
            email: form.email.value,
            password: form.password.value
        };

        const res = await API.post('/register', payload);
        
        if (res.ok) {
            UI.showToast('Conta criada com sucesso! Faça login.');
            form.reset();
            UI.toggleAuth('login');
        } else {
            UI.showToast(res.error, 'error');
        }
    },

    logout: () => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        UI.showLoginView();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) loginForm.addEventListener('submit', Auth.login);

    const registerForm = document.getElementById('register-form');
    if (registerForm) registerForm.addEventListener('submit', Auth.register);
});
