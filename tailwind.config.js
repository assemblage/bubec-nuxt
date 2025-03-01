module.exports = {
  content: [
    "./bubec-theme/**/*.php",
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}"
  ],
  safelist: [
    'xl:!text-2xl','sm:!text-1xl', '!text-xl', '!block'
  ],
  theme: {
    fontFamily: {
      sans: ['Akkurat Pro', 'sans-serif'],
    },
    fontSize: {
      xxs: ['.75rem', { lineHeight: '1rem' }],
      xs: ['1rem', { lineHeight: '1.25rem' }],
      sm: ['1.25rem', { lineHeight: '1.75rem' }],
      base: ['1.5rem', { lineHeight: '2rem' }],
      lg: ['2rem', { lineHeight: '2.375rem' }],
      lgx: ['2.3125rem', { lineHeight: '2.4rem' }],
      xl: ['3.125rem', { lineHeight: '4.0625rem' }],
      '1xl': ['5rem', { lineHeight: '5rem' }],
      '2xl': ['7.5rem', { lineHeight: '8rem' }],
    },
    colors: {
      gray: { 900: '#e6e6e6' },
      dark: { 900: '#323232' },
      yellow: { 900: '#FFF621' },
      black: { 900: '#000000' },
      red: { 900: '#ff0000' },
      green: { 900: '#00ee00' },
      white: { 900: '#ffffff' }
    },
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
      '3xl': '1920px'
    },
    extend: {
      maxWidth: {
        'screen-3xl': '1920px',
      }
    }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
