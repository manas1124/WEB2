 /** @type {import('tailwindcss').Config} */
 export default {
  content: [
    "./Source/**/*.{html,js,jsx,ts,tsx,php}", // Check this line!
    "./index.html",
    "./node_modules/flyonui/dist/js/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("flyonui"),
    require("flyonui/plugin") // Require only if you want to use FlyonUI JS component
  ]
}