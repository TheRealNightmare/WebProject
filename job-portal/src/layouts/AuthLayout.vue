<template>
  <div
    class="min-h-screen flex items-center justify-center bg-[radial-gradient(circle_at_center,_#eef4fc,_#dfe7f5)] p-4 font-sans text-dark"
  >
    <div class="w-full max-w-[420px] flex flex-col gap-4">
      <router-link
        to="/"
        class="flex items-center gap-2 text-muted text-sm font-medium hover:text-dark transition-colors self-start ml-1"
      >
      </router-link>

      <router-view />
    </div>
  </div>
</template>
