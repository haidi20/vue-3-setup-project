import axios from "axios";
import Cookies from 'js-cookie';

// Gunakan base URL dari environment variable
const API_VERSION = "v1";
const BASE_URL = `${import.meta.env.VITE_API_URL}/api/${API_VERSION}`;

const axiosCustom = axios.create({
    baseURL: BASE_URL,
});

// Interceptor untuk tambahkan Bearer Token dan user_id
axiosCustom.interceptors.request.use(
    (config) => {
        const getUserCookie = Cookies.get("auth"); // baca cookie
        let user = null;

        if (getUserCookie) {
            try {
                user = JSON.parse(getUserCookie); // parsing jika perlu
            } catch (e) {
                console.error("Gagal parse auth cookie", e);
            }
        }

        const bearerToken = user?.token || null;
        const authUserId = user?.id || null;

        if (bearerToken) {
            config.headers.Authorization = `Bearer ${bearerToken}`;
        }

        // Tambahkan auth_user_id ke body atau params
        if (config.method !== "get" && config.method !== "delete") {
            if (!(config.data instanceof FormData)) {
                config.data = {
                    ...(config.data || {}),
                    auth_user_id: authUserId,
                };
            }
        } else {
            config.params = {
                ...(config.params || {}),
                auth_user_id: authUserId,
            };
        }

        // Tambahkan header X-Requested-With
        config.headers['X-Requested-With'] = 'XMLHttpRequest';

        return config;
    },
    (error) => Promise.reject(error)
);

export default axiosCustom;