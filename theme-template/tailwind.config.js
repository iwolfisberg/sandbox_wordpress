/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["../../**/*.{html,twig,php}"],
  theme: {
    container: {
      center: true,
    },
    fontFamily: {
      logo: ["Oi", "serif"],
      heading: ["Zain", "serif"],
      text: ["Roboto Condensed", "serif"],
    },
    extend: {
      colors: {
        primary: "rgb(159 0 27)",
        secondary: "rgb(222 146 57)",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
