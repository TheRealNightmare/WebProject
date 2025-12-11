<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">My Applications</h1>
        <p class="text-muted text-sm">Track your application status</p>
      </div>
      <div
        class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm"
      >
        JS
      </div>
    </header>

    <div class="flex flex-col gap-4">
      <div
        v-for="app in applications"
        :key="app.id"
        class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:shadow-md transition-shadow"
      >
        <div>
          <h2 class="text-lg font-bold text-dark mb-1">{{ app.title }}</h2>
          <p class="text-dark text-sm mb-1">{{ app.company }}</p>
          <p class="text-xs text-muted">Applied {{ app.date }}</p>
        </div>
        <span
          :class="[
            'px-4 py-2 rounded-full text-sm font-semibold',
            statusClasses[app.status],
          ]"
        >
          {{ app.status }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const statusClasses = {
  "Under Review": "bg-blue-100 text-blue-800",
  "Interview Scheduled": "bg-green-100 text-green-800",
  Rejected: "bg-red-100 text-red-800",
};

const applications = ref([
  {
    id: 1,
    title: "Senior Frontend Developer",
    company: "TechCorp Inc.",
    date: "2 days ago",
    status: "Under Review",
  },
  {
    id: 2,
    title: "React Developer",
    company: "WebSolutions",
    date: "1 week ago",
    status: "Interview Scheduled",
  },
  {
    id: 3,
    title: "UI Developer",
    company: "DesignHub",
    date: "2 weeks ago",
    status: "Rejected",
  },
]);
</script>
