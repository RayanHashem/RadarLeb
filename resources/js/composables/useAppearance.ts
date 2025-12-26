// Minimal theme initializer to prevent Vite build failure.
// Replace with real theme logic later if the project needs it.
export function initializeTheme() {
  try {
    // Example: ensure no crash on first load
    // You can add dark-mode logic here later.
    document.documentElement.classList.toggle("dark", false);
  } catch {
    // ignore
  }
}
