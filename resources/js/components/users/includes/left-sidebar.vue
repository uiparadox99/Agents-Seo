<template>
  <div>
    <div v-if="!$isMobile()">
      <div class="bgc b-radius mb-5">
        <ul class="jr-list user-sidebar">
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/donation-apeals' }, 'b-border'] ">
            <router-link to="/user/donation-apeals">
            Donation & Appeals</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/course' }, 'b-border'] ">
            <router-link to="/user/course"
            >Education & Courses</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/event' }, 'b-border'] ">
            <router-link to="/user/event">Upcoming Events</router-link>
          </li>

          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/detail' }, 'b-border'] "
          >
          <router-link to="/user/detail"> Mosque Detail</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/mosqueimages' }, 'b-border'] ">
          <router-link to="/user/mosqueimages">
          Mosque Image</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/namaz-timing' }, 'b-border'] " >
          <a :href="'/user/namaz-timing?user_mosque='+this.$store.getters.getMosque.id+'&user_id='+this.$store.getters.getUser.id">
          Namaz Timings</a>
        </li>

        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-jumma'+ 'history=yes' || this.$route.path == '/user/manage-jumma' || this.$route.path == 'user/add-jumma' }, 'b-border'] " >
          <router-link to="/user/manage-jumma"
          >Jumma Registration</router-link>
        </li>

        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-staff' }, 'b-border'] ">
          <router-link to="/user/manage-staff">Manage Staff</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/bank-detail' }, 'b-border'] " >
          <router-link to="/user/bank-detail">
          Bank Accounts</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-facilities' }, 'b-border'] ">
          <router-link to="/user/manage-facilities"
          >Mosque Facilities</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/ramadan' }, 'b-border'] ">
          <router-link to="/user/ramadan"> Ramadan Timings</router-link>
        </li>
        <li
        class="b-border <?php echo $current_url == BASE_PATH.'/user/user-logs'?'bgc-green text-white':'' ?>"
        >
        <router-link to="/user/user-logs">User Logs</router-link>
      </li>
      <li :class="[{ 'bgc-green text-white': this.$route.path == '/contact-us' }, 'b-border'] ">
        <router-link to="/contact-us"
        >Contact MosqueFinder</router-link>
      </li>
      <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/live-adhan' }, 'b-border'] " >
        <router-link to="/user/live-adhan">Live Adhan</router-link>
      </li>
      <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/live-khutba' }, 'b-border'] ">
        <router-link to="/user/live-khutba">Live Khutba</router-link>
      </li>

      <li :class="[{ 'bgc-green text-white': this.$route.path == '/change-password' }, 'b-border'] ">
        <router-link to="/change-password">Change Password</router-link>
      </li>

      <li><a href="javascript:;" @click="$parent.$parent.logout()">Log Out</a></li>
    </ul>
  </div>
</div>
<div v-else>
  <div class="sidebarFilter userLinks">
    <div class="modal left fade" id="sidebar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-body">
           <ul class="jr-list">
            <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/donation-apeals' }, 'b-border'] ">
              <router-link to="/user/donation-apeals">
              Donation & Appeals</router-link>
            </li>
            <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/course' }, 'b-border'] ">
              <router-link to="/user/course"
              >Education & Courses</router-link>
            </li>
            <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/event' }, 'b-border'] ">
              <router-link to="/user/event">Upcoming Events</router-link>
            </li>

            <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/detail' }, 'b-border'] "
            >
            <router-link to="/user/detail"> Mosque Detail</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/mosqueimages' }, 'b-border'] ">
            <router-link to="/user/mosqueimages">
            Mosque Image</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/namaz-timing' }, 'b-border'] " >
            <router-link to="/user/namaz-timing">
            Namaz Timings</router-link>
          </li>

          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-jumma' }, 'b-border'] " >
            <router-link to="/user/manage-jumma"
            >Jumma Registration</router-link>
          </li>

          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-staff' }, 'b-border'] ">
            <router-link to="/user/manage-staff">Manage Staff</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/bank-detail' }, 'b-border'] " >
            <router-link to="/user/bank-detail">
            Bank Accounts</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/manage-facilities' }, 'b-border'] ">
            <router-link to="/user/manage-facilities"
            >Mosque Facilities</router-link>
          </li>
          <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/ramadan' }, 'b-border'] ">
            <router-link to="/user/ramadan"> Ramadan Timings</router-link>
          </li>
          <li
          class="b-border <?php echo $current_url == BASE_PATH.'/user/user-logs'?'bgc-green text-white':'' ?>"
          >
          <router-link to="/user/user-logs">User Logs</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/contact-us' }, 'b-border'] ">
          <router-link to="/contact-us"
          >Contact MosqueFinder</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/live-adhan' }, 'b-border'] " >
          <router-link to="/user/live-adhan">Live Adhan</router-link>
        </li>
        <li :class="[{ 'bgc-green text-white': this.$route.path == '/user/live-khutba' }, 'b-border'] ">
          <router-link to="/user/live-khutba">Live Khutba</router-link>
        </li>

        <li :class="[{ 'bgc-green text-white': this.$route.path == '/change-password' }, 'b-border'] ">
          <router-link to="/change-password">Change Password</router-link>
        </li>

        <li><a href="javascript:;" @click="$parent.$parent.logout()">Log Out</a></li>

      </ul>
    </div>

  </div>
</div>
</div>
</div>
</div>
</div>
</template>