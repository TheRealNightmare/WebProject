<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Job Management</h1>
        <p class="text-muted text-sm">Oversee job listings</p>
      </div>
      <div
        class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-sm"
      >
        A
      </div>
    </header>

    <div v-if="loading" class="text-center py-8 text-muted">
      Loading jobs...
    </div>

    <div
      v-else
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto"
    >
      <table class="w-full text-left border-collapse min-w-[700px]">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Title
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Employer
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Location
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Type
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Applicants
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Posted On
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="job in jobs"
            :key="job.id"
            class="border-b border-gray-100 last:border-0 hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-sm font-medium text-dark">
              {{ job.title }}
            </td>
            <td class="px-6 py-4 text-sm text-muted">
              {{ job.employer ? job.employer.name : "Unknown" }}
            </td>
            <td class="px-6 py-4 text-sm text-muted">{{ job.location }}</td>
            <td class="px-6 py-4 text-sm text-muted capitalize">
              {{ job.type }}
            </td>
            <td class="px-6 py-4">
              <span
                class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold"
                >{{ job.applications_count }}</span
              >
            </td>
            <td class="px-6 py-4 text-sm text-muted">
              {{ new Date(job.created_at).toLocaleDateString() }}
            </td>
            <td class="px-6 py-4 flex gap-3">
              <button
                @click="deleteJob(job.id)"
                class="text-red-500 hover:text-red-700"
                title="Delete Job"
              >
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="jobs.length === 0" class="text-center py-8 text-muted">
        No jobs found.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";

const jobs = ref([]);
const loading = ref(true);

const fetchJobs = async () => {
  loading.value = true;
  try {
    const response = await api.get("/admin/jobs");
    jobs.value = response.data;
  } catch (error) {
    console.error("Error fetching admin jobs", error);
  } finally {
    loading.value = false;
  }
};

const deleteJob = async (id) => {
  if (!confirm("Are you sure you want to delete this job post?")) return;

  try {
    await api.delete(`/admin/jobs/${id}`);
    jobs.value = jobs.value.filter((j) => j.id !== id);
  } catch (error) {
    console.error("Error deleting job", error);
    alert("Failed to delete job");
  }
};

onMounted(() => {
  fetchJobs();
});
</script>
