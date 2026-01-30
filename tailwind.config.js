export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: [
        "bg-yellow-100",
        "text-yellow-700",
        "bg-green-100",
        "text-green-700",
        "bg-blue-100",
        "text-blue-700",
        "bg-red-100",
        "text-red-700",
        "bg-gray-100",
        "text-gray-700",
        "bg-purple-100",
    ],
    theme: {
        screens: {
            sm: "640px",
            md: "768px",
            lg: "1024px",
            xl: "1280px",
        },
    },

    plugins: [],
};
