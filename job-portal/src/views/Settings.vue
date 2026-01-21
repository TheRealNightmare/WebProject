<template>
  <div class="max-w-4xl mx-auto">
    <header class="mb-8">
      <h1 class="text-2xl font-bold text-dark mb-1">Account Settings</h1>
      <p class="text-muted text-sm">Manage your profile and preferences</p>
    </header>

    <div
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
    >
      <div class="flex border-b border-gray-200">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'px-6 py-4 text-sm font-medium transition-colors relative',
            activeTab === tab.id
              ? 'text-primary'
              : 'text-muted hover:text-dark',
          ]"
        >
          {{ tab.label }}
          <div
            v-if="activeTab === tab.id"
            class="absolute bottom-0 left-0 w-full h-0.5 bg-primary"
          ></div>
        </button>
      </div>

      <div class="p-8">
        <div v-if="loading" class="text-center py-10 text-muted">
          Loading profile...
        </div>

        <div
          v-else-if="activeTab === 'general'"
          class="animate-[fadeIn_0.3s_ease-out]"
        >
          <h3 class="text-lg font-bold text-dark mb-6">Profile Information</h3>

          <div
            v-if="profileMessage"
            :class="`mb-4 p-3 rounded-lg text-sm ${isError ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'}`"
          >
            {{ profileMessage }}
          </div>

          <form @submit.prevent="updateProfile">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="block text-sm text-muted mb-2">Full Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
              <div>
                <label class="block text-sm text-muted mb-2"
                  >Email Address</label
                >
                <input
                  v-model="form.email"
                  type="email"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm text-muted mb-2">Location</label>
                <input
                  v-model="form.location"
                  type="text"
                  placeholder="e.g. New York, USA"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
            </div>

            <div class="flex justify-end">
              <button
                type="submit"
                :disabled="saving"
                class="px-6 py-2.5 bg-primary text-white rounded-lg font-bold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all disabled:opacity-50"
              >
                {{ saving ? "Saving..." : "Save Changes" }}
              </button>
            </div>
          </form>
        </div>

        <div
          v-if="activeTab === 'security'"
          class="animate-[fadeIn_0.3s_ease-out]"
        >
          <h3 class="text-lg font-bold text-dark mb-6">Change Password</h3>

          <div
            v-if="passwordMessage"
            :class="`mb-4 p-3 rounded-lg text-sm ${isPasswordError ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'}`"
          >
            {{ passwordMessage }}
          </div>

          <form @submit.prevent="updatePassword">
            <div class="space-y-4 max-w-md">
              <div>
                <label class="block text-sm text-muted mb-2"
                  >Current Password</label
                >
                <input
                  v-model="passwordForm.current_password"
                  type="password"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
              <div>
                <label class="block text-sm text-muted mb-2"
                  >New Password</label
                >
                <input
                  v-model="passwordForm.new_password"
                  type="password"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
              <div>
                <label class="block text-sm text-muted mb-2"
                  >Confirm New Password</label
                >
                <input
                  v-model="passwordForm.new_password_confirmation"
                  type="password"
                  required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                />
              </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
              <button
                type="submit"
                :disabled="savingPassword"
                class="px-6 py-2.5 bg-white border border-gray-200 text-dark rounded-lg font-medium hover:bg-gray-50 transition-all disabled:opacity-50"
              >
                {{ savingPassword ? "Updating..." : "Update Password" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../api"; // Ensure this path is correct

const activeTab = ref("general");
const tabs = [
  { id: "general", label: "General" },
  { id: "security", label: "Security" },
];

// -- General Profile Logic --
const loading = ref(true);
const saving = ref(false);
const profileMessage = ref("");
const isError = ref(false);

const form = ref({
  name: "",
  email: "",
  location: "",
});

const fetchUser = async () => {
  try {
    const response = await api.get("/user");
    form.value = {
      name: response.data.name,
      email: response.data.email,
      location: response.data.location || "",
    };
  } catch (error) {
    console.error("Failed to load user", error);
  } finally {
    loading.value = false;
  }
};

const updateProfile = async () => {
  saving.value = true;
  profileMessage.value = "";
  isError.value = false;

  try {
    await api.put("/user", form.value);
    profileMessage.value = "Profile updated successfully!";
  } catch (error) {
    isError.value = true;
    profileMessage.value =
      error.response?.data?.message || "Failed to update profile.";
  } finally {
    saving.value = false;
  }
};

// -- Password Logic --
const savingPassword = ref(false);
const passwordMessage = ref("");
const isPasswordError = ref(false);

const passwordForm = ref({
  current_password: "",
  new_password: "",
  new_password_confirmation: "",
});

const updatePassword = async () => {
  if (
    passwordForm.value.new_password !==
    passwordForm.value.new_password_confirmation
  ) {
    isPasswordError.value = true;
    passwordMessage.value = "New passwords do not match.";
    return;
  }

  savingPassword.value = true;
  passwordMessage.value = "";
  isPasswordError.value = false;

  try {
    await api.put("/user/password", passwordForm.value);
    passwordMessage.value = "Password updated successfully!";
    // Clear form
    passwordForm.value = {
      current_password: "",
      new_password: "",
      new_password_confirmation: "",
    };
  } catch (error) {
    isPasswordError.value = true;
    // Extract validation error message if available
    const msg = error.response?.data?.message || "Failed to update password.";
    const errors = error.response?.data?.errors;
    passwordMessage.value = errors ? Object.values(errors).flat()[0] : msg;
  } finally {
    savingPassword.value = false;
  }
};

onMounted(() => {
  fetchUser();
});
</script>
