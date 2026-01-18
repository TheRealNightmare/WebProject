<template>
  <div class="flex min-h-screen bg-bgbody font-sans">
    <Sidebar />
    <main class="flex-1 p-8 md:p-12 transition-all ml-0 md:ml-64">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Sidebar from "../components/Sidebar.vue";
</script>
