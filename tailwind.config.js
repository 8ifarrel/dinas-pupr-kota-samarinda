/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'false',

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    screens: {  
      'xs': '360px',  // untuk beberapa mobile

      'sm': '640px',

      'md': '768px',

      'lg': '1024px',

      'xl': '1280px',

      '2xl': '1536px',

      '3xl': '1920px', // untuk TV
    },
    extend: {
      height: { // dvh
        dscreen: '100dvh',
      },
      fontFamily: {
        'sans': ['Inter', 'sans-serif'],
      },
      colors: {
        'yellow': 'rgba(252, 183, 23, 1)',
        'blue': 'rgba(34, 52, 104, 1)',
      }, 
    },

    
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('tailwindcss-filters')
  ],
}