module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {},
    },
    plugins: [require("daisyui")],
    daisyui: {
      themes: ['light', 'dark', 'night', 'cupcake', 'lemonade', 'dracula', 'abyss', 'acid'],
    },
  }  