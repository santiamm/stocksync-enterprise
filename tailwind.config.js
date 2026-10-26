import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Identidad visual: azul petróleo (estructura), ámbar de señalización de bodega (acento),
            // verde y rojo solo para entradas y salidas.
            colors: {
                petroleo: { DEFAULT: '#0E3A47', 600: '#15505F', 300: '#7FA3AD', 50: '#E6EEF0' },
                concreto: '#EDF1F2',
                linea: '#D5DDE0',
                gris: '#5B6B70',
                senal: { DEFAULT: '#F5B301', 50: '#FFF6D6', 700: '#7A5200' },
                entrada: { DEFAULT: '#1F7A55', 50: '#E5F3EC' },
                salida: { DEFAULT: '#B3261E', 50: '#FBE9E7' },
            },
            fontFamily: {
                sans: ['Barlow', ...defaultTheme.fontFamily.sans],
                display: ['"Barlow Condensed"', 'Barlow', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
