/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/*.php","./public/**/*.php", "./src/**/*.php", "./public/assets/scripts/*.js" ],
  theme: {
    extend: {
      font: {
        "first-font": ['Carter One', 'serif'],
      },
    },
  },
  plugins: [],
}

