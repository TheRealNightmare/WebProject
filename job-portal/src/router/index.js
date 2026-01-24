import { createRouter, createWebHistory } from "vue-router";
import AuthLayout from "../layouts/AuthLayout.vue";
import Login from "../views/auth/Login.vue";
import Signup from "../views/auth/Signup.vue";
import DashboardLayout from "../layouts/DashboardLayout.vue";
import SeekerDashboard from "../views/seeker/Dashboard.vue";
import EmployerJobs from "../views/employer/MyJobs.vue";
import EmployerApplicants from "../views/employer/Applicants.vue";
import AdminDashboard from "../views/admin/Dashboard.vue";
import JobManagement from "../views/admin/JobManagement.vue";
import JobDetails from "../views/seeker/JobDetails.vue";
import MyApplications from "../views/seeker/MyApplications.vue";
import Profile from "../views/seeker/Profile.vue";
import Settings from "../views/Settings.vue";

const routes = [
  {
    path: "/",
    component: AuthLayout,
    children: [
      {
        path: "", // Default path "/" matches here
        redirect: "login", // Redirect to /login
      },
      {
        path: "login",
        name: "Login",
        component: Login,
      },
      {
        path: "signup",
        name: "Signup",
        component: Signup,
      },
    ],
  },
  {
    path: "/app",
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: "seeker/dashboard",
        component: SeekerDashboard,
        meta: { role: "seeker" },
      },
      {
        path: "job/:id",
        component: JobDetails,
        meta: { role: "seeker" },
      },
      {
        path: "seeker/applications",
        component: MyApplications,
        meta: { role: "seeker" },
      },
      {
        path: "seeker/profile",
        component: Profile,
        meta: { role: "seeker" },
      },
      {
        path: "employer/jobs",
        component: EmployerJobs,
        meta: { role: "employer" },
      },
      {
        path: "employer/applicants",
        component: EmployerApplicants,
        meta: { role: "employer" },
      },
      {
        path: "admin/dashboard",
        component: AdminDashboard,
        meta: { role: "admin" },
      },
      {
        path: "admin/jobs",
        component: JobManagement,
        meta: { role: "admin" },
      },
    ],
  },
  // {
  //   path: "/app",
  //   component: DashboardLayout,
  //   meta: { requiresAuth: true },
  //   children: [
  //     // ... existing seeker routes ...
  //     {
  //       path: "seeker/settings",
  //       component: Settings,
  //       meta: { role: "seeker" }, // Keeps Seeker sidebar active
  //     },

  //     // ... existing employer routes ...
  //     {
  //       path: "employer/settings",
  //       component: Settings,
  //       meta: { role: "employer" }, // Keeps Employer sidebar active
  //     },

  //     // ... existing admin routes ...
  //     {
  //       path: "admin/settings",
  //       component: Settings,
  //       meta: { role: "admin" }, // Keeps Admin sidebar active
  //     },
  //   ],
  // },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Simple navigation guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  if (to.meta.requiresAuth && !token) {
    next("/login");
  } else {
    next();
  }
});

export default router;
