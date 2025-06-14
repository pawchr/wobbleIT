/** @type {import('tailwindcss').Config} */
// tailwind.config.js
module.exports = {
  content: ['./templates/**/*.html.twig', './assets/**/*.js'],
  theme: {
    extend: {
      colors: {
        primary: '#E4572E',
        dark: '#171A21',
        light: '#CBBFBB',
        muted: '#736F4E',
        base: '#3B3923',
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.25rem',
      },
    },
  },
  plugins: [],
}
