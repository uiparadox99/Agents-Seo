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
          <div class="p-4 shadow mb-3">
           <div class="row">
            <div class="col-md-6">
              <h2 class="text-green jr-res">Search User</h2>
            </div>
          </div>
          <form action="" method="get"  @submit.prevent="submit()">
            <div class="row">
              <div class="col-md-4 form-group">
                <label>Name</label>
                <input type="text" name="name" v-model="form.name" class="form-control" placeholder="User Name">
              </div>
              <div class="col-md-4 form-group">
                <label>Email</label>
                <input type="text" name="email" v-model="form.email"  class="form-control" placeholder="User Email">
              </div>
              <div class="col-md-4 form-group">
                <label>Phone</label>
                <input type="text" name="phone" v-model="form.phone"  class="form-control" placeholder="User Phone">
              </div>
              <div class="col-md-4">
                <label>Start Date</label>
                <Datepicker name="start_date"  format="dd-MM-yyyy" v-model="form.start_date" input-class="datefield" id="start_date"  :class="[{ 'error': submitted && errors.has('start_date') },'  start_date']"  placeholder="Select Date" ></Datepicker>
                <span v-show="errors.has('start_date')" class="text-danger">{{ errors.first('start_date') }}</span>
              </div>
              <div class="col-md-4">
                <label>End Date</label>
                <Datepicker name="end_date" id="end_date"  format="dd-MM-yyyy" v-model="form.end_date" input-class="datefield" :class="[{ 'error': submitted && errors.has('end_date') },'  end_date']" placeholder="Select Date" ></Datepicker>
                <span v-show="errors.has('end_date')" class="text-danger">{{ errors.first('end_date') }}</span>
              </div>
              <div class="col-md-4">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success btn-block">Search</button>
              </div>
            </div>
          </form>
        </div>
        <ContentLoader v-if="loading">
          <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
          <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
          <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
          <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
          <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
          <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
        </ContentLoader>
        <div class="p-4 shadow " v-else>

          <div class="row">
            <div class="col-md-6">
              <h2 class="text-green jr-res">User Logs</h2>
            </div>

          </div>



          <table class="table table-bordered table-striped" v-if="logs != '' && logs.length > 0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="log in logs">
                <td>{{log.first_name}} {{log.last_name}}</td>
                <td>{{log.email}}</td>
                <td>{{log.phone}}</td>
                <td>{{log.date | eventDateFormat}}</td>
                <td>{{log.check_in_time.replace(log.date,'')}}</td>
              </tr>
            </tbody>
          </table>
        
      <div class="col-md-12" v-else>

        <h4 class="text-center text-success">No Record Found</h4>
      </div>
   

      
    </div>
  </div>
</div>
</main>
<VFooter></VFooter>
</div>
<div v-if="$isMobile()">
  <VGHeader></VGHeader>
  <main class="container pt-3 pb-3">

   <VLSidebar></VLSidebar>



   <h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button>Search User</h4>
   
   <form action="" method="get">
    <div class="row">
      <div class="col-md-4 form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="User Name">
      </div>
      <div class="col-md-4 form-group">
        <label>Email</label>
        <input type="text" name="email" value="<?php echo $email ?>" class="form-control" placeholder="User Email">
      </div>
      <div class="col-md-4 form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo $phone ?>" class="form-control" placeholder="User Phone">
      </div>
      <div class="col-6">
        <label>Start Date</label>
        <input type="text" name="start_date" value="<?php echo $start_date ?>" id="start_date" class="form-control" placeholder="Date" autocomplete="off">
      </div>
      <div class="col-6">
        <label>End Date</label>
        <input type="text" name="end_date" value="<?php echo $end_date ?>" id="end_date" class="form-control" placeholder="Date" autocomplete="off">
      </div>
      <div class="col-md-4">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-success btn-block">Search</button>
      </div>
    </div>
  </form>


  <h4 class="text-green text-center mt-2">User Logs</h4>



<!-- 
      <?php  if ($stmtpn->rowCount()) { ?>
       
              
         
         <?php  while($r = $stmtpn->fetchObject()){ ?>
             <table class="table table-bordered table-striped">
           
            
           
            <tr>
               <th>Name</th>
              <td><?php echo $r->name ?></td>
            </tr>
            <tr>
               <th>Email</th>
              <td><?php echo $r->email ?></td>
                </tr>
            <tr>
               <th>Phone</th>
              <td><?php echo $r->phone ?></td>
                </tr>
            <tr>
                <th>Date</th>
              <td><?php echo  date('d M Y',strtotime($r->date)) ?></td>
                </tr>
            <tr>
                <th>Time</th>
              <td><?php echo date('H:i',strtotime($r->check_in_time)) ?></td>
            </tr>
          </table>
         <?php } ?>
           
         <?php 

    if ($totalres){ 
      if ($endpage > 1){
        ?>
        <div class="mt-4 ">
          <nav aria-label="Page navigation example">
            <ul class="pagination ">
              <?php if($curpage != $startpage){ ?>
                <li class="page-item mr-4">
                  <a href="<?php echo add_edit_gets('page', $previouspage); ?>" class="side-link" aria-label="Next"><i class="fa fa-angle-left arrow"></i>
                  </a>
                </li>


              <?php } ?>
              <?php if($curpage != $startpage && $curpage == $endpage){ ?>
                <li class="page-item mr-2">
                  <a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $startpage); ?>">
                    <?php echo $startpage ?>
                  </a>
                </li>
                <li class="page-item mr-2">
                  ....
                </li>
              <?php } ?>
              <?php if($curpage >= 2){

                if($curpage >= 3){
                  ?>

                  <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $previouspage-1); ?>"><?php echo $previouspage-1 ?></a>
                  </li>
                  <?php
                }
                ?>
                <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $previouspage); ?>"><?php echo $previouspage ?></a>
                </li>
              <?php } ?>  
              <li class="page-item mr-2 active"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $curpage); ?>"><?php echo $curpage ?></a></li>

              <?php if($curpage != $endpage){ ?>
                <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $nextpage); ?>"><?php echo $nextpage ?></a></li>
                <?php if($curpage > 3 && $nextpage+1 <= $endpage){
                  ?>
                  <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $nextpage+1); ?>"><?php echo $nextpage+1 ?></a>
                  </li>
                  <?php
                }else{

                  if($nextpage+1 <= $endpage){

                    for($i=$nextpage+1;$i<=$endpage && $i <= $nextpage+2;$i++){
                      ?>
                      <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $i); ?>"><?php echo $i ?></a>
                      </li>
                      <?php
                    }
                  }
                }
                if($nextpage+2 < $endpage){
                  ?>
                  <li class="page-item mr-2"><a class="page-link rounded-circle">....</a>
                  </li>
                  <li class="page-item mr-2"><a class="page-link rounded-circle" href="<?php echo add_edit_gets('page', $endpage); ?>"><?php echo $endpage ?></a>
                  </li>
                  <?php
                }
                ?>
                <li class="page-item">
                  <a href="<?php echo add_edit_gets('page', $nextpage); ?>" aria-label="Next" class="side-link">  <i class="fa fa-angle-right arrow">

                  </i>
                </a>
              </li>
                 
                <?php } ?>
              </ul>
            </nav>
          </div>
          <?php 
        }
      }
      ?>

      <?php  }else{ ?> -->
      <div class="col-md-12">

        <h4 class="text-center text-success">No Record Found</h4>
      </div>
      <!-- <?php } ?> -->

    </main>
    <VFooter></VFooter>
  </div>
</div>
</template>
<script>
import Datepicker from 'vuejs-datepicker'
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
      logs: {},
      disabledDates: {
        to: new Date()
      },
      disabledendDates: {
        to: new Date()
      },
      form:{
        name:'',
        email:'',
        phone:'',
        start_date:'',
        end_date:'',
      }
    }

  },
  components: {
    Datepicker
  },
  beforeMount(){
    this.mosque_id = this.$store.getters.getMosque.id;
    this.getData();

  },

          
  methods: {
   serialize(obj) {
    var str = [];
    for (var p in obj)
      if (obj.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      }
      return str.join("&");
    },
    getData(){
      var query = this.serialize(this.form);
        
      var dataUrl = 'v1/mosque-user-logs/'+this.$store.getters.getMosque.slug+'?'+query;
      axios({ method: "GET", "url":dataUrl,"headers": { "content-type": "application/json" } }).then(result => {
        this.logs = result.data.data;
        this.loading = false;
      }, error => {

      });           
    },
    submit(){
      this.loading = true;
      this.getData();
    }
  }
}
</script>