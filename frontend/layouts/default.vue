<template>
  <v-app>

    <v-navigation-drawer
      v-model="drawer"
      class="indigo"
      permanent
      expand-on-hover
      app
      :mini-variant.sync="mini"
      :mini-variant-width="100"
      height="100%">
      <div v-if="this.$auth.user">
        <div v-if="this.$auth.user.role === 'Admin'">
          <v-list>
            <v-list-item>
              <v-list-item-action>
                <v-icon class="white--text">mdi-account-box</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  {{ this.$auth.user.name }}
                </v-list-item-title>
                <v-list-item-subtitle class="white--text">
                  {{ this.$auth.user.email }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-for="link in links" :key="link.text" router :to="link.route">
              <v-list-item-action>
                <v-icon class="white--text">{{ link.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  {{ link.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </div>

        <div v-if="this.$auth.user.role === 'Regular'">
          <v-list>
            <v-list-item>
              <v-list-item-action>
                <v-icon class="white--text">mdi-account-box</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  {{ this.$auth.user.name }}
                </v-list-item-title>
                <v-list-item-subtitle class="white--text">
                  {{ this.$auth.user.email }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-for="regularLink in regularUserLinks" :key="regularLink.text" router :to="regularLink.route">
              <v-list-item-action>
                <v-icon class="white--text">{{ regularLink.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  {{ regularLink.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </div>
      </div>

      <template v-slot:append>
        <div class="pa-2">
          <v-list>
            <v-list-item router :to="helpRoute">
              <v-list-item-action>
                <v-icon class="white--text">mdi-help-circle</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  Help
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item @click="signOut">
              <v-list-item-action>
                <v-icon class="white--text">mdi-exit-to-app</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="white--text">
                  Logout
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </div>
      </template>

    </v-navigation-drawer>
    <v-main>
      <v-container
        fluid
        class="py-8 px-6"
      >

        <nuxt/>


      </v-container>


    </v-main>


  </v-app>
</template>

<script>

export default {

  middleware: ['auth'],
  data: () => ({
    links: [
      {icon: 'mdi-view-dashboard', text: 'Main', route: '/'},
      {icon: 'mdi-desktop-classic', text: 'Workspaces', route: '/workspaces'},
      {icon: 'mdi-calendar-text-outline', text: 'Reservations', route: '/reservations'},
      {icon: 'mdi-calendar-text-outline', text: 'My Reservations', route: '/my-reservations'},
      {icon: 'mdi-account', text: 'Users', route: '/users'}
    ],
    regularUserLinks: [
      {icon: 'mdi-view-dashboard', text: 'Main', route: '/'},
      {icon: 'mdi-calendar-text-outline', text: 'My Reservations', route: '/my-reservations'},
    ],
    bottomLinks: [

      {icon: 'mdi-help-circle', text: 'Help'},
      {icon: 'mdi-exit-to-app', text: 'Logout'},
    ],
    helpRoute: '/help',
    drawer: null,
    mini: false,
  }),

  methods:
    {
      async signOut() {
        await this.$auth.logout()
        this.$router.push('login')

      },


    }
}

</script>
