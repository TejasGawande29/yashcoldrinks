// tailwind.config.js
module.exports = {
    content: ["./public/**/*.html", "./src/**/*.{html,js}"],
    theme: {
      extend: {
        colors: {
          primary: '#1D4ED8',
          secondary: '#9333EA',
        },
        fontFamily: {
          sans: ['Inter', 'sans-serif'],
        },
      },
    },
    darkMode: 'class', // or 'media'
    plugins: [],
  }
  