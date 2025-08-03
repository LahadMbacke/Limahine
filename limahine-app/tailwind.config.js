
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Filament/**/*.php",
    "./resources/views/filament/**/*.blade.php",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        // Palette de couleurs basée sur le logo
        primary: {
          50: '#fefdf8',
          100: '#fdf9e8',
          200: '#fbf1c5',
          300: '#f7e497',
          400: '#f1d067',
          500: '#e8b73a', // Doré principal
          600: '#d49c2a',
          700: '#b07c25',
          800: '#8f6225',
          900: '#755122',
        },
        secondary: {
          50: '#f7f5f3',
          100: '#ede8e3',
          200: '#ddd4ca',
          300: '#c7b8a8',
          400: '#b09485',
          500: '#9d7b6a', // Marron clair
          600: '#8a6555',
          700: '#735246',
          800: '#5e443b',
          900: '#4e3931',
        },
        accent: {
          50: '#f6f5f4',
          100: '#ebe8e5',
          200: '#d9d1cc',
          300: '#c1b3ab',
          400: '#a38e83',
          500: '#8b7066',
          600: '#6d5650', // Marron foncé
          700: '#5a453f',
          800: '#4a3834',
          900: '#3f302c',
        },
        neutral: {
          50: '#fafafa',
          100: '#f5f5f5',
          200: '#e5e5e5',
          300: '#d4d4d4',
          400: '#a3a3a3',
          500: '#737373',
          600: '#525252',
          700: '#404040',
          800: '#262626',
          900: '#171717',
        }
      },
      fontFamily: {
        'elegant': ['Playfair Display', 'serif'],
        'modern': ['Inter', 'sans-serif'],
        'script': ['Dancing Script', 'cursive'],
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.6s ease-out',
        'scale-in': 'scaleIn 0.4s ease-out',
        'float': 'float 3s ease-in-out infinite',
        'glow': 'glow 2s ease-in-out infinite alternate',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(50px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.9)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        glow: {
          '0%': { boxShadow: '0 0 5px rgba(232, 183, 58, 0.3)' },
          '100%': { boxShadow: '0 0 20px rgba(232, 183, 58, 0.6), 0 0 30px rgba(232, 183, 58, 0.4)' },
        },
      },
      boxShadow: {
        'golden': '0 4px 14px 0 rgba(232, 183, 58, 0.25)',
        'brown': '0 4px 14px 0 rgba(109, 86, 80, 0.25)',
        'elegant': '0 10px 40px rgba(0, 0, 0, 0.1)',
        'glow': '0 0 20px rgba(232, 183, 58, 0.3)',
      },
      backdropBlur: {
        xs: '2px',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
