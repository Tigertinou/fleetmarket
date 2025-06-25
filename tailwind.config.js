const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: {
          DEFAULT: '#0d9488',
          dark: '#0f766e',
          light: '#5eead4',
        },
      },
    },
  },
  safelist: [
    'bg-theme',
    'bg-theme-2',
    'bg-efficiency-A',
    'bg-efficiency-B',
    'bg-efficiency-C',
    'bg-efficiency-D',
    'bg-efficiency-E',
    'bg-efficiency-F',
    'bg-efficiency-G',
    'fill-efficiency-A',
    'fill-efficiency-B',
    'fill-efficiency-C',
    'fill-efficiency-D',
    'fill-efficiency-E',
    'fill-efficiency-F',
    'fill-efficiency-G',
  ],
  plugins: [],
}
