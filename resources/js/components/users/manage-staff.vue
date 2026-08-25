<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
      <main class="container pt-5 pb-5">
        <div class="row">
          <div class="col-md-3 mb-5">
           <VLSidebar></VLSidebar>
         </div>

         <div class="col-md-9  ">
          <div class="p-4 shadow ">

            <div class="row">
              <div class="col-md-6">
                <h2 class="text-green jr-res">Manage Staff</h2>
              </div>
              <div class="col-md-6">
                <div class="text-right">
                  <router-link to="/user/add-staff"  class="btn bgc-green text-white  pl-5 pr-5  pt-1 pb-1 b-radius">Add Staff</router-link>
                </div>
              </div>
            </div>
  <alert></alert>
<ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>
            <div class="row" v-else-if="staff != '' && staff.length > 0">
      
      
              <div class="col-md-4 mb-3" v-for="r in staff" :id="r.id">
              <div style="border:1px solid #f0f0f0;border-radius: 5px">
                <h5 class="green-heading" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">{{ r.designation}}</h5>
              <div class="text-center p-2">
             <router-link :to="'/user/edit-staff/'+r.id" class="text-success float-right"><i class="fa fa-edit"></i></router-link>
            
                      <button @click="deleteStaff(r.id)" name="deleteStaff" class="text-danger float-left p-1" style="border:0"><i class="fa fa-trash"></i></button>
                 


                      <img :src="$parent.BASE_API_PATH+'/uploads/'+r.image" style="width: 170px;height: 170px;border-radius: 50%;"  v-if="r.image != '' && r.image != null">

                 
                      <img :src="'/assets/New/images/Rectangle 92.png'" style="width: 170px;height: 170px;border-radius: 50%;" v-else>
                 
                  
                      <p class="mb-0 mt-3 color-light">{{ r.name }} </p>
                      <p class="mb-0 color-light">{{ r.email }}</p>
                      <p class="mb-0 color-light">{{ r.phone }}</p>
              
             
                      <button class="btn btn-sm btn-success btn-radius " @click="changeStatus(0,r.id)" :id="'button'+r.id" v-if="r.active == 1">Active</button>
                 
                      <button class="btn btn-sm btn-danger btn-radius" @click="changeStatus(1,r.id)" :id="'button'+r.id" v-else>Inactive</button>
                  
                    
                    </div>
                 </div>
            </div>
          
            
         

          </div>
          <h4 class="text-center text-success" v-else>No Record Found</h4>
        </div>
      </div>
    </div>
  </main>
  <VFooter></VFooter>
</div>
<div v-if="$isMobile()">
  <VGHeader></VGHeader>
  <main class="container pt-3 pb-3">

   <VLSidebar></VLSidebar>

   <h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button>Manage Staff</h4>
   
   <div class="text-center mb-2">
    <router-link to="/user/add-staff"  class="btn bgc-green text-white  btn-sm pl-5 pr-5">Add Staff</router-link>
  </div>
  <alert></alert>

<ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>
            <div class="row" v-else-if="staff != '' && staff.length > 0">
    <div class="col-6" v-for="r in staff" :id="r.id">
              <div style="border:1px solid #f0f0f0;border-radius: 5px">
          
              <div class="text-center p-2">
             <router-link :to="'/user/edit-staff/'+r.id" class="text-success float-right"><i class="fa fa-edit"></i></router-link>
            
                      <button @click="deleteStaff(r.id)" name="deleteStaff" class="text-danger float-left p-1" style="border:0"><i class="fa fa-trash"></i></button>
                 


                      <img :src="$parent.BASE_API_PATH+'/uploads/'+r.image" style="width:100%;height: 130px;border-radius: 50%;"  v-if="r.image != '' && r.image != null">

                 
                      <img :src="'/assets/New/images/Rectangle 92.png'" style="width: 100%;height: 130px;border-radius: 50%;" v-else>
                 
                  
                      <p class="mb-0 mt-3">{{ r.name }} </p>
                      <p class="mb-0" style="word-break: break-all;">{{ r.email }}</p>
                      <p class="mb-0">{{ r.phone }}</p>
              
             
                      <button class="btn btn-sm btn-success btn-radius " @click="changeStatus(0,r.id)" :id="'button'+r.id" v-if="r.active == 1">Active</button>
                 
                      <button class="btn btn-sm btn-danger btn-radius" @click="changeStatus(1,r.id)" :id="'button'+r.id" v-else>Inactive</button>
                  
                    
                    </div>
                 </div>
            </div>
        

          </div>
          <h4 class="text-center text-success" v-else>No Record Found</h4>

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
      has_message: false,
      error_message: false,
      mosque_id:'',
      staff: {},
    }

  },
  beforeMount(){
    this.mosque_id = this.$store.getters.getMosque.mosque_id;
    this.getData();

  },
  methods: {
    getData(){
      var dataUrl = 'v1/mosque-staff/'+this.$store.getters.getMosque.id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.staff = result.data.data;
        this.loading = false;
      }, error => {

      });           
    },
    deleteStaff(id){
      if (confirm('Are You Sure?')) {
        var dataUrl = 'v1/delete-mosque-staff/'+id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          if (result.status) {
            this.$parent.success_message = 'Staff Deleted';
            $('#'+id).remove();
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
    changeStatus(active,id){
      this.loading = false;
        var dataUrl = 'v1/change-staff-status/';
        axios({ method: "POST", "url":dataUrl, data: {'id':id,'active':active},"headers": { "content-type": "application/json" } }).then(result => {
          if (result.status) {
            this.$parent.success_message = 'Staff Status Changed';
            this.getData();
          /*  if (active == 1) {
                $('#button'+id).removeClass('btn-danger');
                $('#button'+id).addClass('btn-success');
                $('#button'+id).html('Active');
            }else{
               $('#button'+id).removeClass('btn-success');
                $('#button'+id).addClass('btn-danger');
                $('#button'+id).html('Inactive');
            }*/
          
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
    showtime(time){
      time = time.split('-');
      return time[0]+' to '+time[1];
    }
  }
}
</script>