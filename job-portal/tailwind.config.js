/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        // Extracted from your CSS variables
        primary: {
          DEFAULT: "#8b2dfb",
          hover: "#761cdb",
          light: "#f3e8ff",
        },
        dark: "#1f2937",
        muted: "#6b7280",
        bgbody: "#f3f4f6",
        success: "#10b981",
        danger: "#ef4444",
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
      },
    },
  },
  plugins: [],
};
