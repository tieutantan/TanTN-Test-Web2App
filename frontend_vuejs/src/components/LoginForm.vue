<template>
  <div class="flex items-center justify-center min-h-screen bg-transparent">
    <div class="space-y-4 bg-white p-10 rounded">
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input
              v-model="username"
              id="username"
              name="username"
              type="text"
              required
              class="w-full px-3 py-2 mt-1 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
              v-model="password"
              id="password"
              name="password"
              type="password"
              required
              class="w-full px-3 py-2 mt-1 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div>
          <button
              type="submit"
              class="w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Login
          </button>
        </div>
      </form>
      <div class="flex items-center justify-center">
        <button
            @click="handleFacebookLogin"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
            <path fill="#1877F2" d="M22.675 0h-21.35C.595 0 0 .595 0 1.325v21.351C0 23.405.595 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.794.715-1.794 1.763v2.31h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.325-.595 1.325-1.324V1.325C24 .595 23.405 0 22.675 0z"/>
          </svg>
          Login with Facebook
        </button>
      </div>
      <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
    </div>
  </div>
</template>

<script>
/* global FB */
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      errorMessage: ''
    };
  },
  mounted() {
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '484168491206760',
        cookie     : true,
        xfbml      : true,
        version    : 'v13.0'
      });
      FB.AppEvents.logPageView();
    };

    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  },
  methods: {
    async handleSubmit() {
      try {
        this.errorMessage = '';
        const response = await axios.post('http://localhost:1111/index.php?r=auth/login', {
          username: this.username,
          password: this.password
        });
        localStorage.setItem('accessToken', response.data.accessToken);
        this.$router.push('/dashboard');
      } catch (error) {
        if (error.response.data.message) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'An error occurred. Please try again or contact support.';
        }
      }
    },
    handleFacebookLogin() {
      FB.login(response => {
        if (response.authResponse) {
          FB.api('/me', response => {
            console.log(response);
            this.$router.push('/dashboard');
          });
        } else {
          console.log('User cancelled login or failed.');
        }
      });
    }
  }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>