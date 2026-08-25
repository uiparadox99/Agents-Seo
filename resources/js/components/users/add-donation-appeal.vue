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
							<h4 class="text-green ">Donation Appeal</h4>
							<div class="mt-4">

								<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
									<input type="hidden" name="id" id="id" v-model="form.id">
									<div class="form-group row" v-if="detail == ''">
										<div  class="col-md-4">
											<label>Purpose</label>
										</div>
										<div  class="col-md-5">
											<select :class="[{ 'error': submitted && errors.has('purpose') }, 'form-control']" id="purpose" name="purpose" v-model="form.purpose_id"   data-vv-as="purpose" v-validate="'required'">
												<option value="">Select</option>
												<option v-for="po in purpose" :value="po.id+','+po.image">{{po.name}}</option>
											</select>
											
											<label v-if="submitted && errors.has('purpose')" class="error">{{ errors.first('purpose') }}</label>

										</div>
									</div>	
									<input type="hidden" v-model="form.purpose_id" v-else>
									<div class="form-group row">
										<div  class="col-md-4">
											<label>Your Bank Accounts</label>
										</div>
										<div  class="col-md-5">
											<select :class="[{ 'error': submitted && errors.has('account') }, 'form-control']" name="account" v-model="form.bank_account_id" data-vv-as="account" v-validate="'required'">>
												<option value="">Select</option>
												<option v-for="acc in account" :value="acc.id">{{acc.account}} ({{acc.bank.name}})</option>
											</select>
											<label v-if="submitted && errors.has('account')" class="error">{{ errors.first('account') }}</label>
										</div>
										<div class="col-md-3 ">
											<p class="m-0 font-size-12"><i class="fa fa-info-circle"></i> Select existing bank Accoint to connect or add new bank account</p>
										</div>
									</div>	
									<div class="form-group row">
										<div  class="col-md-4">
											<label>Description</label>
										</div>
										<div  class="col-md-5">
											<textarea v-model="form.description" class="form-control" maxlength="300" rows="4"></textarea>
											<label class="mt-2"><input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
									<input type="checkbox" name="active" v-else @click="check($event)" class=""> Active</label>
										</div>
									</div>
									<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&#10006;</span>
										</button>
										<span v-html="error_message"></span>
									</div>

									<div class=" text-right">
										<button type="submit" name="save" class="btn btn-success pl-5 pr-5" v-if="!submitted">Save</button>
										<button disabled="" class="btn btn-success pl-5 pr-5" v-else><i class="fa fa-spine fa-spinner"></i></button>
										<button type="reset" name="cancel" class="btn btn-danger pl-5 pr-5">Cancel</button>

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
				<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button>Donation Appeal</h4>
				<div class="mt-3">
					<VLSidebar></VLSidebar>
					<form action="" method="POST" id="updateform" enctype="multipart/form-data"  @submit.prevent="submit()">
						<input type="hidden" name="id" id="id" v-model="form.id">
						<div class="form-group row" v-if="detail == ''">
							<div  class="col-md-4">
								<label>Purpose</label>
							</div>
							<div  class="col-md-5">
								<select :class="[{ 'error': submitted && errors.has('purpose') }, 'form-control']" id="purpose" name="purpose" v-model="form.purpose_id"   data-vv-as="purpose" v-validate="'required'">
									<option value="">Select</option>
									<option v-for="po in purpose" :value="po.id+','+po.image">{{po.name}}</option>
								</select>
								
								<label v-if="submitted && errors.has('purpose')" class="error">{{ errors.first('purpose') }}</label>

							</div>
						</div>	
						<input type="hidden" v-model="form.purpose_id"  v-else>
						<div class="form-group row">
							<div  class="col-md-4">
								<label>Your Bank Accounts</label>
							</div>
							<div  class="col-md-5">
								<select :class="[{ 'error': submitted && errors.has('account') }, 'form-control']" name="account" v-model="form.bank_account_id" data-vv-as="account" v-validate="'required'">>
									<option value="">Select</option>
									<option v-for="acc in account" :value="acc.id">{{acc.account}} ({{acc.bank.name}})</option>
								</select>
								<label v-if="submitted && errors.has('account')" class="error">{{ errors.first('account') }}</label>
							</div>
							<div class="col-md-3 ">
								<p class="m-0 font-size-12"><i class="fa fa-info-circle"></i> Select existing bank Accoint to connect or add new bank account</p>
							</div>
						</div>	
						<div class="form-group row">
							<div  class="col-md-4">
								<label>Description</label>
							</div>
							<div  class="col-md-5">
								<textarea v-model="form.description" class="form-control" maxlength="300" rows="4"></textarea>
								<label class="mt-2"> 
									<input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
									<input type="checkbox" name="active" v-else @click="check($event)" class="">
									 Active</label>
							</div>
						</div>
						<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&#10006;</span>
							</button>
							<span v-html="error_message"></span>
						</div>

						<div class=" row">
							<div class=" col-6 pr-1">
								<button type="submit" name="save" class="btn btn-success pl-5 pr-5" v-if="!submitted">Save</button>
								<button disabled="" class="btn btn-success pl-5 pr-5" v-else><i class="fa fa-spine fa-spinner"></i></button>
							</div>
							<div class=" col-6 pl-1">
								<button type="reset" name="cancel" class="btn btn-danger btn-sm btn-block">Cancel</button>
							</div>
						</div>
					</form>
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
			purpose: {},
			account:{},
			error_message: "",
			has_error: false,
			submitted: false,
			form:{
				id:'',
				bank_account_id:'',
				purpose_id:'',
				users_id:this.$store.getters.getMosque.users_id,
				description:'',
				active:1,
			}
		}

	},
	beforeMount(){
		this.getData();
	},
	methods: {
		getData(){
			if (typeof this.$route.params.id !== 'undefined' && this.$route.params.id != '') {
				var dataUrl = 'v1/donation-appeal-detail/'+this.$route.params.id;
				axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
					var data = result.data.data
					this.detail = data;
					this.form.id = data.id;
					this.form.bank_account_id = data.bank_account_id;
					this.form.purpose_id = data.purpose_id+','+data.purpose.image;
					this.form.description = data.description;
					this.form.active = data.active;
				}, error => {

				});
			}
			var dataUrl = 'v1/dropdown-data';
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				var data = result.data.data
				this.purpose = data.purpose;
				this.account = data.accounts;
			}, error => {

			});           
		},
		check(e){
			if (e.target.checked) {
				this.form.active = 1;
			}else{
				this.form.active = 0;
			}
		},
		submit(){
			var $this = this;
			this.submitted = true;
			this.$validator.validate().then(valid => {
				if (valid) {
					this.error_message = "";
					this.has_error = false;
					axios({
						method: "POST",
						url: "/v1/save-mosque-donation-appeal",
						data: JSON.stringify(this.form),
						headers: { "content-type": "application/json" }
					}).then(  response => {
						var response = response.data;
						if (response.status) {			
						    this.$parent.success_message = 'Donaton Apeal Added';				
							this.$router.push({path: '/user/donation-apeals'});
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
