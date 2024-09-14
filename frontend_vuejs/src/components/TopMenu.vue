<template>
  <div class="top-0 w-full flex justify-center bg-white bg-opacity-80 p-5 shadow-md z-50 md:fixed">
    <button
      @click="$router.push('/')"
      :class="buttonClass('/')"
      class="text-xl ml-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Home
    </button>
    <button
      @click="$router.push('/login')"
      :class="buttonClass('/login')"
      class="text-xl ml-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Login
    </button>
    <button
      @click="$router.push('/registration')"
      :class="buttonClass('/registration')"
      class="text-xl ml-2 px-4 py-2 text-sm font-medium border border-gray-300 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Register
    </button>
  </div>
</template>

<script>
export default {
  name: 'TopMenu',
  computed: {
    currentRoute() {
      return this.$route.path;
    }
  },
  methods: {
    buttonClass(route) {
      return this.currentRoute === route ? 'bg-white text-indigo-600 border-3 ' : 'text-white bg-indigo-600 ';
    }
  }
};
</script>

<style scoped>
/* No custom styles needed */
</style>