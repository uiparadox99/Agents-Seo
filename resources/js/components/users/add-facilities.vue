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
       <div class="clearfix"></div>
       <div class="">
          <div class="hom-cre-acc-left hom-cre-acc-right">

           <div class="">

            <form class="add-facilities" method="POST" action="" id="updateform"  @submit.prevent="submit()">
<input type="hidden" name="mosque_id" v-model="mosque_id">
              <h4 class="text-success">Update Facilities</h4>
              <hr>
              <alert></alert>
              <label>Capacity </label>
              <div class="row">

                <div class=" form-group col-sm-6">

                 <input class="form-control" id="capacity"  v-on:keypress="$parent.isNumber($event)" maxlength="4" name="capacity" type="text" v-model="capacity"  placeholder="Capacity">
               </div>
               
                  <div class=" form-group col-sm-6" v-for="f in facilities">
                   <input type="checkbox"   :data-id="f.id" class="filled-in " :checked="checkExist(f.id)" name="facilities[]" :value="f.id" :id="'scff'+f.id" />
                   <label :for="'scff'+f.id" >{{f.name}}</label>
                 </div>
         

             </div>
             <div class="text-center">
               
             <button class=" form-group btn btn-success text-uppercase btn-lg pl-5 pr-5" type="submit" name="save">Update Mosque</button>
             </div>

           </form>
         </div>
       </div>
    
   </div>
 </div>
</div>
</div>
</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
     <main class="container pt-2 pb-2">

 
       <VLSidebar></VLSidebar>
 
      <div class="">
       <div class="clearfix"></div>
       <div class="">
       

    
          <div class="hom-cre-acc-left hom-cre-acc-right">

           <div class="">

            <form class="add-facilities" method="POST" action="" id="updateform" @submit.prevent="submit()">
<input type="hidden" name="mosque_id" v-model="mosque_id">

              <h5 class="text-center text-success"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button>Update Facilities</h5>
               <alert></alert>
             
              <div class="row mt-3">
                <div class="col-3 mt-1">
                   <label style="font-size:20px"><b>Capacity </b></label>
                </div>

                <div class=" form-group col-4">

               <input class="form-control" id="capacity"  v-on:keypress="$parent.isNumber($event)" maxlength="4" name="capacity" type="text" v-model="capacity"  placeholder="Capacity">
               </div>
               <div class=" form-group col-sm-6" v-for="f in facilities">
                   <input type="checkbox"   :data-id="f.id" class="filled-in " :checked="checkExist(f.id)" name="facilities[]" :value="f.id" :id="'scff'+f.id" />
                   <label :for="'scff'+f.id" >{{f.name}}</label>
                 </div>

             </div>
<div class="text-center">
  
             <button class=" form-group btn btn-success btn-md text-uppercase " type="submit" name="save">Update Mosque</button>
</div>

           </form>
         </div>
       </div>

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
      facilities: {},
      addedfacilities: {},
      error_message: "",
      has_error: false,
      submitted: false,
       mosque_id:this.$store.getters.getMosque.id,
      capacity:'',
    }

  },
  beforeMount(){
    this.getData();
  },
  methods: {
    getData(){
    
      var dataUrl = 'v1/dropdown-data';
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        var data = result.data.data.facilities;
        this.facilities = data;
      }, error => {

      });     

     
      var dataUrl = 'v1/mosque-facility/'+this.$store.getters.getMosque.id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.addedfacilities = result.data.data;
      }, error => {

      });      

        var dataUrl = 'v1/mosque-detail/'+this.$store.getters.getMosque.slug;
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
              var data = result.data.data.detail;
              this.capacity = data.capacity;
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
    checkExist(id){
      var $this = this;
       for (var key of Object.keys($this.addedfacilities)) {
        if ($this.addedfacilities[key].facilties_id == id) {
          return true;
        }

       }
       return false;
    },
    submit(){
      var $this = this;
      this.submitted = true;
      this.$validator.validate().then(valid => {
        if (valid) {
          this.error_message = "";
          this.has_error = false;
          var formData= $('#updateform').serialize();
          axios({
            method: "POST",
            url: "/v1/update-facility",
            data: formData,
          }).then(  response => {
            var response = response.data;
            if (response.status) {      
              this.$parent.success_message = 'Facilities Updated Successfully';       
              this.$router.push({path: '/user/manage-facilities'});
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
