module.exports = {
    prefix: 'tw-',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            color: {
                'primary': '#4A9AF8',
                'at-primary': '#90D2F7',
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
    plugins: [],
}
