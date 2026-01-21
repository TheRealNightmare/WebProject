<template>
  <div v-if="job">
    <router-link
      to="/app/seeker/dashboard"
      class="inline-flex items-center gap-2 text-dark font-medium mb-6 hover:text-primary transition-colors"
    >
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </router-link>

    <div class="grid grid-cols-1 lg:grid-cols-[2.2fr_1fr] gap-8 items-start">
      <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
        <div class="mb-8">
          <h1 class="text-2xl font-bold text-dark mb-1">{{ job.title }}</h1>
          <p class="text-muted mb-4">{{ job.employer?.name }}</p>
          <div class="flex flex-wrap gap-4 text-sm text-muted font-medium">
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-location-dot"></i> {{ job.location }}</span
            >
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-briefcase"></i> {{ job.type }}</span
            >
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-dollar-sign"></i>
              {{ job.salary_range }}</span
            >
          </div>
        </div>

        <div
          v-if="job.match_percentage"
          class="bg-primary-light border border-primary/10 rounded-xl p-6 flex justify-between items-center mb-8"
        >
          <div>
            <h3 class="text-primary font-bold mb-1">Your Skill Match</h3>
            <p class="text-sm text-primary/80">
              You match {{ Math.round(job.match_percentage) }}% of the profile.
            </p>
          </div>
          <div
            class="w-12 h-12 rounded-full border-4 border-primary flex items-center justify-center text-primary font-bold text-xs bg-white"
          >
            {{ Math.round(job.match_percentage) }}%
          </div>
        </div>

        <div class="space-y-8">
          <section>
            <h3 class="font-bold text-lg mb-4 text-dark">Job Description</h3>
            <p class="text-muted leading-relaxed mb-4 whitespace-pre-line">
              {{ job.description }}
            </p>

            <h4 class="font-bold text-dark mb-2">Skills Required</h4>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="skill in job.skills"
                :key="skill.id"
                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium"
              >
                {{ skill.name }}
              </span>
            </div>
          </section>

          <div
            v-if="message"
            :class="`p-4 rounded-lg text-sm ${
              isError ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'
            }`"
          >
            {{ message }}
          </div>

          <button
            @click="applyForJob"
            :disabled="applying || job.has_applied"
            :class="`w-full py-4 rounded-xl font-bold text-lg shadow-xl transition-all disabled:opacity-50 ${
              job.has_applied
                ? 'bg-green-600 text-white cursor-not-allowed shadow-green-600/20'
                : 'bg-primary text-white hover:bg-primary-hover shadow-primary/20'
            }`"
          >
            <span v-if="applying">Submitting Application...</span>
            <span v-else-if="job.has_applied">
              <i class="fa-solid fa-check mr-2"></i>Applied
            </span>
            <span v-else>Apply for this Position</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="text-center py-10">Loading job details...</div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";

const route = useRoute();
const job = ref(null);
const applying = ref(false);
const message = ref("");
const isError = ref(false);

const fetchJob = async () => {
  try {
    const response = await api.get(`/jobs/${route.params.id}`);
    job.value = response.data;
  } catch (error) {
    console.error("Error fetching job", error);
  }
};

const applyForJob = async () => {
  if (job.value.has_applied) return;

  applying.value = true;
  message.value = "";
  isError.value = false;

  try {
    await api.post(`/jobs/${job.value.id}/apply`, {
      cover_letter: "I am interested in this role.",
    });
    message.value = "Application submitted successfully!";
    job.value.has_applied = true; // Update local state immediately
  } catch (error) {
    isError.value = true;
    message.value = error.response?.data?.message || "Failed to apply.";
  } finally {
    applying.value = false;
  }
};

onMounted(() => {
  fetchJob();
});
</script>
