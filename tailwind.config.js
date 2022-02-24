module.exports = {
    corePlugins: {
        preflight: false,
    },
    prefix: 'tw-',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        fontFamily: {
            Poppins: ["Poppins, sans-serif"],
            Lato: ["Lato", "sans-serif"],
            primary: ["Lato", "sans-serif"],
            Montserrat: ["Montserrat", "sans-serif"],
            Rubik: ["Rubik", "sans-serif"],
        },
        flex: {
            "1": "1 1 0%",
            "2": "2 2 0%",
        },
        extend: {
            colors: {
                'primary': '#4A9AF8',
                'at-primary': '#90D2F7',
                'light-purple': '#eff0fb',
                'primary-blue': '#336cfb',
            },
            keyframes: {
                'fade-in-down': {
                    "from": {
                        transform: "translateY(-0.75rem)",
                        opacity: '0'
                    },
                    "to": {
                        transform: "translateY(0rem)",
                        opacity: '1'
                    },
                },
            },
            animation: {
                'fade-in-down': "fade-in-down 0.2s ease-in-out both",
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
}
