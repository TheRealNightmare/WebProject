<template>
  <div>
    <router-link
      to="/app/seeker/dashboard"
      class="inline-flex items-center gap-2 text-dark font-medium mb-6 hover:text-primary transition-colors"
    >
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </router-link>

    <div class="grid grid-cols-1 lg:grid-cols-[2.2fr_1fr] gap-8 items-start">
      <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
        <div class="mb-8">
          <h1 class="text-2xl font-bold text-dark mb-1">
            Senior Frontend Developer
          </h1>
          <p class="text-muted mb-4">TechCorp Inc.</p>
          <div class="flex flex-wrap gap-4 text-sm text-muted font-medium">
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-location-dot"></i> San Francisco, CA</span
            >
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-briefcase"></i> Full-time</span
            >
            <span class="flex items-center gap-1.5"
              ><i class="fa-solid fa-dollar-sign"></i> $120k - $150k</span
            >
          </div>
        </div>

        <div
          class="bg-primary-light border border-primary/10 rounded-xl p-6 flex justify-between items-center mb-8"
        >
          <div>
            <h3 class="text-primary font-bold mb-1">Your Skill Match</h3>
            <p class="text-sm text-primary/80">
              You match 100% of the required skills.
            </p>
          </div>
          <div
            class="w-12 h-12 rounded-full border-4 border-primary flex items-center justify-center text-primary font-bold text-xs bg-white"
          >
            100%
          </div>
        </div>

        <div class="space-y-8">
          <section>
            <h3 class="font-bold text-lg mb-4 text-dark">Job Description</h3>
            <p class="text-muted leading-relaxed mb-4">
              We are seeking an experienced developer...
            </p>
            <h4 class="font-bold text-dark mb-2">Requirements</h4>
            <ul class="list-disc list-inside text-muted space-y-1">
              <li>5+ years of experience</li>
              <li>Strong React & TS skills</li>
            </ul>
          </section>

          <button
            class="w-full py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary-hover shadow-xl shadow-primary/20 transition-all"
          >
            Apply for this Position
          </button>
        </div>
      </div>

      <div
        class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm sticky top-6"
      >
        <h3 class="font-bold text-dark mb-6">Job Summary</h3>
        <div class="space-y-4 mb-6">
          <div v-for="(val, label) in summary" :key="label">
            <label class="block text-xs text-muted mb-1">{{ label }}</label>
            <span class="font-semibold text-dark text-sm">{{ val }}</span>
          </div>
        </div>
        <div class="space-y-3">
          <button
            class="w-full py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover"
          >
            Apply Now
          </button>
          <button
            class="w-full py-2.5 border border-gray-200 text-dark rounded-lg font-medium hover:bg-gray-50"
          >
            Save Job
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const summary = {
  "Posted Date": "2 days ago",
  "Job Type": "Full-time",
  Location: "San Francisco, CA",
  Salary: "$120k - $150k",
};
</script>
