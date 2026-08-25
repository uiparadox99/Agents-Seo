<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>

      <main
        class=" pt-5 pb-5 mt-0 mb-0 main-mt bg-img"
        style="position: unset;padding: 80px 0!important;"
      >
        <div class="container">
          <form class="row" id="loginrequire" action="" method="post" @submit.prevent="forgot()">
            <div class="box-bgc w-100 b-color p-4 col-md-6  offset-md-3 ">
              <h2 class="text-center text-green">FORGET PASSWORD</h2>
              <alert></alert>
              <div class="form-group mb-4">
                <label class="text-left btn-block" style="text-align: left;">
                  Email Address</label
                >
                <input
                  type="email"
                  name="email"
                   :class="[{ 'error': submitted && errors.has('email') }, 'w-100 p-2 in-color']"
                         v-model="form.email"
                         v-validate="'required'"
                         data-vv-as="email"
                  placeholder="Email Address"
                />
                 <label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
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
                <div class="col-8">
                  <input
                    type="submit"
                    value="Sent Mail"
                    name="forgetpass"
                    class="btn btn-success text-uppercase btn-lg"
                  />
                </div>
                <div class="col-4 text-right">
                  <router-link
                    to="/login"
                    class="hyperlink pt-2 btn-block text-right text-uppercase"
                    >Back To Login</router-link>
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
      <main
        class=" pt-5 pb-5 mt-0 mb-0 main-mt bg-img"
        style="position: unset;padding: 80px 0!important;"
      >
        <div class="container">
          <form class="row" id="loginrequire" action="" method="post" @submit.prevent="forgot()">
            <div class="box-bgc w-100 b-color p-4 col-md-6  offset-md-3 ">
              <h2 class="text-center text-green">FORGET PASSWORD</h2>

              <alert></alert>
              <div class="form-group mb-4">
                <label class="text-left btn-block" style="text-align: left;">
                  Email Address</label
                >
                <input
                  type="email"
                  name="email"
                   :class="[{ 'error': submitted && errors.has('email') }, 'w-100 p-2 in-color']"
                         v-model="form.email"
                         v-validate="'required'"
                         data-vv-as="email"
                  placeholder="Email Address"
                />
                 <label v-if="submitted && errors.has('email')" class="error">{{ errors.first('email') }}</label>
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
                <div class="col-8">
                  <input
                    type="submit"
                    value="Sent Mail"
                    name="forgetpass"
                    class="btn btn-success text-uppercase btn-lg"
                  />
                </div>
                <div class="col-4 text-right">
                <router-link
                    to="/login"
                    class="hyperlink pt-2 btn-block text-right text-uppercase"
                    >Back To Login</router-link>
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
        email: null
      },
      error_message: "",
      success_message: ""
    };
  },
  beforeMount() {
      if (this.$store.getters.isLoggedIn) {
          if (this.$store.getters.isOwner) {
           this.$router.push({path: '/user/detail'});
         }else{
           this.$router.push({path: '/profile'});
         }

       }
  },
  methods: {
    forgot() {
      var $this = this;
      this.submitted = true;
      this.$validator.validate().then(valid => {
        if (valid) {
          axios({
            method: "POST",
            url: "v1/forget-password",
            data: JSON.stringify(this.form),
            headers: { "content-type": "application/json" }
          }).then(
            response => {
              var $this = this;
              if (response.data.status) {
                this.success_message = "Reset link emailed!";
                this.form.email = "";
                setTimeout(function() {
                  $this.error_message = "";
                  $this.errors.clear();
                }, 100);
              } else {
                this.error_message =
                  "Whoopsy. We don’t have that email.";
              }
              setTimeout(function() {
                this.success_message = "";
                $this.error_message = "";
              }, 2500);
            },
            error => {
              console.log("ERROR" + error);
            }
          );
        } else {
          this.error_message = this.errors.items[0].msg;
        }

        setTimeout(function() {
          this.success_message = "";
          $this.error_message = "";
        }, 2500);
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
