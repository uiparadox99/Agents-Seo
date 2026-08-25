<template>
	<div class="app-container">
        <div class="app-content-container">
            
            <!--steps-header-->
            <VHeader step="6"></VHeader>
            <!--steps-header-->
             
            <!--main-content-container-->
            <div class="main-content-container">
            	<form enctype="multipart/form-data" @submit.prevent="saveForm">
            		<h3>User Details</h3>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" v-model="form.email" @input="form.email = $event.target.value.toLowerCase()"  class="form-control">
                  </div>
                  
                  <div class="form-group">
                      <label>Date of Birth</label>
                      <input type="date" name="dob" v-model="form.dob" class="form-control">
                  </div>
                  
                  <h3>Bank Account Details</h3>
                  
                  <div class="form-group">
                      <label>First Name</label>
                      <input type="text" name="first_name" v-model="form.first_name" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" name="last_name" v-model="form.last_name" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Account Holder Name</label>
                      <input type="text" name="account_holder_name" v-model="form.account_holder_name" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="address" v-model="form.address" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Postal Code</label>
                      <input type="text" name="postal_code" v-model="form.postal_code" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Bank Name</label>
                      <input type="text" name="bank_name" v-model="form.bank_name" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Account Number</label>
                      <input type="text" name="account_number" v-model="form.account_number" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Routing Number</label>
                      <input type="text" name="routing_number" v-model="form.routing_number" class="form-control">
                      <small>Not required if you providing IBAN number</small>
                  </div>
                  <div class="form-group">
                      <label>Passport Front Image</label>
                      <input type="file" name="image" ref="file" @change="onFileChange()">
                      <img :src="image" v-show="image" alt="" width="250">
                  </div>
                  <div class="form-group">
                      <input type="submit" class="bg-pink fl-wd-btn b-radius sl-lo" name="submit" value="Create Account">
                      <p class="invalid-feedback text-center m-t-10" v-show="error_message">{{ error_message }}</p>
                  </div>
              </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                form: {
                	type: "bank",
                	first_name: '',
                	last_name: '',
                	address: '',
                	postal_code: '',
                	account_number: '',
                	routing_number: '',
                  account_holder_name:'',
                	bank_name:'',
                	image: '',
                	email: this.$store.state.user.email,
                	dob: this.$store.state.user.dob,
                },
                image: '',
                error_message: null
            }
        },
        beforeMount(){
        	this.getDetails();
        },
        methods: {
        	saveForm: function(){
        		let formData = new FormData();
        		formData.append('image', this.form.image);
        		formData.append('first_name', this.form.first_name);
        		formData.append('last_name', this.form.last_name);
        		formData.append('email', this.form.email);
            formData.append('dob', this.form.dob);
            formData.append('city', this.$store.state.user.city?this.$store.state.user.city.name:'');
        		formData.append('state', this.$store.state.user.country?this.$store.state.user.country.name:'');
        		formData.append('address', this.form.address);
        		formData.append('postal_code', this.form.postal_code);
        		formData.append('account_number', this.form.account_number);
            formData.append('routing_number', this.form.routing_number);
        		formData.append('account_holder_name', this.form.account_holder_name);
        		formData.append('bank_name', this.form.bank_name);

        		axios({ method: "POST", "url":'/create-account', "data": formData, "headers": { "content-type": "multipart/form-data" } }).then(result => {
                        var data = result.data;
                        if(data.status){
                          this.$router.push({path: '/my-profile'})
                        }else{
                            this.error_message = data.message;
                        }
                    }, error => {
                });

        	},
        	onFileChange() {
  		      this.form.image = this.$refs.file.files[0];
  		    },
          getDetails(){
          	var profileURL = "/profile";
              axios({ method: "GET", "url": profileURL, "headers": { "content-type": "application/json" } }).then(result => {
                      if(!result.data.status){
                          this.$router.push({path:'/login'});
                      }
                      this.$store.commit('update_profie', result.data.data);
                      this.loading = true;
                  }, error => {
                      this.$router.push({path:'/login'});
              }); 

              axios({ method: "GET", "url":'/payment-integration', "headers": { "content-type": "application/json" } }).then(result => {
              		var data = result.data.data;
              		this.form.first_name = data.first_name;
              		this.form.last_name = data.last_name;
              		this.form.postal_code = data.postal_code;
              		this.form.bank_name = data.bank_name;
              		this.form.account_number = data.account_number;
              		this.form.routing_number = data.routing_number;
              		this.form.account_holder_name = data.account_holder_name;
              		this.form.address = data.address;
              		this.image = data.image;
                  }, error => {
              });
          },
        }
    };
</script>