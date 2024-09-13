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
          @click="handleGoogleLogin"
          class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
            <path fill="#4285F4" d="M24 9.5c3.9 0 7.1 1.4 9.5 3.7l7-7C35.8 2.5 30.3 0 24 0 14.6 0 6.7 5.4 3 13.3l8.5 6.6C13.2 14.1 18.1 9.5 24 9.5z"/>
            <path fill="#34A853" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3.1-2.4 5.7-4.9 7.4l7.5 5.8c4.4-4.1 7-10.1 7-17.7z"/>
            <path fill="#FBBC05" d="M3 13.3l8.5 6.6C13.2 14.1 18.1 9.5 24 9.5V0C14.6 0 6.7 5.4 3 13.3z"/>
            <path fill="#EA4335" d="M24 48c6.5 0 12-2.1 16-5.7l-7.5-5.8c-2.1 1.4-4.8 2.3-8.5 2.3-6.6 0-12.2-4.5-14.2-10.6L3 34.7C6.7 42.6 14.6 48 24 48z"/>
          </svg>
          Login with Google
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    handleSubmit() {
      // Handle form submission
      console.log('Username:', this.username);
      console.log('Password:', this.password);
    },
    handleGoogleLogin() {
      // Handle Google login
      console.log('Google login');
    }
  }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>