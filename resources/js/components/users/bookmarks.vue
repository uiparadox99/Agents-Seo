<template>
  <div>
    

      <VGHeader></VGHeader>
         <ContentLoader v-if="loading">
        <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
        <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
        <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
        <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
      </ContentLoader>
     <div class="container" v-else>
          <div class="b-shadow mt-3 mb-3 p-3">
               <h5 class="text-left mb-4 text-success" >Yours Bookmarks <router-link to="/profile" class="btn btn-success btn-sm float-right">Back</router-link></h5>
     
          <div v-if="detail.bookmarks != '' && detail.bookmarks != null && detail.bookmarks.length > 0" v-for="r in detail.bookmarks"> 
            

          <div class="row mt-2" >
         
            <div class="col-10">

            <div style="font-size:12px; overflow: hidden;" ><a :href="r.url" target="_blank" >{{r.url}}</a></div>

            </div>

            <div class="col-2">
             
              
              <button @click="deleteBookmark(r.id)" name="deleteBookmark" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
              <div class="clearfix"></div>
              </div>
          </div>
          <hr style="margin-top: 0.3rem;
    margin-bottom: 0rem;">
                    </div>
							<p class="text-center mt-2 mb-2 p-2" v-else   style="font-size:12px">No Bookmark Added</p>
					
						<div class="clearfix"></div>
			</div>

 </div>

      <VFooter></VFooter>
  
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