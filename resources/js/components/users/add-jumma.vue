<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
     	<main class="container pt-5 pb-5">


  <div class="row">
    <!--LEFT SECTION-->
    <div class="col-md-3">
     <VLSidebar></VLSidebar>
    </div>
    <!--CENTER SECTION-->
    <div class="col-md-9">
      <div class="shadow p-4">

						<h4 class="text-green">Add Jummah Timming</h4>
					<div class="mt-3">

						<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
		                    <!-- <div class="modal-header">
		                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		                    </div> -->
		              
		                    <div class="row">
		                    	
		                        <input type="hidden" name="id" v-model="form.id" id="id" />
                                 
		                       
		                        <div class="form-group col-sm-3">
		                        	<!-- <label class="btn-block text-center">Select Date</label> -->
		                             <Datepicker name="datepicker" format="yyyy-MM-dd"  :disabled-dates="disabledDates" v-model="form.date" input-class="datefield" v-validate="'required'" :class="[{ 'error': submitted && errors.has('date') }]" data-vv-as="date" placeholder="Select Date" ></Datepicker>
							   <span v-show="errors.has('datepicker')" class="text-danger">{{ errors.first('datepicker') }}</span>
							    </div>	
		                        <div class="form-group col-sm-3">
		                        	<!-- <label class="btn-block text-center">Start /  Adhaan Time</label> -->
		                        	<input type="text" minlength="5"  name="start" v-model='form.start' v-validate="'required'"  :class="[{ 'error': submitted && errors.has('start') }, 'form-control']" data-vv-as="start" autocomplete="off"  placeholder="Start / Adhaan Time" v-mask="$parent.timeMask">
		                      <span v-show="errors.has('start')" class="text-danger">{{ errors.first('start') }}</span>
							    </div>
		                        <div class="form-group col-sm-3">
		                        <!-- 	<label class="btn-block text-center">Jammat Time</label> -->
		                        	<input type="text" name="jammat" minlength="5" v-model='form.jammat' v-validate="'required'" :class="[{ 'error': submitted && errors.has('jammat') }, 'form-control']" data-vv-as="jammat" autocomplete="off" placeholder="Jammat Time" v-mask="$parent.timeMask">
		                        <span v-show="errors.has('jammat')" class="text-danger">{{ errors.first('jammat') }}</span>
								</div>	
		                         <div class="form-group col-sm-3">
		                        	<!-- <label class="btn-block text-center">Max Capacity</label> -->
		                        	<input type="text" v-model='form.max_capacity' v-validate="'required'" maxlength="4" name="max_capacity" :class="[{ 'error': submitted && errors.has('max_capacity') }, 'form-control']" data-vv-as="max_capacity" placeholder="Max Capacity" v-mask="'####'">
		                            <span v-show="errors.has('max_capacity')" class="text-danger">{{ errors.first('max_capacity') }}</span>
							    </div>	
		                        
		                    </div>
		                     <div class="row">
		                    <!-- <?php if (empty($detail)) { ?> -->
		                    	 <div class="form-group col-sm-4">
		                    	 	<label>Same for coming weeks?</label>
		                    	 	<select name="weeks" v-model='form.weeks' :class="[{ 'error': submitted && errors.has('weeks') }, 'form-control']" data-vv-as="weeks">
		                    	 		<option value="">Select</option>
		                    	 		<option value="1">1</option>
		                    	 		<option value="2">2</option>
		                    	 		<option value="3">3</option>
		                    	 	</select>
									 <!-- <span v-show="errors.has('weeks')" class="text-danger">{{ errors.first('subject') }}</span> -->
		                    	 </div>
		                    	  <!-- <?php } ?> -->
		                    	   <div class="form-group col-sm-3 pr-0">
		                    	  	<label class="btn-block">&nbsp;</label>
		                    	  	<label>
									  <input type="checkbox" v-if="form.check_temprature == 1" @click="check($event)" checked="" name="check_temprature"> 
									  <input type="checkbox" name="check_temprature" v-else @click="check($event)" class=""> Check Temperature ?
									  </label>
		                    	  </div>
		                    	  <div class="form-group col-sm-3">
		                    	  	<label>&nbsp;</label>
		                    	      <button type="submit" name="save" class="btn btn-success pl-5 pr-5 btn-sm btn-block" v-if="!submitted">SAVE</button>
								      <button disabled="" class="btn btn-success pl-5 pr-5 btn-sm btn-block" v-else><i class="fa fa-spine fa-spinner"></i></button>
		                    	  </div>
		                        
		                    </div>
		            
		               
		                </form>
					</div>			
				</div>
			</div>
			<!--RIGHT SECTION-->
			
		</div>
</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
   	<main class="container pt-2 pb-2">
      <VLSidebar></VLSidebar>
      <div class=" ">
						<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> Jummah Timming</h4>
						<div class="clearfix"></div>
					<div class="mt-4">

						<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
		                    <!-- <div class="modal-header">
		                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		                    </div> -->
		                    
		                    <div class=" row">
		                    	
		                        <input type="hidden" name="id" v-model="form.id" id="id" />

		                       
		                        <div class="form-group col-6 pr-2">
		                           <Datepicker name="datepicker" format="yyyy-MM-dd" v-model="form.date" input-class="datefield" v-validate="'required'" :class="[{ 'error': submitted && errors.has('date') },'font-size-12  date']" data-vv-as="date" placeholder="Select Date" ></Datepicker>
		                       <span v-show="errors.has('datepicker')" class="text-danger">{{ errors.first('datepicker') }}</span>
							    </div>	
		                        <div class="form-group col-6 pl-2">
		                          <input type="text" minlength="5"  name="start" v-model='form.start' v-validate="'required'"  :class="[{ 'error': submitted && errors.has('start') }, 'form-control font-size-12 p-2  time']" data-vv-as="start" autocomplete="off"  placeholder="Start / Adhaan Time" v-mask="$parent.timeMask">
		                       <span v-show="errors.has('start')" class="text-danger">{{ errors.first('start') }}</span>
							    </div>
		                        <div class="form-group col-6  pr-2">
                                   <input type="text" name="jammat" minlength="5" v-model='form.jammat' v-validate="'required'" :class="[{ 'error': submitted && errors.has('jammat') }, 'form-control font-size-12 p-2 time']" data-vv-as="jammat" autocomplete="off" placeholder="Jammat Time" v-mask="$parent.timeMask">
		                       <span v-show="errors.has('jammat')" class="text-danger">{{ errors.first('jammat') }}</span>
							    </div>	
		                         <div class="form-group col-6 pl-2">
		                        	<input type="text" v-model='form.max_capacity' v-validate="'required'" maxlength="4" name="max_capacity" :class="[{ 'error': submitted && errors.has('max_capacity') }, 'form-control font-size-12 p-2']" data-vv-as="max_capacity" placeholder="Max Capacity" v-mask="'####'">
		                      <span v-show="errors.has('max_capacity')" class="text-danger">{{ errors.first('max_capacity') }}</span>
							    </div>	
		                         <!-- <?php if (empty($detail)) { ?>-->
		                    	 <div class="form-group col-12 ">
		                    	 	<label>Same for coming weeks?</label>
		                    	 	
									<select name="weeks" v-model='form.weeks' :class="[{ 'error': submitted && errors.has('weeks') }, 'form-control']" data-vv-as="weeks">
		                    	 		<option value="">Select</option>
		                    	 		<option value="1">1</option>
		                    	 		<option value="2">2</option>
		                    	 		<option value="3">3</option>
		                    	 	</select>
		                    	 </div>
		                    
		                    	<!--   <?php } ?> -->
		                    	  	  <div class="form-group col-12 ">
		                    	
		                    	  	<label>
										<input type="checkbox" v-if="form.check_temprature == 1" @click="check($event)" checked="" name="check_temprature" value="1"> 
									  <input type="checkbox" name="check_temprature" v-else @click="check($event)" class=""> Check Temperature ?</label>
		                    	  </div>
		                        
		                    </div>

		                    <div class=" text-center">
		                        <button type="submit" name="save" class="btn btn-success pl-5 pr-5 btn-sm btn-block" v-if="!submitted">SAVE</button>
								<button disabled="" class="btn btn-success pl-5 pr-5" v-else><i class="fa fa-spine fa-spinner"></i></button>
		                        
		                    </div>
		                </form>
					</div>			
				</div>
			
</main>

      <VFooter></VFooter>
    </div>
  </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
export default {
	data (){
		return {
			
			detail: '',
			error_message: "",
			has_error: false,
			submitted: false,
			disabledDates: {
				to: new Date()
			},
			form:{
				id:'',
				mosque_id:this.$store.getters.getMosque.id,
				start:'',
				date: this.datepicker,
				jammat:'',
				max_capacity:'',
				weeks:'',
				check_temprature:'',
				updateId: this.$route.params.id
			}
		}

	},

	beforeMount(){
		this.getData();
	},
	  components: {
            Datepicker
        },
	methods: {
		getData(){
			if (typeof this.$route.params.id !== 'undefined' && this.$route.params.id != '') {
				var dataUrl = 'v1/update-juma-timing/'+this.$route.params.id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					var data = result.data.data
					this.detail = data;
					this.form.id = data.id;
					this.form.mosque_id = data.mosque_id;
					this.form.start = data.start;
					this.form.date = data.date;
					this.form.jammat = data.jamaat;
					this.form.max_capacity = data.max_capacity;
					this.form.check_temprature = data.check_temprature;
					
					
				}, error => {

				});
			}
			         
		},
		check(e){
			if (e.target.checked) {
				this.form.check_temprature = 1;
			}else{
				this.form.check_temprature = 0;
			}
		},
		submit(){
		
			var $this = this;
			this.submitted = true;
			this.$validator.validate().then(valid => {
				if (valid) {
					this.error_message = "";
					this.has_error = false;
					let formData = new FormData();
					for (var key of Object.keys(this.form)) {
						formData.append(key, this.form[key]);
					}
					
					
					axios({
						method: "POST",
						url: "v1/add-juma",
						data: formData,
						headers: { "content-type": "application/json" }
					}).then(  response => {
						var response = response.data;
						if (response.status) {			
							this.$parent.success_message = 'Jumma Timing Added Successfully';				
							this.$router.push({path: '/user/manage-jumma'});
						}else{
							this.has_error = true;
							this.error_message = response.message;
							setTimeout(function() {
								$this.error_message = "";
								$this.has_error = false;
								$this.submitted = false;
							}, 5000);
						}
					});
				}else{
					this.has_error = true;
					this.error_message = this.errors.items[0].msg;
					setTimeout(function() {
						$this.error_message = "";
						$this.has_error = false;
						$this.submitted = false;
					}, 5000);
				}
			});
	

		}
	}
}
</script>

<style>
.datefield{
	height: 35px;
	width: 100%;
	border:1px solid #ced4da;
	border-radius:3.5px;
	text-align:center;
	
}
</style>