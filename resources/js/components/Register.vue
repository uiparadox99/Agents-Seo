<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
      <main class=" pt-5 pb-5 main-mt bg-img">
        <div class="container">
          <form class="s12" id="registerrequire" method="post" action=""  @submit.prevent="register()">
            <div class="row ">
              <div class="col-md-7 hide-on-mobile">
                <h1 class="text-green well-res">
                  WELCOME TO <br />
                  MOSQUE FINDER
                </h1>
              </div>

              <div class="col-md-5">
                <div class="box-bgc w-100 b-color p-3 w-100">
                  <h2 class="text-center text-green">SIGN UP</h2>
                  <p class="text-center box-text-color font-size-15">
                    Don't have an account? Create your account . It's take less
                    then a minutes
                  </p>

                  <div class="row name">
                    <div class="col-md-6 form-group ">
                      <label class="mb-2 box-text-color">First Name</label>
                      <input
                        type="text"
                        name="first_name"
                        id=""
                        placeholder="Enter first name"
                        :class="[{ 'error': submitted && errors.has('first_name') }, 'w-100 p-2 in-color']"
                         v-model="form.first_name"
                         v-validate="'required'"
                         data-vv-as="first_name"
                      />
                       <label v-if="submitted && errors.has('first_name')" class="error">first name required</label>
                    </div>

                    <div class="col-md-6 form-group">
                      <label class="mb-2 box-text-color">Last Name</label>
                      <input
                        type="text"
                        name="last_name"
                        id=""
                        placeholder="Enter last name"
                        :class="[{ 'error': submitted && errors.has('last_name') }, 'w-100 p-2 in-color']"
                         v-model="form.last_name"
                         v-validate="'required'"
                         data-vv-as="last_name"
                      />
                       <label v-if="submitted && errors.has('last_name')" class="error">last name required</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Email</label>
                    <input
                      type="email"
                      name="email"
                      id=""
                      placeholder=" Enter your Email"
                      :class="[{ 'error': submitted && errors.has('email') }, 'w-100 p-2 in-color']"
                         v-model="form.email"
                         v-validate="'required'"
                         data-vv-as="email"
                      />
                       <label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Password</label>
                    <input
                      type="password"
                      name="password"
                      id=""
                      placeholder=" Enter your Password"
                      :class="[{ 'error': submitted && errors.has('password') }, 'w-100 p-2 in-color']"
                         v-model="form.password"
                         v-validate="'required'"
                         data-vv-as="password"
                      />
                       <label v-if="submitted && errors.has('password')" class="error">{{ errors.first('password') }}</label>
                  </div>
                  <input type="hidden" value="Register" name="register" />
                  <div class="form-group">
                    <label class="mb-2 box-text-color">Confirm Password</label>
                    <input
                      type="password"
                      name="confirm_password"
                      id=""
                      placeholder=" Enter Confirm password"
                                  :class="[{ 'error': submitted && errors.has('confirm_password') }, 'w-100 p-2 in-color']"
                         v-model="form.confirm_password"
                         v-validate="'required'"
                         data-vv-as="confirm_password"
                      />
                       <label v-if="submitted && errors.has('confirm_password')" class="error">confirm password is required</label>
                  </div>
                  <vue-recaptcha ref="recaptcha"
                  @verify="onVerify" sitekey="6LeNsNcZAAAAANDHAsosMFCU8XgayVp_2dRP_7V9">
                </vue-recaptcha>
                <div class="alert alert-danger alert-dismissible fade in" role="alert" v-show="error_message != ''">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&#10006;</span>
                  </button>
                  <span v-html="error_message"></span>
                </div>

                  <button
                    type="submit"
                    class="btn bgc-green text-white b-radius pr-3 pl-3 pl-5 pr-5"
                  >
                    Sign Up
                  </button>

                  <div class="text-right ">

                    <div class="mt-4">
                      Are you a already member ?
                      <router-link to="/login" class="text-success "
                        >Sign In</router-link
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
      <main class=" pt-5 pb-5 main-mt bg-img">
        <div class="container">
          <form
            class="s12"
            id="registerrequire"
            method="post"
            action="" @submit.prevent="register()"
          >
            <div class="row ">
              <div class="col-md-7 hide-on-mobile">
                <h1 class="text-green well-res">
                  WELCOME TO <br />
                  MOSQUE FINDER
                </h1>
              </div>

              <div class="col-md-5">
                <div class="box-bgc w-100 b-color p-3 w-100">
                  <h2 class="text-center text-green">SIGN UP</h2>
                  <p class="text-center box-text-color font-size-15">
                    Don't have an account? Create your account . It's take less
                    then a minutes
                  </p>

                <div class="row name">
                    <div class="col-md-6 form-group ">
                      <label class="mb-2 box-text-color">First Name</label>
                      <input
                        type="text"
                        name="first_name"
                        id=""
                        placeholder="Enter first name"
                        :class="[{ 'error': submitted && errors.has('first_name') }, 'w-100 p-2 in-color']"
                         v-model="form.first_name"
                         v-validate="'required'"
                         data-vv-as="first_name"
                      />
                       <label v-if="submitted && errors.has('first_name')" class="error">first name required</label>
                    </div>

                    <div class="col-md-6 form-group">
                      <label class="mb-2 box-text-color">Last Name</label>
                      <input
                        type="text"
                        name="last_name"
                        id=""
                        placeholder="Enter last name"
                        :class="[{ 'error': submitted && errors.has('last_name') }, 'w-100 p-2 in-color']"
                         v-model="form.last_name"
                         v-validate="'required'"
                         data-vv-as="last_name"
                      />
                       <label v-if="submitted && errors.has('last_name')" class="error">last name required</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Email</label>
                    <input
                      type="email"
                      name="email"
                      id=""
                      placeholder=" Enter your Email"
                      :class="[{ 'error': submitted && errors.has('email') }, 'w-100 p-2 in-color']"
                         v-model="form.email"
                         v-validate="'required'"
                         data-vv-as="email"
                      />
                       <label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Password</label>
                    <input
                      type="password"
                      name="password"
                      id=""
                      placeholder=" Enter your Password"
                      :class="[{ 'error': submitted && errors.has('password') }, 'w-100 p-2 in-color']"
                         v-model="form.password"
                         v-validate="'required'"
                         data-vv-as="password"
                      />
                       <label v-if="submitted && errors.has('password')" class="error">{{ errors.first('password') }}</label>
                  </div>
                  <input type="hidden" value="Register" name="register" />
                  <div class="form-group">
                    <label class="mb-2 box-text-color">Confirm Password</label>
                    <input
                      type="password"
                      name="confirm_password"
                      id=""
                      placeholder=" Enter Confirm password"
                                  :class="[{ 'error': submitted && errors.has('confirm_password') }, 'w-100 p-2 in-color']"
                         v-model="form.confirm_password"
                         v-validate="'required'"
                         data-vv-as="confirm_password"
                      />
                       <label v-if="submitted && errors.has('confirm_password')" class="error">confirm password is required</label>
                  </div>
                  <vue-recaptcha ref="recaptcha"
                  @verify="onVerify" sitekey="6LeNsNcZAAAAANDHAsosMFCU8XgayVp_2dRP_7V9">
                </vue-recaptcha>
                <div class="alert alert-danger alert-dismissible fade in" role="alert" v-show="error_message != ''">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&#10006;</span>
                  </button>
                  <span v-html="error_message"></span>
                </div>
                  <button
                    type="submit"
                    class="btn bgc-green text-white b-radius pr-3 pl-3 pl-5 pr-5"
                  >
                    Sign Up
                  </button>

                  <div class="text-right ">

                    <div class="mt-4">
                      Are you a already member ? 
                         <router-link to="/login" class="text-success "
                        >Sign In</router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>

      <VFooter></VFooter>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      submitted: false,
      form: {
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        confirm_password: null,
      },
      error_message: "",
      has_error: false,
    };
  },
  beforeMount() {
    /*this.form.type = this.$route.meta.type;
        if (this.$route.fullPath === 'register') {
            this.form.type = 'buyer';
        }*/

        if (this.$store.getters.isLoggedIn) {
          if (this.$store.getters.isOwner) {
           this.$router.push({path: '/user/detail'});
         }else{
           this.$router.push({path: '/profile'});
         }

       }
  },
  mounted() {
    /*if (this.$route.fullPath === 'register') {
            this.form.type = 'buyer';
        }*/
  },
  methods: {
    register() {
      var $this = this;
      this.submitted = true;
      this.$validator.validate().then(valid => {
        if (valid) {
          axios({
            method: "POST",
            url: "v1/register",
            data: JSON.stringify(this.form),
            headers: { "content-type": "application/json" }
          }).then(
            response => {
              var response = response.data;
              if (response.status) {
                this.$parent.success_message = 'Registerd Successfully!. We have send sent verification email please check your inbox';       
              this.$router.push({path: '/login'});
              } else {
                this.submitted = false;
                this.error_message = response.message;
                setTimeout(function() {
                  $this.error_message = "";
                }, 2500);
              }
            },
            error => {
              console.log("ERROR" + error);
            }
          );
        } else {
          this.error_message = this.errors.items[0].msg;
          setTimeout(function() {
            $this.error_message = "";
            $this.submitted = false;
          }, 2500);
        }
      });
    }
  },

  beforeRouteUpdate(to, from, next) {
    if (this.$store.getters.isLoggedIn) {
          if (this.$store.getters.isOwner) {
           this.$router.push({path: '/user/detail'});
         }else{
           this.$router.push({path: '/profile'});
         }
         
       
    } else {
      next();
    }
  }
};
</script>
