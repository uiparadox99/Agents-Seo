<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
   <main class="container mt-3 mb-4">

	<!-- 1st ROW 	 -->

		<form action="" method="post" id="changpassword" enctype="multipart/form-data " data-toggle="validator" role="form" @submit.prevent="submit()">
  
                    <div class="modal-header" style="display: block">
                      

                        <h4 class="modal-title btn-block" id="addManagementLabel">Change Password For 
                           

                          <router-link to="/user/detail" v-if="this.$store.getters.isOwner" class="btn btn-success float-right"><i class="fa fa-arrow-left"></i> Back</router-link>
                     
                          <router-link to="/profile" v-else class="btn btn-success float-right"><i class="fa fa-arrow-left"></i> Back</router-link>
                      
                      </h4>
                 
                        
                    </div>
                    <div class="modal-body">
                      <alert></alert>
                     <div class="form-group row">
                              <label for="currentpassword" class="col-sm-5 form-control-label">Current Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"  parsley-type="text" :class="[{ 'error': submitted && errors.has('current password') }, 'form-control']"  data-vv-as="current password"
                                    v-validate="'required'"
                                    v-model="form.old_password"
                                     name="currentpassword" placeholder="Current Password">
                                 <label v-if="submitted && errors.has('current password')" class="error">{{ errors.first('current password') }}</label>
                            </div>
                        </div>
                         <div class="form-group row">
                              <label for="passowrd" class="col-sm-5 form-control-label">New Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"   data-minlength="6" :class="[{ 'error': submitted && errors.has('new password') }, 'form-control']"  data-vv-as="new password"
                                    v-validate="'required'"
                                    v-model="form.new_password" id="password" name="password" placeholder="Password" >
                                <label v-if="submitted && errors.has('new password')" class="error">{{ errors.first('new password') }}</label>
                            </div>
                        </div>                     
                         <div class="form-group row">
                              <label for="confirmpassword" class="col-sm-5 form-control-label">Confirm Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"  :class="[{ 'error': submitted && errors.has('confirm password') }, 'form-control']"  data-vv-as="confirm password"
                                    v-validate="'required'"
                                    v-model="form.confirm_password" id="confirmpassword"  name="confirmpassword" placeholder="Confirm Password">
                               <label v-if="submitted && errors.has('confirm password')" class="error">{{ errors.first('confirm password') }}</label>
                            </div>
                        </div>
                 <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&#10006;</span>
                        </button>
                        <span v-html="error_message"></span>
                    </div>
                        <button type="submit" name="changepassword" class="btn btn-success waves-effect waves-light">change</button>
                    </div>
                </form>
	</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
 <main class="container mt-0 mb-4">

  <!-- 1st ROW   -->

    <form action="" method="post" id="changpassword" enctype="multipart/form-data " data-toggle="validator" role="form" @submit.prevent="submit()">
  
                    <div class="modal-header" style="display: block">
                      

                       <h4 class=" btn-block text-center text-success" >Change Password </h4> 
                      <div class="clearfix"></div>

                     <h5 class="modal-title btn-block mb-0" id="addManagementLabel">  Ilham Ali

                
                         <router-link to="/user/detail" v-if="this.$store.getters.isOwner" class="btn btn-success btn-sm float-right"><i class="fa fa-arrow-left"></i> Back</router-link>
                     
                          <router-link to="/profile" v-else class="btn btn-success btn-sm float-right"><i class="fa fa-arrow-left"></i> Back</router-link>
                      
                  </h5>
                 
                        
                    </div>
                    <div class="modal-body">
                       <alert></alert>
                     <div class="form-group row">
                              <label for="currentpassword" class="col-sm-5 form-control-label">Current Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"  parsley-type="text" :class="[{ 'error': submitted && errors.has('current password') }, 'form-control']"  data-vv-as="current password"
                                    v-validate="'required'"
                                    v-model="form.old_password"
                                     name="currentpassword" placeholder="Current Password">
                                 <label v-if="submitted && errors.has('current password')" class="error">{{ errors.first('current password') }}</label>
                            </div>
                        </div>
                         <div class="form-group row">
                              <label for="passowrd" class="col-sm-5 form-control-label">New Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"   data-minlength="6" :class="[{ 'error': submitted && errors.has('new password') }, 'form-control']"  data-vv-as="new password"
                                    v-validate="'required'"
                                    v-model="form.new_password" id="password" name="password" placeholder="Password" >
                                <label v-if="submitted && errors.has('new password')" class="error">{{ errors.first('new password') }}</label>
                            </div>
                        </div>                     
                         <div class="form-group row">
                              <label for="confirmpassword" class="col-sm-5 form-control-label">Confirm Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="password"  :class="[{ 'error': submitted && errors.has('confirm password') }, 'form-control']"  data-vv-as="confirm password"
                                    v-validate="'required'"
                                    v-model="form.confirm_password" id="confirmpassword"  name="confirmpassword" placeholder="Confirm Password">
                               <label v-if="submitted && errors.has('confirm password')" class="error">{{ errors.first('confirm password') }}</label>
                            </div>
                        </div>
                 <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&#10006;</span>
                        </button>
                        <span v-html="error_message"></span>
                    </div>
                        <button type="submit" name="changepassword" class="btn btn-success waves-effect waves-light">change</button>
                    </div>
                </form>
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
            has_error: false,
            submitted: false,
            form:{
                user_id :this.$store.getters.getUser.id,
                old_password:'',
                new_password:'',
                confirm_password:''
            }
        }
    },
    beforeMount(){
    },
    methods: {
        submit(){
            var $this = this;
            this.submitted = true;
            this.$validator.validate().then(valid => {
                if (valid) {
                  if (this.form.new_password == this.form.confirm_password) {

                  
                    this.error_message = "";
                    this.has_error = false;
                    let formData = new FormData();
                    for (var key of Object.keys(this.form)) {
                        formData.append(key, this.form[key]);
                    }
                    
                    axios({
                        method: "POST",
                        url: "/v1/change-password",
                        data: formData,
                        headers: { "content-type": "application/json" }
                    }).then(  response => {
                        var response = response.data;
                        if (response.status) {          
                            this.$parent.success_message = 'Password Updated Successfully'; 
                            if (this.$store.getters.isOwner) {

                            this.$router.push({path: '/user/detail'});
                            }else{

                            this.$router.push({path: '/profile'});
                            }           
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
                    this.error_message = 'New password & confirm password not matched';
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
        }
    }
}
</script>