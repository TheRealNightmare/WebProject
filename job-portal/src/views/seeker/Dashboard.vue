<template>
  <div>
    <header class="flex justify-between items-start mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Find Your Dream Job</h1>
        <p class="text-muted text-sm">
          Discover opportunities that match your skills
        </p>
      </div>
      <div class="flex items-center gap-6">
        <button class="relative text-muted text-xl hover:text-dark">
          <i class="fa-regular fa-bell"></i>
          <span
            class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-danger rounded-full border-2 border-bgbody"
          ></span>
        </button>
        <div
          class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm cursor-pointer shadow-md"
        >
          JS
        </div>
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
          type="text"
          placeholder="Search jobs..."
          class="bg-transparent border-none outline-none w-full ml-3 text-sm"
        />
      </div>
      <div
        class="flex-1 flex items-center bg-gray-50 px-4 py-2.5 rounded-lg border border-transparent focus-within:border-primary focus-within:bg-white focus-within:ring-2 focus-within:ring-primary/10 transition-all"
      >
        <i class="fa-solid fa-location-dot text-muted"></i>
        <input
          type="text"
          placeholder="Location"
          class="bg-transparent border-none outline-none w-full ml-3 text-sm"
        />
      </div>
      <button
        class="px-5 py-2.5 bg-gray-100 border border-gray-200 rounded-lg font-medium text-dark hover:bg-gray-200 flex items-center gap-2 transition-all"
      >
        <i class="fa-solid fa-filter"></i> Filters
      </button>
    </div>

    <div class="mb-8">
      <h3 class="text-sm text-primary font-bold mb-3 uppercase tracking-wide">
        Your Skills
      </h3>
      <div class="flex flex-wrap gap-2.5">
        <span
          v-for="skill in [
            'React',
            'TypeScript',
            'Node.js',
            'CSS',
            'JavaScript',
          ]"
          :key="skill"
          class="px-3.5 py-1.5 bg-primary text-white text-sm font-medium rounded-full shadow-sm"
        >
          {{ skill }}
        </span>
      </div>
    </div>

    <div class="flex flex-col gap-6 mb-8">
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
            <p class="text-sm text-muted mb-3">{{ job.company }}</p>
            <div class="flex gap-4 text-xs text-muted font-medium">
              <span class="flex items-center gap-1.5"
                ><i class="fa-solid fa-location-dot"></i>
                {{ job.location }}</span
              >
              <span class="flex items-center gap-1.5"
                ><i class="fa-solid fa-briefcase"></i> {{ job.type }}</span
              >
              <span class="flex items-center gap-1.5"
                ><i class="fa-regular fa-clock"></i> {{ job.posted }}</span
              >
            </div>
          </div>
          <div class="flex flex-col items-center gap-1">
            <div
              class="relative w-14 h-14 rounded-full flex items-center justify-center"
              :style="`background: conic-gradient(#8b2dfb ${job.match}%, #e5e7eb 0deg)`"
            >
              <div
                class="w-11 h-11 bg-white rounded-full flex items-center justify-center text-xs font-bold text-dark shadow-inner"
              >
                {{ job.match }}%
              </div>
            </div>
            <span
              class="text-[10px] text-muted font-medium uppercase tracking-wide"
              >Match</span
            >
          </div>
        </div>

        <div class="mb-6">
          <span class="block text-xs text-muted mb-2 font-medium uppercase"
            >Required Skills</span
          >
          <div class="flex flex-wrap gap-2">
            <span
              v-for="skill in job.skills"
              :key="skill.name"
              :class="[
                'px-3 py-1 rounded-full text-xs font-medium',
                skill.match
                  ? 'bg-green-100 text-green-700'
                  : 'bg-gray-100 text-gray-500',
              ]"
            >
              {{ skill.name }}
            </span>
          </div>
        </div>

        <div
          class="flex justify-between items-center pt-5 border-t border-gray-100"
        >
          <span class="text-primary font-bold text-lg">{{ job.salary }}</span>
          <router-link
            :to="`/app/job/${job.id}`"
            class="bg-primary text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all"
            >Apply Now</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const jobs = ref([
  {
    id: 1,
    title: "Senior Frontend Developer",
    company: "TechCorp Inc.",
    location: "San Francisco, CA",
    type: "Full-time",
    posted: "2 days ago",
    match: 100,
    salary: "$120k - $150k",
    skills: [
      { name: "React", match: true },
      { name: "TypeScript", match: true },
      { name: "CSS", match: true },
    ],
  },
  {
    id: 2,
    title: "Frontend Engineer",
    company: "StartupXYZ",
    location: "Remote",
    type: "Full-time",
    posted: "5 days ago",
    match: 80,
    salary: "$100k - $130k",
    skills: [
      { name: "React", match: true },
      { name: "Next.js", match: false },
    ],
  },
]);
</script>
