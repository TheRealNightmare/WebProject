<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-black/50 flex justify-center items-center p-5 z-[100] backdrop-blur-sm"
  >
    <div
      class="bg-white w-full max-w-2xl rounded-xl p-8 shadow-2xl animate-[fadeIn_0.3s_ease-out] overflow-y-auto max-h-[90vh]"
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

      <form @submit.prevent="submitJob">
        <div class="space-y-5">
          <div>
            <label class="block text-sm text-muted mb-1.5">Job Title</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
            />
          </div>

          <div>
            <label class="block text-sm text-muted mb-1.5">Description</label>
            <textarea
              v-model="form.description"
              required
              rows="4"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
            ></textarea>
          </div>

          <div class="grid grid-cols-2 gap-5">
            <div>
              <label class="block text-sm text-muted mb-1.5">Location</label>
              <input
                v-model="form.location"
                type="text"
                required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
              />
            </div>
            <div>
              <label class="block text-sm text-muted mb-1.5"
                >Salary Range</label
              >
              <input
                v-model="form.salary"
                type="text"
                required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
                placeholder="$100k - $120k"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm text-muted mb-1.5">Type</label>
            <select
              v-model="form.type"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
            >
              <option value="Full-time">Full-time</option>
              <option value="Part-time">Part-time</option>
              <option value="Contract">Contract</option>
            </select>
          </div>

          <div>
            <label class="block text-sm text-muted mb-1.5"
              >Required Skills</label
            >
            <div class="flex gap-2 mb-2">
              <select
                v-model="selectedSkill"
                @change="addSkill"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-primary outline-none"
              >
                <option value="" disabled>Select a skill...</option>
                <option
                  v-for="skill in availableSkills"
                  :key="skill.id"
                  :value="skill.name"
                >
                  {{ skill.name }}
                </option>
              </select>
            </div>

            <div class="flex flex-wrap gap-2">
              <span
                v-for="(s, index) in form.skills"
                :key="index"
                class="bg-gray-200 px-3 py-1 rounded-full text-sm flex items-center gap-2"
              >
                {{ s }}
                <button
                  type="button"
                  @click="form.skills.splice(index, 1)"
                  class="text-red-500 hover:text-red-700"
                >
                  &times;
                </button>
              </span>
            </div>
          </div>
        </div>

        <div v-if="error" class="text-red-500 mt-4 text-sm">{{ error }}</div>

        <div class="flex gap-3 mt-8">
          <button
            :disabled="loading"
            type="submit"
            class="flex-[3] py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all disabled:opacity-50"
          >
            {{ loading ? "Posting..." : "Post Job" }}
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
import { ref, reactive, onMounted } from "vue";
import api from "../api";

defineProps({ isOpen: Boolean });
const emit = defineEmits(["close", "jobPosted"]);

const loading = ref(false);
const error = ref("");
const selectedSkill = ref("");
const availableSkills = ref([]);

const form = reactive({
  title: "",
  description: "",
  location: "",
  salary: "",
  type: "Full-time",
  skills: [],
});

onMounted(async () => {
  try {
    const response = await api.get("/skills");
    availableSkills.value = response.data;
  } catch (err) {
    console.error("Failed to fetch skills", err);
  }
});

const addSkill = () => {
  if (selectedSkill.value && !form.skills.includes(selectedSkill.value)) {
    form.skills.push(selectedSkill.value);
  }
  selectedSkill.value = ""; // Reset dropdown
};

const submitJob = async () => {
  loading.value = true;
  error.value = "";
  try {
    await api.post("/employer/jobs", form);
    // Reset form
    Object.assign(form, {
      title: "",
      description: "",
      location: "",
      salary: "",
      type: "Full-time",
      skills: [],
    });
    emit("jobPosted");
  } catch (err) {
    error.value = err.response?.data?.message || "Failed to post job";
  } finally {
    loading.value = false;
  }
};
</script>
