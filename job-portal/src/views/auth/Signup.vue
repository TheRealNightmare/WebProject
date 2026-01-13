<template>
  <div class="bg-white p-10 rounded-2xl shadow-xl shadow-primary/5 w-full">
    <div class="text-center mb-8">
      <div class="flex items-center justify-center gap-2 text-primary font-bold text-lg mb-6">
        <i class="fa-solid fa-briefcase"></i> <span>JobPortal</span>
      </div>
      <h1 class="text-xl font-bold text-dark mb-1">Create Account</h1>
      <p class="text-sm text-muted">Join us today and find your perfect match</p>
    </div>

    <div class="mb-5">
      <label class="block text-sm text-muted mb-2">I want to</label>
      <div class="flex gap-3">
        <button
          type="button"
          v-for="roleOption in roleOptions"
          :key="roleOption.value"
          @click="formData.role = roleOption.value"
          :class="[
            'flex-1 py-2.5 border rounded-lg text-sm font-medium transition-all',
            formData.role === roleOption.value
              ? 'bg-primary text-white border-primary shadow-md'
              : 'bg-transparent border-gray-200 text-muted hover:bg-gray-50',
          ]"
        >
          {{ roleOption.label }}
        </button>
      </div>
    </div>

    <form @submit.prevent="handleSignup" class="space-y-4">
      <div>
        <label class="block text-sm text-muted mb-1.5">Full Name</label>
        <div class="relative flex items-center group">
          <i class="fa-regular fa-user absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"></i>
          <input
            v-model="formData.name"
            type="text"
            placeholder="John Doe"
            required
            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
          />
        </div>
      </div>

      <div>
        <label class="block text-sm text-muted mb-1.5">Email Address</label>
        <div class="relative flex items-center group">
          <i class="fa-regular fa-envelope absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"></i>
          <input
            v-model="formData.email"
            type="email"
            placeholder="you@example.com"
            required
            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
          />
        </div>
      </div>

      <div>
        <label class="block text-sm text-muted mb-1.5">Password</label>
        <div class="relative flex items-center group">
          <i class="fa-solid fa-lock absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"></i>
          <input
            v-model="formData.password"
            type="password"
            placeholder="••••••••"
            required
            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
          />
        </div>
      </div>

      <div>
        <label class="block text-sm text-muted mb-1.5">Confirm Password</label>
        <div class="relative flex items-center group">
          <i class="fa-solid fa-lock absolute left-4 text-gray-400 text-sm group-focus-within:text-primary transition-colors"></i>
          <input
            v-model="formData.password_confirmation"
            type="password"
            placeholder="••••••••"
            required
            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all"
          />
        </div>
      </div>

      <div v-if="errorMessage" class="text-red-500 text-sm text-center">
        {{ errorMessage }}
      </div>

      <div class="text-xs text-muted leading-relaxed my-4">
        I agree to the
        <a href="#" class="text-primary hover:underline">Terms of Service</a>
        and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
      </div>

      <button
        :disabled="isLoading"
        class="w-full py-3 bg-primary text-white rounded-lg font-semibold shadow-lg shadow-primary/25 hover:bg-primary-hover transition-all disabled:opacity-50"
      >
        {{ isLoading ? 'Creating Account...' : 'Create Account' }}
      </button>
    </form>

    <div class="text-center mt-6 text-sm text-muted">
      Already have an account?
      <router-link to="/login" class="text-primary font-medium hover:underline">Sign in</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

const router = useRouter();
const isLoading = ref(false);
const errorMessage = ref("");

const roleOptions = [
  { label: "Find a Job", value: "seeker" },
  { label: "Hire Talent", value: "employer" }
];

const formData = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  role: "seeker" // default
});

const handleSignup = async () => {
  isLoading.value = true;
  errorMessage.value = "";

  try {
    const response = await api.post('/register', formData);
    
    // Store token and user info
    localStorage.setItem('token', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));

    // Redirect based on role
    const paths = {
      seeker: "/app/seeker/dashboard",
      employer: "/app/employer/jobs"
    };
    router.push(paths[formData.role]);
    
  } catch (error) {
    errorMessage.value = error.response?.data?.message || "Registration failed";
  } finally {
    isLoading.value = false;
  }
};
</script>