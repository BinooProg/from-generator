// Theme toggle functionality
document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("themeToggle");
    const html = document.documentElement;

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem("theme") || "light";

    // Apply the saved theme
    if (currentTheme === "dark") {
        html.classList.add("dark");
    } else {
        html.classList.remove("dark");
    }

    // Toggle theme on button click
    themeToggle.addEventListener("click", () => {
        html.classList.toggle("dark");

        // Save the preference
        const theme = html.classList.contains("dark") ? "dark" : "light";
        localStorage.setItem("theme", theme);
    });
});
