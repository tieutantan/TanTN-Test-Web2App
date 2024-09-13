<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-900">Register</h2>
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
        </div>
        <div>
          <label for="usernameOrEmail" class="block text-sm font-medium text-gray-700">Username or Email</label>
          <input
            v-model="usernameOrEmail"
            id="usernameOrEmail"
            name="usernameOrEmail"
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fullName: '',
      usernameOrEmail: '',
      password: '',
      confirmPassword: ''
    };
  },
  methods: {
    handleSubmit() {
      // Handle form submission
      console.log('Full Name:', this.fullName);
      console.log('Username or Email:', this.usernameOrEmail);
      console.log('Password:', this.password);
      console.log('Confirm Password:', this.confirmPassword);
    }
  }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>