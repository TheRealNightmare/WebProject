<template>
  <div class="max-w-3xl mx-auto">
    <router-link
      to="/app/seeker/dashboard"
      class="inline-flex items-center gap-2 text-muted mb-6 hover:text-dark"
    >
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </router-link>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
      <div class="mb-6 pb-6 border-b border-gray-100">
        <h1 class="text-xl font-bold text-dark mb-1">Job Seeker Profile</h1>
        <p class="text-sm text-muted">Manage your profile information</p>
      </div>

      <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div
            v-for="field in ['Full Name', 'Email', 'Phone', 'Location']"
            :key="field"
          >
            <label class="block text-sm text-muted mb-1.5">{{ field }}</label>
            <input
              type="text"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all"
            />
          </div>
        </div>

        <div>
          <label class="block text-sm text-muted mb-1.5">Skills</label>
          <div class="flex gap-2 mb-3">
            <input
              type="text"
              class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
              placeholder="Add skill..."
            />
            <button
              type="button"
              class="px-5 py-2.5 bg-primary text-white font-medium rounded-lg hover:bg-primary-hover"
            >
              Add
            </button>
          </div>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="tag in ['React', 'Vue', 'CSS']"
              :key="tag"
              class="px-3 py-1 bg-primary-light text-primary rounded-full text-sm font-medium flex items-center gap-2"
            >
              {{ tag }}
              <i
                class="fa-solid fa-xmark cursor-pointer hover:text-primary-hover"
              ></i>
            </span>
          </div>
        </div>

        <div>
          <label class="block text-sm text-muted mb-1.5">Resume</label>
          <div
            class="border-2 border-dashed border-gray-200 rounded-lg p-6 bg-gray-50 flex justify-between items-center"
          >
            <div class="flex items-center gap-3">
              <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
              <span class="text-sm font-medium text-dark">resume.pdf</span>
            </div>
            <i
              class="fa-solid fa-xmark text-muted cursor-pointer hover:text-danger"
            ></i>
          </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex gap-4">
          <button
            class="flex-1 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover shadow-lg shadow-primary/20"
          >
            Save Changes
          </button>
          <button
            type="button"
            class="px-6 py-3 border border-gray-200 text-dark rounded-lg font-medium hover:bg-gray-50"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
