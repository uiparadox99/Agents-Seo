<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
       <main class="container pt-5 pb-5">


  <div class="row">
    <!--LEFT SECTION-->
    <div class="col-md-3">
      <VLSidebar></VLSidebar>
    </div>
    <!--CENTER SECTION-->
    <div class="col-md-9">

              <alert></alert>
              <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>

      <div class="shadow p-4" v-else>
        <h4 class="text-green">Ramadan  
          <router-link v-if="ramadan.length < 1" class="btn bgc-green text-white  pl-5 pr-5  pt-1 pb-1 b-radius float-right" to="/user/add-ramadan-schedule">Add Schedule</router-link>
               <div class="clearfix"></div></h4>
        
        <div class="table-responsive">

          <table class="table table-striped table-bordered">
            <thead>
              <tr class="bgc-green text-white">
               <th>Start Date</th>                
               <th>End Date</th>          
                <th>Action</th>             
             </tr>

           </thead>
           <tbody>

              <tr v-if="ramadan.length > 0" v-for="r in ramadan">
                <td>{{r.start_date | eventDateFormat}}</td>
                <td>{{r.end_date | eventDateFormat}}</td>

                <td><router-link :to="'/user/add-ramadan-schedule/'+r.id" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></router-link></td>
              </tr>
            <tr v-else>
              <td colspan="3" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>
            </tr>
        </tbody>

      </table>






    </div>
  </div>
</div>

<!-- GET QUOTES Popup END -->

<!--RIGHT SECTION-->

</div>
</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
    <main class="container pt-3 pb-3">
 <VLSidebar></VLSidebar>

 
      <!-- <?php include"includes/left-sidebar.php" ?> -->

        <h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button> <span style="margin-left: -20px;">Ramadan</span>  </h4>
        <!-- <?php if($stmtpn->rowCount() < 1){ ?> -->
        <div class="text-center">
          <router-link class="btn bgc-green text-white  mb-2  pt-1 pb-1 b-radius " to="/user/add-ramadan-schedule">Add Schedule</router-link><div class="clearfix"></div>
        </div>
      <!-- <?php } ?>
        <?php include"../portal/includes/display-alert.php" ?> -->
        <div class="table-responsive">

          <table class="table table-striped table-bordered">
            <thead>
              <tr class="bgc-green text-white">
               <th>Start Date</th>                
               <th>End Date</th>                
               <th>Action</th>                
             </tr>

           </thead>
           <tbody>
            <!-- <?php  if ($stmtpn->rowCount()) { ?>
             <?php  while($r = $stmtpn->fetchObject()){ ?>
              <tr>
                <td><?php echo $r->start_date; ?></td>
                <td><?php echo $r->end_date; ?></td>
                   <td><a href="<?php echo BASE_PATH ?>user/add-ramadan-schedule?id=<?php echo $r->id ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a></td>
              </tr>
            <?php } ?>
          <?php }else{ ?> -->
            <tr>
              <td colspan="3" style="text-align: center;font-size: 22px;font-weight: bold">No Data Found</td>
            </tr>
          <!-- <?php } ?> -->
        </tbody>

      </table>

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
      loading: true,
      message: "",
      current:1,
      error_message: "",
      has_message: false,
      error_message: false,
      mosque_id:'',
      ramadan: {},
    }

  },
  beforeMount(){
    this.mosque_id = this.$store.getters.getMosque.id;
    this.getData();

  },
  methods: {
    getData(){
      var dataUrl = 'v1/mosque-ramadan/'+this.$store.getters.getMosque.id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.ramadan = result.data.data;
        this.loading = false;
      }, error => {

      });           
    }
  }
}
</script>