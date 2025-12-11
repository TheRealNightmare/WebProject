import { createRouter, createWebHistory } from "vue-router";

// Layouts
import DashboardLayout from "../layouts/DashboardLayout.vue";

// Views
import Landing from "../views/Landing.vue";
import Login from "../views/auth/Login.vue";
import Signup from "../views/auth/Signup.vue";
import SeekerDashboard from "../views/seeker/Dashboard.vue";
import SeekerApplications from "../views/seeker/MyApplications.vue";
import SeekerProfile from "../views/seeker/Profile.vue";
import JobDetails from "../views/seeker/JobDetails.vue";
import EmployerJobs from "../views/employer/MyJobs.vue";
import EmployerApplicants from "../views/employer/Applicants.vue";
import AdminDashboard from "../views/admin/Dashboard.vue";
import AdminJobs from "../views/admin/JobManagement.vue";

const routes = [
  { path: "/", component: Landing },
  { path: "/login", component: Login },
  { path: "/signup", component: Signup },

  // App Routes (Protected)
  {
    path: "/app",
    component: DashboardLayout,
    children: [
      // Seeker
      {
        path: "seeker/dashboard",
        component: SeekerDashboard,
        meta: { role: "seeker" },
      },
      {
        path: "seeker/applications",
        component: SeekerApplications,
        meta: { role: "seeker" },
      },
      {
        path: "seeker/profile",
        component: SeekerProfile,
        meta: { role: "seeker" },
      },
      { path: "job/:id", component: JobDetails, meta: { role: "seeker" } },

      // Employer
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

      // Admin
      {
        path: "admin/dashboard",
        component: AdminDashboard,
        meta: { role: "admin" },
      },
      { path: "admin/jobs", component: AdminJobs, meta: { role: "admin" } },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
