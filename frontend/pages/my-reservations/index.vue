<template>
  <v-container>
    <v-card style="box-shadow: none !important;">
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="reservations"
        :search="search"
        class="elevation-1"
      >

        <template v-slot:top>
          <v-toolbar
            flat
          >


            <v-toolbar-title>Reservations</v-toolbar-title>
            <v-divider
              class="mx-4"
              inset
              vertical
            ></v-divider>

            <v-spacer></v-spacer>


            <v-dialog
              v-model="dialog"
              max-width="500px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"

                  href="/"
                >
                  Make Reservation
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-form v-model="isFormValid">
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedReservation.userName"
                          label="User"
                          readonly
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="8"
                        md="8"
                      >
                        <v-text-field
                          v-model="editedReservation.toEditorFrom"
                          label="Date From"
                          type="datetime-local"
                          min="2022-05-02T00:00"
                          max="2030-05-02T00:00"
                          :rules="dateFromRules"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="8"
                        md="8"
                      >
                        <v-text-field
                          v-model="editedReservation.toEditorTo"
                          type="datetime-local"
                          label="Date To"

                          min="2022-05-02T00:00"
                          max="2030-05-02T00:00"
                          :rules="dateToRules"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedReservation.workspaceName"
                          label="Workspace"
                          readonly
                        ></v-text-field>
                      </v-col>

                    </v-row>
                    </v-form>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    class="text-left primary"
                    text
                    @click="close"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    class="text-left primary"
                    text
                    :disabled="!isFormValid"
                    @click="save"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="600px">
              <v-card>
                <v-card-title class="text-h5">Are you sure you want to delete this reservation?</v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="error" text @click="closeDelete">Cancel</v-btn>
                  <v-btn color="success" text @click="deleteItemConfirm">OK</v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>

        </template>

        <template v-slot:item.actions="{ item }">

          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteItem(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>

    <div>
      <v-snackbar
        v-model="reservationEditSuccess"
        color="success"
      >
        Reservation has been edited successfully!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="reservationEditSuccess = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>


    <div>
      <v-snackbar
        v-model="reservationEditFail"
        color="error"
      >
        Other reservation exists at your selected time!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="reservationEditFail = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>
  </v-container>
</template>

<script>
import moment, {now} from "moment-timezone"

export default {
  // page properties go here

  data: function ()  {
    return {
      search: '',
      dialog: false,
      dialogDelete: false,
      reservationEditFail: false,
      reservationEditSuccess: false,
      isFormValid: false,
      editedIndex: -1,
      headers:
        [
          {text: 'User Name', value: 'userName', sortable: false, align: 'center'},
          {text: 'Date From', value: 'dateFrom', sortable: false, align: 'center'},
          {text: 'Date To', value: 'dateTo', sortable: false, align: 'center'},
          {text: 'Status', value: 'status', sortable: false, align: 'center'},
          {text: 'Workspace Name', value: 'workspaceName', sortable: false, align: 'center'},
          {text: 'Created At', value: 'created_at', sortable: false, align: 'center'},
          {text: 'Actions', value: 'actions', align: 'center', sortable: false},
        ],
      reservations: [],
      allReservations: [],
      users: [],
      workspaces: [],
      reservation: null,

      editedReservation: {
        id: '',
        user_id: '',
        dateFrom: '',
        dateTo: '',
        status: '',
        toEditorFrom: '',
        toEditorTo: '',
        workspace_id: '',
        userName: '',
        workspaceName: ''
      },
      newReservation: {
        id: '',
        user_id: '',
        dateFrom: '',
        dateTo: '',
        workspace_id: '',
      },
      updatedReservation: {
        id: '',
        user_id: '',
        dateFrom: '',
        dateTo: '',
        workspace_id: '',
      },

      minimumTime: moment.tz(now(), 'UTC').format('YYYY-MM-DD HH:mm:ss'),

      dateFromRules: [

        v => !!v || "Required",
      ],

      dateToRules: [
        v => !!v || "Required",
        v => this.editedReservation.toEditorFrom < v || "Date To must be greater than Date From",
        v => v > this.minimumTime || "Date must be greater than Current time",
        v => moment(new Date(this.editedReservation.toEditorTo)).diff(moment(new Date
          (this.editedReservation.toEditorFrom)), 'months', true) < 1 ||
          "Reservation can not be longer than 1 month"
      ],
    }
  },
  watch: {
    dialog(val) {
      val || this.close()
    },
  },
  mounted() {
    this.getUsers()
    this.getWorkspaces()
    this.getReservations()
    this.getAllReservations()
  },
  components: {},
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Reservation'
    },
  },
  methods: {
    closeDialog() {
      this.dialog = false
      this.$nextTick(() => {

      })
    },
    getReservations() {

      this.$axios.get(`/api/reservations/`)
        .then(response => {
          this.reservations = response.data.data
          this.reservations = this.reservations.filter((item) => item.user_id === this.$auth.user.id)

          for (let i = 0; i < this.reservations.length; i++) {

            for (let j = 0; j < this.users.length; j++) {
              if (this.reservations[i].user_id === this.users[j].id) {
                this.reservations[i].userName = this.users[j].name
              }
            }
            for (let k = 0; k < this.workspaces.length; k++) {
              if (this.reservations[i].workspace_id === this.workspaces[k].id) {
                this.reservations[i].workspaceName = this.workspaces[k].tableNumber
              }

            }
            this.reservations[i].created_at = moment.tz(this.reservations[i].created_at, 'UTC').format('YYYY-MM-DD HH:mm')

            this.reservations[i].toEditorFrom = moment.tz(this.reservations[i].dateFrom, 'UTC').format('YYYY-MM-DDTHH:mm:ss')
            this.reservations[i].toEditorTo = moment.tz(this.reservations[i].dateTo, 'UTC').format('YYYY-MM-DDTHH:mm:ss')

            if (this.reservations[i].dateTo < moment.tz(now(), 'UTC').format('YYYY-MM-DD HH:mm:ss')) {
              this.reservations[i].status = 'Expired'

            } else this.reservations[i].status = 'Ongoing'
          }

        })
        .catch(error => {
          console.log(error)
        })

    },
    getAllReservations() {

      this.$axios.get(`/api/reservations/`)
        .then(response => {
          this.allReservations = response.data.data

          for (let i = 0; i < this.allReservations.length; i++) {

            for (let j = 0; j < this.users.length; j++) {
              if (this.allReservations[i].user_id === this.users[j].id) {
                this.allReservations[i].userName = this.users[j].name
              }
            }
            for (let k = 0; k < this.workspaces.length; k++) {
              if (this.allReservations[i].workspace_id === this.workspaces[k].id) {
                this.allReservations[i].workspaceName = this.workspaces[k].tableNumber
              }

            }
            this.allReservations[i].created_at = moment.tz(this.allReservations[i].created_at, 'UTC').format('YYYY-MM-DD HH:mm')

            this.allReservations[i].toEditorFrom = moment.tz(this.allReservations[i].dateFrom, 'UTC').format('YYYY-MM-DDTHH:mm:ss')
            this.allReservations[i].toEditorTo = moment.tz(this.allReservations[i].dateTo, 'UTC').format('YYYY-MM-DDTHH:mm:ss')

            if (this.allReservations[i].dateTo < moment.tz(now(), 'UTC').format('YYYY-MM-DD HH:mm:ss')) {
              this.allReservations[i].status = 'Expired'

            } else this.allReservations[i].status = 'Ongoing'
          }

        })
        .catch(error => {
          console.log(error)
        })

    },
    getUsers() {
      this.$axios.get(`api/users/`)
        .then(response => {
          this.users = response.data.data
        })
        .catch(error => {

        })

    },
    getWorkspaces() {
      this.$axios.get(`api/workspaces/`)
        .then(response => {
          this.workspaces = response.data.data
        })
        .catch(error => {
        })
    },

    editItem(item) {

      this.editedIndex = this.reservations.indexOf(item)
      this.editedReservation = Object.assign({}, item)
      if (this.reservations[this.editedIndex].status !== 'Expired') {
        this.dialog = true
      }
    },
    deleteItem(item) {
      this.editedIndex = this.reservations.indexOf(item)
      this.reservation = item
      this.editedReservation = Object.assign({}, item)
      this.dialogDelete = true
    },
    deleteItemConfirm() {
      this.$axios.delete(`/api/reservations/${this.reservation.id}`)
        .then(response => {
          this.reservations.splice(this.editedIndex, 1)
          this.closeDelete()
        })
        .catch(error => {
          console.log(error)
        })
    },
    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedReservation = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedReservation = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    validate() {
      this.$refs.form.validate()
    },
    save() {

      if (this.editedIndex > -1) { // if reservation exists

        this.updatedReservation.id = this.editedReservation.id
        this.updatedReservation.user_id = this.editedReservation.user_id
        this.updatedReservation.dateTo = moment.tz(this.editedReservation.toEditorTo, 'UTC')
          .format('YYYY-MM-DD HH:mm:ss')
        this.updatedReservation.dateFrom = moment.tz(this.editedReservation.toEditorFrom, 'UTC')
          .format('YYYY-MM-DD HH:mm:ss')
        this.updatedReservation.workspace_id = this.editedReservation.workspace_id

        let minimumTime = moment.tz(now(), 'UTC').format('YYYY-MM-DD HH:mm:ss')

        // Check if reservation can be updated
        for (let i = 0; i < this.allReservations.length; i++) {
          if (this.allReservations[i].workspace_id === this.updatedReservation.workspace_id) {
            if ((moment(this.updatedReservation.dateFrom).isAfter(moment(this.allReservations[i].dateFrom))
                && moment(this.updatedReservation.dateFrom).isBefore(moment(this.allReservations[i].dateTo))) ||
              (moment(this.updatedReservation.dateTo).isAfter(moment(this.allReservations[i].dateFrom)) &&
                moment(this.updatedReservation.dateTo).isBefore(moment(this.allReservations[i].dateTo))) ||
              (moment(this.updatedReservation.dateFrom).isBefore(moment(this.allReservations[i].dateFrom)) &&
                moment(this.updatedReservation.dateTo).isAfter(moment(this.allReservations[i].dateTo)))) {
              this.reservationEditFail = true
              break
            }
            else if (moment(this.updatedReservation.dateFrom).isBefore(moment(minimumTime)) ||
              moment(this.updatedReservation.dateTo).isBefore(moment(minimumTime)))
            {
              this.dateBeforeCurrentTime = true
              break
            }
            else {
              this.$axios.patch(`/api/reservations/${this.editedReservation.id}`, this.updatedReservation)
                .then(response => {
                  this.close()
                  console.log(response)
                  this.reservationEditSuccess = true
                  Object.assign(this.allReservations[this.editedIndex], this.updatedReservation)
                })
                .catch(error => {
                  console.log(error)
                })

            }
          }
        }
      }
      this.close()
    },
  },

}

</script>

