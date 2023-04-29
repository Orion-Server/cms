import colors from 'tailwindcss/colors'

/** @type {import('tailwindcss').Config} */
export const darkMode = 'class'

export const content = [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
]

export const theme = {
    extend: {
        spacing: {
            '22': '5.5rem',
            '35': '8.75rem',
        },
        colors: {
            slate: {
                ...colors.slate,
                850: '#152033',
            }
        },
    },
    plugins: [],
}
