<template>
  <div>
    <header class="flex justify-between items-start mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Find Your Dream Job</h1>
        <p class="text-muted text-sm">
          Discover opportunities that match your skills
        </p>
      </div>
    </header>

    <div
      class="bg-white p-4 rounded-xl flex items-center gap-4 mb-8 border border-gray-200 shadow-sm"
    >
      <div
        class="flex-1 flex items-center bg-gray-50 px-4 py-2.5 rounded-lg border border-transparent focus-within:border-primary focus-within:bg-white focus-within:ring-2 focus-within:ring-primary/10 transition-all"
      >
        <i class="fa-solid fa-magnifying-glass text-muted"></i>
        <input
          v-model="searchQuery"
          @keyup.enter="fetchJobs"
          type="text"
          placeholder="Search jobs by title or location..."
          class="bg-transparent border-none outline-none w-full ml-3 text-sm"
        />
      </div>
      <button
        @click="fetchJobs"
        class="px-5 py-2.5 bg-primary text-white rounded-lg font-medium hover:bg-primary-hover transition-all"
      >
        Search
      </button>
    </div>

    <div v-if="loading" class="text-center py-10 text-muted">
      Loading jobs...
    </div>

    <div v-else class="flex flex-col gap-6 mb-8">
      <div
        v-for="job in jobs"
        :key="job.id"
        class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 transition-all group"
      >
        <div class="flex justify-between mb-6">
          <div>
            <h2
              class="text-lg font-bold text-dark mb-1 group-hover:text-primary transition-colors"
            >
              {{ job.title }}
            </h2>
            <p class="text-sm text-muted mb-3">
              {{ job.employer?.name || "Company Confidential" }}
            </p>
            <div class="flex gap-4 text-xs text-muted font-medium">
              <span class="flex items-center gap-1.5"
                ><i class="fa-solid fa-location-dot"></i>
                {{ job.location }}</span
              >
              <span class="flex items-center gap-1.5"
                ><i class="fa-solid fa-briefcase"></i> {{ job.type }}</span
              >
              <span class="flex items-center gap-1.5"
                ><i class="fa-regular fa-clock"></i>
                {{ new Date(job.created_at).toLocaleDateString() }}</span
              >
            </div>
          </div>

          <div
            v-if="job.match_percentage > 0"
            class="flex flex-col items-center gap-1"
          >
            <div
              class="relative w-14 h-14 rounded-full flex items-center justify-center"
              :style="`background: conic-gradient(#8b2dfb ${job.match_percentage}%, #e5e7eb 0deg)`"
            >
              <div
                class="w-11 h-11 bg-white rounded-full flex items-center justify-center text-xs font-bold text-dark shadow-inner"
              >
                {{ Math.round(job.match_percentage) }}%
              </div>
            </div>
            <span
              class="text-[10px] text-muted font-medium uppercase tracking-wide"
              >Match</span
            >
          </div>
        </div>

        <div
          class="flex justify-between items-center pt-5 border-t border-gray-100"
        >
          <span class="text-primary font-bold text-lg">{{
            job.salary_range
          }}</span>
          <router-link
            :to="`/app/job/${job.id}`"
            class="bg-primary text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all"
          >
            View Details
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";

const jobs = ref([]);
const loading = ref(true);
const searchQuery = ref("");

const fetchJobs = async () => {
  loading.value = true;
  try {
    const params = {};
    if (searchQuery.value) params.search = searchQuery.value;

    const response = await api.get("/jobs", { params });
    jobs.value = response.data.data;
  } catch (error) {
    console.error("Failed to fetch jobs", error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchJobs();
});
</script>
