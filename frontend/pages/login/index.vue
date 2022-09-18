<template>
  <v-container>
    <v-dialog v-model="loginDialog" persistent max-width="600px" min-width="360px">
      <div>
        <v-tabs v-model="tab" show-arrows background-color="deep-purple accent-4" icons-and-text dark grow>
          <v-tabs-slider color="purple darken-4"></v-tabs-slider>
          <v-tab v-for="i in tabs" v-bind:key="i.name">
            <v-icon large>{{ i.icon }}</v-icon>
            <div class="caption py-1">{{ i.name }}</div>
          </v-tab>

          <v-tab-item>
            <v-card class="px-4">
              <v-card-text>
                <v-form ref="frontLoginForm" v-model="valid" lazy-validation>
                  <v-row
                    class="pa-4"
                    align="center"
                    justify="center"
                  >
                    <azure-login-component/>
                  </v-row>

                  <v-divider></v-divider>
                  <v-col cols="12" class="text-center"> OR</v-col>
                  <v-row>


                    <v-col cols="12">

                      <v-text-field v-model="loginForm.email" :rules="loginEmailRules"
                                    prepend-icon="mdi-account-circle  "
                                    label="E-mail" required></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                        v-model="loginForm.password"
                        :append-icon="show1?'eye':'eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show1 ? 'text' : 'password'"
                        name="input-10-1"
                        prepend-icon="mdi-lock"
                        label="Password"
                        hint="At least 8 characters" counter @click:append="show1 = !show1"></v-text-field>
                    </v-col>
                    <v-col cols="12"> Don't have an account yet?
                      <a href="/registration" class="text-decoration-none"> Create it here!</a>

                    </v-col>


                    <v-spacer></v-spacer>
                    <v-col class="d-flex ml-auto" cols="12" sm="3" xsm="12">
                      <v-btn x-large block :disabled="!valid" color="success" @click="validateLogin"> Login</v-btn>
                    </v-col>
                  </v-row>

                </v-form>
              </v-card-text>
               </v-card>
          </v-tab-item>
        </v-tabs>
      </div>
    </v-dialog>

    <div class="text-center ma-2">

      <v-snackbar
        v-model="wrongCredentials"
        color="error"
      >
        Wrong credentials provided!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="wrongCredentials = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

  </v-container>

</template>


<script>
import AzureLoginComponent from "~/components/AzureLoginComponent"

export default {
  components: AzureLoginComponent,

  data: () => ({
    wrongCredentials: false,
    layout: 'empty',
    loginDialog: true,
    tab: 0,
    tabs: [
      {name: "Login", icon: "mdi-account"},

    ],
    valid: true,

    name: "",
    email: "",
    password: "",
    verify: "",
    loginPassword: "",
    loginEmail: "",
    loginForm: {
      email: '',
      password: ''
    },

    loginEmailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid",
      v => /.+@uc.group$/.test(v) || "E-mail must use @uc.group domain"
    ],
    show1: false,
    rules: {
      required: value => !!value || "Required.",
      min: v => (v && v.length >= 8) || "Min 8 characters"
    }
  }),
  computed: {},
  mounted() {

  },
  methods: {

    async validateLogin() {
      if (this.$refs.frontLoginForm.validate()) {
        try {
          await this.$auth.loginWith('local', {
            data: this.loginForm

          })
        } catch (e) {
          this.wrongCredentials = true
        }

      }
    },
    reset() {
      this.$refs.frontLoginForm.reset();
    },
    resetValidation() {
      this.$refs.frontLoginForm.resetValidation();
    }
  },
}
</script>
