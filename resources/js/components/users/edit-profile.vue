<template>
    <div>
        <VGHeader></VGHeader>
        <main class="container mt-5 mb-4">
            <alert></alert>
            <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
            </ContentLoader>
            <form action=""  method="post"  enctype="multipart/form-data"  id="updateform"  @submit.prevent="submit()" v-else>
                <div class="shadow">
                    <h2 class="text-center green-heading mbl-edit-profile">
                        Edit Your Profile
                    </h2>
                    <div class="modal-body  p-3">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="upload-image-preview" style="">

                                 <img :src="$parent.BASE_API_PATH+'/uploads/'+detail.image" v-if="detail.image != '' && detail.image != null"  alt="" class="img-circle mb-2 ">

                                 <img
                                 src="/assets/New/images/Ellipse 5.png"
                                 alt=""
                                 class="img-circle mb-2 " v-else/>

                             </div>

                             <input type="file"   ref="file" name="img"  v-on:change="handleFileUploads()"  class="form-control pt-1 pb-2 pl-1 font-size-15"  placeholder="Image">
                         </div>
                         <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>First Name</label>
                                    <input
                                    type="text"
                                    name="first_name"
                                    id="name"
                                    :class="[{ 'error': submitted && errors.has('first_name') }, 'form-control']"
                                    data-vv-as="first_name"
                                    v-validate="'required'"
                                    v-model="form.first_name"
                                    placeholder="First Name"
                                    />
                                        <label v-if="submitted && errors.has('first_name')" class="error">{{ errors.first('first_name') }}</label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Last Name</label>
                                    <input
                                    type="text"
                                    name="last_name"
                                    id="last_name"
                                    :class="[{ 'error': submitted && errors.has('last_name') }, 'form-control']"
                                    data-vv-as="last_name"
                                    v-validate="'required'"
                                    v-model="form.last_name"
                                    placeholder="First Name"
                                    />
                                        <label v-if="submitted && errors.has('last_name')" class="error">{{ errors.first('last_name') }}</label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Email</label>
                                    <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    readonly
                                    v-model="email"
                                    class="form-control"
                                    autocomplete="off"
                                    value=""
                                    placeholder="Email Address"
                                    />
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Phone</label>
                                    <input
                                    type="text"
                                    name="phone"
                                    maxlength="11"
                                    minlength="11"
                                    v-model="form.phone"
                                    :class="[{ 'error': submitted && errors.has('phone') }, 'form-control']"
                                    data-vv-as="phone"
                                    v-validate="'required'"
                                    placeholder="Phone"
                                    />
                                        <label v-if="submitted && errors.has('phone')" class="error">{{ errors.first('phone') }}</label>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label>Address</label>
                                    <input
                                    type="text"
                                    name="address"
                                    maxlength="70"
                                    :class="[{ 'error': submitted && errors.has('address') }, 'form-control']"
                                    data-vv-as="address"
                                    v-validate="'required'"
                                    v-model="form.address"
                                    value=""
                                    placeholder="Address"
                                    />
                                        <label v-if="submitted && errors.has('address')" class="error">{{ errors.first('address') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="has_error">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&#10006;</span>
                        </button>
                        <span v-html="error_message"></span>
                    </div>
                    <div class="text-center">
                        <button
                        type="submit"
                        name="update"
                        class="btn btn-success text-uppercase  btn-lg"
                        style="padding: 10px 100px;"
                        >
                        Update
                    </button>


                </div>

            </div>
        </div>
    </form>
</main>
<VFooter></VFooter>
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
            email: '',
            history:0,
            detail: {},
            form:{
                user_id :'',
                image:null,
                first_name:'',
                last_name:'',
                phone:'',
                address:'',
                other_info:''
            }
        }
    },
    beforeMount(){
        this.getData();
    },
    methods: {

        getData(){

            var dataUrl = 'v1/user-profile/'+this.$store.getters.getUser.id;
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                this.detail = result.data.data;
                this.loading = false;
                this.form.user_id  = this.detail.id;
                this.form.first_name = this.detail.first_name;
                this.form.last_name = this.detail.last_name;
                this.form.phone = this.detail.phone;
                this.form.address = this.detail.address;
                this.email = this.detail.email;
            }, error => {

            });           
        },
        handleFileUploads(){
            this.form.image =  this.$refs.file.files[0];
            if (this.$refs.file.files && this.$refs.file.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = $('<img>').attr('src', e.target.result);
                    $('.upload-image-preview').html(img);
                };

                reader.readAsDataURL(this.$refs.file.files[0]);
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
                        url: "/v1/edit-profile",
                        data: formData,
                        headers: { "content-type": "application/json" }
                    }).then(  response => {
                        var response = response.data;
                        if (response.status) {          
                            this.$parent.success_message = 'Profile Updated Successfully';             
                            this.$router.push({path: '/profile'});
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