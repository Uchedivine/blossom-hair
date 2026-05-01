import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#fdf2f8',
                    100: '#fce7f3',
                    200: '#fbcfe8',
                    300: '#f9a8d4',
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
                    700: '#be185d',
                    800: '#9f1239',
                    900: '#831843',
                    950: '#500724',
                },
                cream: '#faf9f7',
            },
            fontFamily: {
                'playfair': ['"Playfair Display"', 'serif'],
                'satisfy': ['Satisfy', 'cursive'],
            },
        },
    },
    plugins: [],
}
