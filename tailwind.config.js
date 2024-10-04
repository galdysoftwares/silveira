/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // You will probably also need those lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {},
    },
    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#2094f3",  /* Dark Blue */
                    "primary-focus": "#1779d2",  /* Slightly Brighter Blue for Focus */
                    "primary-content": "#ffffff",  /* White Text for Primary */
                    secondary: "#6c757d",  /* Light Gray */
                    "secondary-focus": "#5a626a",  /* Slightly Darker Gray for Focus */
                    "secondary-content": "#ffffff",  /* White Text for Secondary */
                    accent: "#37cdbe",  /* Lighter Blue (can be used for highlights) */
                    "accent-focus": "#2aa79b",  /* Slightly Brighter Blue for Focus */
                    "accent-content": "#ffffff",  /* White Text for Accent */
                    neutral: "#212529",   /* Dark Gray for Background */
                    "neutral-focus": "#1e2124",   /* Slightly Darker Gray for Focus */
                    "neutral-content": "#ffffff",  /* White Text for Background */
                    "base-100": "#212529",   /* Dark Gray (same as neutral) */
                    "base-200": "#343a40",   /* Slightly Darker Gray */
                    "base-300": "#474d53",   /* Even Darker Gray */
                    "base-content": "#ffffff",  /* White Text for Base */
                    info: "#6fb3e0",     /* Lighter Blue for Info */
                    success: "#28a745",   /* Green for Success */
                    warning: "#ffc107",   /* Orange for Warning */
                    error: "#dc3545",    /* Red for Error */
                },
            },
            'business'
        ],
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}
