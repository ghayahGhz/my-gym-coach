/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'mgc-purple': '#896CFE',  // اللون الأساسي (أنثى)
        'mgc-lime': '#E2F163',    // لون التنبيهات والذكر
        'mgc-black': '#232323',   // الخلفية
        'mgc-white': '#FFFFFF',   // النصوص
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'], // للعناوين [cite: 208]
        'spartan': ['League Spartan', 'sans-serif'], // للنصوص [cite: 208]
      }
    },
  },
  plugins: [],
}