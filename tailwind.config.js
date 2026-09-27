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
            colors: {
                "surface": "#f8f9ff",
                "on-primary-container": "#f5fff7",
                "on-error-container": "#93000a",
                "error-container": "#ffdad6",
                "on-surface": "#0d1c2e",
                "on-secondary": "#ffffff",
                "on-secondary-fixed": "#001d31",
                "surface-container-high": "#dce9ff",
                "on-primary-fixed-variant": "#005137",
                "surface-bright": "#f8f9ff",
                "surface-container-low": "#eff4ff",
                "on-background": "#0d1c2e",
                "tertiary-container": "#b15f00",
                "tertiary-fixed": "#ffdcc3",
                "on-primary-fixed": "#002114",
                "outline": "#6d7a72",
                "secondary-fixed": "#cce5ff",
                "inverse-on-surface": "#eaf1ff",
                "outline-variant": "#bccac0",
                "on-tertiary": "#ffffff",
                "on-tertiary-container": "#fffbff",
                "surface-variant": "#d5e3fc",
                "secondary-container": "#5bb8fe",
                "secondary": "#006398",
                "on-primary": "#ffffff",
                "on-error": "#ffffff",
                "secondary-fixed-dim": "#93ccff",
                "inverse-surface": "#233144",
                "on-tertiary-fixed-variant": "#6e3900",
                "primary-fixed-dim": "#68dba9",
                "inverse-primary": "#68dba9",
                "primary-container": "#00855d",
                "background": "#f8f9ff",
                "on-tertiary-fixed": "#2f1500",
                "surface-container-lowest": "#ffffff",
                "primary": "#006948",
                "surface-container": "#e6eeff",
                "surface-container-highest": "#d5e3fc",
                "primary-fixed": "#85f8c4",
                "on-secondary-fixed-variant": "#004b73",
                "tertiary": "#8d4b00",
                "error": "#ba1a1a",
                "on-secondary-container": "#00476e",
                "tertiary-fixed-dim": "#ffb77d",
                "on-surface-variant": "#3d4a42",
                "surface-tint": "#006c4a",
                "surface-dim": "#ccdbf3"
            },
            spacing: {
                "space-md": "0.75rem",
                "space-lg": "1.25rem",
                "space-sm": "0.375rem",
                "margin-mobile": "1rem",
                "gutter-mobile": "0.5rem",
                "gutter": "0.75rem",
                "margin": "1.5rem",
                "space-xl": "1.75rem",
                "space-xs": "0.25rem"
            },
            fontFamily: {
                "headline-sm": ["Hanken Grotesk"],
                "label-sm": ["Geist"],
                "headline-xl-mobile": ["Hanken Grotesk"],
                "body-sm": ["Geist"],
                "headline-md": ["Hanken Grotesk"],
                "body-lg": ["Geist"],
                "headline-xl": ["Hanken Grotesk"],
                "body-md": ["Geist"],
                "label-md": ["Geist"],
                "mono-tabular": ["Geist"],
                "headline-lg": ["Hanken Grotesk"]
            }
        },
    },

    plugins: [forms],
};