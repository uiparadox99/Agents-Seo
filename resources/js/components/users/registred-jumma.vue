<template>
  <div>

      <VGHeader></VGHeader>
          <ContentLoader v-if="loading">
        <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
        <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
        <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
        <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
        <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
      </ContentLoader>
      <div class="container" v-else>
        <alert></alert>
        <h5 class="text-left mt-4 mb-2 text-success" >Registred Jumma <router-link to="/profile" class="btn btn-success btn-sm float-right">Back</router-link></h5>
        <div class="text-center mb-2">

            <a href="javascript:;" @click="changeview(1)" v-if="!history" class="btn btn-warning btn-sm text-white ">History</a>

            <a href="javascript:;" @click="changeview(0)" v-else class="btn btn-warning btn-sm text-white ">Current</a>  
        </div>

        <div v-if="detail.participate_jummas != '' && detail.participate_jummas != null && detail.participate_jummas.length > 0" >

           <div v-if="!history">


            <div v-for="r in detail.participate_jummas" v-if="r.juma_time != null && checkDateGreater(r.juma_time.date)">


                <div class="modal fade" :id="'exampleModal'+r.id" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="padding: 0rem 1rem; border-bottom:none">

                            <button type="button" class="close" data-dismiss="modal" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                          <barcode :value="r.qr_code" displayValue="false" height="50" width="1.5"></barcode>

                      </div>

                  </div>
              </div>
          </div>
          <table class="table table-bordered p-2" style="border:3px solid #D1D1D1">

            <tbody style="font-size:15px">
                <tr>
                    <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Date</th>
                    <td>
                     {{r.juma_time.date |eventDateFormat}}
                 </td>

             </tr>
             <tr>
                <th style="width:50%;background: #f4f4f4; border-right:2px #D1D1D1" >Start/Adhaan Time
                </th>
                <td>
                   {{r.juma_time.start}}
               </td>

           </tr>
           <tr>
            <th style="width: 38%;background: #f4f4f4;border-right:2px #D1D1D1">Jammat Time</th>
            <td>
             {{r.juma_time.jamaat}}
         </td>

     </tr>

     <tr>
        <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Barcode</th>
        <td><button data-toggle="modal" :data-target="'#exampleModal'+r.id"
            class="btn btn-success btn-sm btn-block text-white b-radius"
            style="border-radius: 102px;">view barcode</button></td>

        </tr>
        <tr>
            <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Mosque Name</th>
            <td>
             {{r.juma_time.mosque.name}}
         </td>

     </tr>
     <tr>
        <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Action</th>
        <td>
            <button @click="deleteRegisterd(r.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
        </td>
    </tr>

</tbody>

</table>
</div>
</div>
<div v-else>


    <div v-for="r in detail.participate_jummas" v-if="r.juma_time != null && !checkDateGreater(r.juma_time.date)">


        <div class="modal fade" :id="'exampleModal'+r.id" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0rem 1rem; border-bottom:none">

                    <button type="button" class="close" data-dismiss="modal" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                  <barcode :value="r.qr_code" displayValue="false" height="50" width="1.5"></barcode>

              </div>

          </div>
      </div>
  </div>
  <table class="table table-bordered p-2" style="border:3px solid #D1D1D1">

    <tbody style="font-size:15px">
        <tr>
            <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Date</th>
            <td>
             {{r.juma_time.date |eventDateFormat}}
         </td>

     </tr>
     <tr>
        <th style="width:50%;background: #f4f4f4; border-right:2px #D1D1D1" >Start/Adhaan Time
        </th>
        <td>
           {{r.juma_time.start}}
       </td>

   </tr>
   <tr>
    <th style="width: 38%;background: #f4f4f4;border-right:2px #D1D1D1">Jammat Time</th>
    <td>
     {{r.juma_time.jamaat}}
 </td>

</tr>

<tr>
    <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Barcode</th>
    <td><button data-toggle="modal" :data-target="'#exampleModal'+r.id"
        class="btn btn-success btn-sm btn-block text-white b-radius"
        style="border-radius: 102px;">view barcode</button></td>

    </tr>
    <tr>
        <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Mosque Name</th>
        <td>
         {{r.juma_time.mosque.name}}
     </td>

 </tr>
 <tr>
    <th style="width: 38%;background: #f4f4f4; border-right:2px #D1D1D1">Action</th>
    <td>
        <button @click="deleteRegisterd(r.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
    </td>
</tr>

</tbody>

</table>
</div>
</div>




</div>
<p class="text-center  p-2" v-else style="font-size:12px">Jumma Not Registred Yet!</p>
<div class="clearfix"></div>
</div>

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
            history:0,
            detail: {},
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
            }, error => {

            });           
        },
        datesComparision(mDate,sDate){
            mDate = new Date(mDate);
            sDate = new Date(sDate);
            if (mDate > sDate) {
                return true;
            }
            return false;
        },
        changeview(check){
            this.history = check;
        },
        unsubscribe(id){
            if (confirm('Are You Sure?')) {
                this.loading = true;
                var dataUrl = 'v1/unsubscribe?id='+id;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                    if (result.status) {
                        this.$parent.success_message = 'Unsubscribed Successfully';
                        this.getData();
                    }else{
                        this.$parent.error_message = '';
                        setTimeout(function() {
                            $this.error_message = "";
                            $this.has_error = false;
                        }, 5000);
                    }
                }, error => {

                }); 
            }
        },
        deleteRegisterd(id){
            if (confirm('Are You Sure?')) {
                this.loading = true;
                var dataUrl = 'v1/delete-participated-jumma/'+id;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                    if (result.status) {
                        this.$parent.success_message = 'Juma Registration Deleted Successfully';
                        this.getData();
                    }else{
                        this.$parent.error_message = '';
                        setTimeout(function() {
                            $this.error_message = "";
                            $this.has_error = false;
                        }, 5000);
                    }
                }, error => {

                }); 
            }
        },
        deleteBookmark(id){
            if (confirm('Are You Sure?')) {
                this.loading = true;
                var dataUrl = 'v1/delete-bookmark/'+id;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                    if (result.status) {
                        this.$parent.success_message = 'Bookmark Deleted Successfully';
                        this.getData();
                    }else{
                        this.$parent.error_message = '';
                        setTimeout(function() {
                            $this.error_message = "";
                            $this.has_error = false;
                        }, 5000);
                    }
                }, error => {

                }); 
            }
        },
        updateTime(id,slug){


            var dataUrl = 'v1/update-subscribe-prayer/'+id;
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                if (result.status) {
                    $('#bell'+id).remove();
                    this.$router.push('/'+slug+'.html');
                }else{
                    this.$parent.error_message = '';
                    setTimeout(function() {
                        $this.error_message = "";
                        $this.has_error = false;
                    }, 5000);
                }
            }, error => {

            }); 
            
        },
        checkDateGreater(date){
            date = new Date(date);
            var today = new Date();
            if(date > today){
                return true;
            }
            return false;
        }
    }
}
</script>