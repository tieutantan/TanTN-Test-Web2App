<template>
  <div class="dashboard p-5">
    <h1 class="text-3xl font-bold mb-4 mt-20">Dashboard - Hello {{ fullName }}</h1>

    <div v-for="(objects, date) in nearEarthObjects" :key="date" class="mb-6">
      <h2 class="text-xl font-semibold mb-2">{{ date }}</h2>
      <div class="grid md:grid-cols-3 lg:grid-cols-6 sm:grid-cols-1 gap-4">
        <div v-for="object in objects" :key="object.id" class="p-4 mb-4 bg-white rounded shadow">
          <p class="text-lg font-medium">Name: {{ object.name }}</p>
          <p>Absolute Magnitude: {{ object.absolute_magnitude_h }}</p>
          <p>Estimated Diameter (km): {{ object.estimated_diameter.kilometers.min }} -
            {{ object.estimated_diameter.kilometers.max }}</p>
          <p>Potentially Hazardous: <span
              :class="{'text-red-500': object.is_potentially_hazardous_asteroid, 'text-green-500': !object.is_potentially_hazardous_asteroid}">{{
              object.is_potentially_hazardous_asteroid
            }}</span></p>
          <p>Close Approach Date: {{ object.close_approach_data[0].close_approach_date }}</p>
          <p>Relative Velocity (km/h): {{ object.close_approach_data[0].relative_velocity.kilometers_per_hour }}</p>
          <p>Miss Distance (km): {{ object.close_approach_data[0].miss_distance.kilometers }}</p>
        </div>
      </div>
    </div>

    <div v-if="links" class="space-y-2 text-center">
      <button
          v-for="(url, key) in links"
          :key="key"
          @click="openLink(url)"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 uppercase mx-1"
      >
        {{ key }} page
      </button>
    </div>
  </div>
</template>

<script>
/* global FB */
import axios from 'axios';

export default {
  name: 'DashboardPage',
  data() {
    return {
      links: null,
      nearEarthObjects: null,
      fullName: '',
    };
  },
  async created() {
    await this.checkToken();
  },
  mounted() {

    window.fbAsyncInit = function () {
      FB.init({
        appId: '484168491206760',
        cookie: true,
        xfbml: true,
        version: 'v12.0'
      });
      FB.AppEvents.logPageView();
    };

    (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

  },
  methods: {
    async checkToken() {
      try {
        const token = localStorage.getItem('accessToken');
        if (!token) {
          throw new Error('No token found');
        }

        const response = await axios.get('http://localhost:1111/index.php?r=auth/check', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        if (response.data && response.data.data) {
          this.fullName = response.data.data.fullName;
          await this.fetchNearEarthObjects('https://api.nasa.gov/neo/rest/v1/feed?start_date=2015-09-07&end_date=2015-09-08&api_key=DEMO_KEY');
        } else {
          throw new Error('Invalid token');
        }
      } catch (error) {

        this.checkFacebookLoginStatus();

      }
    },
    async fetchNearEarthObjects(url) {
      try {
        const response = await axios.get(url);
        this.links = response.data.links;
        this.nearEarthObjects = response.data.near_earth_objects;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    openLink(url) {
      this.fetchNearEarthObjects(url);
    },
    checkFacebookLoginStatus() {
      FB.getLoginStatus(response => {
        if (response.status !== 'connected') {
          this.$router.push('/login');
        } else {
          this.fullName = response.authResponse.userID + ' - Facebook user';
        }
      });
    }
  }
};
</script>

<style scoped>
/* No additional styles needed as Tailwind CSS is used */
</style>