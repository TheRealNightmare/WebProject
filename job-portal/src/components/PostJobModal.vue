<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-black/50 flex justify-center items-center p-5 z-[100] backdrop-blur-sm"
  >
    <div
      class="bg-white w-full max-w-2xl rounded-xl p-8 shadow-2xl animate-[fadeIn_0.3s_ease-out]"
    >
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-dark">Post New Job</h3>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-dark text-lg"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form @submit.prevent="$emit('submit')">
        <div class="space-y-5">
          <div>
            <label class="block text-sm text-muted mb-1.5">Job Title</label>
            <input
              type="text"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
              placeholder="e.g. Senior Frontend Developer"
            />
          </div>

          <div>
            <label class="block text-sm text-muted mb-1.5">Description</label>
            <textarea
              rows="4"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
            ></textarea>
          </div>

          <div class="grid grid-cols-2 gap-5">
            <div>
              <label class="block text-sm text-muted mb-1.5">Location</label>
              <input
                type="text"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
                placeholder="e.g. Remote"
              />
            </div>
            <div>
              <label class="block text-sm text-muted mb-1.5"
                >Salary Range</label
              >
              <input
                type="text"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
                placeholder="$100k - $120k"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm text-muted mb-1.5"
              >Required Skills</label
            >
            <div class="flex gap-2">
              <input
                type="text"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
                placeholder="Add skill..."
              />
              <button
                type="button"
                class="px-5 py-2.5 bg-primary text-white font-semibold rounded-lg hover:bg-primary-hover"
              >
                Add
              </button>
            </div>
          </div>
        </div>

        <div class="flex gap-3 mt-8">
          <button
            type="submit"
            class="flex-[3] py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all"
          >
            Post Job
          </button>
          <button
            type="button"
            @click="$emit('close')"
            class="flex-1 py-3 bg-gray-200 text-dark rounded-lg font-semibold hover:bg-gray-300 transition-all"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
defineProps({ isOpen: Boolean });
defineEmits(["close", "submit"]);
</script>
