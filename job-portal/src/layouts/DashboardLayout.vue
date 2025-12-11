<template>
  <div class="flex min-h-screen bg-bgbody font-sans">
    <Sidebar />
    <main class="ml-64 flex-1 p-8 md:p-12 transition-all">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Sidebar from '../components/Sidebar.vue';
</script>