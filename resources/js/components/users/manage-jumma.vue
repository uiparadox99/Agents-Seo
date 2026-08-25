<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
     <main class="container pt-5 pb-5">


  <div class="row">

    <div class="col-md-3 mb-5">
     <VLSidebar></VLSidebar>
   </div>

   <div class="col-md-9  ">
    <div class="p-4 shadow ">

      <div class="row">
        <div class="col-md-8">
          <h2 class="text-green jr-res">{{title}}</h2>
         
          
        </div>
        <div class="col-md-4">
           <div class="text-right" v-if="current == 1">
             <router-link to="/user/add-jumma" class="btn bgc-green text-white  pl-3 pr-3  pt-1 pb-1 ">Add</router-link>
             <a href="javascript:;" @click="changeView(0)" class="btn btn-success text-white   pl-3 pr-3 pt-1 pb-1 ">Old History</a>
              </div>
              <div class="text-right" v-else>
                <a href="javascript:;" @click="changeView(1)" class="btn btn-success text-white   pl-3 pr-3 pt-1 pb-1" >Back To Current</a>
              </div>
        </div>
      </div>
    

 <alert></alert>

        <div class=" mt-4 table-responsive">
            <ContentLoader v-if="loading">
    <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
    <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
    <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
    <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
  </ContentLoader>
          <table class="table t-style b-radius text-center table-bordered datatable" v-else>
            <thead>
              <tr>
                <th class="bgc-green text-white pt-3 pb-3" width="15%">Date</th>
                <th class="bgc-green text-white pt-3 pb-3" width="5%">Start</th>
                <th class="bgc-green text-white pt-3 pb-3"  width="5%">Jamat</th>
                <th class="bgc-green text-white pt-3 pb-3"  width="5%">Capacity</th>
                <th class="bgc-green text-white pt-3 pb-3"  width="5%">Registered</th>
                <th class="bgc-green text-white"  width="5%">Checked-In</th>
                <th class="bgc-green text-white pt-3 pb-3">Actions</th>
              </tr>
            </thead>
            <tbody >
 
                <tr v-if="viewjumma !='' && viewjumma.length > 0" v-for="view in viewjumma">
              
                  <td class="" v-if="view.data !=''">
                 {{view.date | formateDate('D MMM YYYY','YYYY/MM/DD')}}
                 </td>
                  <td class=""  v-if="view.start !=''">
                   {{view.start}}
                    </td>
                  <td class="" v-if="view.jamaat !=''">
                   {{view.jamaat}}
                    </td>
                  <td class="" v-if="view.max_capacity !=''">
                   {{view.max_capacity}}
                    </td>
                  <td class="">
                     {{view.registered}}
                    </td>
                  <td class="">
                 {{view.checked_in}}
                    </td>
                  <td class=" pr-0 pl-0 pt-2 pb-2">

                    <router-link :to="'/user/check-participants/'+view.id" class="btn bgc-green btn-xs btn-sm text-white">check list</router-link>&nbsp;
                    <router-link :to="'/user/add-jumma/'+ view.id" class="btn bgc-green btn-xs btn-sm text-white">Edit</router-link>
                  
                    <div class="mt-1" v-if="check > 0">
                      <router-link :to="'/user/alert-email/'+ view.id" class="btn btn-danger  btn-xs btn-sm text-white">Alert Email</router-link>
                    </div>
              

                  </td>
                </tr>
              
                <tr v-else>
                  <td colspan="7">No Record Found</td>
                </tr>
              
            </tbody>

          </table>
        </div>

    </div>
  </div>
</div>


</main>
      <VFooter></VFooter>
    </div>
    <div v-else>
      <VGHeader></VGHeader>
  <main class="container pt-3 pb-1">
<VLSidebar></VLSidebar>
    <div class="">


          <h4 class="text-green jr-res mb-3"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> {{title}}</h4>
          <div class="clearfix"></div>

          <div class="text-center" v-if="current == 1">
           <router-link to="/user/add-jumma" class="btn bgc-green text-white btn-sm  pl-5 pr-5  pt-1 font-size-12 pb-1 ">Add</router-link>
           <a href="javascript:;" @click="changeView(0)" class="btn  bgc-green btn-sm text-white  pl-4 pr-4 font-size-12  pt-1 pb-1 ">Old History</a>
         </div>
         <div class="text-center" v-else>
          <a href="javascript:;" @click="changeView(1)" class="btn  bgc-green btn-sm text-white  pl-4 pr-4 font-size-12  pt-1 pb-1" >Back To Current</a>
        </div>
   
      
   
      
      <alert></alert>

  
        <div class="pb-2 mt-2 table-responsive">
            <ContentLoader v-if="loading">
    <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
    <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
    <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
    <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
  </ContentLoader>
          <table class="table t-style b-radius text-center table-bordered datatable"  v-else >
            <thead>
              <tr>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10  " >Date</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10 " >Start</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10  " >Jamat</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10  "  >Capacity</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10  "  >Registered</th>
                <th class="bgc-green text-white font-size-10 ">Checked-In</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-10">Actions</th>
              </tr>
            </thead>
            <tbody>
             
                <tr v-if="mainData !=''" v-for="view in viewjumma">
                   <td class="" v-if="view.data !=''">
                 {{view.date | formateDate('D MMM YYYY','YYYY/MM/DD')}}
                 </td>
                  <td class=""  v-if="view.start !=''">
                   {{view.start}}
                    </td>
                  <td class="" v-if="view.jamaat !=''">
                   {{view.jamaat}}
                    </td>
                  <td class="" v-if="view.max_capacity !=''">
                   {{view.max_capacity}}
                    </td>
                  <td class="">
                       {{view.registered}}
                    </td>
                  <td class="">
                      {{view.checked_in}}
                    </td>
                  <td class=" pr-0 pl-0">

                    <router-link :to="'/user/check-participants/'+view.id" class="btn bgc-green mt-1 btn-block btn-xs font-size-10 p-0 btn-sm text-white">check list</router-link> 
                    <router-link :to="'/user/add-jumma/'+ view.id" class="btn bgc-green mt-1 btn-block btn-xs font-size-10 p-0 btn-sm text-white">Edit</router-link>
                    <div class="mt-1" v-if="check > 0">
                      <router-link :to="'/user/alert-email/'+ view.id" class="btn btn-danger  btn-xs btn-sm font-size-10 pt-0 pb-0 text-white">Alert</router-link>
                    </div>
                 
                  </td>
                </tr>
             
                <tr v-else>
                  <td colspan="7">No Record Found</td>
                </tr>
              
            </tbody>

          </table>
        </div>

    </div>



</main>

      <VFooter></VFooter>
    </div>
  </div>
</template>

<script>
export default {
	data(){
		return{
      mainData: '',
      viewjumma:'',
         loading: true,
      participant:'',
      check:'',
      title:'Juma Times',
         current:1,
      id:this.$store.getters.getMosque.id,
      history:this.$route.params.history,
		}
	},
	beforeMount(){
    this.getData();
	},

	methods:{
			getData(){
       
      var dataUrl = 'v1/mosque-juma/'+this.id;
      console.log(dataUrl)
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.mainData = result.data.data;
        this.viewjumma = this.mainData.jummalist
           this.loading = false;
				
			}, error => {

			});           
		},
    changeView(val){
      this.current = val;
      this.loading = true;
      if (val == 0) {
        var dataUrl = 'v1/mosque-juma/'+this.$store.getters.getMosque.id+'?history=1';
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
           this.mainData = result.data.data;
        this.viewjumma = this.mainData.jummalist
          this.loading = false;
        }, error => {

        });
      }else{
        var dataUrl = 'v1/mosque-juma/'+this.$store.getters.getMosque.id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
           this.mainData = result.data.data;
        this.viewjumma = this.mainData.jummalist
          this.loading = false;
        }, error => {

        });
      }
    }
	},


}
</script>