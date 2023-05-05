import colors from 'tailwindcss/colors'

/** @type {import('tailwindcss').Config} */
export const darkMode = 'class'

export const content = [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/filament/**/*.blade.php'
]

export const theme = {
    extend: {
        spacing: {
            '22': '5.5rem',
            '35': '8.75rem',
        },
        bottom: {
            '18': '4.5rem',
        },
        colors: {
            slate: {
                ...colors.slate,
                850: '#152033',
            },
            danger: colors.rose,
            primary: colors.blue,
            success: colors.green,
            warning: colors.yellow,
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
}
