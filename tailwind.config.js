/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/*.php","./public/**/*.php", "./src/**/*.php" ],
  theme: {
    extend: {
      font: {
        "first-font": ['Carter One', 'serif'],
      },
    },
  },
  plugins: [],
}

