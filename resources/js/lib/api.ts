import axios from 'axios';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';
import router from '@/router';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost/api',
  headers: {
    Accept: 'application/json',
  },
});

api.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore();
    const { token } = storeToRefs(authStore);

    if (token.value) {
      config.headers.Authorization = `Bearer ${token.value}`;
    }

    return config;
  },
  (error) => Promise.reject(error)
);

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      const authStore = useAuthStore();
      authStore.setToken(null);
      authStore.setUser(null);

      router.push({ name: 'login' });
    }

    return Promise.reject(error);
  }
);

export default api;
