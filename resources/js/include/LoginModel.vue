<template>
	<div>
		<div class="modal copysettingsmodal" id="loginModel">
			<div class="modal-dialog" style="max-width:40vw;min-height:40vh">
				<div class="modal-content" style=" ">
					<div class="modal-header">
						<div v-if="loader"><i class="fa fa-spin fa-spinner" style="    font-size: 21px;"></i> </div>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div v-if="$store.getters.isLoggedIn" class="modal-body">
						 <div class="login-box">
						 	 <h5 class="text-center">Hello {{$store.getters.getUser.name}}</h5>
						 	 <h6 class="text-center">Email: {{$store.getters.getUser.email}}</h6>
						 	 <hr>
						 	 	<div  class="row mb-5">
									<div class="col-md-6 offset-md-3 text-center ">
										 <h4 class="text-center">Active plan</h4>
										 	<p>
										 		<b>Plan type:</b> &nbsp;&nbsp;{{$store.getters.getUser.package.name}} <br>
										 	 <b>Project Limit:</b> &nbsp;&nbsp;{{$store.getters.getUser.package.projects}} <br>
										 	</p>
										 	<router-link to="pricing" class="btn cm-btn pr-4 pl-4"><i class="fa fa-wallet"></i> &nbsp; View Plans</router-link>
									</div>
								</div>
								<ul class="login-btns">
									<li><a href="javascript:;" class="text-success" @click="$parent.$parent.logout"><i class="fas fa-sign-out-alt"></i> Logout</a> </li>
									<li><a href="javascript:;" class="text-danger" @click="deleteAccount"><i class="fa fa-trash"></i> Delete Account</a>  </li>
									<li><a href="javascript:;" class="text-blue" @click="updatePassword"><i class="fa fa-lock"></i> Update Password</a>  </li>
									<li><a href="javascript:;" type="button" class="text-blue" data-dismiss="modal"> Done</a></li>
								</ul>
							
						 </div>
					</div>
					<div class="modal-body" v-else>

						<div class="row" v-if="!loginWizard">
							<div class="col-md-6 offset-md-3 text-center">
								<button @click="AuthProvider('google')"  class="login-btn btn-google" style=""><i class="fab fa-google"></i> Sign in with Google</button>
								<button @click="AuthProvider('facebook')"  class="login-btn btn-facebook" style=""><i class="fab fa-facebook-square"></i> Sign in with Facebook</button>
								<button @click="AuthProvider('github')"  class="login-btn btn-github"><i class="fab fa-github"></i> Sign in with GitHub</button>
								<button class="login-btn" @click="loginWizard = true" style="    color:#fff;background-color: #db4437;"><i class="fa fa-envelope"></i> Sign in with email</button>
								<p style="font-size:14px">By continuing you are indicating that you accept our <br> <router-link to="/terms" class="text-success"> Terms of Service</router-link> and <router-link to="/policy" class="text-success"> Privacy Policy</router-link> </p>
							</div>
						</div>
						<div v-else class="row">
									<div class="col-md-8 offset-md-2 ">
							<div class="login-box" v-if="!showPassword && !registerNew && !socialOne">
								<h3>Sign in with email</h3>
								<form @submit.prevent="checkEmail" method="post">
									<div class="form-group">
										<input type="text" class="form-control" name="email"  autocomplete="off"  v-model="form.email" placeholder="Email"   data-vv-as="email"  v-validate="'required|email'">
									</div>
									<div class="float-right text-right">
										<a href="javascript:;"  @click="cancel">CANCEL</a> &nbsp; 
										<button type="submit" class="cm-btn btn">NEXT</button>
										<br>
										<router-link to="/terms" class="text-success"> Terms of Service</router-link> &nbsp; <router-link to="/policy" class="text-success"> Privacy Policy</router-link>
									</div>
								</form>
								
							</div>
							<div class="login-box" v-else-if="showPassword && !registerNew && !socialOne">
								<h3>Sign in</h3>
								<form @submit.prevent="login" method="post">
									<div class="form-group cus-select">
											<span>Email</span>
										<input type="text" class="form-control" name="email" v-model="form.email"  autocomplete="off"  placeholder="Email"   data-vv-as="email"  v-validate="'required|email'">
									</div>
									<div class="form-group cus-select">
										<span>Password</span>
										 <div class="pass-icon2 login-pass-eye" @click="showLoginPassword()"></div>
										<input type="password" class="form-control" name="password" id="password" v-model="form.password" placeholder="Choose password" data-vv-as="password"  v-validate="'required'">
									</div>
									<div class="float-right text-right">
										<a href="javascript:;"  @click="cancel">CANCEL</a>  &nbsp; 
										<button type="submit" class="btn cm-btn">NEXT</button>
										<br>
										<router-link to="/terms" class="text-success"> Terms of Service</router-link> &nbsp; <router-link to="/policy" class="text-success"> Privacy Policy</router-link>
									</div>
								</form>
							</div>
							<div class="login-box" v-else-if="registerNew && !socialOne">
								<h3>Create account</h3>
								<form @submit.prevent="register" method="post">
									<div class="form-group cus-select">
										<span>Email</span>
										<input type="text"  name="email" v-model="form.email" placeholder="Email" autocomplete="off"   data-vv-as="email"  v-validate="'required|email'">
									</div>
									<div class="form-group cus-select">
										<span>Name</span>
										<input type="text"  name="name" v-model="form.name" placeholder="First & last name"  autocomplete="off"   data-vv-as="name"  v-validate="'required'">
									</div>
									<div class="form-group cus-select">
										<span>Choose Password</span>
										 <div class="pass-icon2 pass-eye" @click="showPasswordField()"></div>
										<input type="password"  name="password" id="registerpassword" v-model="form.password" placeholder="Choose password" data-vv-as="password"  v-validate="'required'">
									</div>
									<div class="float-right text-right">
										<a href="javascript:;"  @click="cancel">CANCEL</a>  &nbsp; 
										<button type="submit" class="cm-btn btn">NEXT</button>
										<br>
										<router-link to="/terms" class="text-success"> Terms of Service</router-link> &nbsp; <router-link to="/policy" class="text-success"> Privacy Policy</router-link>
									</div>
								</form>
							</div>
							<div class="login-box" v-else-if="socialOne && !registerNew">
								<h3>Sign in</h3>
								<br>
								<h4>You already have an account</h4>
								<p>You've already used<br> <b>{{form.email}}</b> Sign in with <span class="text-capitalize">{{social_name}}</span> to continue.</p>
							</div>
						</div>
						</div>
						<div class="alert alert-danger alert-dismissible fade in show mt-2" role="alert" v-if="has_error">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&#10006;</span>
							</button>
							<span v-html="error_message"></span>
						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer" v-if="!$store.getters.isLoggedIn">
						<button type="button" class=" btn-none float-right" data-dismiss="modal">Done</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return{
			  error_message: "",
			loginWizard:false,
			 has_error: false,
			 registerNew: false,
			 socialOne: false,
			 loader: false,
			 showPassword: false,
			 social_name:'',
			form:{
				email:'',
				name:'',
				password:'',
			},
			stepcount:1,
		}
	},
	mounted(){

	},

	methods:{
		AuthProvider(provider) {

			var self = this

			this.$auth.authenticate(provider).then(response =>{

				self.SocialLogin(provider,response)

			}).catch(err => {
				console.log({err:err})
			})

		},

		SocialLogin(provider,response){

			this.$http.post('/sociallogin/'+provider,response).then(response => {

				console.log(response.data)

			}).catch(err => {
				console.log({err:err})
			})
		},
		cancel(){
			this.socialOne = false;
			this.showPassword = false;
			this.registerNew = false;
			this.loginWizard = false;
		},
		showPasswordField() {
              var x = document.getElementById("registerpassword");
              if (x.type === "password") {
                x.type = "text";
                 $(".pass-eye").addClass("show");
            } else {
                x.type = "password";
                $(".pass-eye").removeClass("show");
            }
        },
        showLoginPassword() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
                 $(".login-pass-eye").addClass("show");
            } else {
                x.type = "password";
                $(".login-pass-eye").removeClass("show");
            }
        },
		checkEmail(){
			var mthis = this;
			this.$validator.validate().then(valid => {
				if (valid) {
					let formData = new FormData();
					formData.append('email',this.form.email);
					mthis.loader = true;
					axios({
						method: "POST",
						url: "/check-user",
						data: formData,
						headers: { "content-type": "application/json" }
					}).then(  response => {
						var response = response.data;
						if (response.status) {
							var user = response.data.user;
							if (user.login_type != 'site') {
									mthis.socialOne = true;
									mthis.social_name = user.login_type;
							}else{
								mthis.showPassword = true;
							}
						}else{
							mthis.registerNew = true;
						}

						mthis.loader = false;
					});
				}else{
					this.has_error = true;
					mthis.loader = false;
					this.error_message = this.errors.items[0].msg;
					setTimeout(function() {
						mthis.error_message = "";
						mthis.has_error = false;
					}, 2500);
				}
			})
		},
		login() {
        // get the redirect object
        var $this = this;
        this.$validator.validate().then(valid => {
           if (valid) {
         this.error_message = "";
         this.has_error = false;
         $this.loader = true;
             axios({
              method: "POST",
              url: "/login",
              data: JSON.stringify(this.form),
              headers: { "content-type": "application/json" }
             }).then(  response => {
              var response = response.data;
              if (response.status) {
                var loginres = response.user;
                this.$store.commit('set_loginType', loginres.type);
                this.$store.commit('loginUser', loginres);
            
            /*       this.$router.push({path: '/profile'});*/
                
              }else{
                this.has_error = true;
                  this.error_message = response.message;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
              }
              $this.loader = false;
            });
           }else{
                this.has_error = true;
                $this.loader = false;
                  this.error_message = this.errors.items[0].msg;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
           }
          });
      },
     register() {
        // get the redirect object
        var $this = this;
        this.$validator.validate().then(valid => {
           if (valid) {
         this.error_message = "";
         this.has_error = false;
           $this.loader = true;
             axios({
              method: "POST",
              url: "/register",
              data: JSON.stringify(this.form),
              headers: { "content-type": "application/json" }
             }).then(  response => {
              var response = response.data;
              if (response.status) {
                var loginres = response.user;
                     this.$store.commit('set_loginType', loginres.type);
                this.$store.commit('loginUser', loginres);
                  $this.loader = false;
              }else{
                this.has_error = true;
                  $this.loader = false;
                  this.error_message = response.message;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
              }
            });
           }else{
                this.has_error = true;
                  $this.loader = false;
                  this.error_message = this.errors.items[0].msg;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
           }
          });
      }
	},
}
</script>