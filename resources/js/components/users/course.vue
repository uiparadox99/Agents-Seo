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
					<h4 class="text-green">Courses <router-link to="/user/add-course" class="btn btn-success float-right">Add Course</router-link></h4>
					<alert></alert>
					<ContentLoader v-if="loading">
								<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
								<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
								<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
								<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
							</ContentLoader>
					<div class="mt-4" v-else>
						<div class="row" v-if="courses != '' && courses.length > 0">
						
							<div class="col-md-6" v-for="course in courses" :id="course.id">
									<div class="new-event-box mb-4" style="    height: 505px;">
										<h5 class="event-title mb-0">
                                           {{course.name.substr(0, 30)}}
                                            </h5>
											<img :src="$parent.BASE_API_PATH+'/uploads/'+course.img" style="height:230px" v-if="course.img != ''">

											<img src="/assets/images/s10.jpeg" style="height:230px" v-else>   

								
										<div class="p-2" >
											<table class="table table-striped table-bordered mb-0">
												<tr>
													<th class="p-1" width="35%">Teacher</th>
													<td class="p-1">
                                                        {{course.author}}
                                                        </td>
												</tr>
												<tr>
													<th class="p-1" width="35%">Timing</th>
													<td class="p-1">
														{{showtime(course.class_time)}}
                                                         </td>
												</tr>
											</table>
											<table class="table table-striped table-bordered mb-1">
												<tr>
													<th class="p-1" width="15%">Price</th>
													<td class="p-1" width="20%" style="background: #fff"><span style="font-size:15px" class="text-success">£ </span>
                                                      {{course.price}}
                                                    </td>
													<th class="p-1" width="25%">Duration</th>
													<td class="p-1" style="background: #fff"> 
                                                        {{course.duration}}
                                                        </td>
												</tr>
												
											</table>
											<p class="mb-2" style="text-align:justify">
                                                 {{course.description.substr(0, 100)}}
                                                </p>
											<div class="" >
												  <router-link :to="'/user/course-detail/'+course.id" class="btn btn-sm btn-success text-white" >Students</router-link>
                                       
												<!-- <router-link to="/user/startClass" class="btn btn-success btn-xs btn-sm">Go to Live class</router-link>
 -->
												<div class="float-right">
													<router-link  :to="'/user/edit-course/'+course.id" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></router-link>&nbsp;
													<a href="javascript:;" v-on:click="deleteCourse(course.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
						
						</div>
						<h4 class="text-success text-center mt-4" v-else>No Record Found</h4>
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
					<h5 class="text-green "><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button><span class="text-center btn-block" style="padding-left: -25px;">Courses</span> </h5>
					<alert></alert>
					<div class="text-center">
						<router-link to="/user/add-course" class="btn btn-success btn-sm">Add Course</router-link>
					</div>
					<div class="mt-4">
						<div class="row">
						
							<div class="col-md-6" v-for="course in courses" :id="course.id">
									<div class="new-event-box mb-4" style="    height: 505px;">
										<h5 class="event-title mb-0">
                                           {{course.name.substr(0, 30)}}
                                            </h5>
											<img :src="$parent.BASE_API_PATH+'/uploads/'+course.img" style="height:230px" v-if="course.img != ''">

											<img src="/assets/images/s10.jpeg" style="height:230px" v-else>   

								
										<div class="p-2" >
											<table class="table table-striped table-bordered mb-0">
												<tr>
													<th class="p-1" width="35%">Teacher</th>
													<td class="p-1">
                                                        {{course.author}}
                                                        </td>
												</tr>
												<tr>
													<th class="p-1" width="35%">Timing</th>
													<td class="p-1">
														{{showtime(course.class_time)}}
                                                         </td>
												</tr>
											</table>
											<table class="table table-striped table-bordered mb-1">
												<tr>
													<th class="p-1" width="15%">Price</th>
													<td class="p-1" width="20%" style="background: #fff"><span style="font-size:15px" class="text-success">£ </span>
                                                      {{course.price}}
                                                    </td>
													<th class="p-1" width="25%">Duration</th>
													<td class="p-1" style="background: #fff"> 
                                                        {{course.duration}}
                                                        </td>
												</tr>
												
											</table>
											<p class="mb-2" style="text-align:justify">
                                                 {{course.description.substr(0, 100)}}
                                                </p>
											<div class="" >
												  <router-link to="/user/course-detail" class="btn btn-sm btn-success text-white" >Students</router-link>
                                       
												<!-- <router-link to="/user/startClass" class="btn btn-success btn-xs btn-sm">Go to Live class</router-link>
 -->
												<div class="float-right">
													<router-link  :to="'/user/edit-course/'+course.id" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></router-link>&nbsp;
													<a href="javascript:;" v-on:click="deleteCourse(course.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
												</div>
											</div>
										</div>
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
			loading: true,
			message: "",
			error_message: "",
			has_message: false,
			error_message: false,
			users_id:'',
			courses: {},
		}

	},
	beforeMount(){
		this.users_id = this.$store.getters.getMosque.users_id;
		this.getData();

	},
	methods: {
		getData(){
			var dataUrl = 'v1/mosque-courses/'+this.$store.getters.getMosque.id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.courses = result.data.data;
				this.loading = false;
			}, error => {

			});           
		},
		deleteCourse(id){
			if (confirm('Are You Sure?')) {
				var dataUrl = 'v1/delete-course/'+id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					if (result.status) {
						this.$parent.success_message = 'Course Deleted';
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
		showtime(time){
			time = time.split('-');
			return time[0]+' to '+time[1];
		}
	}
}
</script>