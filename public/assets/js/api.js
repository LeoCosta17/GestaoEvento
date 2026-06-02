// api.js - Centralized Fetch Wrapper

const API = {
    getToken: () => localStorage.getItem('token'),
    
    request: async (endpoint, options = {}) => {
        const url = `${API_URL}${endpoint}`;
        
        const headers = {
            'Content-Type': 'application/json',
            ...(options.headers || {})
        };

        const token = API.getToken();
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        const config = {
            ...options,
            headers
        };

        try {
            const response = await fetch(url, config);
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Erro na requisição');
            }
            
            return { ok: true, data };
        } catch (error) {
            return { ok: false, error: error.message };
        }
    },

    get: (endpoint) => API.request(endpoint, { method: 'GET' }),
    post: (endpoint, body) => API.request(endpoint, { method: 'POST', body: JSON.stringify(body) }),
    put: (endpoint, body) => API.request(endpoint, { method: 'PUT', body: JSON.stringify(body) }),
    delete: (endpoint) => API.request(endpoint, { method: 'DELETE' })
};
