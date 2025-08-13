/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#1E3A8A", // Dark blue
                secondary: "#3B82F6", // Bright blue
                lightblue: "#E0F2FE", // Light blue background
                textgray: "#374151", // Dark gray for text
            },
        },
    },
    plugins: [],
};
