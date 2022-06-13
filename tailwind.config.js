const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/*.js',
    ],

    theme: {
        colors: {
            'current': 'currentColor',
            'transparent': 'transparent',
            'gray': colors.neutral,

            'purple': '#7413dc',
            'teal': '#00a794',
            'black': '#000000',
            'white': '#ffffff',
            'section-green': '#004851',
            'red': '#e22e12',
            'pink': '#ffb4e5',
            'green': '#23a950',
            'navy': '#003982',
            'blue': '#006ddf',
            'yellow': '#ffe627',
            'grey-5': '#f2f2f2',
            'grey-20': '#cccccc',
            'grey-40': '#999999',
            'grey-60': '#666666',
            'grey-80': '#333333',

            'purple-darkened': '#3a0a6e',
            'teal-darkened': '#005349',
            'red-darkened': '#711709',
            'pink-darkened': '#805a73',
            'green-darkened': '#125528',
            'navy-darkened': '#001d41',
            'blue-darkened': '#003770',
            'yellow-darkened': '#807314',
            'grey-5-darkened': '#797979',
            'grey-20-darkened': '#cccccc',
            'grey-40-darkened': '#666666',
            'grey-60-darkened': '#333333',
            'grey-80-darkened': '#1a1a1a',
        },

        listStyleType: {
            none: 'none',
            square: 'square',
        },

        extend: {
            fontFamily: {
                sans: ['"Nunito Sans"', ...defaultTheme.fontFamily.sans],
            },

            transitionProperty: {
                'border-color': 'border-color',
                'text-color': 'color',
            },

            minWidth: {
                ...defaultTheme.spacing,
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                full: '100%',
                screen: '100vh',

            },

            maxWidth: {
                ...defaultTheme.spacing,
                ...defaultTheme.percentage,
                'xxs': '10rem',
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                full: '100%',
                screen: '100vh',
            },

            minHeight: {
                ...defaultTheme.spacing,
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                full: '100%',
                screen: '100vh',
            },

            maxHeight: {
                ...defaultTheme.spacing,
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                full: '100%',
                screen: '100vh',
            }
        },
    },
};
