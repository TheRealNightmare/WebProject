<template>
  <div class="bg-bgbody min-h-screen">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
      <div
        class="max-w-7xl mx-auto px-5 py-4 flex justify-between items-center"
      >
        <a href="#" class="flex items-center gap-2 font-bold text-xl text-dark">
          <i class="fa-solid fa-briefcase text-primary text-2xl"></i>
          <span>JobPortal</span>
        </a>
        <nav class="hidden md:flex gap-8">
          <a
            href="#"
            class="text-muted font-medium hover:text-dark transition-colors"
            >Find Jobs</a
          >
          <a
            href="#"
            class="text-muted font-medium hover:text-dark transition-colors"
            >For Employers</a
          >
          <a
            href="#"
            class="text-muted font-medium hover:text-dark transition-colors"
            >About</a
          >
        </nav>
        <div class="flex items-center gap-4">
          <router-link
            to="/login"
            class="text-primary font-semibold hover:text-primary-hover"
            >Login</router-link
          >
          <router-link
            to="/signup"
            class="bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primary-hover transition-colors"
            >Sign Up</router-link
          >
        </div>
      </div>
    </header>

    <section
      class="bg-[linear-gradient(135deg,_#eef4fc_0%,_#dceced_100%)] py-20 text-center px-4"
    >
      <h1 class="text-4xl md:text-5xl font-bold text-dark mb-4">
        Find Your Dream Job Today
      </h1>
      <p class="text-lg text-muted mb-10">
        Discover thousands of job opportunities with smart skill matching
        technology
      </p>

      <div
        class="bg-white p-2 rounded-xl flex flex-col md:flex-row items-center max-w-3xl mx-auto shadow-lg"
      >
        <div class="flex-1 flex items-center px-4 py-3 w-full">
          <i class="fa-solid fa-magnifying-glass text-muted mr-3"></i>
          <input
            type="text"
            placeholder="Job title or keyword"
            class="w-full outline-none text-dark"
          />
        </div>
        <div class="hidden md:block w-px h-8 bg-gray-200"></div>
        <div
          class="flex-1 flex items-center px-4 py-3 w-full border-t md:border-t-0 border-gray-100"
        >
          <i class="fa-solid fa-location-dot text-muted mr-3"></i>
          <input
            type="text"
            placeholder="Location"
            class="w-full outline-none text-dark"
          />
        </div>
        <button
          class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-primary-hover w-full md:w-auto mt-2 md:mt-0"
        >
          Search
        </button>
      </div>
    </section>
  </div>
</template>
