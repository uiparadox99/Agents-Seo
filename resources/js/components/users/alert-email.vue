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
						<h4 class="text-green">Alert Email</h4>
						<div class="mt-3">

							<form action="" onsubmit="return false" method="POST" id="updateform"  @submit.prevent="submit()">

								
									<input type="hidden" name="id" v-model="form.id" id="id" />
									<input type="hidden" name="sendEmail" >
									<div class="form-group">
										<label>Email Subject</label>
										<input type="text" name="subject" v-model="form.subject" v-validate="'required'" :class="[{ 'error': submitted && errors.has('subject') }, 'form-control']" data-vv-as="subject" id="subject" value="" placeholder="Subject">
										<span v-show="errors.has('subject')" class="text-danger">{{ errors.first('subject') }}</span>
									</div>	
									<div class="form-group ">
										<label>Email Message</label>
										<textarea name="message" id="message" rows="5" v-model="form.message" v-validate="'required'" :class="[{ 'error': submitted && errors.has('message') }, 'form-control']" data-vv-as="subject" placeholder="Message"></textarea>
									      <span v-show="errors.has('message')" class="text-danger">{{ errors.first('message') }}</span>
									</div>	
									
								 
								<div class=" text-center">
									<button id="buttonBlock" type="submit" class="btn btn-success pl-5 pr-5"  v-if="!submitted">Send Mail</button>
									<button disabled="" class="btn btn-success pl-5 pr-5 btn-sm btn-block" v-else><i class="fa fa-spine fa-spinner"></i></button>

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

		<div class="">
			<h5 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button>Add / Edit Account</h5>
			<div class="mt-3">

				<form action="" method="POST" id="updateform">

					
					<div class=" row">

						<input type="hidden" name="id" id="id" value="<?php echo !empty($detail)?$detail->id:'' ?>" />


						<div class="form-group mb-2 col-6 pr-2">
							<label class="" style="font-size: 14px;">Account Head</label>
							<input type="text" maxlength="15" name="account_head"  class="form-control" value="" style="border: 1px solid #ddd" placeholder="Account Head">
						</div>	
						<div class="form-group mb-2 col-6 pl-2">
							<label class="" style="font-size: 14px;">Bank Account Number</label>
							<input type="text" maxlength="8" name="bank_account"  class="form-control" value="" style="border: 1px solid #ddd" placeholder="Bank Account">
						</div>	
						<div class="form-group mb-2 col-6  pr-2">
							<label class="" style="font-size: 14px;">Sort Code</label>
							<input type="text" name="bank_head" required="" class="form-control" value="" style="border: 1px solid #ddd" placeholder="Bank Head">
						</div>	
						<div class="form-group mb-2 col-6 pl-2">
							<label class="" style="font-size: 14px;">Bank Name</label>
							<select class="form-control" name="bank">
								<option value="">Select</option>
								<!-- <?php while($r = $banks->fetchObject()){ ?>
									<option value="<?php echo $r->id ?>" <?php echo !empty($detail) && $detail->bank_id == $r->id?'selected':''; ?>>
										<?php echo $r->name ?>
									</option>
								<?php } ?> -->
							</select>

						</div>	
						<div class="form-group col-sm-4">
										
										<label class="btn-block"><input type="checkbox" name="active" class="" > Active?</label>
									</div>
					</div>

					<div class=" text-center">
						<button id="buttonBlock" onclick="" name="save" class="btn btn-success btn-block">Save</button>

					</div>
				</form>
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
			detail: '',
			error_message: "",
			has_error: false,
			submitted: false,
			form:{
				mailid:this.$route.params.id,
				sendEmail:'',
				subject:'',
				message:''
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
						url: "/v1/alert-mail",
						data: JSON.stringify(this.form),
						headers: { "content-type": "application/json" }
					}).then(  response => {
						var response = response.data;
						if (response.status) {			
						    this.$parent.success_message = 'Mail Sent Successfully';				
							this.$router.push({path: '/user/manage-jumma'});
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
