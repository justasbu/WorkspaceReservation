<template>

<v-container>

  <v-card class="mx-auto" max-width="700">
    <v-card-title>Forgot password form</v-card-title>
    <v-card-subtitle>Please enter your email </v-card-subtitle>
    <v-card-text>
      <v-form ref="forgotPasswordForm" v-model="valid" lazy-validation>
        <v-row>

          <v-col cols="12">
            <v-text-field v-model="email" :rules="emailRules"
                          prepend-icon="mdi-at"
                          label="E-mail" required></v-text-field>
          </v-col>

          <v-col class="d-flex ml-auto" cols="12" sm="6" xsm="12">
            <v-btn x-large block :disabled="!valid" color="success" @click="validateEmail">
              Send Password Reset Link
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
      Email sent! Please check your mailbox.

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

    emailSent: false,
    email: '',
    emailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid",
      v =>  /.+@uc\.+group$/.test(v) || "E-mail must be under uc.group domain",
    ],


    rules: {
      required: value => !!value || "Required.",
      min: v => (v && v.length >= 8) || "Min 8 characters"
    }
  }),
  computed: {

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
            setInterval(function() {
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
