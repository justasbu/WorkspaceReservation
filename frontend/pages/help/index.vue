<template>
  <v-container>
            <v-card class="px-4">
              <v-card-title>Support Request</v-card-title>
              <v-card-subtitle>In this form, you can send a ticket to our support team</v-card-subtitle>
              <v-form ref="frontHelpForm" v-model="helpModel" lazy-validation>

                <v-row>
                  <v-col cols="12">
                    <v-text-field v-model="helpForm.subject" :rules="subjectRules"
                                  label="Subject"
                                  hint="Enter subject of your issue"
                                  prepend-icon="mdi-rename-box"
                                  required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea v-model="helpForm.body" :rules="bodyRules"
                                  label="Description"
                                hint="Please try to describe your issue as clear as possible"
                                prepend-icon="mdi-subtitles"
                                required></v-textarea>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col class="d-flex ml-auto" cols="12" sm="3" xsm="12" >
                    <v-btn  block  color="primary" @click="validateHelpForm"> Send  </v-btn>
                  </v-col>
                </v-row>
              </v-form>

            </v-card>
    <div>
      <v-snackbar
        v-model="emailSent"
        color="success"
      >
        Your request has been sent! Our agent will be in touch with you shortly.

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
  data: () => ({
    wrongCredentials: false,
    layout: 'empty',
    emailSent: false,
    loginDialog: true,
    tab: 0,
    tabs: [
      {name:"Login", icon:"mdi-account"},

    ],
    frontHelpForm: true,
    helpModel: true,
    helpDialog: true,

    helpForm: {
      subject: '',
      body: ''
    },

    subjectRules: [
      v => !!v || "Required",
      v => (v && v.length >= 4) || "Minimum 4 characters"
    ],
    bodyRules: [
      v => !!v || "Required",
      v => (v && v.length >= 8) || "Minimum 8 characters"
    ],

  }),
  computed: {
  },
  mounted() {

  },
  methods: {

      validateHelpForm() {
      if (this.$refs.frontHelpForm.validate()) {

        try {
           this.$axios.$post(`/api/send-helpEmail/`,
            {
              subject: this.helpForm.subject,
              body: this.helpForm.body,
              userID: this.$auth.user.id
            })
          .then(response => {
            console.log(response)
            this.emailSent = true
            this.reset()
          })

          }
        catch (e) {
          console.log(e)
        }

      }
    },
    reset() {
      this.$refs.frontHelpForm.reset();
    },
    resetValidation() {
      this.$refs.frontHelpForm.resetValidation();
    }
  },
}
</script>
