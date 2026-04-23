/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#004e98',
        secondary: '#3a6ea5',
        accent: '#ffe700',
        light: '#ebebeb',
        silver: '#c0c0c0',
      }
    },
  },
  plugins: [],
}
