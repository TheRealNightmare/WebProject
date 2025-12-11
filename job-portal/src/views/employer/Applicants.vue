<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Applicants</h1>
        <p class="text-muted text-sm">Review and manage applicants</p>
      </div>
      <div
        class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm"
      >
        TC
      </div>
    </header>

    <div class="mb-6 relative max-w-sm">
      <label class="block text-xs text-muted mb-1.5 ml-1">Filter by Job</label>
      <div class="relative">
        <input
          type="text"
          value="Senior Frontend Developer"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-white text-dark font-medium shadow-sm focus:border-primary outline-none"
        />
        <i
          class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-muted text-xs"
        ></i>
      </div>
    </div>

    <div class="flex flex-col gap-6">
      <div
        v-for="applicant in applicants"
        :key="applicant.email"
        class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm"
      >
        <div
          class="flex flex-col md:flex-row justify-between items-start gap-6 mb-6 pb-6 border-b border-gray-100"
        >
          <div>
            <h2 class="text-lg font-bold text-dark">{{ applicant.name }}</h2>
            <p class="text-sm text-muted mb-3">{{ applicant.email }}</p>
            <div class="flex flex-wrap gap-2 mb-3">
              <span
                v-for="skill in applicant.skills"
                :key="skill"
                class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-100"
                >{{ skill }}</span
              >
            </div>
          </div>
          <div
            class="flex items-center justify-center w-16 h-16 rounded-full border-4 border-gray-100 relative"
          >
            <span class="text-sm font-bold text-amber-600"
              >{{ applicant.match }}%</span
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
                :stroke-dasharray="`${applicant.match}, 100`"
              />
            </svg>
          </div>
        </div>
        <div class="flex flex-wrap gap-3">
          <button
            class="px-4 py-2 bg-primary text-white rounded-md text-sm font-semibold hover:bg-primary-hover flex items-center gap-2"
          >
            <i class="fa-solid fa-download"></i> Resume
          </button>
          <button
            class="px-4 py-2 bg-success text-white rounded-md text-sm font-semibold hover:bg-green-600"
          >
            Schedule Interview
          </button>
          <button
            class="px-4 py-2 border border-gray-200 text-dark rounded-md text-sm font-medium hover:bg-gray-50"
          >
            Reject
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const applicants = ref([
  {
    name: "John Smith",
    email: "john.smith@email.com",
    match: 60,
    skills: ["React", "TypeScript", "CSS", "Git"],
  },
  {
    name: "Sarah Johnson",
    email: "sarah.j@email.com",
    match: 85,
    skills: ["React", "JS", "CSS", "Redux"],
  },
]);
</script>
