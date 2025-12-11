<template>
  <div class="bg-white p-10 rounded-2xl shadow-xl shadow-primary/5 w-full">
    <div class="text-center mb-8">
      <div
        class="flex items-center justify-center gap-2 text-primary font-bold text-lg mb-6"
      >
        <i class="fa-solid fa-briefcase"></i> <span>JobPortal</span>
      </div>
      <h1 class="text-xl font-bold text-dark mb-1">Create Account</h1>
      <p class="text-sm text-muted">
        Join us today and find your perfect match
      </p>
    </div>

    <div class="mb-5">
      <label class="block text-sm text-muted mb-2">I want to</label>
      <div class="flex gap-3">
        <button
          v-for="role in ['Find a Job', 'Hire Talent']"
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
    </div>

    <form class="space-y-4">
      <div v-for="field in fields" :key="field.label">
        <label class="block text-sm text-muted mb-1.5">{{ field.label }}</label>
        <div class="relative flex items-center group">
          <i
            :class="[
              field.icon,
              'absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors',
            ]"
          ></i>
          <input
            :type="field.type"
            :placeholder="field.placeholder"
            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
          />
        </div>
      </div>

      <div class="text-xs text-muted leading-relaxed my-4">
        I agree to the
        <a href="#" class="text-primary hover:underline">Terms of Service</a>
        and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
      </div>

      <button
        class="w-full py-3 bg-primary text-white rounded-lg font-semibold shadow-lg shadow-primary/25 hover:bg-primary-hover transition-all"
      >
        Create Account
      </button>
    </form>

    <div class="text-center mt-6 text-sm text-muted">
      Already have an account?
      <router-link to="/login" class="text-primary font-medium hover:underline"
        >Sign in</router-link
      >
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const activeRole = ref("Find a Job");
const fields = [
  {
    label: "Full Name",
    type: "text",
    placeholder: "John Doe",
    icon: "fa-regular fa-user",
  },
  {
    label: "Email Address",
    type: "email",
    placeholder: "you@example.com",
    icon: "fa-regular fa-envelope",
  },
  {
    label: "Password",
    type: "password",
    placeholder: "••••••••",
    icon: "fa-solid fa-lock",
  },
  {
    label: "Confirm Password",
    type: "password",
    placeholder: "••••••••",
    icon: "fa-solid fa-lock",
  },
];
</script>
