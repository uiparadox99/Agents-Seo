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

      <h4 class="text-green">Registered  Users of ({{mainData.date}})</h4>
      <alert></alert>
      <div class="mt-3">
        <div class="ds-boar-title">
        
        </div>
        <div class="table-responsive">
          
  
        <table class="table table-bordered table-striped datatable" id="">
          <thead>
            <tr class="bgc-green text-white">
             <th>Name</th>                
             <th>Person Name</th>                
             <th>3rd Person Name</th>                
             <th>Email</th>                
             <th>Phone</th>                
             <th>Temperature</th>                
             <th>Action</th>                
            </tr>
            </thead>
          
               <tbody>
             
                  <tr v-if="participants.length > 0" v-for ="(data, index) in participants">
                    
                    <td v-if="data.first_name && data.last_name !=''">{{data.first_name}} {{data.last_name}}</td>
                    <td v-if="data.person_name != ''">{{data.person_name}}</td>
                    <td v-if="data['3rd_person_name'] !=''">{{data['3rd_person_name']}}</td>
                    <td v-if="data.email !=''">{{data.email}}</td>
                    <td v-if="data.phone !=''">{{data.phone}}</td>
                     <td v-if="data.temprature !=''">{{data.temprature}}</td>
                    
                    <td>
                      <button v-if="{disabled:data.participate_id == 1 && checkinTime >= data.date}" class="btn btn-success btn-xs btn-sm"><i class="fa fa-check-circle"></i></button>
                      <form  v-else-if="data.date == checkinTime" @submit.prevent="checkedIn(data.participate_id)" class="float-right" >
                        <input type="hidden" v-model="form.id" name="id">
                        <button type="submit" name="checkin" class="btn btn-success btn-xs btn-sm "><i class="fa fa-check"></i></button></form>
                
                     <form class="float-left" @submit.prevent="deleteParticipate(data.participate_id)">
                       <input type="hidden" v-model="form.id" name="id">
                        <button type="submit" name="deleteBooking" class="btn btn-danger btn-xs btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                  </tr>
             
              
                <tr v-else>
                  <td colspan="6" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>
                </tr>
              
            </tbody>
            
          </table>
 </div>
          
          
          
          

        </div>
      </div>
    </div>

    <!-- GET QUOTES Popup END -->

    <!--RIGHT SECTION-->
    
  </div>
</main>

      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>

<main class="container pt-3 pb-3">



    <VLSidebar></VLSidebar>



    <div class="">

      <h5 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> Registered  Users of ({{mainData.date}})</h5>
      
      <div class="mt-3">
        <div class="ds-boar-title">
         <alert></alert>
        </div>
        <div class="table-responsive">
          
      
        <table class="table table-bordered table-striped datatable" id="">
          <thead>
            <tr class="bgc-green text-white">
             <th class="font-size-12 pl-1">Name</th> 
                               
             <th class="font-size-12 pl-1">Email</th>                
             <th class="font-size-12 pl-1">Phone</th> 
                            
             <th class="font-size-12 pl-1">Action</th>                
            </tr>
            </thead>
                <tbody>
               
                
                  <tr v-if="participants.length > 0" v-for ="(data, index) in participants">
                    <td v-if="data.first_name && data.last_name !=''">{{data.first_name}} {{data.last_name}}</td>
                   
                     <td v-if="data.email !=''">{{data.email}}</td>
                    <td v-if="data.phone !=''">{{data.phone}}</td>
                   
                    <td>
                    
                        <button v-if="{disabled:data.participate_id == 1 && checkinTime >= data.date}" class="btn btn-success btn-xs btn-sm"><i class="fa fa-check-circle"></i></button>
                    
                      <form v-else-if="data.date == checkinTime" @submit.prevent="checkedIn(data.participate_id)" class="float-right">
                         <input type="hidden" v-model="form.id" name="id">
                        <button type="submit" name="checkin" class="btn btn-success btn-xs btn-sm"><i class="fa fa-check"></i></button></form>
                  

                    <form action="" method="post" class="float-left" @submit.prevent="deleteParticipate(data.participate_id)">
                         <input type="hidden" v-model="form.id" name="id">
                        <button type="submit" name="deleteBooking" class="btn btn-danger btn-xs btn-sm"><i class="fa fa-trash"></i></button></form>
                    </td>
                  </tr>
             
                <tr v-else>
                  <td colspan="6" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>
                </tr>
             
            </tbody>
            
          </table>
            </div>

          
          
          
          

        </div>
      </div>

</main>


      <VFooter></VFooter>
    </div>
  </div>
</template>


<script>
export default {
	data(){
		return{
      mainData: '',
      id: this.$route.params.id,
      mosque_id: this.$store.getters.getMosque.id,
      participants:'',
      dateformat:'',
      form:{
        id:'',
				checked_in:'',
			
			}
		}
	},
	beforeMount(){
    this.getData();
  
	},

	methods:{
			getData(){
			var dataUrl = 'v1/check-participants/'+this.id+'/'+this.mosque_id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.mainData = result.data.data;
        this.participants = this.mainData.participate
        
				
			}, error => {

			});           
		},

    
  	deleteParticipate(participate_id){
    
			if (confirm('Are You Sure?')) {
				var dataUrl = 'v1/delete-participants/'+participate_id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					if (result.status) {
						this.$parent.success_message = 'Participant Deleted';
						$('#'+participate_id).remove();
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



    async checkedIn(participate_id) {
        this.form.id = participate_id;
        await axios.post('v1/checkedIn', this.form).then(result =>{
          		if (result.status) {
						this.$parent.success_message = 'Checked In Successfully';
						
					}else{
					    this.$parent.error_message = '';
						setTimeout(function() {
							$this.error_message = "";
							$this.has_error = false;
						}, 5000);
					}
        });
         
    }
	},



}
</script>