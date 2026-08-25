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
							<h4 class="text-green">Bank Accounts <router-link to="/user/add-bank-account" class="btn btn-success float-right pr-4 pl-4">Add Account</router-link></h4>
							<alert></alert>
							<ContentLoader v-if="loading">
								<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
								<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
								<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
								<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
								<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
							</ContentLoader>

							<div class="mt-3" v-else>

								<br>
						<!-- <?php if (!empty($stmtpn) && $stmtpn->rowCount() > 0) {

							while($r = $stmtpn->fetchObject()){ ?> -->
							<div class="back-account-box mb-4"  v-for="a in accounts" :id="'accountBox'+a.id">
								<form action=""  method="POST" :id="'accountForm'+a.id" @submit.prevent="submit(a.id)">
									<input type="hidden" name="id" id="id" :value="a.id" />
									<div class="row form-group">
										<div class="col-md-3">
											<label>Bank Head</label>
										</div>
										<div class="col-md-9">
											<input type="text" maxlength="15" name="account_head" class="form-control"  :value="a.account_head" style="border: 1px solid #ddd" placeholder="Account Head">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-3">
											<label>Account Number</label>
										</div>
										<div class="col-md-9">
											<input type="text" maxlength="8" name="account"  v-on:keypress="$parent.isNumber($event)" class="form-control" :value="a.account" style="border: 1px solid #ddd" placeholder="Bank Account">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-3">
											<label>Sort Code</label>
										</div>
										<div class="col-md-9">
											<input type="text" name="head"  v-mask="'##-##-##'" class="form-control" v-model="a.head" style="border: 1px solid #ddd" :id="'sortCode'+a.id" placeholder="code">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-3">
											<label>Bank Name</label>
										</div>
										<div class="col-md-9">
											<select class="form-control" name="bank">
												<option value="">Select</option>

												<option v-for="b in banks" :value="b.id"  :selected="b.id == a.bank_id ? true : false">
													{{b.name}}
												</option>
												
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">
											<label >Paypal Account (Id or Email)</label>
										</div>
										<div class="col-md-9">
											<input type="text" name="paypal" class="form-control" :value="a.paypal" style="border: 1px solid #ddd" placeholder="paypal">
										</div>
										
										
									</div>
									
									<div class="row form-group">
										<div class="col-md-3">
											<!-- 	<label>Active / Inactive</label> -->
										</div>
										<div class="col-md-9">
											<label class="btn-block"><input type="checkbox" name="active" value="1" class="" :checked="a.active == 1 ? true : false"> Active / Inactive</label>
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
										</div>
										<div class="col-md-3">
											<button type="submit" name="save" class="btn btn-success btn-block">Edit</button>
										</div>
										<div class="col-md-3">

											
											<button  @click="deleteAccount(a.id)" name="deleteAccount" class="btn btn-danger btn-block">Delete</button>

										</div>
									</div>
								</form>
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



			<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> Bank Accounts </h4>
			<div class="text-center"><router-link to="user/add-bank-account" class="btn btn-success btn-sm">Add Account</router-link></div>
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


				<!-- <?php while($r = $stmtpn->fetchObject()){ ?> -->
				<table class="table table-bordered" v-for="a in accounts" :id="'accountBox'+a.id">

					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Account Head</th>
						<td width="62%">
							{{a.account_head}}
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Sort Code</th>
						<td width="62%">
							{{a.head}}
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Bank Name</th>
						<td width="62%">
							<span v-if="a.bank != null">{{a.bank.name}}</span>
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Bank Account</th>
						<td width="62%">
							{{a.account}}
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Paypal</th>
						<td width="62%">
							{{a.paypal}}
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Status</th>
						<td width="62%">
							<button class="btn btn-sm btn-success " v-if="a.active == 1">Active</button>

							<button class="btn btn-sm btn-danger " v-else>Inactive</button>
						</td>
					</tr>
					<tr>
						<th class="font-size-15" style="width: 38%;background: #f0f0f0">Action</th>
						<td>
							<router-link :to="'/user/edit-bank-account/'+a.id" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></router-link>
							<button  @click="deleteAccount(a.id)" name="deleteAccount" class="btn btn-danger btn-sm float-right">Delete</button>
						</td>
					</tr>

				</table>

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
			mosque_id:'',
			sortCode:'',
			has_error: false,
			submitted: false,
			accounts: {},
			banks: {},
		}

	},
	beforeMount(){
		this.mosque_id = this.$store.getters.getMosque.mosque_id;
		this.getData();

	},
	methods: {
		getData(){
			var dataUrl = 'v1/mosque-bank-account/'+this.$store.getters.getUser.id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.accounts = result.data.data;
				this.loading = false;
			}, error => {

			}); 

			var dataUrl = 'v1/dropdown-data';
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				var data = result.data.data.banks;
				this.banks = data;
			}, error => {

			});           
		},
		submit(id){
			var $this = this;
			this.submitted = true;
			this.$validator.validate().then(valid => {
				if (valid) {
					this.error_message = "";
					this.has_error = false;
					var formData = $('#accountForm'+id).serialize();
					axios({
						method: "POST",
						url: "/v1/save-mosque-bank-account",
						data: formData,
					}).then(  response => {
						var response = response.data;
						if (response.status) {			
							this.$parent.success_message = 'Account Updated Successfully';				

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
		},
		deleteAccount(id){
			if (confirm('Are You Sure?')) {
				var dataUrl = 'v1/delete-mosque-bank-account/'+id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					if (result.status) {
						this.$parent.success_message = 'Account Deleted';
						$('#accountBox'+id).remove();
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
	}
}
</script>