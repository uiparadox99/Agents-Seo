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
            <h4 class="text-green">Add / Edit Account</h4>
            <alert></alert>
            <div class="mt-3">

              <form action="" method="POST" id="updateform" @submit.prevent="submit()">


                <div class=" row">

                  <input type="hidden" name="id" id="id" v-mode="form.id" />


                  <div class="form-group col-sm-8">
                    <label>Account Head</label>
                    <input type="text" maxlength="15" v-model="form.account_head" name="account_head"  :class="[{ 'error': submitted && errors.has('account_head') }, 'form-control']" data-vv-as="account_head" v-validate="'required'"  style="border: 1px solid #ddd" placeholder="Account Head">
                    <label v-if="submitted && errors.has('account_head')" class="error">{{ errors.first('account_head') }}</label>
                  </div>  
                  <div class="form-group col-sm-4">
                    <label>Bank Account Number</label>
                    <input type="text" maxlength="8" v-model="form.account" name="account"  :class="[{ 'error': submitted && errors.has('account') }, 'form-control']" data-vv-as="account" v-validate="'required'" v-on:keypress="$parent.isNumber($event)" style="border: 1px solid #ddd" placeholder="Bank Account">
                    <label v-if="submitted && errors.has('account')" class="error">{{ errors.first('account') }}</label>
                  </div>  

                  <div class="form-group col-sm-8">
                    <label>Bank Name</label>
                    <select :class="[{ 'error': submitted && errors.has('bank') }, 'form-control']" data-vv-as="bank" v-validate="'required'" v-model="form.bank" name="bank">
                      <option value="">Select</option>
                      <option v-for="b in banks" :value="b.id"  >
                        {{b.name}}
                      </option>

                    </select>
                    <label v-if="submitted && errors.has('bank')" class="error">{{ errors.first('bank') }}</label>

                  </div>  
                  <div class="form-group col-sm-4">
                    <label>Sort Code</label>
                    <input type="text" v-model="form.head" v-mask="'##-##-##'" name="head"  :class="[{ 'error': submitted && errors.has('head') }, 'form-control']" data-vv-as="head" v-validate="'required'" style="border: 1px solid #ddd" placeholder="code">
                    <label v-if="submitted && errors.has('head')" class="error">{{ errors.first('head') }}</label>
                  </div>
                  <div class="form-group col-sm-8">
                    <label>Paypal Account (Id or Email)</label>
                    <input type="text" v-model="form.paypal" name="paypal" class="form-control"  style="border: 1px solid #ddd" placeholder="paypal">
                  </div>

                  <div class="form-group col-sm-4">
                    <label>&nbsp;</label>
                    <label class="btn-block">
                      <input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
                      <input type="checkbox" name="active" v-else @click="check($event)" class="">
                    Active?</label>
                  </div>
                </div>
                <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&#10006;</span>
                  </button>
                  <span v-html="error_message"></span>
                </div>
                <div class=" text-center">
                  <button type="submit" name="save" class="btn btn-success btn-lg pl-5 pr-5">Save</button>

                </div>
              </form>
            </div>      
          </div>
        </div>
      </div>
    </main>
    <VFooter></VFooter>
  </div>
  <div v-else>
    <VGHeader></VGHeader>
    <main class="container pt-3 pb-3">


      <VLSidebar></VLSidebar>

      <div class="">
        <h5 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button>Add / Edit Account</h5>
        <alert></alert>
        <div class="mt-3">

          <form action="" method="POST" id="updateform" @submit.prevent="submit()">

            <div class=" row">

                   <input type="hidden" name="id" id="id" v-mode="form.id" />


              <div class="form-group mb-2 col-6 pr-2">
                <label class="text-success" style="font-size: 16px;">Account Head</label>
              <input type="text" maxlength="15" v-model="form.account_head" name="account_head"  :class="[{ 'error': submitted && errors.has('account_head') }, 'form-control']" data-vv-as="account_head" v-validate="'required'"  style="border: 1px solid #ddd" placeholder="Account Head">
              <label v-if="submitted && errors.has('account_head')" class="error">{{ errors.first('account_head') }}</label>
              </div>  
              <div class="form-group mb-2 col-6 pl-2">
                <label class="text-success" style="font-size: 15px;">Bank Account Number</label>
                 <input type="text" maxlength="8" v-model="form.account" name="account"  :class="[{ 'error': submitted && errors.has('account') }, 'form-control']" data-vv-as="account" v-validate="'required'" v-on:keypress="$parent.isNumber($event)" style="border: 1px solid #ddd" placeholder="Bank Account">
                 <label v-if="submitted && errors.has('account')" class="error">{{ errors.first('account') }}</label>
              </div>  
              <div class="form-group mb-2 col-6  pr-2">
                <label class="text-success" style="font-size: 16px;">Sort Code</label>
                <input type="text" v-model="form.head" v-mask="'##-##-##'" name="head"  :class="[{ 'error': submitted && errors.has('head') }, 'form-control']" data-vv-as="head" v-validate="'required'" style="border: 1px solid #ddd" placeholder="code">
                <label v-if="submitted && errors.has('head')" class="error">{{ errors.first('head') }}</label>
              </div>  
              <div class="form-group mb-2 col-6 pl-2">
                <label class="text-success" style="font-size: 16px;">Bank Name</label>
              <select :class="[{ 'error': submitted && errors.has('bank') }, 'form-control']" data-vv-as="bank" v-validate="'required'" v-model="form.bank" name="bank">
                      <option value="">Select</option>
                      <option v-for="b in banks" :value="b.id"  >
                        {{b.name}}
                      </option>

                    </select>
                    <label v-if="submitted && errors.has('bank')" class="error">{{ errors.first('bank') }}</label>

              </div>  

              <div class="form-group col-12">
                <label  class="text-success" style="font-size: 16px;">Paypal Account (Id or Email)</label>
                <input type="text" v-model="form.paypal" name="paypal" class="form-control"  style="border: 1px solid #ddd" placeholder="paypal">
              </div>
              <div class="form-group col-12">
               <label class="btn-block">
                      <input type="checkbox" name="active" v-if="form.active == 1" @click="check($event)" checked="" class="">
                      <input type="checkbox" name="active" v-else @click="check($event)" class="">
                    Active?</label>
              </div>
            </div>
            <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&#10006;</span>
              </button>
              <span v-html="error_message"></span>
            </div>
            <div class=" text-center">
              <button type="submit" name="save" class="btn btn-success btn-block">Save</button>

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
      banks: {},
      error_message: "",
      addedImg:"",
      has_error: false,
      submitted: false,
      form:{
        id:'',
        account_head:'',
        account:'',
        users_id:this.$store.getters.getUser.id,
        head:'',
        bank:'',
        paypal:'',
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
        var dataUrl = 'v1/mosque-bank-account-detail/'+this.$route.params.id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          var data = result.data.data
          this.detail = data;
          this.form.id = data.id;
          this.form.account_head = data.account_head;
          this.form.account = data.account;
          this.form.head = data.head;
          this.form.bank = data.bank_id;
          this.form.active = data.active;
          this.form.paypal = data.paypal;

        }, error => {

        });
      }
      var dataUrl = 'v1/dropdown-data';
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        var data = result.data.data.banks;
        this.banks = data;
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
          let formData = new FormData();
          for (var key of Object.keys(this.form)) {
            formData.append(key, this.form[key]);
          }

          axios({
            method: "POST",
            url: "/v1/save-mosque-bank-account",
            data: formData,
            headers: { "content-type": "application/json" }
          }).then(  response => {
            var response = response.data;
            if (response.status) {      
              this.$parent.success_message = 'Account Added Successfully';        
              this.$router.push({path: '/user/bank-detail'});
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