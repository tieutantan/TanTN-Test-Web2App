<template>
  <div class="app-background">
    <div class="content">


      <TopMenu />

      <router-view />
    </div>
  </div>
</template>

<script>

import TopMenu from "@/components/TopMenu.vue";

export default {
  name: 'App',
  components: {TopMenu},
};
</script>

<style>
.app-background {
  position: relative;
  min-height: 100vh;
  overflow: hidden;
}

.app-background::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('@/assets/background.png');
  background-size: cover;
  background-position: center;
  filter: blur(12px);
  -webkit-filter: blur(12px);
  z-index: -1;
}

.content {
  position: relative;
  z-index: 1;
}
</style>