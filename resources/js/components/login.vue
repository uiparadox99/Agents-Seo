<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
      <main class=" pt-5 pb-5 main-mt bg-img">
        <div class="container">
         
          <form class="s12" id="registerrequire" method="post" @submit.prevent="login()">
            <div class="row ">
              <div class="col-md-7 hide-on-mobile">
                <h1 class="text-green well-res">
                  WELCOME TO <br />
                  MOSQUE FINDER
                </h1>
              </div>
              <div class="col-md-5">
                <div class="box-bgc w-100 b-color p-3 w-100">
                  <h2 class="text-center text-green">SIGN IN</h2>
                  <p class="text-center box-text-color font-size-15">
                    Don't have an account? Create your account. It takes less
                    then a minute.
                  </p>
                  <alert></alert>
        <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&#10006;</span>
              </button>
              <span v-html="error_message"></span>
            </div>
                  <div class="form-group">
                    <label class="mb-2 box-text-color">Email</label>
                    <input
                      type="text"
                      v-model="form.email"
                      name="email"
                      id="email"
                      data-vv-as="email"
                      v-validate="'required|email'"
                      placeholder=" Enter your Email"
                      :class="[{ 'error': submitted && errors.has('email') }, 'w-100 p-2 in-color'] "
                    />
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Password</label>
                    <input
                      type="password"
                      name="password"
                      id="password"
                      v-model="form.password"
                      data-vv-as="password"
                      v-validate="'required'"
                      placeholder=" Enter your Password"
                      class="w-100 p-2 in-color"/>
                  </div>
                  <input type="hidden" value="Login" name="login" />
                  <div class="row">
                    <div class="col-6">
                      <button
                        type="submit"
                        class="btn bgc-green text-light mt-2 pt-2 pb-2 pl-5 pr-5 b-radius btn-su" >
                        Sign In
                      </button>
                    </div>
                    <div class="col-6 text-right pt-3">
                      <router-link
                        to="/forgot-password"
                        style="color: #39579a;font-size: 19px;"
                        >Forgot Password?</router-link
                      >
                    </div>
                  </div>

                  <div class="text-right mt-4">
                    <div class="">
                      <router-link to="/register" class="text-dark "
                        >Create Your Account :
                        <span class="text-green">Sign Up</span></router-link>
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
      <main class=" pt-5 pb-5  main-mt bg-img">
        <div class="container">
          <form
            class="s12"
            @submit.prevent="login()"
            id="loginrequire"
            method="post"
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
                  <h2 class="text-center text-green">SIGN IN</h2>
                  <p class="text-center box-text-color font-size-15">
                    Don't have an account? Create your account. It takes less
                    then a minute.
                  </p>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Email</label>
                    <input
                      type="text"
                      name="username"
                      data-ng-model="name1"
                      id=""
                      placeholder=" Enter your Email"
                      class="w-100 p-2 in-color"/>
                  </div>

                  <div class="form-group">
                    <label class="mb-2 box-text-color">Password</label>
                    <input
                      type="password"
                      name="password"
                      id=""
                      placeholder=" Enter your Password"
                      class="w-100 p-2 in-color"/>
                  </div>
                  <input type="hidden" value="Login" name="login" />
                  <div class="row">
                    <div class="col-6">
                      <button
                        type="submit"
                        class="btn bgc-green text-white btn-block mt-2 p-2 b-radius btn-sm">
                        Sign In
                      </button>
                    </div>
                    <div class="col-6 text-right pt-3">
                      <router-link
                        to="/forgot-password"
                        class="font-size-15">
                        </router-link>
                    </div>
                  </div>

                  <div class="text-right mt-2">
                    <div class="">
                      <router-link to="/register" class="text-dark "
                        >Create Your Account :
                        <span class="text-success">Sign Up</span></router-link>
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
        form :{
          email: null,
          password: null,
        },  
        error_message: "",
        verfiedMsg: "",
        verifyError: "",
        has_error: false
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        // get the redirect object
        var $this = this;
        this.$validator.validate().then(valid => {
           if (valid) {
         this.error_message = "";
         this.has_error = false;
             axios({
              method: "POST",
              url: "/v1/login",
              data: JSON.stringify(this.form),
              headers: { "content-type": "application/json" }
             }).then(  response => {
              var response = response.data;
              if (response.status) {
                var loginres = response.data;
                this.$store.commit('set_loginType', loginres.owner);
                this.$store.commit('loginUser', loginres.user);
                if (loginres.owner == 1) {
                  this.$store.commit('loginMosque', loginres.mosque_data);
                  this.$router.push({path: '/user/detail'});
                }else{
                  if (this.$store.getters.isSubscribe) {
                     this.$parent.subscribe(this.$store.getters.proccessID,this.$store.getters.proccessUrl);
                  }
                   if (this.$store.getters.isCourse) {
                     this.$parent.applyCourse(this.$store.getters.proccessID,this.$store.getters.proccessUrl);
                   }
                   if (this.$store.getters.isClaim) {
                     this.$router.push({path: '/'+this.$store.getters.getRedirectURL});
                   }
                   if (this.$store.getters.isRegisterJuma) {
                     this.$router.push({path:this.$store.getters.proccessUrl});
                     return true;
                   }
                   this.$router.push({path: '/profile'});
                }
              }else{
                this.has_error = true;
                  this.error_message = response.message;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
              }
            });
           }else{
                this.has_error = true;
                  this.error_message = this.errors.items[0].msg;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
           }
          });
      }
    }
  }
</script>