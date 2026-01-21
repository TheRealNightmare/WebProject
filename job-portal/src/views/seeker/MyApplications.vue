<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">My Applications</h1>
        <p class="text-muted text-sm">Track your application status</p>
      </div>
    </header>

    <div v-if="loading" class="text-center py-10 text-muted">
      Loading applications...
    </div>

    <div
      v-else-if="applications.length === 0"
      class="text-center py-10 text-muted bg-white rounded-xl border border-gray-200"
    >
      You haven't applied to any jobs yet.
    </div>

    <div v-else class="flex flex-col gap-4">
      <div
        v-for="app in applications"
        :key="app.id"
        class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:shadow-md transition-shadow"
      >
        <div>
          <h2 class="text-lg font-bold text-dark mb-1">
            {{ app.job?.title || "Unknown Position" }}
          </h2>
          <p class="text-dark text-sm mb-1">
            {{ app.job?.employer?.name || "Company Confidential" }}
          </p>
          <p class="text-xs text-muted">
            Applied {{ new Date(app.created_at).toLocaleDateString() }}
          </p>
        </div>
        <span
          :class="[
            'px-4 py-2 rounded-full text-sm font-semibold capitalize',
            statusClasses[app.status] || 'bg-gray-100 text-gray-800',
          ]"
        >
          {{ app.status }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";

const loading = ref(true);
const applications = ref([]);

// Updated to match database status values (usually lowercase)
const statusClasses = {
  pending: "bg-blue-100 text-blue-800",
  interview: "bg-green-100 text-green-800",
  rejected: "bg-red-100 text-red-800",
  accepted: "bg-green-600 text-white",
};

const fetchApplications = async () => {
  try {
    const response = await api.get("/my-applications"); // Calls ApplicationController::myApplications
    applications.value = response.data;
  } catch (error) {
    console.error("Failed to fetch applications", error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchApplications();
});
</script>
