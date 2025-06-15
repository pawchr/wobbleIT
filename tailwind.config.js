/** @type {import('tailwindcss').Config} */
// tailwind.config.js
module.exports = {
  content: ['./templates/**/*.html.twig', './assets/**/*.js'],
  theme: {
    extend: {
      colors: {
        orange: '#E4572E',
        dark: '#171A21',
        silver: '#CBBFBB',
        lightgreen: '#736F4E',
        darkgreen: '#3B3923',
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.25rem',
      },
    },
  },
  plugins: [],
}