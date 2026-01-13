<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Job Postings</h1>
        <p class="text-muted text-sm">Manage your job postings</p>
      </div>
      <div class="flex items-center gap-4">
        <button
          @click="showModal = true"
          class="bg-primary text-white px-5 py-2.5 rounded-lg font-semibold flex items-center gap-2 hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all"
        >
          <i class="fa-solid fa-plus"></i> Post New Job
        </button>
      </div>
    </header>

    <div v-if="loading" class="text-center py-10">Loading jobs...</div>

    <div v-else class="flex flex-col gap-6">
      <div
        v-for="job in jobs"
        :key="job.id"
        class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-all"
      >
        <div class="flex flex-col md:flex-row justify-between items-start mb-6">
          <div>
            <h2 class="text-lg font-bold text-dark mb-2">{{ job.title }}</h2>
            <div class="flex gap-2 text-sm text-muted items-center">
              <span>{{ job.location }}</span>
              <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
              <span>{{ job.type }}</span>
              <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
              <span>{{ job.salary_range }}</span>
            </div>
            <p class="text-xs text-muted mt-2">
              Posted {{ new Date(job.created_at).toLocaleDateString() }}
            </p>
          </div>
          <div
            class="bg-primary-light px-4 py-2 rounded-lg text-center mt-4 md:mt-0"
          >
            <span class="block text-xl font-bold text-primary">{{
              job.applications_count
            }}</span>
            <span class="text-xs font-semibold text-primary">Applicants</span>
          </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
          <router-link
            :to="`/app/employer/applicants?jobId=${job.id}`"
            class="flex-1 py-2 bg-primary text-white rounded-md font-semibold text-sm hover:bg-primary-hover text-center"
          >
            View Applicants
          </router-link>
          <button
            class="px-4 py-2 border border-red-200 bg-red-50 text-danger rounded-md font-medium text-sm hover:bg-red-100"
          >
            Close Job
          </button>
        </div>
      </div>
    </div>

    <PostJobModal
      :isOpen="showModal"
      @close="showModal = false"
      @jobPosted="handleJobPosted"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";
import PostJobModal from "../../components/PostJobModal.vue";

const showModal = ref(false);
const jobs = ref([]);
const loading = ref(true);

const fetchJobs = async () => {
  loading.value = true;
  try {
    const response = await api.get("/employer/jobs");
    jobs.value = response.data;
  } catch (error) {
    console.error("Error fetching jobs", error);
  } finally {
    loading.value = false;
  }
};

const handleJobPosted = (newJob) => {
  showModal.value = false;
  fetchJobs(); // Refresh list
};

onMounted(() => {
  fetchJobs();
});
</script>
