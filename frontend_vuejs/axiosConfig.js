// src/axiosConfig.js
import axios from 'axios';

// Tạo một instance của Axios
const axiosInstance = axios.create({
    baseURL: 'http://your-backend-url', // Thay thế bằng URL của backend của bạn
});

// Thêm interceptor để tự động thêm token vào header của các yêu cầu HTTP
axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default axiosInstance;
