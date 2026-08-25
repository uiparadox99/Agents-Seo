<template>
	<div>
		<div v-if="!$isMobile()">
			<VGHeader></VGHeader>
			<main class="container pt-5 pb-5">


				<div class="row">
					<div class="col-md-3">
						<VLSidebar></VLSidebar>
						<div class="row">
							<div class=" form-group col s12">
								<div class="pglist-p3 pglist-bg pglist-p-com">
									<div class="pglist-p-com-ti pglist-p-com-ti-right">
										<h3>Location</h3> </div>
										<div class="list-pg-inn-sp">
											<div class="list-pg-map">
												<div id="googleMap" style="width:100%;height:300px;"></div>
											</div>
										</div>
									</div>
								</div>


							</div>

						</div>
						<div class="col-md-9">
							<div class="shadow p-4">
								<h4>Update - {{mosquedetail.name}}

									<router-link to="/change-password" class="btn btn-success float-right">Change Password</router-link>
								</h4>
								<div class="clearfix"></div>
								<div class="mt-3">

									<div class="hom-cre-acc-left hom-cre-acc-right">

										<div class="">

											<form class="" method="POST" action="" id="updateform"   @submit.prevent="updateMosque()">
												<input type="hidden" name="id" id="id" v-model="id" />

												<div class="row">
													<div class="form-group col-6 ">
														<label>Name </label>
														<input :class="[{ 'error': submitted && errors.has('name') }, 'form-control']" id="name" name="name" type="text" v-on:keypress="$parent.isLetter($event)" v-model="form.name" maxlength="70" placeholder="Mosque Name" data-vv-as="name" v-validate="'required'"  >
														<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
													</div>
													<div class=" form-group col-6">
														<label>Owner </label>
														<input :class="[{ 'error': submitted && errors.has('contact_person') }, 'form-control']" id="contact_person" name="contact_person"  v-on:keypress="$parent.isLetter($event)" v-model="form.contact_person" type="text" maxlength="25"  placeholder="Imaam/Contact Person " data-vv-as="owner" v-validate="'required'"  >
														<label v-if="submitted && errors.has('contact_person')" class="error">{{ errors.first('contact_person') }}</label>
													</div>
												</div>
												<div class="row">

													<div class=" form-group col-6">
														<label>Mobile </label>
														<input :class="[{ 'error': submitted && errors.has('mobile') }, 'form-control']" maxlength="14" id="mobile" v-on:keypress="$parent.isNumber($event)" v-model="form.mobile" name="mobile" type="text"  placeholder="Mobile"  data-vv-as="mobile" v-validate="'required'" >
														<label v-if="submitted && errors.has('mobile')" class="error">{{ errors.first('mobile') }}</label>
													</div>

													<div class=" form-group col-6">
														<label>Phone </label>
														<input :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']" id="phone" maxlength="14"   v-on:keypress="$parent.isNumber($event)" v-model="form.phone" name="phone" :type="text"  placeholder="Phone 1" data-vv-as="phone" v-validate="'required'"  >
														<label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
													</div>

												</div>

												<div class="row">
													<div class=" form-group col-6">
														<label>Email </label>
														<input :class="[{ 'error': submitted && errors.has('email') }, 'form-control']" maxlength="40" id="email"  v-model="form.email" name="email"  type="email"  placeholder="Email" data-vv-as="email" v-validate="'required:email'"  >

													</div>
													<div class=" form-group col-6">
														<label>Post Code </label>
														<input :class="[{ 'error': submitted && errors.has('postcode') }, 'form-control']" maxlength="10" id="postcode"  v-model="form.postcode" name="postcode"  type="text"  placeholder="Post Code" data-vv-as="post code" v-validate="'required'"  onblur="onblurAddress()">
														<label v-if="submitted && errors.has('postcode')" class="error">{{ errors.first('postcode') }}</label>
													</div>
												</div>
												<div class="row">
													<div class=" form-group col-6">
														<label>Address </label>
														<input :class="[{ 'error': submitted && errors.has('address') }, 'form-control']" maxlength="100" id="address"  v-model="form.address" name="address" type="text"  placeholder="Address"  data-vv-as="address" v-validate="'required'" >
														<label v-if="submitted && errors.has('address')" class="error">{{ errors.first('address') }}</label>
													</div>
													
													<div class=" form-group col-6 updateselect">
														<label>City </label>
														<v-select label="name" v-model="form.city" :options="cities" data-vv-as="city" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('city')" class="error">{{ errors.first('city') }}</label>
													</div>
												</div>




												<h4>Management :</h4>
												<hr>
												<div class="row">

													<div class=" form-group col-sm-6 updateselect">
														<label>Council </label>
														<v-select label="name" v-model="form.council" :options="councils" data-vv-as="council" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('councils')" class="error">{{ errors.first('councils') }}</label>
													</div>
													<div class=" form-group col-sm-6 updateselect">
														<label>Faith </label>
														<v-select label="name" v-model="form.theme" :options="faith" data-vv-as="faith" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('theme')" class="error">{{ errors.first('theme') }}</label>
													</div>
												</div>
												<h4>Other Info:</h4>
												<hr>
												<div class="row">
													<div class=" form-group col s12">
														<label>Facebook Page Link </label>
														<input :class="[{ 'error': submitted && errors.has('fblink') }, 'form-control']" type="URL" maxlength="40" v-model="form.fblink"   id="fblink"  name="fblink" placeholder="https://web.facebook.com/*"  pattern="http://www\.facebook\.com\/(.+)|https://web\.facebook\.com\/(.+)|https://www\.facebook\.com\/(.+)" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<label v-if="submitted && errors.has('fblink')" class="error">{{ errors.first('fblink') }}</label>
													</div>
												</div>
												<div class="row">
													<div class=" form-group col s12">
														<label>YouTube Channel Link </label>
														<input type="URL" :class="[{ 'error': submitted && errors.has('youtube_link') }, 'form-control']" maxlength="50"  id="youtube_link" v-model="form.youtube_link"  name="youtube_link" pattern="https://.*" placeholder="YouTube Link" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<label v-if="submitted && errors.has('youtube_link')" class="error">{{ errors.first('youtube_link') }}</label>
													</div>
												</div>
												<div class="row">
													<div class=" form-group col s12">
														<label>Your Web site Link </label>
														<input type="URL" :class="[{ 'error': submitted && errors.has('website') }, 'form-control']" maxlength="40"  id="website" v-model="form.website"  name="website" pattern="http://.*" placeholder="Website Link" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<p>Example : http://www.mosquefinder.co.uk</p>
														<label v-if="submitted && errors.has('website')" class="error">{{ errors.first('website') }}</label>
													</div>
												</div>
												<div class="row">
													<div class=" form-group col s12">
														<label>Mosque Description </label>
														<textarea :class="'form-control'" id="other_info" maxlength="500" name="other_info" placeholder="" v-model="form.other_info">
														</textarea>

													</div>
												</div>	
												<input id="lat" name="lat" type="hidden"  value="">
												<input id="lng" name="lng" type="hidden" value="">

												<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&#10006;</span>
													</button>
													<span v-html="error_message"></span>
												</div>
												<div class="text-center">

													<button class=" form-group btn btn-success btn-lg pl-5 pr-5 text-uppercase" id="btn" onclick="codeAddress()" type="submit" name="save">Update Mosque</button>
												</div>

											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</main>
				<VFooter></VFooter>
			</div>
			<div v-if="$isMobile()">
				<VGHeader></VGHeader>
				<main class="container pt-2 pb-2">
					<VLSidebar></VLSidebar>
					<div class="">
						<!--CENTER SECTION-->
						<h4 class="text-center text-success"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> Update - 
							<!-- <?php echo $detail->name ?>  -->
						</h4>
						<div class="text-center">

							<router-link to="/change-password" class="btn btn-success btn-sm">Change Password</router-link>
						</div>
						<div class="clearfix"></div>
						<div class="mt-2">

							<div class="hom-cre-acc-left hom-cre-acc-right">

								<div class="">

									<form class="" method="POST" action="" id="updateform"  @submit.prevent="updateMosque()" >
										<input type="hidden" name="id" id="id" v-model="id" />

												
													<div class="mb-2 ">
														<label>Name </label>
														<input :class="[{ 'error': submitted && errors.has('name') }, 'form-control']" id="name" name="name" type="text" v-on:keypress="$parent.isLetter($event)" v-model="form.name" maxlength="70" placeholder="Mosque Name" data-vv-as="name" v-validate="'required'"  >
														<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
													</div>
													<div class=" mb-2">
														<label>Owner </label>
														<input :class="[{ 'error': submitted && errors.has('contact_person') }, 'form-control']" id="contact_person" name="contact_person" v-model="form.contact_person" type="text" maxlength="25"  placeholder="Imaam/Contact Person " data-vv-as="owner" v-validate="'required'"  >
														<label v-if="submitted && errors.has('contact_person')" class="error">{{ errors.first('contact_person') }}</label>
													</div>
										
								

													<div class="mb-2">
														<label>Mobile </label>
														<input :class="[{ 'error': submitted && errors.has('mobile') }, 'form-control']" maxlength="14" id="mobile" v-on:keypress="$parent.isNumber($event)" v-model="form.mobile" name="mobile" type="text"  placeholder="Mobile"  data-vv-as="mobile" v-validate="'required'" >
														<label v-if="submitted && errors.has('mobile')" class="error">{{ errors.first('mobile') }}</label>
													</div>

													<div class="mb-2">
														<label>Phone </label>
														<input :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']" id="phone" maxlength="14"  v-model="form.phone" name="phone" :type="text"  placeholder="Phone 1" data-vv-as="phone" v-validate="'required'"  >
														<label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
													</div>

													<div class=" mb-2">
														<label>Email </label>
														<input :class="[{ 'error': submitted && errors.has('email') }, 'form-control']" maxlength="40" id="email"  v-model="form.email" name="email"  type="email"  placeholder="Email" data-vv-as="email" v-validate="'required:email'"  >

													</div>
													<div class=" mb-2">
														<label>Post Code </label>
														<input :class="[{ 'error': submitted && errors.has('postcode') }, 'form-control']" maxlength="10" id="postcode"  v-model="form.postcode" name="postcode"  type="text"  placeholder="Post Code" data-vv-as="post code" v-validate="'required'"  onblur="onblurAddress()">
														<label v-if="submitted && errors.has('postcode')" class="error">{{ errors.first('postcode') }}</label>
													</div>
								
													<div class="mb-2">
														<label>Address </label>
														<input :class="[{ 'error': submitted && errors.has('address') }, 'form-control']" maxlength="100" id="address"  v-model="form.address" name="address" type="text"  placeholder="Address"  data-vv-as="address" v-validate="'required'" >
														<label v-if="submitted && errors.has('address')" class="error">{{ errors.first('address') }}</label>
													</div>
													
													<div class="mb-2 updateselect">
														<label>City </label>
														<v-select label="name" v-model="form.city" :options="cities" data-vv-as="city" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('city')" class="error">{{ errors.first('city') }}</label>
													</div>
											




												<h4>Management :</h4>
												<hr>
												<div class="row">

													<div class=" form-group col-sm-6 updateselect">
														<label>Council </label>
														<v-select label="name" v-model="form.council" :options="councils" data-vv-as="council" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('councils')" class="error">{{ errors.first('councils') }}</label>
													</div>
													<div class=" form-group col-sm-6 updateselect">
														<label>Faith </label>
														<v-select label="name" v-model="form.theme" :options="faith" data-vv-as="faith" v-validate="'required'"></v-select>
														<label v-if="submitted && errors.has('theme')" class="error">{{ errors.first('theme') }}</label>
													</div>
												</div>
												<h4>Other Info:</h4>
												<hr>
													<div class=" mb-2">
														<label>Facebook Page Link </label>
														<input :class="[{ 'error': submitted && errors.has('fblink') }, 'form-control']" type="URL" maxlength="40" v-model="form.fblink"   id="fblink"  name="fblink" placeholder="https://web.facebook.com/*"  pattern="http://www\.facebook\.com\/(.+)|https://web\.facebook\.com\/(.+)|https://www\.facebook\.com\/(.+)" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<label v-if="submitted && errors.has('fblink')" class="error">{{ errors.first('fblink') }}</label>
													</div>
											
													<div class=" mb-2">
														<label>YouTube Channel Link </label>
														<input type="URL" :class="[{ 'error': submitted && errors.has('youtube_link') }, 'form-control']" maxlength="50"  id="youtube_link" v-model="form.youtube_link"  name="youtube_link" pattern="https://.*" placeholder="YouTube Link" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<label v-if="submitted && errors.has('youtube_link')" class="error">{{ errors.first('youtube_link') }}</label>
													</div>
											
													<div class=" mb-2">
														<label>Your Web site Link </label>
														<input type="URL" :class="[{ 'error': submitted && errors.has('website') }, 'form-control']" maxlength="40"  id="website" v-model="form.website"  name="website" pattern="http://.*" placeholder="Website Link" data-error="Please enter the right URL." >
														<div class="help-block with-errors "></div>
														<p>Example : http://www.mosquefinder.co.uk</p>
														<label v-if="submitted && errors.has('website')" class="error">{{ errors.first('website') }}</label>
													</div>
												
													<div class=" mb-2">
														<label>Mosque Description </label>
														<textarea :class="'form-control'" id="other_info" maxlength="500" name="other_info" placeholder="" v-model="form.other_info">
														</textarea>

												</div>	
												<input id="lat" name="lat" type="hidden"  value="">
												<input id="lng" name="lng" type="hidden" value="">

												<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&#10006;</span>
													</button>
													<span v-html="error_message"></span>
												</div>

											<button class=" mb-2 btn btn-success btn-block text-uppercase" type="submit" name="save">Update Mosque</button>
											<div class=" mb-2 ">
												<div class="pglist-p3 pglist-bg pglist-p-com">
													<div class="pglist-p-com-ti pglist-p-com-ti-right">
														<h5>Location</h5> </div>
														<div class="list-pg-inn-sp">
															<div class="list-pg-map">
																<div id="googleMap" style="width:100%;height:300px;"></div>
															</div>
														</div>
													</div>
												</div>

											</form>
										</div>
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
				data (){
					return {
						mosquedetail: {},
						cities: [],
						councils: [],
						faith: [],
						error_message: "",
						has_error: false,
						submitted: false,
						form:{
							id:this.$store.getters.getMosque.id,
							name:this.$store.getters.getMosque.name,
							email:this.$store.getters.getMosque.email,
							phone:this.$store.getters.getMosque.phone,
							mobile:this.$store.getters.getMosque.mobile,
							contact_person:this.$store.getters.getMosque.contact_person,
							address:this.$store.getters.getMosque.address,
							postcode:this.$store.getters.getMosque.postcode,
							city:this.$store.getters.getMosque.city != null?this.$store.getters.getMosque.city.name:'',
							council:this.$store.getters.getMosque.council != null?this.$store.getters.getMosque.council.name:'',
							theme:this.$store.getters.getMosque.theme != null?this.$store.getters.getMosque.theme.name:'',
							fblink:this.$store.getters.getMosque.fblink,
							youtube_link:this.$store.getters.getMosque.youtube_link,
							website:this.$store.getters.getMosque.website,
							other_info:this.$store.getters.getMosque.other_info
						}
					}

				},
				beforeMount(){
					
					this.loadjs();
					this.getData();

				},
				methods: {
					loadjs(){
						var mainthis = this;
						let externalScript = document.createElement('script')
					    externalScript.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC25ud3-p1XvE0YEWHmCKla49qXs5ZW0BI&callback=myMap')
					    document.head.appendChild(externalScript);

					},
					getData(){
						var dataUrl = 'v1/dropdown-data';
						axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
							var data = result.data.data
							this.cities = data.cities;
							this.councils = data.councils;
							this.faith = data.faiths;
						}, error => {

						});  

						
						var dataUrl = 'v1/mosque-detail/'+this.$store.getters.getMosque.slug;
						axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
							var data = result.data.data.detail;
							this.mosquedetail = data;
						}, error => {

						});         
					},
					updateMosque(){
						  var $this = this;
						  this.submitted = true;
						  this.$validator.validate().then(valid => {
						         if (valid) {
						         this.error_message = "";
						         this.has_error = false;
						         var formData = this.form;
						         formData.city = this.form.city.id;
						         formData.council = this.form.council.id;
						         formData.theme = this.form.theme.id;
						             axios({
						              method: "POST",
						              url: "/v1/update-mosque",
						              data: JSON.stringify(formData),
						              headers: { "content-type": "application/json" }
						          }).then(  response => {
						          	var response = response.data;
						          	if (response.status) {
						          		var data  = response.data;
						          		this.$store.commit('loginMosque', data.mosque_data);
						          		 this.$router.push({path: '/user/detail'});
						          	}else{
						          		this.has_error = true;
						          		this.error_message = response.message;
						          		setTimeout(function() {
						          			$this.error_message = "";
						          			$this.has_error = false;
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