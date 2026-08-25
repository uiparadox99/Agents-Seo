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
							<h4 class="text-green">Donation Appeals <router-link to="/user/add-donation-appeal" class="btn btn-success float-right">Add Donation Appeal</router-link></h4>
							<alert></alert>
							
							<ContentLoader v-if="loading">
								<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
								<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
								<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
								<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
							</ContentLoader>
							<div v-else>


								<div class="mt-3" v-if="apeals != '' && apeals.length > 0">
									<div class="donation-record mb-2 p-0" v-for="apeal in apeals" :id="apeal.id">
										<h5 class="green-heading mb-0">
											<span v-if="apeal.purpose != null">{{apeal.purpose.name}}</span>
											<div class="float-right">
												<router-link :to="'/user/edit-donation-appeal/'+apeal.id"><i class="fa fa-edit"></i></router-link>
												<a href="javascript:;" v-on:click="deleteApeal(apeal.id)"><i class="fa fa-trash text-danger"></i></a>
											</div>
										</h5>
										<div class="p-3">
											<div style="border:2px solid #f0f0f0" class="mb-3">

												<img :src="$parent.BASE_API_PATH+'/uploads/'+apeal.image" style="width: 100%;" v-if="apeal.image != ''">

												<img src="/assets/images/s10.jpeg" style="width: 100px;" v-else>         

												<div class="p-2">


													<table class="table table-bordered mt-4">
														<tr>
															<td style="background: #f0f0f0"><b>Account No</b> <span class="text-green" v-if="apeal.account != null">
																{{apeal.account.account}}
															</span></td>

															<td ><b>Sort Code</b> <span class="text-green"  v-if="apeal.account != null">
																{{apeal.account.account_head}}
															</span></td>
															<td style="background: #f0f0f0"><b>Bank Name</b> <span class="text-green"  v-if="apeal.account != null && apeal.account.bank != null">
																{{apeal.account.bank.name}}
															</span></td>
														</tr>
													</table>
												</div>
											</div>
											<div style="background: #f0f0f0" class="p-3">
												<h4 class="text-green">Description</h4>
												<p class="mb-0 ">
													{{apeal.description}}
												</p>
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

				<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button>Donation Appeals</h4>
				<div class="text-center">
					<router-link to="/user/add-donation-appeal" class="btn btn-success btn-sm mb-2">Add Donation Appeal</router-link>
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
				<div class="mt-2" v-else>
					<div  v-if="apeals != '' && apeals.length > 0">
						<div class="donation-record mb-2 p-0"  v-for="apeal in apeals" :id="apeal.id">

							<h6 class="mb-3 mt-2 text-center text-success text-uppercase" style="font-size:17px"><span v-if="apeal.purpose != null">{{apeal.purpose.name}}</span></h6>

							<img :src="$parent.BASE_API_PATH+'/uploads/'+apeal.image" style="width: 100%;height: 200px;object-fit: cover;" v-if="apeal.image != ''">

							<img src="/assets/images/s10.jpeg" style="width: 100%;" v-else>         

							<table class="table table-bordered " style="line-height: 0.1">


								<tr>
									<th class="font-size-15" style="width: 38%;background: #f0f0f0">Account Head</th>
									<td><span class="text-green"  v-if="apeal.account != null">
										{{apeal.account.account_head}}
									</span></td>
								</tr>
								<tr>
									<th class="font-size-15" style="width: 38%;background: #f0f0f0">Sort Code</th>
									<td><span class="text-green"  v-if="apeal.account != null && apeal.account.bank != null">
										{{apeal.account.bank_head}}
									</span></td>
								</tr>
								<tr>
									<th class="font-size-15" style="width: 38%;background: #f0f0f0">Bank Name</th>
									<td><span class="text-green"  v-if="apeal.account != null && apeal.account.bank != null">
										{{apeal.account.bank.name}}
									</span></td>
								</tr>
								<tr>
									<th class="font-size-15" style="width: 38%;background: #f0f0f0">Bank Account</th>
									<td> <span class="text-green" v-if="apeal.account != null">
										{{apeal.account.account}}
									</span></td>
								</tr>
								<tr>
									<th class="font-size-15" style="width: 38%;background: #f0f0f0">Action</th>
									<td>
										<router-link :to="'/user/edit-donation-appeal/'+apeal.id"><i class="fa fa-edit"></i></router-link>
										<a href="javascript:;" v-on:click="deleteApeal(apeal.id)"><i class="fa fa-trash text-danger"></i></a>
									</td>
								</tr>



							</table>



						</div>
					</div>
					<h4 class="text-success text-center" v-else>No Record Found</h4>

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
			apeals: {},
		}

	},
	beforeMount(){
		this.users_id = this.$store.getters.getMosque.users_id;
		this.getData();

	},
	methods: {
		getData(){
			var dataUrl = 'v1/mosque-donation-appeals/'+this.users_id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.apeals = result.data.data;
				this.loading = false;
			}, error => {

			});           
		},
		deleteApeal(id){
			if (confirm('Are You Sure?')) {
				var dataUrl = 'v1/delete-apeal/'+id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					if (result.status) {
						this.$parent.success_message = 'Donation Apeal Deleted';
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
		}
	}
}
</script>