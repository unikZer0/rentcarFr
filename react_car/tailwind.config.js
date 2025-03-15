/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
    "./public/index.html",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#ff4d30",
        secondary: "#010103",
        orange: {
          500: "#ff4d30",
          600: "#e6441b",
          700: "#d13d19",
        },
        gray: {
          light: "#f8f8f8",
          dark: "#706f7b",
        },
    },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/line-clamp'),
  ],
} 
