<template>
  <v-dialog v-model="loginDialog" persistent max-width="600px" min-width="360px">
    <div>
      <v-tabs v-model="tab" show-arrows background-color="deep-purple accent-4" icons-and-text dark grow>
        <v-tabs-slider color="purple darken-4"></v-tabs-slider>
        <v-tab v-for="i in tabs">
          <v-icon large>{{ i.icon }}</v-icon>
          <div class="caption py-1">{{ i.name }}</div>
        </v-tab>
        <v-tab-item>
          <v-card class="px-4">
            <v-card-text>
              <v-form ref="registerForm" v-model="valid" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-text-field v-model="name"
                                  prepend-icon="mdi-account-circle-outline"
                                  :rules="[rules.required]"
                                  label="Name"
                                  required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="email" :rules="emailRules"
                                  prepend-icon="mdi-at"
                                  label="E-mail" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="password"
                                  prepend-icon="mdi-lock"
                                  :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                  :rules="[rules.required, rules.min]"
                                  :type="show1 ? 'text' : 'password'"
                                  name="input-10-1" label="Password"
                                  hint="At least 8 characters"
                                  counter
                                  @click:append="show1 = !show1"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field block v-model="verify"
                                  prepend-icon="mdi-lock-check"
                                  :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                  :rules="[rules.required, passwordMatch]"
                                  :type="show1 ? 'text' : 'password'"
                                  name="input-10-1"
                                  label="Confirm Password"
                                  counter
                                  @click:append="show1 = !show1"></v-text-field>
                  </v-col>
                  <v-col cols="12"> Already have an account?
                    <a href="/login" class="text-decoration-none">Click here to login!</a>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col class="d-flex ml-auto" cols="12" sm="3" xsm="12">
                    <v-btn x-large block :disabled="!valid" color="success" @click="validateRegistration">Register
                    </v-btn>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs>
    </div>
  </v-dialog>

</template>


<script>

export default {
  layout: 'empty',
  data: () => ({

    loginDialog: true,
    tab: 0,
    tabs: [
      {name: "Register", icon: "mdi-account-outline"}

    ],
    valid: true,

    name: "",
    email: "",
    password: "",
    verify: "",
    role: "Regular",

    emailRules: [
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
  computed: {
    passwordMatch() {
      return () => this.password === this.verify || "Password must match";
    }
  },
  methods: {

    validateRegistration() {
      if (this.$refs.registerForm.validate()) {
        this.$axios.post('/api/auth/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.verify,
          role: this.role
        })
          .then(response => {
            console.log(response)
            this.$router.push('/login')
          })
      }
    },
    reset() {
      this.$refs.registerForm.reset();
    },
    resetValidation() {
      this.$refs.registerForm.resetValidation();
    }
  },
}
</script>
