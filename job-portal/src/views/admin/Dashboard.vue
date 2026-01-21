<template>
  <div>
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-2xl font-bold text-dark mb-1">Admin Dashboard</h1>
        <p class="text-muted text-sm">Manage users and job listings</p>
      </div>
      <div
        class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold text-sm"
      >
        A
      </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <div
        class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex justify-between items-start"
        v-for="stat in statsDisplay"
        :key="stat.label"
      >
        <div>
          <p
            class="text-muted text-xs mb-2 uppercase tracking-wide font-semibold"
          >
            {{ stat.label }}
          </p>
          <h3 class="text-2xl font-bold text-dark">{{ stat.val }}</h3>
        </div>
        <i :class="[stat.icon, stat.color, 'text-2xl']"></i>
      </div>
    </div>

    <div class="flex justify-between items-center mb-6">
      <div class="relative w-80">
        <i
          class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-muted text-sm"
        ></i>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search users..."
          class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary outline-none"
        />
      </div>
      <div class="flex gap-2 bg-white p-1 rounded-lg border border-gray-200">
        <button
          v-for="tab in ['All', 'seeker', 'employer']"
          :key="tab"
          @click="currentFilter = tab"
          :class="[
            'px-4 py-1.5 text-xs font-medium rounded-md transition-all capitalize',
            currentFilter === tab
              ? 'bg-primary text-white'
              : 'hover:bg-gray-50',
          ]"
        >
          {{ tab === "All" ? "All Users" : tab + "s" }}
        </button>
      </div>
    </div>

    <div v-if="loading" class="text-center py-8 text-muted">
      Loading data...
    </div>

    <div
      v-else
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto"
    >
      <table class="w-full text-left border-collapse min-w-[700px]">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Name
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Email
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Role
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Joined
            </th>
            <th class="px-6 py-4 text-xs font-bold text-dark uppercase">
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in filteredUsers"
            :key="user.id"
            class="border-b border-gray-100 last:border-0 hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-sm font-medium text-dark">
              {{ user.name }}
            </td>
            <td class="px-6 py-4 text-sm text-muted">{{ user.email }}</td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'px-2.5 py-1 rounded-full text-xs font-semibold capitalize',
                  user.role === 'seeker'
                    ? 'bg-teal-100 text-teal-800'
                    : user.role === 'employer'
                      ? 'bg-purple-100 text-purple-800'
                      : 'bg-gray-100',
                ]"
              >
                {{ user.role }}
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-muted">
              {{ new Date(user.created_at).toLocaleDateString() }}
            </td>
            <td class="px-6 py-4 flex gap-3">
              <button
                @click="deleteUser(user.id)"
                class="text-red-500 hover:text-red-700"
                title="Delete User"
              >
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        v-if="filteredUsers.length === 0"
        class="text-center py-8 text-muted"
      >
        No users found.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import api from "../../api";

const users = ref([]);
const stats = ref({
  total_users: 0,
  seekers: 0,
  employers: 0,
  active_jobs: 0,
});
const loading = ref(true);
const searchQuery = ref("");
const currentFilter = ref("All");

const statsDisplay = computed(() => [
  {
    label: "Total Users",
    val: stats.value.total_users,
    icon: "fa-solid fa-users",
    color: "text-primary",
  },
  {
    label: "Job Seekers",
    val: stats.value.seekers,
    icon: "fa-solid fa-user-group",
    color: "text-teal-600",
  },
  {
    label: "Employers",
    val: stats.value.employers,
    icon: "fa-solid fa-briefcase",
    color: "text-primary",
  },
  {
    label: "Total Jobs",
    val: stats.value.active_jobs,
    icon: "fa-regular fa-file-lines",
    color: "text-orange-600",
  },
]);

const filteredUsers = computed(() => {
  return users.value.filter((user) => {
    const matchesSearch =
      user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      user.email.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesFilter =
      currentFilter.value === "All" || user.role === currentFilter.value;

    return matchesSearch && matchesFilter;
  });
});

const fetchData = async () => {
  loading.value = true;
  try {
    const [statsRes, usersRes] = await Promise.all([
      api.get("/admin/stats"),
      api.get("/admin/users"),
    ]);
    stats.value = statsRes.data;
    users.value = usersRes.data;
  } catch (error) {
    console.error("Error fetching admin data", error);
  } finally {
    loading.value = false;
  }
};

const deleteUser = async (id) => {
  if (
    !confirm(
      "Are you sure you want to delete this user? This action cannot be undone.",
    )
  )
    return;

  try {
    await api.delete(`/admin/users/${id}`);
    users.value = users.value.filter((u) => u.id !== id);
    // Refresh stats after deletion
    const statsRes = await api.get("/admin/stats");
    stats.value = statsRes.data;
  } catch (error) {
    console.error("Error deleting user", error);
    alert("Failed to delete user");
  }
};

onMounted(() => {
  fetchData();
});
</script>
