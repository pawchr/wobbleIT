/** @type {import('tailwindcss').Config} */
// tailwind.config.js
module.exports = {
  content: ['./templates/**/*.html.twig', './assets/**/*.js'],
  theme: {
    extend: {
      colors: {
        primarybg: '#e5e7eb',
        alert: '#E4572E',
        textsecondary: '#737373',
        buttonprimary: '#3B3923',
        accent:'#736F4E',
        silver: '#CBBFBB',
        darkgreen: '#3B3923',
        
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.25rem',
      },
      fontFamily: {
        heading: ['Poppins', 'sans-serif'],
        body: ['Roboto', 'sans-serif'],
      },
    },
  },
  plugins: [],
}