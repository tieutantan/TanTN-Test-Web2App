<template>
  <div class="flex items-center justify-center min-h-screen bg-transparent">
    <div class="space-y-4 bg-white p-10 rounded">
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input
              v-model="fullName"
              id="fullName"
              name="fullName"
              type="text"
              required
              class="w-full px-3 py-2 mt-1 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
          <p class="text-xs italic text-gray-400">Only letters and spaces with length 1-50</p>
        </div>
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
          <p class="text-xs italic text-gray-400">Only alphanumeric string with length 6-20</p>
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
          <p class="text-xs italic text-gray-400">Must at least one number and one uppercase and lowercase letter, and
            at least 8 or more characters</p>
        </div>
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
              v-model="confirmPassword"
              id="confirmPassword"
              name="confirmPassword"
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
            Register
          </button>
        </div>
      </form>
      <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      fullName: '',
      username: '',
      password: '',
      confirmPassword: '',
      errorMessage: ''
    };
  },
  created() {
    this.fullName = '';
    this.username = '';
    this.password = '';
    this.confirmPassword = this.password;
  },
  methods: {
    async handleSubmit() {
      if (this.password !== this.confirmPassword) {
        this.errorMessage = 'Passwords do not match';
        return;
      }

      try {

        const response = await axios.post('http://localhost:1111/index.php?r=auth/register', {
          fullName: this.fullName,
          username: this.username,
          password: this.password
        });

        // get accessToken from response.data and store it in localStorage
        localStorage.setItem('accessToken', response.data.accessToken);

        // redirect to dashboard
        this.$router.push('/dashboard');

      } catch (error) {
        // If there is an error message in the response, set it to the errorMessage data property
        if (error.response.data.message) {
          this.errorMessage = error.response.data.message;
        } else {
          // If there is no error message in the response, set a generic error message
          this.errorMessage = 'An error occurred. Please try again or contact support.';
        }
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>