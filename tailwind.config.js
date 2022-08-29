module.exports = {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}",
  ],
  theme: {
    fontSize: {
      xs: ['1rem', { lineHeight: '1.25rem' }],
      sm: ['1.25rem', { lineHeight: '1.75rem' }],
      base: ['1.5rem', { lineHeight: '2rem' }],
      lg: ['2rem', { lineHeight: '2.25rem' }],
      xl: ['3.125rem', { lineHeight: '3.5rem' }],
      '1xl': ['5rem', { lineHeight: '5rem' }],
      '2xl': ['7.5rem', { lineHeight: '7.5rem' }],
    },
    colors: {
      gray: { 900: '#e6e6e6' },
      dark: { 900: '#323232' },
      yellow: { 900: '#FFF621' },
      black: { 900: '#000000' },
      red: { 900: '#ff0000' },
      green: { 900: '#00ee00' },
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
    require('@tailwindcss/line-clamp'),
    require('@tailwindcss/aspect-ratio'),    
  ],
}
