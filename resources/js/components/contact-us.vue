<template>
	<div>
		<VGHeader></VGHeader>
		<main class="container mt-2 pt-5 pb-5">

		<!-- <div class="panel-display mb-5 rounded">
			<ins class="adsbygoogle" style="display:inline-block;width:100%;height:150px"
			data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"><p class="panel-text text-success" onclick="scrollToBottomSocial(this)">Install Our App To Calculate Zakat</p></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div> -->
		


		<div class="row">


			<div class="col-md-5 pr-0">
				<img src="assets/New/images/contact-us.jpg"  class="w-100" style="height: 593px;">
			</div>

			<div class="col-md-7 pl-0">

				<form method="POST" action="" @submit.prevent="submit()" id="updateform" class="pl-4 pr-4 pt-3 pb-3 b-shadow" style="">
					<h1 class="text-center text-success mb-3">Contact For Inquiry</h1>
					<div class="form-group mb-4  ">
						<!-- <label for="name">Name</label> -->
						<input id="name" :class="[{ 'error': submitted && errors.has('name') }, 'form-control']" data-vv-as="name" v-validate="'required'" v-model="name" style="height: 52px;" type="text" name="name"  placeholder="Name">
						<label v-if="submitted && errors.has('name')" class="error">{{ errors.first('name') }}</label>
					</div>
					<div class="form-group mb-4 ">
						<!-- <label for="phone">Mobile</label> -->
						<input id="phone" maxlength="12" :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']"  data-vv-as="phone" v-validate="'required'" style="height: 52px;" type="text" v-model="phone" name="phone" placeholder="Phone">
						<label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
					</div>
					<div class="form-group mb-4 ">
						<!-- <label for="email">Email</label> -->
						<input id="email" :class="[{ 'error': submitted && errors.has('email') }, 'form-control']"  data-vv-as="email" v-validate="'required'" style="height: 52px;" type="email" v-model="email" name="email" placeholder="Email Address">
						<label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
					</div>					
					<div class="form-group mb-4 ">
						<!-- <label for="message">Message</label> -->
						<textarea id="message" rows="4" name="message" v-model="message" :class="[{ 'error': submitted && errors.has('message') }, 'form-control']"  data-vv-as="message" v-validate="'required'" placeholder="Message"></textarea>
						<label v-if="submitted && errors.has('message')" class="error">{{ errors.first('message') }}</label>
					</div>
					<!-- <div class="g-recaptcha mb-2" data-sitekey="6LeNsNcZAAAAANDHAsosMFCU8XgayVp_2dRP_7V9" ></div> 6LcQrrEcAAAAAE6qaaoh6gkncsj66YkWZXVvc1wF -->
					<vue-recaptcha ref="recaptcha"
					@verify="onVerify" :loadRecaptchaScript="true"  @expired="onCaptchaExpired" sitekey="6LcQrrEcAAAAAG1NBrfVdRyxJ9VOkHwgT5CtLQ0m">
				</vue-recaptcha>
				<br>
				<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&#10006;</span>
					</button>
					<span v-html="error_message"></span>
				</div>
				<div class="text-center">
					<input type="submit" value="Send Mail" name="save" class="btn btn-success btn-lg btn-block text-uppercase pl-5 pr-5"> 
				</div>
			</form>
		</div>
	</div>

	
	<div class="panel-display mt-4">


				<!-- <div class="hide-on-mobile" >
					<ins class="adsbygoogle" style="display:block;width:100%;height:150px;"
					data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"><p class="panel-text text-success" onclick="scrollToBottomSocial(this)">Install Our App To Calculate Zakat</p></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div> -->
				<!-- <div class="hide-on-desktop" >
					<ins class="adsbygoogle" style="display:block;width:100%;height:300px;"
					data-ad-client="ca-pub-9682339330195266" data-ad-slot="9329871325"><p class="panel-text text-success" onclick="scrollToBottomSocial(this)">Install Our App To Calculate Zakat</p></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div> -->
				<!-- <div class="con-com con-pag-map con-com-mar-bot-o">
					<h4 class="con-tit-top-o">Touch with us</h4>
					<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A. Landmark : Next To Airport</p>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6290413.804893654!2d-93.99620524741552!3d39.66116578737809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880b2d386f6e2619%3A0x7f15825064115956!2sIllinois%2C+USA!5e0!3m2!1sen!2sin!4v1469954001005" allowfullscreen=""></iframe>
				</div> -->
			</div>

		</main>
		<VFooter></VFooter>
	</div>
</template>


<script>
import VueRecaptcha from 'vue-recaptcha';
export default {
	components: { VueRecaptcha },
	data(){
		return{
			name: '',
			phone:'',
			email:'',
			message:'',
			mainData:'',
			error_message: "",
			has_error: false,
			submitted: false,
			robot: false
		}
	},

	methods:{
		onVerify(token){
			this.robot = true;
		},
		onCaptchaExpired(token){
			this.robot = false;
			this.$refs.recaptcha.reset();
		},
		submit(){
			var $this = this;
			// var dataUrl = 'v1/contact-us';
			this.submitted = true;
			this.$validator.validate().then(valid => {
				if (valid) {
					this.error_message = "";
					this.has_error = false;
					if (this.robot) {
						axios.post('v1/contact-us', {
							name:this.name,
							phone:this.phone,
							email:this.email,
							message:this.message
						})
						.then(function (response) {
							var response = response.data;
							if (response.status) {			
								$this.$parent.success_message = 'Contact Request Send Successfully';
								$('#updateform').trigger("reset");	
							}else{
								$this.has_error = true;
								$this.error_message = response.message;
								setTimeout(function() {
									$this.error_message = "";
									$this.has_error = false;
									$this.submitted = false;
								}, 5000);
							}
						});
					}else{
						this.has_error = true;
						this.error_message = 'Please Fill Captcha';
						setTimeout(function() {
							$this.error_message = "";
							$this.has_error = false;
							$this.submitted = false;
						}, 5000);
					}
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

	},
// 	 components: {
//     'vue-recaptcha': VueRecaptcha
//   },
}
</script>

