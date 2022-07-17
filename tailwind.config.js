const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                black: colors.black,
                white: colors.white,
                gray: colors.coolGray,
                red: colors.red,
                yellow: colors.amber,
                blue: colors.blue,
                custoum: '#e3e3e3',
                brand : "#02A8A8",
                hoverColor : "#069e9e",
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
