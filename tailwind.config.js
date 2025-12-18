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

  safelist: [
    // success
    'bg-green-600',
    'hover:bg-green-700',
    'focus:ring-green-500',

    // primary
    'bg-blue-600',
    'hover:bg-blue-700',
    'focus:ring-blue-500',

    // danger
    'bg-red-600',
    'hover:bg-red-700',
    'focus:ring-red-500',

    // default
    'bg-gray-600',
    'hover:bg-gray-700',
    'focus:ring-gray-500',
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
