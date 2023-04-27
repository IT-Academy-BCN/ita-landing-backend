/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      "completed": "#bedfc8",
      "building": "#f8e9b9",
      "soon": "#f7cbc4",
      "projects-title": "#1c1c1e",
      "grey-it": "#7e7e7e",
    },
    extend: {},
  },
  plugins: [
    require("daisyui"),
  ],
}


