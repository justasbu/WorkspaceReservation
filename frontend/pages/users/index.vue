<template>
  <v-container>
    <div v-if="$auth.user.role === 'Admin'">
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
          :items="users"
          :search="search"
          class="elevation-1"
        >

          <template v-slot:top>
            <v-toolbar
              flat
            >


              <v-toolbar-title>Users</v-toolbar-title>
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

                <v-card>
                  <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col
                          cols="12"
                          sm="6"
                          md="2"
                        >
                          <v-text-field
                            v-model="editedUser.id"
                            label="User"
                            readonly
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                          sm="6"
                          md="4"
                        >
                          <v-text-field

                            v-model="editedUser.name"
                            label="Name"
                            :rules="[() => !!editedUser.name || 'This field is required']"
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                          sm="6"
                          md="6"
                        >
                          <v-text-field
                            v-model="editedUser.email"
                            label="Email"
                            readonly
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                          sm="4"
                          md="4"
                        >
                          <v-select
                            v-model="editedUser.role"
                            label="Role"
                            :items="roles"
                          ></v-select>
                        </v-col>

                      </v-row>
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
                      @click="save"
                    >
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="text-h5">Are you sure you want to delete this user?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
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
    </div>
  </v-container>
</template>

<script>

export default {
  // page properties go here

  data: () => {
    return {
      search: '',
      dialog: false,
      dialogDelete: false,
      editedIndex: -1,
      headers:
        [
          {text: 'ID', value: 'id', sortable: false, align: 'left'},
          {text: 'Name', value: 'name', sortable: false, align: 'left'},
          {text: 'Email', value: 'email', sortable: false, align: 'left'},
          {text: 'Role', value: 'role', sortable: false, align: 'center'},
          {text: 'Created At', value: 'created_at', sortable: false, align: 'center'},
          {text: 'Last Updated At', value: 'updated_at', sortable: false, align: 'center'},
          {text: 'Actions', value: 'actions', align: 'center', sortable: false},
        ],
      requiredField: {
        required: v => !!v || "Required"
      },
      users: [],
      user: null,
      roles: ['Regular', 'Admin'],
      editedUser: {
        id: '',
        name: '',
        role: '',
      },
      newUser: {
        id: '',
        name: '',
        role: '',
      },
      updatedUser: {
        id: '',
        name: '',
        role: '',
      },
    }
  },
  watch: {
    dialog(val) {
      val || this.close()
    },
  },
  mounted() {

    this.getUsers();
  },
  components: {},
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New User' : 'Edit User'
    },
  },
  methods: {
    closeDialog() {
      this.dialog = false
      this.$nextTick(() => {

      })
    },
    getUsers() {
      this.$axios.get(`/api/users/`)
        .then(response => {
          console.log(response)
          this.users = response.data.data
        })


    },
    editItem(item) {
      this.editedIndex = this.users.indexOf(item)
      this.editedUser = Object.assign({}, item)
      this.dialog = true
    },
    deleteItem(item) {
      this.editedIndex = this.users.indexOf(item)
      this.user = item
      this.editedUser = Object.assign({}, item)
      this.dialogDelete = true
    },
    deleteItemConfirm() {
      this.$axios.delete(`/api/users/${this.user.id}`)
        .then(response => {

          this.users.splice(this.editedIndex, 1)
          this.closeDelete()
        })
        .catch(error => {
          console.log(error)
        })
    },
    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedUser = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedUser = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    validate() {
      this.$refs.form.validate()
    },
    save() {

      if (this.editedIndex > -1) { // if exists
        this.updatedUser.id = this.editedUser.id
        this.updatedUser.name = this.editedUser.name
        this.updatedUser.email = this.editedUser.email
        this.updatedUser.role = this.editedUser.role

        Object.assign(this.users[this.editedIndex], this.updatedUser)
        console.log(this.updatedUser)
        this.$axios.patch(`/api/users/${this.editedUser.id}`, this.updatedUser)
          .then(response => {
            this.close()
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })
      } else { // creating new user

        this.newUser.id = this.editedUser.id
        this.newUser.name = this.editedUser.name
        this.newUser.email = this.editedUser.email
        this.newUser.role = this.editedUser.role

        console.log(this.newUser)
        this.$axios.post(`/api/users/`, this.newUser)
          .then(response => {
            this.close()
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })
      }
      this.close()
    },
  },

}

</script>

