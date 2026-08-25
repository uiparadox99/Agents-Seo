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
							<div class="facilities">
								<h3 class="text-green">Update Facilities and Services   <router-link to="/user/add-facilities" class="btn p-2 pl-5 pr-5 b-radius float-right  btn-success text-white"> Update</router-link></h3>
								<alert></alert>

								<ContentLoader v-if="loading">
									<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
									<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
									<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
									<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
									<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
									<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
								</ContentLoader>


								<div class="" v-else>                                      
									<ul class="list list-style mt-3 ">

										<li class="mb-2" v-if="capacity != '' && capacity > 0"><i class="fas fa-check text-green"></i> &nbsp; Capacity &nbsp; {{capacity}}
							</li>

										<li class="mb-2" v-for="f in facilities"><i class="fas fa-check text-green"></i> &nbsp; {{f.facility.name}}
										</li>


									</ul>
									<div class="clearfix"></div>
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




				<div class="facilities">
					<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> <span style="margin-left: -30px;">Facilities & Services</span>   </h4>

					<ContentLoader v-if="loading">
						<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
						<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
						<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
						<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
						<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
						<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
					</ContentLoader>


					<div class="" v-else>   

						<ul class="list list-style mt-3 ">

							<li class="mb-2" v-if="capacity != '' && capacity > 0"><i class="fas fa-check text-green"></i> &nbsp; Capacity &nbsp; {{capacity}}
							</li>

							<li class="mb-2" v-for="f in facilities"><i class="fas fa-check text-green"></i> &nbsp; {{f.facility.name}}
							</li>

							<div class="clearfix"></div>
						</ul>



						<div class="text-center">
							<a href="<?php echo BASE_PATH; ?>user/add-facilities" class="btn  pl-5 pr-5 b-radius btn-sm  bgc-green text-white mb-2 mt-3"> Update</a>
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
			current:1,
			capacity:'',
			error_message: "",
			has_message: false,
			error_message: false,
			mosque_id:'',
			facilities: {},
		}

	},
	beforeMount(){
		this.mosque_id = this.$store.getters.getMosque.id;
		this.getData();

	},
	methods: {
		getData(){
			var dataUrl = 'v1/mosque-facility/'+this.$store.getters.getMosque.id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.facilities = result.data.data;
				this.loading = false;
			}, error => {

			});  

			var dataUrl = 'v1/mosque-detail/'+this.$store.getters.getMosque.slug;
						axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
							var data = result.data.data.detail;
							this.capacity = data.capacity;
						}, error => {

						});          
		}
	}
}
</script>