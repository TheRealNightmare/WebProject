<template>
  <div class="max-w-3xl mx-auto">
    <router-link
      to="/app/seeker/dashboard"
      class="inline-flex items-center gap-2 text-muted mb-6 hover:text-dark"
    >
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </router-link>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
      <div class="mb-6 pb-6 border-b border-gray-100">
        <h1 class="text-xl font-bold text-dark mb-1">Job Seeker Profile</h1>
        <p class="text-sm text-muted">Manage your profile information</p>
      </div>

      <div v-if="loading" class="text-center py-4">Loading profile...</div>

      <form v-else @submit.prevent="updateProfile" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm text-muted mb-1.5">Full Name</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all"
            />
          </div>
          <div>
            <label class="block text-sm text-muted mb-1.5">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all"
            />
          </div>
          <div>
            <label class="block text-sm text-muted mb-1.5">Location</label>
            <input
              v-model="form.location"
              type="text"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all"
            />
          </div>
        </div>

        <div>
          <label class="block text-sm text-muted mb-1.5">Skills</label>
          <div class="flex gap-2 mb-3">
            <select
              v-model="selectedSkill"
              @change="addSkill"
              class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
            >
              <option value="" disabled>Add a skill...</option>
              <option
                v-for="skill in availableSkills"
                :key="skill.id"
                :value="skill.name"
              >
                {{ skill.name }}
              </option>
            </select>
          </div>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(skill, index) in form.skills"
              :key="index"
              class="px-3 py-1 bg-primary-light text-primary rounded-full text-sm font-medium flex items-center gap-2"
            >
              {{ skill }}
              <i
                @click="removeSkill(index)"
                class="fa-solid fa-xmark cursor-pointer hover:text-primary-hover"
              ></i>
            </span>
          </div>
        </div>

        <div
          v-if="message"
          :class="`text-sm ${isError ? 'text-red-500' : 'text-green-500'}`"
        >
          {{ message }}
        </div>

        <div class="pt-6 border-t border-gray-100 flex gap-4">
          <button
            type="submit"
            :disabled="saving"
            class="flex-1 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover shadow-lg shadow-primary/20 disabled:opacity-50"
          >
            {{ saving ? "Saving..." : "Save Changes" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import api from "../../api";

const loading = ref(true);
const saving = ref(false);
const message = ref("");
const isError = ref(false);
const availableSkills = ref([]);
const selectedSkill = ref("");

const form = reactive({
  name: "",
  email: "",
  location: "",
  skills: [],
});

onMounted(async () => {
  try {
    // Fetch all available skills
    const skillsRes = await api.get("/skills");
    availableSkills.value = skillsRes.data;

    // Fetch user profile
    const userRes = await api.get("/user");
    const user = userRes.data;

    form.name = user.name;
    form.email = user.email;
    form.location = user.location || "";
    // Map backend skills objects to array of names for the form
    form.skills = user.skills ? user.skills.map((s) => s.name) : [];
  } catch (error) {
    console.error("Error loading profile", error);
  } finally {
    loading.value = false;
  }
});

const addSkill = () => {
  if (selectedSkill.value && !form.skills.includes(selectedSkill.value)) {
    form.skills.push(selectedSkill.value);
  }
  selectedSkill.value = "";
};

const removeSkill = (index) => {
  form.skills.splice(index, 1);
};

const updateProfile = async () => {
  saving.value = true;
  message.value = "";
  isError.value = false;

  try {
    await api.put("/user", form);
    message.value = "Profile updated successfully!";
  } catch (error) {
    isError.value = true;
    message.value = error.response?.data?.message || "Failed to update profile";
  } finally {
    saving.value = false;
  }
};
</script>
