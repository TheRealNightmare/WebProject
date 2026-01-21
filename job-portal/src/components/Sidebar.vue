<template>
  <aside
    class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200 hidden md:flex flex-col p-6 z-50"
  >
    <div class="flex items-center gap-2 font-bold text-xl text-primary mb-12">
      <i :class="roleIcon" class="text-xl"></i>
      <span>{{ roleTitle }}</span>
    </div>

    <nav class="flex flex-col gap-2 flex-1">
      <router-link
        v-for="(item, index) in menuItems"
        :key="index"
        :to="item.link"
        active-class="bg-primary-light text-primary font-semibold"
        class="flex items-center px-4 py-3 text-muted hover:bg-gray-100 hover:text-dark rounded-lg transition-colors group"
      >
        <i
          :class="item.icon"
          class="w-6 text-lg mr-2 transition-transform group-hover:scale-110"
        ></i>
        <span>{{ item.label }}</span>
        <span
          v-if="item.badge"
          class="ml-auto bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-xl"
          >{{ item.badge }}</span
        >
      </router-link>
    </nav>

    <div class="mt-auto pt-6 border-t border-gray-200">
      <router-link
        to="/login"
        class="flex items-center text-danger hover:text-red-700 font-medium gap-3 px-4 py-2 transition-colors"
      >
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <span>Logout</span>
      </router-link>
    </div>
  </aside>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const currentRole = computed(() => route.meta.role || "seeker");

const roleTitle = computed(() =>
  currentRole.value === "admin" ? "Admin Panel" : "JobPortal",
);
const roleIcon = computed(() =>
  currentRole.value === "admin"
    ? "fa-solid fa-shield-halved"
    : "fa-solid fa-briefcase",
);

const menuItems = computed(() => {
  if (currentRole.value === "admin") {
    return [
      {
        label: "User Management",
        icon: "fa-solid fa-users",
        link: "/app/admin/dashboard",
      },
      {
        label: "Job Management",
        icon: "fa-solid fa-file-lines",
        link: "/app/admin/jobs",
      },
      { label: "Settings", icon: "fa-solid fa-gear", link: "#" },
    ];
  } else if (currentRole.value === "employer") {
    return [
      {
        label: "My Job Posts",
        icon: "fa-solid fa-briefcase",
        link: "/app/employer/jobs",
        badge: "3",
      },
      {
        label: "Applicants",
        icon: "fa-solid fa-user-group",
        link: "/app/employer/applicants",
        badge: "4",
      },
      { label: "Settings", icon: "fa-solid fa-gear", link: "#" },
    ];
  } else {
    return [
      {
        label: "Browse Jobs",
        icon: "fa-solid fa-house",
        link: "/app/seeker/dashboard",
      },
      {
        label: "My Applications",
        icon: "fa-solid fa-file-lines",
        link: "/app/seeker/applications",
      },
      {
        label: "My Profile",
        icon: "fa-regular fa-user",
        link: "/app/seeker/profile",
      },
      {
        label: "Settings",
        icon: "fa-solid fa-gear",
        link: "/app/seeker/settings",
      },
    ];
  }
});
</script>
