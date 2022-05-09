<template>

  <v-container>

    <v-card class="mx-auto" max-width="700">
      <v-card-title>Forgot password form</v-card-title>
      <v-card-subtitle>Please enter your email</v-card-subtitle>
      <v-card-text>
        <v-form ref="forgotPasswordForm" v-model="valid" lazy-validation>
          <v-row>

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
                            name="input-10-1" label="New Password"
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
                            label="Confirm New Password"
                            counter
                            @click:append="show1 = !show1"></v-text-field>
            </v-col>

            <v-col class="d-flex ml-auto" cols="12" sm="6" xsm="12">
              <v-btn x-large block :disabled="!valid" color="success" @click="validateEmail">
                Reset Password
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>

    <div>
      <v-snackbar
        v-model="emailSent"
        color="success"
      >
        Password has been reset successfully!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="emailSent = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>
  </v-container>
</template>

<script>

export default {
  layout: 'empty',
  data: () => ({

    valid: true,
    show1: false,
    emailSent: false,
    password: "",
    verify: "",
    email: '',
    emailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid",
      v => /.+@uc\.+group$/.test(v) || "E-mail must be under uc.group domain",
    ],


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

    validateEmail() {
      if (this.$refs.forgotPasswordForm.validate()) {
        this.$axios.post('/api/forget-password/', {
          email: this.email
        })
          .then(response => {
            console.log(response)
            this.emailSent = true
            this.reset()
            setInterval(function () {
              this.$router.push('/login')
            }, 5000);


          })
      }
    },
    reset() {
      this.$refs.forgotPasswordForm.reset();
    },
    resetValidation() {
      this.$refs.forgotPasswordForm.resetValidation();
    }
  },
}
</script>
