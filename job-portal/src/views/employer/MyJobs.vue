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
        <div
          class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm"
        >
          TC
        </div>
      </div>
    </header>

    <div class="flex flex-col gap-6">
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
              <span>{{ job.salary }}</span>
            </div>
            <p class="text-xs text-muted mt-2">Posted {{ job.posted }}</p>
          </div>
          <div
            class="bg-primary-light px-4 py-2 rounded-lg text-center mt-4 md:mt-0"
          >
            <span class="block text-xl font-bold text-primary">{{
              job.applicants
            }}</span>
            <span class="text-xs font-semibold text-primary">Applicants</span>
          </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
          <button
            class="flex-1 py-2 bg-primary text-white rounded-md font-semibold text-sm hover:bg-primary-hover"
          >
            View Applicants
          </button>
          <button
            class="px-4 py-2 border border-gray-200 rounded-md font-medium text-sm text-muted hover:bg-gray-50"
          >
            Edit
          </button>
          <button
            class="px-4 py-2 border border-red-200 bg-red-50 text-danger rounded-md font-medium text-sm hover:bg-red-100"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <PostJobModal :isOpen="showModal" @close="showModal = false" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import PostJobModal from "../../components/PostJobModal.vue";

const showModal = ref(false);
const jobs = ref([
  {
    id: 1,
    title: "Senior Frontend Developer",
    location: "San Francisco, CA",
    type: "Full-time",
    salary: "$120k - $150k",
    posted: "2 days ago",
    applicants: 24,
  },
  {
    id: 2,
    title: "Product Designer",
    location: "New York, NY",
    type: "Full-time",
    salary: "$100k - $130k",
    posted: "1 week ago",
    applicants: 18,
  },
]);
</script>
