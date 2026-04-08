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
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'system-ui', 'sans-serif'],
            },
            fontSize: {
                '12': '12px',
            },
            colors: {
                'primary': '#004161',
                'primary-dark': '#003451',
                'accent': '#99CC33',
                'background': '#F5F7FA',
                'border': '#E5E7EB',
                'error': '#004161',
                'success': '#99CC33',
                'warning': '#004161',
                'info': '#004161',
                'text-primary': '#1F2937',
                'text-secondary': '#6B7280',
                'brand': {
                    'bg': '#F3F4F6',
                    'surface': '#FFFFFF',
                    'border': '#E5E7EB',
                    'text': '#1F2937',
                },
            },
        },
    },

    plugins: [forms],
};
