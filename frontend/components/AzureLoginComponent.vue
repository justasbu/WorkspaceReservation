<template>
  <v-btn
    max-height="41"
    max-width="215"
    @click="login"
  >
    <v-img
      class="grey lighten-2"
      :src="require('~/assets/images/ms_login.png')"
      max-height="41"
      max-width="215"
    ></v-img>
  </v-btn>
</template>

<script>
export default {
  name: 'newLogin',
  layout: "empty",
  computed: {
    url: () => 'http://localhost:8000/api/auth/login/azure'
  },
  mounted () {
    window.addEventListener('message', this.onMessage)
  },
  beforeDestroy () {
    window.removeEventListener('message', this.onMessage)
  },
  methods: {
    async login () {
      const newWindow = openWindow('', 'login');
      const url = await this.$store.dispatch('auth/fetchOauthUrl', {
        provider: 'azure'
      })
      newWindow.location.href = url
    },
    /**
     * @param {MessageEvent} e
     */
    onMessage (e) {
      this.$store.dispatch('auth/saveToken', {
        token: e.data.token
      })
      this.$auth.setToken('local', 'Bearer ' + e.data.token);
      this.$auth.setStrategy('local');
      this.$auth.fetchUser().then( () => {
        return this.$router.push('/');
      }).catch( (e) => {
      });
    }
  }
}
/**
 * @param title
 * @param  {Object} options
 * @return {Window}
 */
function openWindow (url, title, options = {}) {
  if (typeof url === 'object') {
    options = url
    url = ''
  }
  options = { url, title, width: 600, height: 720, ...options }
  const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
  const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
  const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
  const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height
  options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
  options.top = ((height / 2) - (options.height / 2)) + dualScreenTop
  const optionsStr = Object.keys(options).reduce((acc, key) => {
    acc.push(`${key}=${options[key]}`)
    return acc
  }, []).join(',')
  const newWindow = window.open(url, title, optionsStr)
  if (window.focus) {
    newWindow.focus()
  }
  return newWindow
}
</script>
