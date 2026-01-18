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

    <div
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto"
    >
      <table class="w-full text-left border-collapse min-w-[700px]">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th
              v-for="h in [
                'Title',
                'Company',
                'Location',
                'Type',
                'Applicants',
                'Status',
                'Actions',
              ]"
              :key="h"
              class="px-6 py-4 text-xs font-bold text-dark uppercase"
            >
              {{ h }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="job in jobs"
            :key="job.title"
            class="border-b border-gray-100 last:border-0 hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-sm font-medium text-dark">
              {{ job.title }}
            </td>
            <td class="px-6 py-4 text-sm text-muted">{{ job.company }}</td>
            <td class="px-6 py-4 text-sm text-muted">{{ job.location }}</td>
            <td class="px-6 py-4 text-sm text-muted">{{ job.type }}</td>
            <td class="px-6 py-4">
              <span
                class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold"
                >{{ job.count }}</span
              >
            </td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'px-2.5 py-1 rounded-full text-xs font-semibold',
                  job.status === 'Active'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-gray-100 text-gray-600',
                ]"
                >{{ job.status }}</span
              >
            </td>
            <td class="px-6 py-4 flex gap-3">
              <button class="text-blue-500 hover:text-blue-700">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="text-red-500 hover:text-red-700">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const jobs = ref([
  {
    title: "Senior Frontend Developer",
    company: "TechCorp Inc.",
    location: "SF, CA",
    type: "Full-time",
    count: 24,
    status: "Active",
  },
  {
    title: "Data Scientist",
    company: "DataCorp",
    location: "Boston, MA",
    type: "Full-time",
    count: 45,
    status: "Closed",
  },
]);
</script>
