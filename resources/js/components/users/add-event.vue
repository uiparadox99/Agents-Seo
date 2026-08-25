<template>
	<div>
		<div v-if="!$isMobile()">
			<VGHeader></VGHeader>
			<main class="container pt-5 pb-5">

				<div class="row">
					<div class="col-md-3">
						<VLSidebar></VLSidebar>
					</div>
					<div class="col-md-9">
						<div class="shadow p-4">
							<h4 class="text-green">Add / Edit Event</h4>
							<alert></alert>
							<div class="mt-3">
								<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
									<div class=" row">

										<input type="hidden" name="id" id="id" v-model="form.id" />

										<div class="form-group col-sm-4">
											<label>Image</label>
											<input type="file" name="img" ref="file" class="form-control" v-on:change="handleFileUploads()" style="border: 1px solid #ddd;    overflow: hidden;">
										</div>

										<div class="form-group col-sm-8">
											<label>Name</label>
											<input type="text" id="name" name="name"  v-model="form.name"  :class="[{ 'error': submitted && errors.has('name') }, 'form-control']" data-vv-as="name" v-validate="'required'" style="border: 1px solid #ddd" placeholder="Name">
											<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
										</div>	

									
										<div class="form-group col-sm-6">
											<label>Date</label>
											<div class="row">
												<div class="col-6 pr-1">
													  <Datepicker name="start_date"  :disabled-dates="disabledDates" format="dd-MM-yyyy" v-model="form.start_date" input-class="datefield" id="start_date" v-validate="'required'" :class="[{ 'error': submitted && errors.has('start_date') },'  start_date']" data-vv-as="start date" placeholder="Select Date" ></Datepicker>
													 <span v-show="errors.has('start_date')" class="text-danger">{{ errors.first('start_date') }}</span>
												</div>
												<div class="col-6 pl-1">
													 <Datepicker name="end_date" id="end_date" :disabled-dates="disabledendDates" format="dd-MM-yyyy" v-model="form.end_date" input-class="datefield" v-validate="'required'" :class="[{ 'error': submitted && errors.has('end_date') },'  end_date']" data-vv-as="end date" placeholder="Select Date" ></Datepicker>
													 <span v-show="errors.has('end_date')" class="text-danger">{{ errors.first('end_date') }}</span>
												</div>
											</div>
											<label v-if="submitted && errors.has('start_date')" class="error">{{ errors.first('start_date') }}</label>
											<label v-if="submitted && errors.has('end_date')" class="error">{{ errors.first('end_date') }}</label>

										</div>

										<div class="form-group col-sm-6">
											<label>Time</label>
											<div class="row">
												<div class="col-6 pr-1">
													<input type="text" name="start_time" v-model="form.start_time" id="start_time"    :class="[{ 'error': submitted && errors.has('start_time') }, 'form-control']" data-vv-as="start time" v-validate="'required'"  value="" style="border: 1px solid #ddd" v-mask="$parent.timeMask" placeholder=" Timing">
													<label v-if="submitted && errors.has('start_time')" class="error">{{ errors.first('start_time') }}</label>
												</div>
												<div class="col-6 pl-1">
													<input type="text" name="end_time" v-model="form.end_time" v-mask="$parent.timeMask" id="end_time" :class="[{ 'error': submitted && errors.has('end_time') }, 'form-control']" data-vv-as="end time" v-validate="'required'"  style="border: 1px solid #ddd" placeholder=" Timing">
													<label v-if="submitted && errors.has('end_time')" class="error">{{ errors.first('end_time') }}</label>
												</div>
											</div>
											
											

										</div>

										<div class="form-group col-sm-12">
											<label>Address</label>
											<input type="text" maxlength="30" name="address"  v-model="form.address" :class="[{ 'error': submitted && errors.has('address') }, 'form-control']" data-vv-as="address" v-validate="'required'" style="border: 1px solid #ddd" placeholder="Address">
											<label v-if="submitted && errors.has('address')" class="error">{{ errors.first('address') }}</label>
										</div>	

										<div class="form-group col-sm-12">
											<label>Description</label>
											<textarea type="text" name="description" v-model="form.description" data-vv-as="price" v-validate="'required'" :class="[{ 'error': submitted && errors.has('pdescriptionrice') }, 'form-control']" row="3"  style="border: 1px solid #ddd" placeholder="Description"></textarea>
											<label v-if="submitted && errors.has('description')" class="error">{{ errors.first('description') }}</label>
										</div>


									</div>
									<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&#10006;</span>
										</button>
										<span v-html="error_message"></span>
									</div>

									<div id="timeError"></div>
									<div class=" text-center">
										<button type="submit" name="save" class="btn btn-success pl-5 pr-5">Save</button>

									</div>
								</form>
							</div>			
						</div>
					</div>
				</div>
			</main>
			<VFooter></VFooter>
		</div>
		<div v-else>
			<VGHeader></VGHeader>
			<main class="container pt-3 pb-3">

						<VLSidebar></VLSidebar>
							<h5 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> Add / Edit Course</h5>
							<alert></alert>
							<div class="mt-3">
								<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
									<div class=" row">

										<input type="hidden" name="id" id="id" v-model="form.id" />

										<div class="form-group col-sm-4">
											<label>Course Image</label>
											<input type="file" name="img" ref="file" class="form-control" v-on:change="handleFileUploads()" style="border: 1px solid #ddd;    overflow: hidden;">
										</div>

										<div class="form-group col-sm-4">
											<label class="text-success">Course Name</label>
											<input type="text" maxlength="30" name="name"  v-model="form.name" required=""  :class="[{ 'error': submitted && errors.has('name') }, 'form-control']" data-vv-as="name" v-validate="'required'" style="border: 1px solid #ddd" placeholder="Course Name">
											<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
										</div>	

										
										<div class="form-group col-sm-4">
											<label>Teacher</label>
											<select name="teacher" id="teacher" v-model="form.teacher" :class="[{ 'error': submitted && errors.has('teacher') }, 'form-control']" data-vv-as="teacher" v-validate="'required'">
												<option value="">Select</option>
												<option :value="teacher.name" v-for="teacher in teachers">{{teacher.name}}</option>
											</select>
											<label v-if="submitted && errors.has('teacher')" class="error">{{ errors.first('teacher') }}</label>
										</div>	

										<div class="form-group col-sm-4">
											<label>Course Duration</label>
											<div class="row">
												<div class="col-6 pr-1">
													<input type="text" name="duration"  :class="[{ 'error': submitted && errors.has('duration') }, 'form-control']" v-model="form.duration"  data-vv-as="duration" v-validate="'required'"  style="border: 1px solid #ddd" placeholder="Duration">
												</div>
												<div class="col-6 pl-1">
													<select class="form-control" name="duration_length" v-model="form.duration_length">
														<option value="Days" >Days</option>
														<option value="Weeks">Weeks</option>
														<option value="Months">Months</option>
														<option value="Years">Years</option>
													</select>
												</div>
											</div>
											<label v-if="submitted && errors.has('duration')" class="error">{{ errors.first('duration') }}</label>

										</div>	

										<div class="form-group col-sm-4">
											<label>Class Time</label>
											<div class="row">
												<div class="col-6 pr-1">
													<input type="text" name="start_time" v-model="form.start_time" id="start_time"  required=""  :class="[{ 'error': submitted && errors.has('start_time') }, 'form-control']" data-vv-as="start time" v-validate="'required'"  value="" style="border: 1px solid #ddd" v-mask="$parent.timeMask" placeholder=" Timing">
												</div>
												<div class="col-6 pl-1">
													<input type="text" name="end_time" v-model="form.end_time" v-mask="$parent.timeMask" id="end_time" :class="[{ 'error': submitted && errors.has('end_time') }, 'form-control']" data-vv-as="end time" v-validate="'required'"  style="border: 1px solid #ddd" placeholder=" Timing">
												</div>
											</div>
											<label v-if="submitted && errors.has('start_time')" class="error">{{ errors.first('start_time') }}</label>
											<label v-if="submitted && errors.has('end_time')" class="error">{{ errors.first('end_time') }}</label>

										</div>

										<div class="form-group col-sm-4">
											<label>Price</label>
											<input type="text" name="price" v-on:keypress="$parent.isPrice($event)" v-model="form.price" :class="[{ 'error': submitted && errors.has('price') }, 'form-control']" data-vv-as="price" v-validate="'required'" style="border: 1px solid #ddd" placeholder="Price">
											<label v-if="submitted && errors.has('price')" class="error">{{ errors.first('price') }}</label>
										</div>

										<div class="form-group col-sm-12">
											<label>Course Description</label>
											<textarea type="text" name="description" v-model="form.description" data-vv-as="price" v-validate="'required'" :class="[{ 'error': submitted && errors.has('pdescriptionrice') }, 'form-control']" row="3"  style="border: 1px solid #ddd" placeholder="Course Description"></textarea>
											<label v-if="submitted && errors.has('description')" class="error">{{ errors.first('description') }}</label>
										</div>

										<div class="form-group col-sm-4">

											<label class="btn-block">
												<input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
												<input type="checkbox" name="active" v-else @click="check($event)" class="">
											Active?</label>
										</div>

									</div>
									<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&#10006;</span>
										</button>
										<span v-html="error_message"></span>
									</div>

									<div id="timeError"></div>
									<div class=" text-center">
										<button type="submit" name="save" class="btn btn-success pl-5 pr-5">Save</button>

									</div>
								</form>
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
			disabledendDates: {
				to: new Date()
			},
			form:{
				id:'',
				name:'',
				mosque_id:this.$store.getters.getMosque.id,
				start_date:new Date(),
				end_date:new Date(),
				start_time:'',
				end_time:'',
				address:'',
				description:'',
				img:null,
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
		getStartDate(){
			this.form.end_date = this.form.start_date;
			this.disabledendDates.to = this.form.start_date;
		},
		getData(){
			if (typeof this.$route.params.id !== 'undefined' && this.$route.params.id != '') {
				var dataUrl = 'v1/mosque-event-detail/'+this.$route.params.id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					var data = result.data.data
					this.detail = data;
					this.form.id = data.id;
					this.form.name = data.name;
					this.form.start_date = data.start_date;
					this.form.end_date = data.end_date;
					this.form.start_time = data.time;
					this.form.end_time = data.end_time;
					this.form.address = data.address;
					this.form.description = data.description;
				}, error => {

				});
			}
			         
		},
		check(e){
			if (e.target.checked) {
				this.form.active = 1;
			}else{
				this.form.active = 0;
			}
		},
		handleFileUploads(){
			this.form.img =  this.$refs.file.files[0];
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
						url: "/v1/save-mosque-event",
						data: formData,
						headers: { "content-type": "application/json" }
					}).then(  response => {
						var response = response.data;
						if (response.status) {			
							this.$parent.success_message = 'Event Added Successfully';				
							this.$router.push({path: '/user/event'});
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
