import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './vendor/filament/**/*.blade.php',
        './app/Filament/**/*.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            spacing: {
                '22': '5.5rem',
                '35': '8.75rem',
            },
            fontSize: {
                'xss': '.6875rem',
                'xxs': '.65rem',
            },
            bottom: {
                '18': '4.5rem',
            },
            colors: {
                slate: {
                    ...colors.slate,
                    850: '#152033',
                },
                gray: colors.slate,
                danger: colors.rose,
                primary: colors.blue,
                success: colors.emerald,
                warning: colors.orange,
            }
        },
    },
    plugins: [
        forms,
        typography,
    ],
}
