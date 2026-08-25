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
							<h4 class="text-green text-center">Staff</h4>
							<alert></alert>
							<div class="mt-3">

								<form action="" method="POST" id="updateform" enctype="multipart/form-data"   @submit.prevent="submit()">
									<input type="hidden" name="id" id="id" v-model="form.id" value=""/>
									<div class="row">
										<div class="col-md-4">
											<div class="upload-image-preview" style="width: 100%;height: 250px;">

												<img :src="$parent.BASE_API_PATH+'/uploads/'+addedImg" v-if="addedImg != ''" alt="" class="img-circle mb-2 pic-profile">

												<img src="/assets/New/images/Ellipse 5.png" v-else alt="" class="img-circle mb-2 pic-profile">


											</div>
											<input type="file" ref="file" name="img" @change="showImage" class="filestyle" data-classButton="btn btn-success" data-input="false" data-classIcon="icon-plus" data-buttonText="Upload image">

										</div>
										<div class="col-md-8">


											<div class=" grey-border-radius">
												<div class=" row">

													<div class="form-group col-sm-4">
														<label>Name</label>
													</div>
													<div class="form-group col-sm-8">

														<input type="text" name="name" id="name" v-model="form.name"  data-vv-as="name" v-validate="'required'" :class="[{ 'error': submitted && errors.has('name') }, 'form-control']"  placeholder="Name">
														<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
													</div>

													<div class="form-group col-sm-4">
														<label>Email</label>
													</div>
													<div class="form-group col-sm-8">
														<input type="email" name="email" id="email"  data-vv-as="email" v-validate="'required'" :class="[{ 'error': submitted && errors.has('email') }, 'form-control']"  autocomplete="off" v-model="form.email" placeholder="Email Address">
														<label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
													</div>	

													<div class="form-group col-sm-4">
														<label>Phone</label>
													</div>
													<div class="form-group col-sm-8">
														<input type="text" name="phone" v-model="form.phone"  v-on:keypress="$parent.isNumber($event)"  maxlength="14"  data-vv-as="phone" v-validate="'required'" :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']"  placeholder="Phone">
														<label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
													</div>
													<div class="form-group col-sm-4">
														<label>Designation</label>
													</div>
													<div class="form-group col-sm-8">
														<select data-vv-as="designation" v-validate="'required'" :class="[{ 'error': submitted && errors.has('designation') }, 'form-control']" name="designation" v-model="form.designation">
															<option value="">Select</option>

															<option v-for="d in designation" :value="d.name">{{d.name}}
															</option>

														</select>
														<label v-if="submitted && errors.has('designation')" class="error">{{ errors.first('designation') }}</label>

													</div>	

													<div class="form-group col-sm-12">
														<labeL class="btn-block">&nbsp;</label>

															<label class="btn-block">
																<input type="checkbox" name="can_checkin" v-if="form.can_checkin == 1" @click="checkcan_checkin($event)" checked="" class="">
																<input type="checkbox" name="can_checkin" v-else @click="checkcan_checkin($event)" class="">
															Can Check In?</label>



															<label class="btn-block">
																<input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
																<input type="checkbox" name="active" v-else @click="check($event)" class="">
															Active?</label>



														</div>	

													</div>
												</div>
											</div>
										</div>

										<div class=" text-center mt-3">
											<button type="submit" name="save" class="btn btn-success btn-lg pl-5 pr-5">Save</button>

										</div>
									</form>
								</div>			
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

					<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> Staff</h4>
					<alert></alert>
					<div class="mt-3">

						<form action="" method="POST" id="updateform" enctype="multipart/form-data" @submit.prevent="submit()">

			
							<div class=" row">

								<input type="hidden" name="id" id="id" value="<?php echo !empty($detail)?$detail->id:'' ?>" />


								<div class="form-group mb-2 col-sm-4 text-success">
									<label>Picture</label>
									<input type="file" ref="file" name="img" @change="showImage" class="filestyle" data-classButton="btn btn-success" data-input="false" data-classIcon="icon-plus" data-buttonText="Upload image">
								</div>	
									
													<div class="form-group col-sm-8 text-success">
													<label>Name</label>
														<input type="text" name="name" id="name" v-model="form.name"  data-vv-as="name" v-validate="'required'" :class="[{ 'error': submitted && errors.has('name') }, 'form-control']"  placeholder="Name">
														<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
													</div>

												
													<div class="form-group col-sm-8 text-success">
															<label>Email</label>
														<input type="email" name="email" id="email"  data-vv-as="email" v-validate="'required'" :class="[{ 'error': submitted && errors.has('email') }, 'form-control']"  autocomplete="off" v-model="form.email" placeholder="Email Address">
														<label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
													</div>	

												
													<div class="form-group col-sm-8 text-success">
														<label>Phone</label>
														<input type="text" name="phone" v-model="form.phone"  v-on:keypress="$parent.isNumber($event)"  maxlength="14"  data-vv-as="phone" v-validate="'required'" :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']"  placeholder="Phone">
														<label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
													</div>
												
													<div class="form-group col-sm-8 text-success">
															<label>Designation</label>
														<select data-vv-as="designation" v-validate="'required'" :class="[{ 'error': submitted && errors.has('designation') }, 'form-control']" name="designation" v-model="form.designation">
															<option value="">Select</option>

															<option v-for="d in designation" :value="d.name">{{d.name}}
															</option>

														</select>
														<label v-if="submitted && errors.has('designation')" class="error">{{ errors.first('designation') }}</label>

													</div>	

													<div class="form-group col-sm-12 text-success">
													

															<label class="btn-block">
																<input type="checkbox" name="can_checkin" v-if="form.can_checkin == 1" @click="checkcan_checkin($event)" checked="" class="">
																<input type="checkbox" name="can_checkin" v-else @click="checkcan_checkin($event)" class="">
															Can Check In?</label>



															<label class="btn-block">
																<input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
																<input type="checkbox" name="active" v-else @click="check($event)" class="">
															Active?</label>



														</div>	

							</div>

							<div class=" text-center">
								<button type="submit" name="save" class="btn btn-success pl-5 pr-5  btn-sm">Save</button>

							</div>
						</form>
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
				detail: '',
				designation: {},
				error_message: "",
				addedImg:"",
				has_error: false,
				submitted: false,
				form:{
					id:'',
					name:'',
					designation:'',
					mosque_id:this.$store.getters.getMosque.id,
					phone:'',
					email:'',
					img:null,
					can_checkin:0,
					active:1,
				}
			}

		},
		beforeMount(){
			this.getData();
		},
		methods: {
			showImage(){
				if (this.$refs.file.files && this.$refs.file.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						var img = $('<img>').attr('src', e.target.result);
						$('.upload-image-preview').html(img);
					};

					reader.readAsDataURL(this.$refs.file.files[0]);

					this.form.img =  this.$refs.file.files[0];
				}
			},
			getData(){
				if (typeof this.$route.params.id !== 'undefined' && this.$route.params.id != '') {
					var dataUrl = 'v1/mosque-staff-detail/'+this.$route.params.id;
					axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
						var data = result.data.data
						this.detail = data;
						this.form.id = data.id;
						this.form.name = data.name;
						this.form.designation = data.designation;
						this.form.email = data.email;
						this.addedImg = data.image;
						this.form.active = data.active;
						this.form.phone = data.phone;
						this.form.can_checkin = data.can_checkin;

					}, error => {

					});
				}
				var dataUrl = 'v1/dropdown-data';
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					var data = result.data.data.designation;
					this.designation = data;
				}, error => {

				});           
			},
			checkcan_checkin(e){
				if (e.target.checked) {
					this.form.can_checkin = 1;
				}else{
					this.form.can_checkin = 0;
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
							url: "/v1/save-mosque-staff",
							data: formData,
							headers: { "content-type": "application/json" }
						}).then(  response => {
							var response = response.data;
							if (response.status) {			
								this.$parent.success_message = 'Staff Added Successfully';				
								this.$router.push({path: '/user/manage-staff'});
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