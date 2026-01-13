<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Applicants</h1>
        <p class="text-muted text-sm">Review and manage applicants</p>
      </div>
    </header>

    <div class="mb-6 relative max-w-sm">
      <label class="block text-xs text-muted mb-1.5 ml-1">Filter by Job</label>
      <div class="relative">
        <select
          v-model="selectedJobId"
          @change="fetchApplicants"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-dark font-medium shadow-sm focus:border-primary outline-none appearance-none"
        >
          <option v-for="job in jobs" :key="job.id" :value="job.id">
            {{ job.title }}
          </option>
        </select>
        <i
          class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-muted text-xs pointer-events-none"
        ></i>
      </div>
    </div>

    <div v-if="loading" class="py-8 text-center text-muted">
      Loading applicants...
    </div>
    <div
      v-else-if="applicants.length === 0"
      class="py-8 text-center text-muted"
    >
      No applicants found for this job.
    </div>

    <div v-else class="flex flex-col gap-6">
      <div
        v-for="app in applicants"
        :key="app.id"
        class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm"
      >
        <div
          class="flex flex-col md:flex-row justify-between items-start gap-6 mb-6 pb-6 border-b border-gray-100"
        >
          <div>
            <h2 class="text-lg font-bold text-dark">{{ app.seeker.name }}</h2>
            <p class="text-sm text-muted mb-3">{{ app.seeker.email }}</p>
            <div class="text-xs text-gray-500">
              Applied on: {{ new Date(app.created_at).toLocaleDateString() }}
            </div>
          </div>
          <div
            class="flex items-center justify-center w-16 h-16 rounded-full border-4 border-gray-100 relative"
          >
            <span class="text-sm font-bold text-amber-600"
              >{{ Math.round(app.match_percentage) }}%</span
            >
            <svg
              class="absolute inset-0 w-full h-full -rotate-90"
              viewBox="0 0 36 36"
            >
              <path
                class="text-amber-500"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke="currentColor"
                stroke-width="3"
                :stroke-dasharray="`${app.match_percentage}, 100`"
              />
            </svg>
          </div>
        </div>
        <div class="flex flex-wrap gap-3">
          <a
            :href="`/storage/${app.resume_path}`"
            target="_blank"
            v-if="app.resume_path"
            class="px-4 py-2 bg-primary text-white rounded-md text-sm font-semibold hover:bg-primary-hover flex items-center gap-2"
          >
            <i class="fa-solid fa-download"></i> Resume
          </a>
          <button
            class="px-4 py-2 bg-success text-white rounded-md text-sm font-semibold hover:bg-green-600"
          >
            Schedule Interview
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";

const route = useRoute();
const jobs = ref([]);
const applicants = ref([]);
const selectedJobId = ref(null);
const loading = ref(false);

const fetchJobs = async () => {
  try {
    const response = await api.get("/employer/jobs");
    jobs.value = response.data;

    // If query param exists, use it, otherwise default to first job
    if (route.query.jobId) {
      selectedJobId.value = parseInt(route.query.jobId);
    } else if (jobs.value.length > 0) {
      selectedJobId.value = jobs.value[0].id;
    }

    if (selectedJobId.value) {
      fetchApplicants();
    }
  } catch (error) {
    console.error("Error fetching jobs", error);
  }
};

const fetchApplicants = async () => {
  if (!selectedJobId.value) return;
  loading.value = true;
  try {
    const response = await api.get(
      `/employer/jobs/${selectedJobId.value}/applicants`
    );
    applicants.value = response.data;
  } catch (error) {
    console.error("Error fetching applicants", error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchJobs();
});
</script>
