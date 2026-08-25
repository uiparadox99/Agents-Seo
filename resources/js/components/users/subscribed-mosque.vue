<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>

      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
      <main class=" pt-0 pb-0 mt-1">
        <div class="container">
          <h5 class="text-left mt-4 mb-2 text-success" >Subscribed Mosques <router-link to="profile" class="btn btn-success btn-sm float-right">Back</router-link></h5>
        </div>
  <ContentLoader v-if="loading">
        <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
        <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
        <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
        <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
      </ContentLoader>
      <div class="container" v-else>
        <alert></alert>
          <div class="row" v-if="detail.subscribes != '' && detail.subscribes != null && detail.subscribes.length > 0">
            <div class="col-12 mb-5 mt-2"  v-for="r in detail.subscribes">
              <div class="b-shadow  position-relative">
              <div class="p-3">
                <div v-if="r.mosque.mosque_logo != '' && r.mosque.mosque_logo != null && r.mosque.mosque_logo.length > 0">
                  <div class="">
                    <img :src="$parent.BASE_API_PATH+'/uploads/'+r.mosque.mosque_logo[0].logo" alt="" class="w-100" style="    height: 190px;">
                  </div>
                </div>
                <div class="" v-else>
                  <img src="/assets/New/images/Rectangle 12.png" alt="" class="w-100" style="    height:190px ;">
                </div>
                <div class="">
                  <button @click="unsubscribe(r.id)" name="unsubscribe" class=" btn-sm  bg-white  text-dark position-absolute btn-sub text-uppercase un-radius "><h5 class="mb-0">Unsubscribe</h5> </button>
                </div>

                <div class="bell" v-if="datesComparision(r.mosque.prayers_updated_at,r.prayers_updated_at)" :id="'bell'+r.id">
                  <a  @click="updateTime(r.id,r.mosque.slug)" href="javascript:;"
                  class="bell-box position-absolute d-block text-center font-weight-bold"><i
                  class="fa fa-bell  d-block text-center bell-ico mb-2"></i><h5 class="mb-0">Prayers Times <br>
                  Changed</h5> </a>
                </div>
                
       
              <router-link :to="r.mosque.slug+'.html'" target="_blank"><h4 class="text-green text-center mt-3">{{r.mosque.name}}</h4></router-link>

              <div class="mt-3 ">
                <div class="text-center bell">
                  <a :href="'tel:'+r.mosque.phone" class="   bgc-green text-white font-size-12 pt-2 pb-2 pl-3 pr-3 btn-radius">Imam
                  Contact</a> &nbsp;&nbsp;&nbsp;
                  <a href="javascript:;" @click="$parent.jumaRegistration(r.mosque.id,r.mosque.slug)" class="  bgc-green font-size-12 text-white  pt-2 pb-2 pl-3 pr-3 btn-radius">Register
                  Jummah</a>
                  <div class="clearfix"></div>


                  <!-- <br>
                    <a target="_blank" href="/user/check-live-khutba?mosqueslug=<?php echo $r->slug ?>&checkKhutba=yes" class="  bgc-green text-white   pt-2 pb-2 pl-3 pr-3 btn-radius">Live Jummah Khutba</a> -->
                  </div>
                </div>
                       </div>
              </div>
            </div>
           </div>
        


       <p class="text-center" v-else>No Mosque Subscribed</p>
         </div>



     </main>

     <VFooter></VFooter>
   </div>
 </div>
</template>

<script>
export default {
  data (){
    return {
      loading: true,
      message: "",
      error_message: "",
      has_error: false,
      submitted: false,
      history:0,
      detail: {},
    }
  },
  beforeMount(){
    this.getData();
  },
  methods: {

    getData(){

      var dataUrl = 'v1/user-profile/'+this.$store.getters.getUser.id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.detail = result.data.data;
        this.loading = false;
      }, error => {

      });           
    },
    datesComparision(mDate,sDate){
      mDate = new Date(mDate);
      sDate = new Date(sDate);
      if (mDate > sDate) {
        return true;
      }
      return false;
    },
    changeview(check){
      this.history = check;
    },
    unsubscribe(id){
      if (confirm('Are You Sure?')) {
        this.loading = true;
        var dataUrl = 'v1/unsubscribe?id='+id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          if (result.status) {
            this.$parent.success_message = 'Unsubscribed Successfully';
            this.getData();
          }else{
            this.$parent.error_message = '';
            setTimeout(function() {
              $this.error_message = "";
              $this.has_error = false;
            }, 5000);
          }
        }, error => {

        }); 
      }
    },
    deleteRegisterd(id){
      if (confirm('Are You Sure?')) {
        this.loading = true;
        var dataUrl = 'v1/delete-participated-jumma/'+id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          if (result.status) {
            this.$parent.success_message = 'Juma Registration Deleted Successfully';
            this.getData();
          }else{
            this.$parent.error_message = '';
            setTimeout(function() {
              $this.error_message = "";
              $this.has_error = false;
            }, 5000);
          }
        }, error => {

        }); 
      }
    },
    deleteBookmark(id){
      if (confirm('Are You Sure?')) {
        this.loading = true;
        var dataUrl = 'v1/delete-bookmark/'+id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          if (result.status) {
            this.$parent.success_message = 'Bookmark Deleted Successfully';
            this.getData();
          }else{
            this.$parent.error_message = '';
            setTimeout(function() {
              $this.error_message = "";
              $this.has_error = false;
            }, 5000);
          }
        }, error => {

        }); 
      }
    },
    updateTime(id,slug){


      var dataUrl = 'v1/update-subscribe-prayer/'+id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        if (result.status) {
          $('#bell'+id).remove();
          this.$router.push('/'+slug+'.html');
        }else{
          this.$parent.error_message = '';
          setTimeout(function() {
            $this.error_message = "";
            $this.has_error = false;
          }, 5000);
        }
      }, error => {

      }); 
      
    },
    checkDateGreater(date){
      date = new Date(date);
      var today = new Date();
      if(date > today){
        return true;
      }
      return false;
    }
  }
}
</script>