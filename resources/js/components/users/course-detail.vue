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
						<div class="row">
							<div class="col-md-12 pt-5">
								<div class="border-green b-radius p-3">

									<h4 class="text-success">{{detail.name}} Students</h4>
									<alert></alert>
									<div class="table-responsive">


										<table class="table table-striped mb-0 table-bordered">
											<thead>
												<tr>
													<th>Name</th>
													<th>Email</th>
													<th>Phone</th>


													<th width="20%">Action</th>
												</tr>
											</thead>
											<tbody>

												<tr v-if="detail.user_courses.length > 0" v-for="ap in detail.user_courses" :id="ap.user.id">


													<td>
														{{ap.user.first_name}} {{ap.user.last_name}}
													</td>
													<td>
														{{ap.user.email}}
													</td>
													<td>
														{{ap.user.phone}}
													</td>


													<td :id="ap.user.id+'buttons'">
														<div v-if="ap.active == 1">
															<button class="btn btn-sm btn-success text-white" >Accepted</button>
														</div>
														<div v-else>
															<a href="javascript:;" @click="changeStatus(detail.id,ap.user.id,'accept')" class="btn btn-sm btn-success text-white float-left" >Accept</a>
															<a href="javascript:;" @click="changeStatus(detail.id,ap.user.id,'reject')" class="btn btn-sm btn-danger text-white float-right" >Reject</a>
														</div>
													</td>
												</tr>

												<tr v-else>
													<td colspan="5" class="text-center text-success">No Record Found</td>
												</tr>

											</tbody>
										</table>
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
			<main class="container pt-3 pb-3">
				<VLSidebar></VLSidebar>

				<h5 class="text-green text-center mb-0"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> <span style="margin-left: -10px">Courses Students</span></h5>
				<div class="clearfix"></div>
					<alert></alert>

				<div class=" mt-2">

					<div class="border-green b-radius mb-3 p-2" v-if="detail.user_courses.length > 0" v-for="ap in detail.user_courses" :id="ap.id">
						<div>
							{{ap.user.first_name}} {{ap.user.last_name}}
							<div class="float-right">
								<div v-if="ap.active == 1">
									<button class="btn btn-sm btn-success text-white" >Accepted</button>
								</div>
								<div v-else>
									<a href="javascript:;" @click="changeStatus(ap.id,'accept')" class="btn btn-sm btn-success text-white float-left" >Accept</a>
									<a href="javascript:;" @click="changeStatus(ap.id,'reject')" class="btn btn-sm btn-danger text-white float-right" >Reject</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<p class="mb-0"> 
							{{ap.user.email}} | {{ap.user.phone}}
						</p>


					</div>

					<p v-else class="text-center text-success">No Record Found</p>

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
			teachers: {},
			error_message: "",
			has_error: false,
			submitted: false,
		}

	},
	beforeMount(){
		this.getData();
	},
	methods: {
		getData(){

			var dataUrl = 'v1/course-detail/'+this.$route.params.id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				var data = result.data.data
				var duration = data.duration.split(' ');
				var time = data.class_time.split('-');
				this.detail = data;
			}, error => {

			});
			

		},
		changeStatus(course_id,user_id,status){
				var dataUrl = 'v1/change-course-application-status/';
				let formData = new FormData();
					formData.append('course_id', course_id);
					formData.append('user_id', user_id);
					formData.append('status', status);
			axios({
				method: "POST",
				url: "/v1/change-course-application-status",
				data: formData,
				headers: { "content-type": "application/json" }
			}).then(  response => {
				var response = response.data;
				if (response.status) {	
					if (status == 'accept') {
						this.$parent.success_message = 'Application Accepted SuccessFully';
						$('#'+user_id+'buttons').html('<button class="btn btn-sm btn-success text-white" >Accepted</button>');
					}else{
						this.$parent.success_message = 'Application Rejected SuccessFully';
						$('#'+user_id).remove();
					}	
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
		}
		
	}
}
</script>
