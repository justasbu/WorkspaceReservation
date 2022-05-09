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
      style="box-shadow: none !important;"
      :headers="headers"
      :items="workspaces"
      :search="search"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>
            <v-icon

              class="mr-2"
              @click=""
              color="primary"
            >
            </v-icon>Workspaces</v-toolbar-title>
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
                v-on="on"
              >
                New workspace
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>


              <v-card-text>
                <v-container>
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedWorkspace.tableNumber"
                          label="Table Name"
                          :rules="requiredRule"

                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-select
                          v-model="editedWorkspace.monitorsCount"
                          label="Monitors Count"
                          :items="monitors"
                          :rules="requiredRule"
                        ></v-select>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-select
                          v-model="editedWorkspace.mount"
                          label="Mounted / Seperated Monitors"
                          :items="mountedOrSeperated"
                          :rules="requiredRule"
                        ></v-select>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-select
                          v-model="editedWorkspace.dockingStation"
                          label="Docking Station / PC"
                          :items="dockingOrPC"
                          :rules="requiredRule"
                        ></v-select>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedWorkspace.headPhones"
                          label="Headphones"
                          :rules="requiredRule"
                          required
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-select
                          v-model="editedWorkspace.tableType"
                          label="Table Type"
                          :items="liftableOrNot"
                          :rules="requiredRule"
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

          <v-dialog v-model="dialogDelete" max-width="600px">
            <v-card>
              <v-card-title primary-title class="justify-center">Are you sure you want to delete this hotel?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="text-left primary" text @click="closeDelete">Cancel</v-btn>
                <v-btn class="text-left primary" text @click="deleteItemConfirm">OK</v-btn>
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
          {text: 'Table Name', value: 'tableNumber', sortable: false, align: 'left'},
          {text: 'Monitors Count', value: 'monitorsCount', sortable: false, align: 'center'},
          {text: 'Mounted / Seperated Monitors', value: 'mount', sortable: false, align: 'center'},
          {text: 'Docking Station / PC', value: 'dockingStation', align: 'center', sortable: false},
          {text: 'Headphones', value: 'headPhones', align: 'center', sortable: false},
          {text: 'Table Type', value: 'tableType', align: 'center', width: '250px', sortable: false},
          {text: 'Actions', value: 'actions', align: 'center', sortable: false},
        ],
      requiredRule: [value => !!value || 'Please fill this field.'],
      workspaces: [],
      workspace:null,
      mountedOrSeperated:['Monitors on Mount', 'Seperated Monitors'],
      liftableOrNot: ['Non-Liftable', 'Liftable'],
      dockingOrPC:['Docking Station', 'PC'],
      monitors: [1,2,3,4],
      valid: true,

      editedWorkspace: {
        id: '',
        tableNumber: '',
        monitorsCount: '',
        mount: '',
        dockingStation: '',
        headPhones: '',
        tableType: '',
        zone_id: 1
      },
      updatedWorkspace: {
        id: '',
        tableNumber: '',
        monitorsCount: '',
        mount: '',
        dockingStation: '',
        headPhones: '',
        tableType: '',
        zone_id: 1
      },
      newWorkspace: {
        id: '',
        tableNumber: '',
        monitorsCount: '',
        mount: '',
        dockingStation: '',
        headPhones: '',
        tableType: '',
        zone_id: 1
      },
    }
  },
  watch: {
    dialog(val) {
      val || this.close()
    },
  },
  mounted() {

    this.getWorkspaces();
  },
  components: {},
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New Workspace' : 'Edit Workspace'
    },
  },
  methods: {
    closeDialog() {
      this.dialog = false
      this.$nextTick(() => {

      })
    },
    getWorkspaces() {
      this.$axios.get(`/api/workspaces/`)
        .then(response => {
          this.workspaces = response.data.data
        })
    },
    editItem(item) {
      this.editedIndex = this.workspaces.indexOf(item)
      this.editedWorkspace = Object.assign({}, item)
      this.dialog = true

    },
    deleteItem(item) {
      this.editedIndex = this.workspaces.indexOf(item)
      this.workspace = item
      this.editedWorkspace = Object.assign({}, item)
      this.dialogDelete = true
    },
    deleteItemConfirm() {
      this.$axios.delete(`/api/workspaces/${this.workspace.id}`)
      .then(response =>{
        this.workspaces.splice(this.editedIndex, 1)
        this.closeDelete()
      })
      .catch(error => {
        console.log(error)
      })

    },
    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedWorkspace = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedWorkspace = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    validate () {
      this.$refs.form.validate()
    },
    submit() {
      return !(this.editedWorkspace.tableType && this.editedWorkspace.monitorsCount && this.editedWorkspace.mount &&
        this.editedWorkspace.dockingStation && this.editedWorkspace.headPhones && this.editedWorkspace.tableType)
    },
    save() {
      if (this.editedIndex > -1) { // if exists
        this.updatedWorkspace.id = this.editedWorkspace.id
        this.updatedWorkspace.tableNumber = this.editedWorkspace.tableNumber
        this.updatedWorkspace.monitorsCount = this.editedWorkspace.monitorsCount
        this.updatedWorkspace.mount = this.editedWorkspace.mount
        this.updatedWorkspace.dockingStation = this.editedWorkspace.dockingStation
        this.updatedWorkspace.headPhones = this.editedWorkspace.headPhones
        this.updatedWorkspace.tableType = this.editedWorkspace.tableType

        Object.assign(this.workspaces[this.editedIndex], this.updatedWorkspace)
        console.log(this.updatedWorkspace)
        this.$axios.patch(`/api/workspaces/${this.editedWorkspace.id}`, this.updatedWorkspace)
          .then(response => {
            this.close()
            console.log(response)
          })
        .catch(error =>{
          console.log(error)
        })
      } else {
        this.newWorkspace.id = this.editedWorkspace.id
        this.newWorkspace.tableNumber = this.editedWorkspace.tableNumber
        this.newWorkspace.monitorsCount = this.editedWorkspace.monitorsCount
        this.newWorkspace.mount = this.editedWorkspace.mount
        this.newWorkspace.dockingStation = this.editedWorkspace.dockingStation
        this.newWorkspace.headPhones = this.editedWorkspace.headPhones
        this.newWorkspace.tableType = this.editedWorkspace.tableType

        console.log(this.newWorkspace)
        this.$axios.post(`/api/workspaces/`, this.newWorkspace)
          .then(response => {
            this.close()
            console.log(response)
          })
          .catch(error =>{
            console.log(error)
          })
      }
      this.close()
    },
  },

}

</script>

