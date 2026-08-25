<template>
    <div>
        <div class="modal" id="fillDataModel" style="z-index: 15509999999999;">
            <div class="modal-dialog">
                <div class="modal-content">
  
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">FIll Data</h4>
                        <button type="button" class="close" onclick="$('#fillDataModel').hide()" data-dismiss="modal">&times;</button>
                    </div>
  
                    <!-- Modal body -->
                    <div class="modal-body align-items-center">
                        <div class="row ">
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" v-model="fillData.business" placeholder="Enter Your Business Name">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" v-model="fillData.tagline" placeholder="Enter Your Tagline Here">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text"  @input="handleNumericInput" maxlength="13" class="form-control" v-model="fillData.phone" placeholder="Enter Your Phone Number">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" maxlength="30" class="form-control" v-model="fillData.person" placeholder="Enter Your Name">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="email" class="form-control" v-model="fillData.email" placeholder="Enter Your Email Address">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" maxlength="30" class="form-control" v-model="fillData.designation" placeholder="Enter Your Designation">
                            </div>
                           
                            <div class="col-md-6 mb-2">
                                <input type="text" max="30" class="form-control"  v-model="fillData.website" placeholder="Enter Your Website">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" maxlength="100" class="form-control" v-model="fillData.address" placeholder="Enter Your Address">
                            </div>
                        </div>
                    <div class="text-center mt-2">
                        <button type="button" @click="addData" class="btn btn-primary">Fill it</button>
                    </div>
                    </div>
  
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="text-danger btn-none" onclick="$('#fillDataModel').hide()" data-dismiss="modal">Close</button>
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
            mainData: '',
            fillData:{
                business:'',
                person:'',
                designation:'',
                phone:'',
                tagline:'',
                email:'',
                address:'',
                website:'',
            },
          }
      },
          
      beforeMount(){
        this.fillData = this.$parent.fillData;
      },
  
      methods:{
        handleNumericInput() {
      // Remove non-numeric characters from the input
      this.fillData.phone = this.fillData.phone.replace(/[^0-9]/g, '');
    },
          clickOnFile(){
              $("#yourfile").click();
          },
          addData(){
              this.$parent.fillData =  this.fillData;
              this.$parent.loadScreens('no');
              $('#fillDataModel').hide();
              $('.modal-backdrop').remove();
          }
      },
  }
  </script>