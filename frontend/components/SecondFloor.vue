<template>
  <v-container>


    <v-card
      class="pa-1"
      height="100%"
      shaped>
      <v-card-title>Reservation Picker</v-card-title>
      <v-card-subtitle>Please enter date range to filer available workspaces</v-card-subtitle>
      <v-row>
        <v-col>
          <v-form ref="wsFilterForm" v-model="filterForm">
            <v-text-field cols="12" Label="Date From" v-model="dateFrom" :rules="dateFromRules"
                          min="2022-05-02T00:00"
                          max="2030-05-02T00:00"
                          type="datetime-local"></v-text-field>
            <v-text-field
              cols="12"
              Label="Date To" v-model="dateTo" :rules="dateToRules"
              min="2022-05-02T00:00"
              max="2030-05-02T00:00"
              type="datetime-local"

            ></v-text-field>
            <v-card-actions class="justify-end">
              <v-btn color="primary"
                     dark
                     class="mb-1"
                     block
                     :disabled="!filterForm"
                     @click="filter">
                Filter
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-col>

        <v-col>
          <v-card class="float-xl-center" shaped max-width="400">
            <v-card-title class="justify-center">Agenda</v-card-title>
            <v-row>
              <v-col>
               <v-chip color="rgba(0, 255, 0, 0.5)">Available</v-chip>
              </v-col>
              <v-col class="ml-6">
                <v-chip color="#FB5D5D" opacity="0.3">Reserved</v-chip>
              </v-col>
              <v-col>
                <v-chip color="grey" opacity="0.3">Unavailable</v-chip>
              </v-col>
            </v-row>
          </v-card>

        </v-col>
      </v-row>
    </v-card>


    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         viewBox="0 0 1460 564">
      <image width="1460" height="564" href="../static/office_plan_-_page_3_x600 (1).png"></image>
      <a @click="openDialog(84)" xlink:title="Meeting Room #2">
        <rect x="11" y="2" v-bind:fill="getColor(84)" opacity="0.3" width="210" height="145"></rect>
      </a>

      <a xlink:title="Workspace #1" @click="openDialog(1)">
        <rect x="904" y="176" v-bind:fill="getColor(1)" opacity="0.3" width="50" height="50"></rect>
      </a>
      <a xlink:href="#" xlink:title="Workspace #2" @click="openDialog(2)">
        <rect x="904" y="239" v-bind:fill="getColor(2)" opacity="0.3" width="50" height="50"></rect>
      </a><a xlink:href="#" xlink:title="Workspace #3" @click="openDialog(3)">
      <rect x="904" y="297" v-bind:fill="getColor(3)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #4" @click="openDialog(4)">
      <rect x="967" y="205" v-bind:fill="getColor(4)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #5" @click="openDialog(5)">
      <rect x="994" y="280" v-bind:fill="getColor(5)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #6" @click="openDialog(6)">
      <rect x="1083" y="204" v-bind:fill="getColor(6)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #7" @click="openDialog(7)">
      <rect x="1083" y="278" v-bind:fill="getColor(7)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #8" @click="openDialog(8)">
      <rect x="1410" y="285" v-bind:fill="getColor(8)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #9" @click="openDialog(9)">
      <rect x="1410" y="350" v-bind:fill="getColor(9)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #10" @click="openDialog(10)">
      <rect x="1410" y="422" v-bind:fill="getColor(10)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #11" @click="openDialog(11)">
      <rect x="1410" y="498" v-bind:fill="getColor(11)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #12" @click="openDialog(12)">
      <rect x="1342" y="360" v-bind:fill="getColor(12)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #13" @click="openDialog(13)">
      <rect x="1342" y="425" v-bind:fill="getColor(13)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #14" @click="openDialog(14)">
      <rect x="1342" y="486" v-bind:fill="getColor(14)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #15" @click="openDialog(15)">
      <rect x="1292" y="360" v-bind:fill="getColor(15)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #16" @click="openDialog(16)">
      <rect x="1293" y="425" v-bind:fill="getColor(16)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #17" @click="openDialog(17)">
      <rect x="1293" y="486" v-bind:fill="getColor(17)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #18" @click="openDialog(18)">
      <rect x="1234" y="370" v-bind:fill="getColor(18)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #19" @click="openDialog(19)">
      <rect x="1234" y="433" v-bind:fill="getColor(19)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #20" @click="openDialog(20)">
      <rect x="1234" y="500" v-bind:fill="getColor(20)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #21" @click="openDialog(21)">
      <rect x="1184" y="411" v-bind:fill="getColor(21)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #22" @click="openDialog(22)">
      <rect x="1184" y="464" v-bind:fill="getColor(22)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #23" @click="openDialog(23)">
      <rect x="1095" y="456" v-bind:fill="getColor(23)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #24" @click="openDialog(24)">
      <rect x="1095" y="513" v-bind:fill="getColor(24)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #25" @click="openDialog(25)">
      <rect x="1045" y="456" v-bind:fill="getColor(25)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #26" @click="openDialog(26)">
      <rect x="1045" y="514" v-bind:fill="getColor(26)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #27" @click="openDialog(27)">
      <rect x="973" y="463" v-bind:fill="getColor(27)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #28" @click="openDialog(28)">
      <rect x="973" y="512" v-bind:fill="getColor(28)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #29" @click="openDialog(29)">
      <rect x="924" y="463" v-bind:fill="getColor(29)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Meeting Room #1" @click="openDialog(83)">
      <rect x="649" y="410" v-bind:fill="getColor(83)" opacity="0.3" width="135" height="146"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #30" @click="openDialog(30)">
      <rect x="923" y="512" v-bind:fill="getColor(30)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #31" @click="openDialog(31)">
      <rect x="852" y="510" v-bind:fill="getColor(31)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #32" @click="openDialog(32)">
      <rect x="795" y="510" v-bind:fill="getColor(32)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #33" @click="openDialog(33)">
      <rect x="1052" y="363" v-bind:fill="getColor(33)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #34" @click="openDialog(34)">
      <rect x="944" y="364" v-bind:fill="getColor(34)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #35" @click="openDialog(35)">
      <rect x="836" y="365" v-bind:fill="getColor(35)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #36" @click="openDialog(36)">
      <rect x="787" y="365" v-bind:fill="getColor(36)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #37" @click="openDialog(37)">
      <rect x="558" y="510" v-bind:fill="getColor(37)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #38" @click="openDialog(38)">
      <rect x="557" y="446" v-bind:fill="getColor(38)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #39" @click="openDialog(39)">
      <rect x="558" y="369" v-bind:fill="getColor(39)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #40" @click="openDialog(40)">
      <rect x="655" y="354" v-bind:fill="getColor(40)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #41" @click="openDialog(41)">
      <rect x="730" y="353" v-bind:fill="getColor(41)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #42" @click="openDialog(42)">
      <rect x="730" y="283" v-bind:fill="getColor(42)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #43" @click="openDialog(43)">
      <rect x="627" y="282" v-bind:fill="getColor(43)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #44" @click="openDialog(44)">
      <rect x="500" y="344" v-bind:fill="getColor(44)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #45" @click="openDialog(45)">
      <rect x="500" y="403" v-bind:fill="getColor(45)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #46" @click="openDialog(46)">
      <rect x="500" y="458" v-bind:fill="getColor(46)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #47" @click="openDialog(47)">
      <rect x="500" y="513" v-bind:fill="getColor(47)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #48" @click="openDialog(48)">
      <rect x="420" y="330" v-bind:fill="getColor(48)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #49" @click="openDialog(49)">
      <rect x="420" y="388" v-bind:fill="getColor(49)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #50" @click="openDialog(50)">
      <rect x="419" y="451" v-bind:fill="getColor(50)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #51" @click="openDialog(51)">
      <rect x="419" y="506" v-bind:fill="getColor(51)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #52" @click="openDialog(52)">
      <rect x="368" y="330" v-bind:fill="getColor(52)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #53" @click="openDialog(53)">
      <rect x="368" y="388" v-bind:fill="getColor(53)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #54" @click="openDialog(54)">
      <rect x="368" y="450" v-bind:fill="getColor(54)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #55" @click="openDialog(55)">
      <rect x="368" y="506" v-bind:fill="getColor(55)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #56" @click="openDialog(56)">
      <rect x="292" y="328" v-bind:fill="getColor(56)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #57" @click="openDialog(57)">
      <rect x="292" y="387" v-bind:fill="getColor(57)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #58" @click="openDialog(58)">
      <rect x="292" y="446" v-bind:fill="getColor(58)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #59" @click="openDialog(59)">
      <rect x="293" y="509" v-bind:fill="getColor(59)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #60" @click="openDialog(60)">
      <rect x="242" y="328" v-bind:fill="getColor(60)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #61" @click="openDialog(61)">
      <rect x="242" y="387" v-bind:fill="getColor(61)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #62" @click="openDialog(62)">
      <rect x="242" y="446" v-bind:fill="getColor(62)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #63" @click="openDialog(63)">
      <rect x="242" y="509" v-bind:fill="getColor(63)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #64" @click="openDialog(64)">
      <rect x="338" y="128" v-bind:fill="getColor(64)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #65" @click="openDialog(65)">
      <rect x="283" y="127" v-bind:fill="getColor(65)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #66" @click="openDialog(66)">
      <rect x="230" y="127" v-bind:fill="getColor(66)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #67" @click="openDialog(67)">
      <rect x="339" y="76" v-bind:fill="getColor(67)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #68" @click="openDialog(68)">
      <rect x="282" y="76" v-bind:fill="getColor(68)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #69" @click="openDialog(69)">
      <rect x="230" y="75" v-bind:fill="getColor(69)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #70" @click="openDialog(70)">
      <rect x="311" y="2" v-bind:fill="getColor(70)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #71" @click="openDialog(71)">
      <rect x="176" y="324" v-bind:fill="getColor(71)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #72" @click="openDialog(72)">
      <rect x="177" y="389" v-bind:fill="getColor(72)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #73" @click="openDialog(73)">
      <rect x="177" y="449" v-bind:fill="getColor(73)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #74" @click="openDialog(74)">
      <rect x="177" y="508" v-bind:fill="getColor(74)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #75" @click="openDialog(75)">
      <rect x="81" y="323" v-bind:fill="getColor(75)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #76" @click="openDialog(76)">
      <rect x="81" y="388" v-bind:fill="getColor(76)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #77" @click="openDialog(77)">
      <rect x="81" y="451" v-bind:fill="getColor(77)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #78" @click="openDialog(78)">
      <rect x="81" y="510" v-bind:fill="getColor(78)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #79" @click="openDialog(79)">
      <rect x="23" y="323" v-bind:fill="getColor(79)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #80" @click="openDialog(80)">
      <rect x="23" y="388" v-bind:fill="getColor(80)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #81" @click="openDialog(81)">
      <rect x="24" y="451" v-bind:fill="getColor(81)" opacity="0.3" width="50" height="50"></rect>
    </a><a xlink:href="#" xlink:title="Workspace #82" @click="openDialog(82)">
      <rect x="24" y="510" v-bind:fill="getColor(82)" opacity="0.3" width="50" height="50"></rect>
    </a>

    </svg>

    <v-dialog v-model="dialogReserve" max-width="600px">
      <v-card>
        <v-card-title class="headline">Workspace Details</v-card-title>
        <v-card-text>
          <v-text-field label="Table Name" v-model="workspaces.tableNumber" regular readonly></v-text-field>
          <v-text-field label="Monitors Count" v-model="workspaces.monitorsCount" regular readonly></v-text-field>
          <v-text-field label="Mounted / Seperated Monitors" v-model="workspaces.mount" regular readonly></v-text-field>
          <v-text-field label="Docking Station / PC" v-model="workspaces.dockingStation" regular
                        readonly></v-text-field>
          <v-text-field label="Headphones" v-model="workspaces.headPhones" regular readonly></v-text-field>
          <v-text-field label="Table Type" v-model="workspaces.tableType" regular readonly></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="text-left primary" text @click="closeDialog()">Cancel</v-btn>
          <v-btn class="text-left primary" text @click="reserve">Reserve</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <div class="text-center ma-2">

      <v-snackbar
        v-model="emptyFormSnackbar"
        color="error"
      >
        Please fill date fields in Reservation Picker Form!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="emptyFormSnackbar = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

    <div class="text-center ma-2">

      <v-snackbar
        v-model="alreadyReservedSnackbar"
        color="error"
      >
        This workspace is already reserved!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="alreadyReservedSnackbar = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

    <div>
      <v-snackbar
        v-model="reservationSuccess"
        color="success"
      >
        Reservation has been successful!

        <template v-slot:action="{ attrs }">
          <v-btn
            color="black"
            text
            v-bind="attrs"
            @click="reservationSuccess = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

  </v-container>
</template>
<script>
import moment, {now} from "moment-timezone";

export default {

  data: function () {
    return {
      reservationSuccess: false,
      dialogReserve: false,
      alreadyReservedSnackbar: false,
      emptyFormSnackbar: false,
      workspaces: {
        id: '',
        tableNumber: '',
        monitorsCount: '',
        mount: '',
        dockingStation: '',
        headPhones: '',
        tableType: '',
        reservations: []
      },
      dateFrom: '',

      dateTo: '',

      minimumTime: moment.tz(now(), 'UTC').format('YYYY-MM-DD HH:mm:ss'),
      dateFromRules: [

        v => !!v || "Required",
        v => v > this.minimumTime || "Date must be greater than Current time",
       // v => v < this.dateTo || "Date From can not be earlier than Date To date"
      ],
      dateToRules: [
        v => !!v || "Required",
        v => this.dateFrom < v || "Date To must be greater than Date From",
        v => v > this.minimumTime || "Date must be greater than Current time",
        v => moment(new Date(this.dateTo)).diff(moment(new Date(this.dateFrom)), 'months', true) < 1 ||
          "Reservation can not be longer than 1 month"

      ],
      reservations: [],
      allWorkspaces: [],
      workspaceCheck: [],
      moment: moment,
      filterForm: true,
      last30DaysReservations: 0
    }

  },
  components: {},
  mounted() {

    this.getWorkspaces()

  },
  watch: {
    dialogReserve(val) {
      val || this.closeDelete()
    },

  },
  methods: {
    closeDelete() {
      this.dialogReserve = false
      this.$nextTick(() => {

      })
    },

    getWorkspaces() {
      this.$axios.get(`api/workspaces`)
        .then(res => {
          this.allWorkspaces = res.data.data

        })

    },
    openDialog(id) {
      this.dialogReserve = true
      this.$axios.get(`/api/workspaces/${id}`)
        .then(response => {
          this.workspaces = response.data.data

        })
    },
    reserve() {
      // if form was filled
      if (this.$refs.wsFilterForm.validate()) {
        // if workspace is marked as available
        if (this.getColor(this.workspaces.id) === '#008000') {
          this.$axios.post(`/api/reservations/`, {
            user_id: this.$auth.user.id,
            dateFrom: this.dateFrom,
            dateTo: this.dateTo,
            workspace_id: this.workspaces.id
          })
            .then(response => {
              this.reservationSuccess = true
              this.sendConfirmationEmail(response.data.data.id)
              this.postEventToCalendar(response.data.data.id)
              setInterval(function () {
                window.location.reload()
              }, 5000);

            })
        } else this.alreadyReservedSnackbar = true
      } else {
        this.emptyFormSnackbar = true
      }
      this.dialogReserve = false

    },
    closeDialog() {
      this.dialogReserve = false
    },

    getColor(id) {
      const activeColor = '#008000';
      const inactiveColor = '#FF0000'
      if (this.workspaceCheck.length > 0) {
        if (this.workspaceCheck[id - 1].status === 'green') {
          return activeColor
        } else return inactiveColor

      }

    },
    sendConfirmationEmail(id) {

      this.$axios.get(`/api/send-email/${id}`)
        .then(response => {
          console.log(response)
        })


    },
    // Post event to user Outlook calendar
    postEventToCalendar(id) {
      this.$axios.get(`/api/postEvent/${id}`)
        .then(response => {
          console.log(response)
        })
    },


    filter() {
      let result = ''
      for (let i = 0; i < this.allWorkspaces.length; i++) {
        result = 'green'
        for (let j = 0; j < this.allWorkspaces[i].reservations.length; j++) {

          let filterInput1 = moment.tz(this.dateFrom, 'UTC').format('YYYY-MM-DD HH:mm:ss')
          let filterInput2 = moment.tz(this.dateTo, 'UTC').format('YYYY-MM-DD HH:mm:ss')
          let reservationFrom = moment.tz(this.allWorkspaces[i].reservations[j].dateFrom, 'UTC').format('YYYY-MM-DD HH:mm:ss')
          let reservationTo = moment.tz(this.allWorkspaces[i].reservations[j].dateTo, 'UTC').format('YYYY-MM-DD HH:mm:ss')

          if ((moment(filterInput1).isAfter(moment(reservationFrom)) && moment(filterInput1).isBefore(moment(reservationTo))) ||
            (moment(filterInput2).isAfter(moment(reservationFrom)) && moment(filterInput2).isBefore(moment(reservationTo))) ||
            (moment(filterInput1).isBefore(moment(reservationFrom)) && moment(filterInput2).isAfter(moment(reservationTo)))) {
            result = 'red'
            break

          } else {
            result = 'green'
          }

        }
        this.workspaceCheck.push({
          id: (i + 1).toString(),
          status: result
        })
      }

    }
  }


}

</script>
