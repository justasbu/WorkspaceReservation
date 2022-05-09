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

  data: () => ({

    drawer: null,
    mini: false,
  }),

}

</script>
