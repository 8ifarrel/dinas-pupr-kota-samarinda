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

      '3xl': '1920px',

      '4xl': '2560px',

      'tv-vertical': {'raw': '(min-width: 1080px) and (min-height: 1920px) and (orientation: portrait)'},
    },
    extend: {
      fontFamily: {
        'sans': ['Sora', 'sans-serif'],
      },
      colors: {
        // Warna Primer
        'primary-yellow': '#f9a825', // Warna kuning cerah
        'primary-navy': '#1a237e',   // Warna biru navy gelap
  
        // Warna Sekunder/Aksen
        'secondary-light-gray': '#f3f4f6', // Warna abu-abu terang
        'secondary-pale-blue': '#dbeafe',  // Warna biru pucat
        'secondary-pale-yellow': '#fef08a', // Warna kuning pucat
        brand: {
          'yellow': 'rgba(252, 183, 23, 1)',
          'blue': 'rgba(34, 52, 104, 1)',
          
        }
      }, 
    },

    
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('tailwindcss-filters'),
    function ({ addComponents, theme }) {
      addComponents({
        '.font-dropcap div:first-of-type::first-letter': {
          '@apply capitalize font-semibold inline-block float-left leading-none': {},
          'fontSize': '4.5rem',
          'letterSpacing': '0.1em',
        },
        '.text-multicol': {
          '@apply text-justify': {},
        },
        '.text-multicol p': {
          '@apply mb-4': {},
        },
      });

      addComponents({
        '@media (min-width: 768px)': {
          '.text-multicol': {
            columnCount: '2',
            columnGap: '2rem',
          },
          '.text-multicol p': {
            breakInside: 'avoid',
            marginBottom: '2rem',
          },
        },
      });
    }
  ],
}
