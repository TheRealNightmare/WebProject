<template>
  <div
    class="bg-white p-10 rounded-2xl shadow-xl shadow-primary/5 w-full text-center"
  >
    <div
      class="flex items-center justify-center gap-2 text-primary font-bold text-lg mb-6"
    >
      <i class="fa-solid fa-briefcase"></i> <span>JobPortal</span>
    </div>

    <div class="mb-6">
      <h2 class="text-xl font-bold text-dark mb-2">Welcome Back</h2>
      <p class="text-sm text-muted">Sign in to your account</p>
    </div>

    <div class="text-left text-sm text-muted mb-2">I am a</div>
    <div class="flex gap-3 mb-5">
      <button
        v-for="role in roles"
        :key="role"
        @click="activeRole = role"
        :class="[
          'flex-1 py-2.5 border rounded-lg text-sm font-medium transition-all',
          activeRole === role
            ? 'bg-primary text-white border-primary shadow-md'
            : 'bg-transparent border-gray-200 text-muted hover:bg-gray-50',
        ]"
      >
        {{ role }}
      </button>
    </div>

    <form @submit.prevent="handleLogin">
      <div class="space-y-5 mb-6 text-left">
        <div>
          <label class="block text-sm text-muted mb-2">Email Address</label>
          <div class="relative flex items-center group">
            <i
              class="fa-solid fa-envelope absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"
            ></i>
            <input
              type="email"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
              placeholder="you@example.com"
            />
          </div>
        </div>
        <div>
          <label class="block text-sm text-muted mb-2">Password</label>
          <div class="relative flex items-center group">
            <i
              class="fa-solid fa-lock absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"
            ></i>
            <input
              type="password"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
              placeholder="........"
            />
          </div>
        </div>
      </div>

      <div class="flex justify-between items-center mb-6 text-sm">
        <label
          class="flex items-center gap-2 text-muted cursor-pointer hover:text-dark"
        >
          <input type="checkbox" class="accent-primary w-4 h-4" /> Remember me
        </label>
        <a href="#" class="text-primary font-medium hover:underline"
          >Forgot password?</a
        >
      </div>

      <button
        class="w-full py-3 bg-primary text-white rounded-lg font-semibold shadow-lg shadow-primary/25 hover:bg-primary-hover transition-all mb-6"
      >
        Sign In
      </button>

      <p class="text-sm text-muted">
        Don't have an account?
        <router-link
          to="/signup"
          class="text-primary font-medium hover:underline"
          >Sign up</router-link
        >
      </p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const roles = ["Job Seeker", "Employer", "Admin"];
const activeRole = ref("Job Seeker");

const handleLogin = () => {
  const paths = {
    "Job Seeker": "/app/seeker/dashboard",
    Employer: "/app/employer/jobs",
    Admin: "/app/admin/dashboard",
  };
  router.push(paths[activeRole.value]);
};
</script>
