export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: process.env.APP_NAME || 'MyApp',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback' }
    ],
    script: [
      { src: "/plugins/jquery/jquery.min.js", mode: 'client', body: true, defer: true },
      { src: "/plugins/bootstrap/js/bootstrap.bundle.min.js", mode: 'client', body: true, defer: true },
      { src: "/dist/js/adminlte.min.js", mode: 'client', body: true, defer: true },      
      { src: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js", mode: 'client', body: true, defer: true }      
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "~assets/plugins/fontawesome-free/css/all.min.css",
    "~assets/dist/css/adminlte.css",
    // "~assets/plugins/select2/css/select2.min.css",
    // "~assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    "~components/global",
    "~plugins/vform",
    "~plugins/easy-table",
    "~plugins/vlodash",
    "~plugins/loading-element",
    "~plugins/permission",
    "~plugins/geolocation",
    "~plugins/number-format",
    { src: '~/plugins/vue-datepicker', mode: 'client', ssr: false },
    { src: '~/plugins/vselect', mode: 'client', ssr: false }
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: false,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    ['@nuxtjs/router', { /* module options */ }],
    ['@nuxtjs/dotenv', { /* module options */ }],
    '@nuxtjs/google-analytics',
    [
      '@nuxtjs/moment', {
        defaultLocale: 'id',
        locales: ['id'],
        defaultTimezone: 'Asia/Jakarta'
      }
    ]
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/toast',
    'portal-vue/nuxt',
    'nuxt-sweetalert2',
    ['nuxt-leaflet', { /* module options */ }],
  ],

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: '/login',
            method: 'post',
            propertyName: 'token'
          },
          logout: {
            url: '/logout',
            method: 'post'
          },
          user: {
            url: '/user',
            method: 'get',
            propertyName: 'user'
          }
        },
        token: {
          property: 'access_token',
          required: true,
          type: 'Bearer'
        },
        user: {
          property: 'user',
          // autoFetch: true
        },
      },
    }
  },

  routes: [
    '/'
  ],

  // Google Analytics
  googleAnalytics: {
    id: process.env.GOOGLE_ANALYTICS_ID,
  },

  publicRuntimeConfig: {
    googleAnalytics: {
      id: process.env.GOOGLE_ANALYTICS_ID
    }
  },

  toast: {
    // position: 'top-center',
    register: [ // Register custom toasts
      {
        name: 'server_error',
        message: 'Oops...Something went wrong!',
        options: {
          type: 'error',
          icon: "exclamation-triangle",
					iconPack: "fontawesome",
					theme: 'outline',
					position: 'bottom-center',
          action : {
						text : 'Close',
						onClick : (e, toastObject) => {
							toastObject.goAway(0);
						}
					}
        }
      }
    ]
},

  /*
   ** modifying the default loader
   */
   loading: {
    color: 'orange',
    height: '5px',
    continuous: true
  }

}
