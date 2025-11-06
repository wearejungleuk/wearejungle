const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: [
    "./resources/views/**/*.antlers.html",
    "./resources/views/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./content/**/*.md",
    "./content/**/*.yaml",
    "./resources/blueprints/**/*.yaml",
  ],
  theme: {
    extend: {
      colors: {
        "brand-primary": "rgba(var(--color-brand-primary), <alpha-value>)",
        "brand-light-blue": "rgba(var(--color-brand-light-blue), <alpha-value>)",
        "brand-dark-blue": "rgba(var(--color-brand-dark-blue), <alpha-value>)",
        "brand-dark-blue-two": "rgba(var(--color-brand-dark-blue-two), <alpha-value>)",
        "brand-secondary": "rgba(var(--color-brand-secondary), <alpha-value>)",
        "brand-text": "rgba(var(--color-brand-text), <alpha-value>)",
        "black": "rgba(var(--color-black), <alpha-value>)",
        "white": "rgba(var(--color-white), <alpha-value>)",
      },
      fontFamily: {
        heading: ["Fivo Sans Modern ExtBlk", ...defaultTheme.fontFamily.serif],
        body: ["Lexend", ...defaultTheme.fontFamily.sans],
        bodybold: ["Lexend Bold", ...defaultTheme.fontFamily.sans],
        subtitle: ["Ewangi", ...defaultTheme.fontFamily.sans],
      },
      animation: {
        marquee: 'marquee 55s linear infinite',
        marquee2: 'marquee2 55s linear infinite',
        marqueeQuick: 'marquee 25s linear infinite',
        marqueeQuick2: 'marquee2 25s linear infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-100%)' },
        },
        marquee2: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0%)' },
        },
        marqueeQuick: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-100%)' },
        },
        marqueeQuick2: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0%)' },
        },
      },
    },
  },
  plugins: [
    require("@tailwindcss/aspect-ratio"),
    require("tailwindcss-debug-screens"),
    require("@tailwindcss/forms")({
      strategy: "class",
    }),
  ],
};
