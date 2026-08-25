<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
     
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
        <ContentLoader v-if="loading">
        <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
        <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
        <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
        <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
      </ContentLoader>
     <main class="container mt-3 mb-5" v-else>
      <alert></alert>
  <h5 class="text-left mt-4 mb-2 text-success" >Subscribed Courses <router-link to="/profile" class="btn btn-success btn-sm float-right">Back</router-link></h5>



    <div class=" mt-4" v-if="detail.user_courses != '' && detail.user_courses != null && detail.user_courses.length > 0">

        <div class="shadow mb-3" v-for="r in detail.user_courses" v-if="r.active == 1">

         <div class="card-deck">
          <div class="card">
           

              <div class="course-box">
   

              <img :src="$parent.BASE_API_PATH+'/uploads/'+r.course.img"  v-if="r.course.img != '' && r.course.img != null" style="height: 220px; width:100%;">

                <img src="/assets/New/images/Rectangle 92.png" v-else style="height: 220px; width:100%;">
              <div class="course-img">
                <div class="shadow p-2 mb-1 bg-success rounded ">{{r.course.name.substring(0,30)}}</div>
              </div>
             <!--  <div class="live-class-icon">
                <div class="p-2 mb-1"><img src="<?php echo BASE_PATH; ?>public/New/images/live dot.png" style="margin-right:15px; margin-left:3px"><span>Live class</span></div>
              </div> -->
            </div>
            <div class="card-body">

              <a class="card-link"> <strong class="text-success">Time:</strong> {{r.course.class_time}}</a>

              <a href="#" class="card-link text-success" style="float:right">£ {{r.course.price}}</a>
              <p class="card-text mt-1" style="text-align:justify">{{r.course.description.substring(0,120)}}</p>
             <!--  <div class="text-center">
                <form method="post" action="">
                  <input type="hidden" name="course_id" value="<?php echo $r->id ?>">             
                  <input type="hidden" name="mosque_slug" value="<?php echo $slug ?>">              
                  <button type="submit" name="apply" class="btn btn-success text-white pl-5 pr-5 b-radius" style="border-radius: 102px;">Not Yet Live!</button>
                </form>
              </div> -->
            </div>
          </div>
        </div>

      </div>  
  
  </div>

  <p class=" text-center" v-else>Course Not Subscribed Yet!</p>

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