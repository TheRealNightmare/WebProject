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
        v-for="stat in stats"
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
          class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-muted text-sm"
        ></i>
        <input
          type="text"
          placeholder="Search users..."
          class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary outline-none"
        />
      </div>
      <div class="flex gap-2 bg-white p-1 rounded-lg border border-gray-200">
        <button
          v-for="tab in ['All', 'Job Seekers', 'Employers']"
          :key="tab"
          class="px-4 py-1.5 text-xs font-medium rounded-md transition-all hover:bg-gray-50 focus:bg-primary focus:text-white"
        >
          {{ tab }}
        </button>
      </div>
    </div>

    <div
      class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
    >
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th
              v-for="h in [
                'Name',
                'Email',
                'Type',
                'Joined',
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
            v-for="user in users"
            :key="user.email"
            class="border-b border-gray-100 last:border-0 hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-sm font-medium text-dark">
              {{ user.name }}
            </td>
            <td class="px-6 py-4 text-sm text-muted">{{ user.email }}</td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'px-2.5 py-1 rounded-full text-xs font-semibold',
                  user.type === 'Job Seeker'
                    ? 'bg-teal-100 text-teal-800'
                    : 'bg-purple-100 text-purple-800',
                ]"
                >{{ user.type }}</span
              >
            </td>
            <td class="px-6 py-4 text-sm text-muted">{{ user.date }}</td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'px-2.5 py-1 rounded-full text-xs font-semibold',
                  user.status === 'Active'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800',
                ]"
                >{{ user.status }}</span
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
const stats = [
  {
    label: "Total Users",
    val: "6",
    icon: "fa-solid fa-users",
    color: "text-primary",
  },
  {
    label: "Job Seekers",
    val: "4",
    icon: "fa-solid fa-user-group",
    color: "text-teal-600",
  },
  {
    label: "Employers",
    val: "2",
    icon: "fa-solid fa-briefcase",
    color: "text-primary",
  },
  {
    label: "Active Jobs",
    val: "3/4",
    icon: "fa-regular fa-file-lines",
    color: "text-orange-600",
  },
];
const users = ref([
  {
    name: "John Smith",
    email: "john@email.com",
    type: "Job Seeker",
    date: "2024-01-15",
    status: "Active",
  },
  {
    name: "TechCorp Inc.",
    email: "hr@techcorp.com",
    type: "Employer",
    date: "2024-01-10",
    status: "Active",
  },
  {
    name: "Emily Davis",
    email: "emily@email.com",
    type: "Job Seeker",
    date: "2024-03-12",
    status: "Suspended",
  },
]);
</script>
