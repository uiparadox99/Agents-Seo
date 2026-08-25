<template>
    <div class="">
        <!--sign-in-header-->
        <VGHeader></VGHeader>
        <main class=" pt-5 pb-5 mt-3 mb-3 main-mt bg-img">

            <div class="container">
                <form class="row" action="" method="post" @submit.prevent="reset()">
                    <div class="box-bgc w-100 b-color p-4 col-md-6  offset-md-3 ">
                        <h2 class="text-center text-green">SET PASSWORD</h2>
                        <alert></alert>

                        <div class="form-group">
                            <label>Password</label>
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
                        
                        <div class="form-group">
                            <label>Confirm Password</label>
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
                        <div class="alert alert-danger alert-dismissible fade in" role="alert" v-show="error_message != ''">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&#10006;</span>
                          </button>
                          <span v-html="error_message"></span>
                      </div>
                      <div class="alert alert-success alert-dismissible fade in" role="alert" v-show="success_message != ''">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&#10006;</span>
                      </button>
                      <span v-html="success_message"></span>
                  </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="submit" value="Reset" name="resetpassword" class="btn  btn-success btn-lg"> 
                            </div>
                            <div class="col-md-8 pt-2">
                                <label>&nbsp;</label>
                                <router-link to="/forgot-password" class="hyperlink" >Forgot Password?</router-link> &nbsp;&nbsp;  
                                <router-link to="/register" class="hyperlink">Create Your Account</router-link>
                            </div>
                        </div>

                        


                    </div>
                </form>

            </div>

        </main>
        <VFooter></VFooter>
        <!--faq and help-->

    </div>
</template>

<script>
export default {
    data(){
        return {
            submitted: false,
            form: {
                password: null,
                confirm_password: null,
                token: null
            },
            error_message: "",
            success_message: ""
        }
    },
    beforeMount(){
        if (typeof this.$route.query.token == 'undefined' || this.$route.query.token == '') {
            this.$router.push({name:'/'});
        }else{
            this.form.token = this.$route.query.token;
        }
        if (this.$store.getters.isLoggedIn) {
          if (this.$store.getters.isOwner) {
             this.$router.push({path: '/user/detail'});
         }else{
             this.$router.push({path: '/profile'});
         }

     }
 },
 methods: {
    reset(){
        var $this = this;
        this.submitted = true;
        this.$validator.validate().then(valid => {
            if (valid) {
                axios({ method: "POST", "url": "v1/reset-password","data" : JSON.stringify(this.form), "headers": { "content-type": "application/json" } }).then(response => {
                    var $this = this;
                    this.form.password = "";
                    this.form.password_confirmation = "";
                    if (response.data.status) {
                        this.success_message = "Password has been reset";
                        this.form.email = "";
                        var pushRouter  = this.$router;
                        setTimeout(function() {
                            this.success_message = "";
                            
                             this.$router.push({path: '/login'});
                        }, 3000);


                    }else{
                        this.error_message = response.data.message;
                    }
                }, error => {
                    console.log("ERROR"+ error);
                });
            }else{
                this.error_message = this.errors.items[0].msg;
            }
            setTimeout(function() {
                $this.error_message = "";
            }, 2500)
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
}
</script>
