<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-black/50 flex justify-center items-center p-5 z-[100] transition-opacity backdrop-blur-sm"
  >
    <div
      class="bg-white w-full max-w-xl rounded-xl p-8 shadow-2xl animate-[fadeIn_0.3s_ease-out]"
    >
      <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-bold text-dark">Apply for {{ jobTitle }}</h3>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-dark text-lg"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div
        class="bg-primary-light text-primary px-4 py-3 rounded-lg text-sm font-medium mb-6"
      >
        Your skill match: <span class="font-bold">{{ match }}%</span>
      </div>

      <form @submit.prevent="$emit('submit')">
        <div class="mb-6">
          <label class="block text-sm text-muted mb-2">Cover Letter</label>
          <textarea
            class="w-full p-3 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none h-32 resize-none transition-all"
            placeholder="Tell us why you're a great fit..."
          ></textarea>
        </div>
        <div class="mb-6">
          <label class="block text-sm text-muted mb-2">Resume</label>
          <div
            class="border-2 border-dashed border-gray-200 rounded-lg py-8 text-center hover:border-primary/50 hover:bg-gray-50 transition-all cursor-pointer"
          >
            <i
              class="fa-solid fa-arrow-up-from-bracket text-2xl text-gray-400 mb-2"
            ></i>
            <p class="text-sm text-dark font-medium">Upload Resume</p>
            <p class="text-xs text-muted">PDF, DOC (Max 5MB)</p>
          </div>
        </div>
        <div class="flex gap-3 mt-8">
          <button
            type="submit"
            class="flex-1 py-3 bg-primary text-white rounded-md font-semibold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all"
          >
            Submit Application
          </button>
          <button
            type="button"
            @click="$emit('close')"
            class="px-6 py-3 border border-gray-200 rounded-md font-medium text-dark hover:bg-gray-50 transition-all"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
defineProps({ isOpen: Boolean, jobTitle: String, match: Number });
defineEmits(["close", "submit"]);
</script>
