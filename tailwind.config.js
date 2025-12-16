/**
 * Tailwind configuration for this project.
 * Scans blade/php/js files and provides a small 'danger' color palette
 * to support existing non-standard classes like `bg-danger`.
 */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        danger: {
          DEFAULT: '#ef4444', // red-500
          strong: '#dc2626',  // red-600
          medium: '#fca5a5',  // lighter red for rings/accents
        },
      },
    },
  },
  plugins: [],
}
