<template>
  <div>
    <form @submit.prevent="login">
      <input v-model="username" placeholder="Username" />
      <input type="password" v-model="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://your-backend-url/auth/login', {
          username: this.username,
          password: this.password
        });
        const token = response.data.token;
        localStorage.setItem('token', token);
        // Chuyển hướng hoặc thực hiện hành động khác sau khi đăng nhập thành công
      } catch (error) {
        console.error('Login failed:', error);
      }
    }
  }
};
</script>

// src/components/YourComponent.vue
<template>
  <!-- Template của bạn -->
</template>

<script>
import axiosInstance from '@/axiosConfig';

export default {
  methods: {
    async fetchData() {
      try {
        const response = await axiosInstance.get('/your-endpoint');
        console.log(response.data);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  }
};
</script>
