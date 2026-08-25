<template>
	<div>
		<div v-if="!$isMobile()">
			<VGHeader></VGHeader>
			<ContentLoader v-if="loading">
				<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
				<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
				<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
				<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
				<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
				<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
			</ContentLoader>
			<main class="container mt-5 mb-4" v-else>
				<alert></alert>
				
				<div class="row" >
					<div class="col-md-8 offset-md-2">
						<div class="p-2 b-shadow pb-3 profile-panel">
							<div class="row">
								<div class="col-md-4 text-right mt-2">
									<div class="item-position">

										<img :src="$parent.BASE_API_PATH+'/uploads/'+detail.image" v-if="detail.image != '' && detail.image != null" alt="" class="img-circle mb-2 pic-profile">

										<img src="/assets/New/images/Ellipse 5.png" alt="" class="img-circle mb-2 pic-profile" v-else>

									</div>
								</div>

								<div class="col-md-5 mt-2">

									<div class="p-info">
										<h1 class="ml-h1">
											{{detail.first_name}} {{detail.last_name}}
										</h1>

										<ul class="list-style">
											<li class="d-flex mb-3">
												<i class="fas fa-phone-alt text-green text-center li-fa-icon"
												aria-hidden="true"></i>
												<div class="ml-1" v-if="detail.phone != ''">
													{{detail.phone}}
												</div>
												<div class="ml-1" v-else>
													N/A
												</div>
											</li>
											<li class="d-flex mb-3">
												<i class="fa fa-envelope text-green text-center li-fa-icon"
												aria-hidden="true"></i>
												<div class="ml-1" v-if="detail.email != ''">
													{{detail.email}}
												</div>
												<div class="ml-1" v-else>
													N/A
												</div>
											</li>
										</ul>

									</div>
								</div>
								<div class="col-md-3 pr-4">
									<h5  class="bgc-green text-center text-white mb-0 p-2 mt-2">Scan Code</h5>
									<div class="barcode p-2 pt-2 pb-2">

										
										<barcode :value="detail.qr_code" displayValue="false"></barcode>
									</div>
								</div>
							</div>

							<div class="mt-2 ">
								<div class="text-center">
									<router-link to="/edit-profile"  class="btn btn-lg    bgc-green text-white ">Edit Profile</router-link>
									<router-link to="/change-password" class="btn btn-lg    bgc-green text-white "> Change Password</router-link>
									<a href="javascript:;" @click="$parent.logout()" class="btn btn-lg    bgc-green text-white ">Logout</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<h3 class="text-center mt-4 mb-4">Subscribed Mosques</h3>

				<div class="row" v-if="detail.subscribes != '' && detail.subscribes != null && detail.subscribes.length > 0">



					<div class="col-md-4 mb-4" v-for="r in detail.subscribes">
						<div class="b-shadow pb-4 position-relative">
							<div>
								<div v-if="r.mosque.mosque_logo != '' && r.mosque.mosque_logo != null && r.mosque.mosque_logo.length > 0">
									<div class="b-pic-w b-pic-res" >
										<img :src="$parent.BASE_API_PATH+'/uploads/'+ r.mosque.mosque_logo[0].logo" alt="" class="w-100" style="    height: 100%;">
									</div>
								</div>
								<div class="b-pic-w b-pic-res" v-else>
									<img src="/assets/New/images/Rectangle 12.png" alt="" class="w-100" style="    height: 100%;">
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
								
							</div>
							<router-link :to="r.mosque.slug+'.html'" target="_blank"><h4 class="text-green text-center mt-3">{{r.mosque.name}}</h4></router-link>

							<div class="mt-4 ">
								<div class="text-center bell">
									<a :href="'tel:'+r.mosque.phone" class="   bgc-green text-white pt-2 pb-2 pl-3 pr-3 btn-radius">Imam
									Contact</a> &nbsp;&nbsp;&nbsp;
									<a href="javascript:;" @click="$parent.jumaRegistration(r.mosque.id,r.mosque.slug)" class="  bgc-green text-white  pt-2 pb-2 pl-3 pr-3 btn-radius">Register
									Jummah</a>
									<div class="clearfix"></div>
									<!-- <br>
										<a target="_blank" href="/user/check-live-khutba?mosqueslug=<?php echo $r->slug ?>&checkKhutba=yes" class="  bgc-green text-white   pt-2 pb-2 pl-3 pr-3 btn-radius">Live Jummah Khutba</a> -->
									</div>
								</div>
							</div>
						</div>
					</div>

					<p class="text-center" v-else>No Mosque Subscribed</p>

					<h3 class="mb-3">Enroll Courses </h3>
					<div class="row" v-if="detail.user_courses != '' && detail.user_courses != null && detail.user_courses.length > 0">


						<div class="col-md-4 mb-3" v-for="r in detail.user_courses" v-if="r.active == 1">
							<div class="new-event-box">
								<h5 class="event-title mb-0">{{r.course.name.substring(0,30)}}</h5>


								<img :src="$parent.BASE_API_PATH+'/uploads/'+r.course.img"  v-if="r.course.img != '' && r.course.img != null">

								<img src="/assets/New/images/Rectangle 92.png" v-else>

								<div class="p-2">
									<p class="mb-0"><b class="text-success">Time:</b> {{r.course.class_time}} <span class="float-right"><b class="text-success">£ {{r.course.price}}</b></span></p>
									<p class="" style="text-align:justify">{{r.course.description.substring(0,120)}}</p>

								</div>
							</div>
						</div>



					</div>		


					<div class=" shadow  p-4 mb-2" v-else>
						<h2 class="text-green text-center text-accent-3">There is no Course Yet!</h2>
					</div>




					<h3 class="mb-3">Registered Jummah 

						<a href="javascript:;" @click="changeview(1)" v-if="!history" class="btn btn-warning text-white float-right">History</a>

						<a href="javascript:;" @click="changeview(0)" v-else class="btn btn-warning text-white float-right">Current</a>  

					</h3>
					<table class="table table-bordered table-striped mb-4" v-if="!history">
						<thead>
							<tr>
								<th width="15%">Date</th>                
								<th width="17%">Start / Adhaan Time</th>                
								<th width="15%">Jammat Time</th>                
								<th width="10%">Barcode</th>                
								<th class="text-center">Mosque Name</th>  
								<th class="text-center">2nd Person Name</th>  
								<th class="text-center">3rd Person</th>  

								<th class="text-center" v-if="!history" width="10%">Action</th>  

							</tr>

						</thead>
						<tbody  v-if="detail.participate_jummas != '' && detail.participate_jummas != null && detail.participate_jummas.length > 0">

							<tr  v-for="r in detail.participate_jummas" v-if="r.juma_time != null && checkDateGreater(r.juma_time.date)">
								<td>{{r.juma_time.date |eventDateFormat}}</td>
								<td>{{r.juma_time.start}}</td>
								<td>{{r.juma_time.jamaat}}</td>
								<td><barcode :value="r.qr_code" displayValue="false" height="50" width="1.5"></barcode></td>
								<td>{{r.juma_time.mosque.name}}</td>
								<td>{{r.juma_time.mosque.person_name}}</td>
								<td>{{r['3rd_person_name']}}</td>

								<td class="text-center"  v-if="!history">

									<button @click="deleteRegisterd(r.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
									<!-- <a href="data:image/png;base64,<?php echo $barcode ?>" download=""  class="btn btn-success btn-sm"><i class="fa fa-download"></i></a> -->

								</td>

								
							</tr>
						</tbody>
						
						<tbody v-else>
							<tr>
								<td colspan="8" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>

							</tr>

						</tbody>

					</table>
					<table class="table table-bordered table-striped mb-4" v-else>
						<thead>
							<tr>
								<th width="15%">Date</th>                
								<th width="17%">Start / Adhaan Time</th>                
								<th width="15%">Jammat Time</th>                
								<th width="10%">Barcode</th>                
								<th class="text-center">Mosque Name</th>  
								<th class="text-center">2nd Person Name</th>  
								<th class="text-center">3rd Person</th>  

								<th class="text-center" v-if="!history" width="10%">Action</th>  

							</tr>

						</thead>
						<tbody v-if="detail.participate_jummas != '' && detail.participate_jummas != null && detail.participate_jummas.length > 0" >

							<tr   v-for="r in detail.participate_jummas" v-if="r.juma_time != null && !checkDateGreater(r.juma_time.date)">
								<td>{{r.juma_time.date |eventDateFormat}}</td>
								<td>{{r.juma_time.start}}</td>
								<td>{{r.juma_time.jamaat}}</td>
								<td><barcode :value="r.qr_code" displayValue="false" height="50" width="1.5"></barcode></td>
								<td>{{r.juma_time.mosque.name}}</td>
								<td>{{r.juma_time.mosque.person_name}}</td>
								<td>{{r['3rd_person_name']}}</td>

								<td class="text-center"  v-if="!history">

									<button @click="deleteRegisterd(r.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
									<!-- <a href="data:image/png;base64,<?php echo $barcode ?>" download=""  class="btn btn-success btn-sm"><i class="fa fa-download"></i></a> -->

								</td>

								
							</tr>
						</tbody>
						<tbody v-else>
							<tr>

								<td colspan="8" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>

							</tr>

						</tbody>

					</table>
					<div class="row">

						<div class="col-md">
							<div class="bgc  mb-4 pt-2 pb-2 pr-4 pl-4 m-top">
								<h3 class="text-center m-2">Bookmark Events</h3>


								<ul style="list-style: none;" class="h-li bell" v-if="detail.bookmarks != '' && detail.bookmarks != null && detail.bookmarks.length > 0">

									<li class="mb-2 pb-1" v-for="r in detail.bookmarks">
										<a  :href="r.url" target="_blank"  class="text-dark">{{r.url}}</a>

										<button @click="deleteBookmark(r.id)" name="deleteBookmark" class="btn btn-danger btn-sm float-right"><i class="fa fa-trash"></i></button>
										<div class="clearfix"></div>
									</li>


								</ul>

								<p class="text-center" v-else>No Bookmark Added</p>

								<div class="clearfix"></div>

							</div>

						</div>
					</div>

				</main>
				<VFooter></VFooter>
			</div>

			<div v-if="$isMobile()">
				<VGHeader></VGHeader>
				<main class="container mt-5 mb-4">
					<div class="b-shadow mb-3 p-2">

						<div class="row">
							<div class="col-4 text-right  pr-0">
								<div class="item-position text-right">
						
                        	<img :src="$parent.BASE_API_PATH+'/uploads/'+detail.image" v-if="detail.image != '' && detail.image != null" alt="" class="img-circle mb-2 pic-profile">

										<img src="/assets/New/images/Ellipse 5.png" alt="" class="img-circle mb-2 pic-profile" v-else>
                        </div>
                    </div>

                    <div class="col-8 mt-2 pl-0">

                    	<div class="p-info">
                    		<h5 class="ml-h1">
                    					{{detail.first_name}} {{detail.last_name}}
                    		</h5>

                    		<ul class="list-style font-size-12">


                    			<li class="d-flex mb-3">
                    				<i class="fas fa-phone-alt text-green text-center li-fa-icon"
                    				aria-hidden="true"></i>
                    				<div class="ml-1" v-if="detail.phone != ''">
													{{detail.phone}}
												</div>
												<div class="ml-1" v-else>
													N/A
												</div>
                    			</li>

                    			<li class="d-flex mb-3">
                    				<i class="fa fa-envelope text-green text-center li-fa-icon" aria-hidden="true"></i>
                    				<div class="ml-1" v-if="detail.email != ''">
													{{detail.email}}
												</div>
												<div class="ml-1" v-else>
													N/A
												</div>
                    			</li>


                    		</ul>

                    	</div>
                    </div>
                </div>



                <div class="row">
                	<div class="col-4 text-center pr-1">
                		<router-link to="/edit-profile"
                		class="btn btn-sm btn-block bgc-green text-white font-size-12 p-0 pt-1 pb-1">Edit Profile</router-link>
                	</div>
                	<div class="col-4 pr-1 pl-1"> 
                		<router-link to="/change-password"
                		class="btn btn-sm btn-block bgc-green text-white font-size-12 p-0 pt-1 pb-1 "> Change Password</router-link>
                	</div>
                	<div class="col-4 pl-1">
                		<router-link to="#"
                		class="btn  btn-block bgc-green text-white font-size-12 p-0 pt-1 pb-1 ">Logout</router-link>
                	</div>
                </div>

            </div>



            <div class="row">
            	<div class="col-6 pr-1">
            		<router-link to="/subscribed-mosque"
            		class="text-success text-center font-size-15 btn-block">
            		<div class=" b-shadow text-center pb-2 pt-2">
            			<img src="assets/New/images/SubcribeMosque.png" alt="" class=""
            			style="height:90px"><br>
            			Subscribed Mosques
            		</div>
            	</router-link>
            </div>
            <div class="col-6 ">
            	<router-link to="/subscribed-courses"
            	class="text-success text-center font-size-15 btn-block"> 
            	<div class=" b-shadow text-center pb-2 pt-2">
            		<img src="assets/New/images/SubscribeCourses.png" alt="" class="" style="height:90px"><br>
            		Subscribed Courses

            	</div>
            </router-link>
        </div>
    </div>

    <div class="row mt-2">
    	<div class="col-6 pr-1">
    		<router-link to="/registred-jumma"
    		class="text-success text-center font-size-15 btn-block">
    		<div class=" b-shadow text-center pb-2 pt-2">

    			<img src="assets/New/images/jumma1.png" alt="" class=""
    			style="height:90px"><br>
    			Jumma Registration


    		</div>
    	</router-link>
    </div>
    <div class="col-6 ">
    	<router-link to="/bookmarks"
    	class="text-success text-center font-size-15 btn-block">
    	<div class=" b-shadow text-center  pb-2 pt-2">
    		<img src="assets/New/images/menuBookmarks.png" alt="" class=""
    		style="height:90px"><br>
    		Bookmarks
    	</div>
    </router-link>
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