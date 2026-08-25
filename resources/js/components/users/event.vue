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
            <h3 class="text-green">Events  
              <div class="float-right" v-if="current == 1">
                <a href="javascript:;" @click="changeView(0)" class="btn btn-success text-white  pl-5 pr-5  pt-1 pb-1 b-radius " >History</a>
                <router-link to="/user/add-event/" class="btn bgc-green text-white  pl-5 pr-5  pt-1 pb-1 b-radius "  >Add New Event</router-link>
              </div>
              <div class="float-right" v-else>
                <a href="javascript:;" @click="changeView(1)" class="btn btn-success text-white  pl-5 pr-5  pt-1 pb-1 b-radius " >Back To Current</a>
              </div>
            </h3>
            <div class="clearfix"></div>

            <div class=" mt-3">

              <alert></alert>
              <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>


              <div v-else>
                <div class="clearfix"></div>

                <div class="row" v-if="events != '' && events.length > 0">

                 <div class="col-sm-6 " v-for="event in events">
                   <div class="card event-box mb-3">
                    <h5 class="bgc-green p-2 mb-0 text-center text-white event-name">{{event.name}}</h5>
                    <div class="card-image postion-relative">

                      <img :src="$parent.BASE_API_PATH+'/uploads/'+event.img"  v-if="event.img != ''">

                      <img :src="'../public/New/images/Rectangle 92.png'"  v-else>  
                      <router-link :to="'/user/edit-event/'+event.id" class="bgc-green text-white rounded-circle" ><i class="fas fa-edit"></i></router-link>

                    </div>
                    <div class="card-content p-3 pt-4">

                      <p class="text-center">{{event.start_date | eventDateFormat}}
                      At {{event.time}} </p>


                      <p class="text-center" style="word-wrap: break-word;">
                        {{event.address}}
                      </p>

                      <!-- <p class="text-justify bgc-grey p-2" style="word-wrap: break-word;background :#f0f0f0">{{event.description}}</p> -->
                    </div>
                  </div>
                </div>
              </div>


              <h4 style="text-align: center;" class="text-success" v-else> No Event Added</h4>
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

   <h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> <span style="margin-left: -30px"> Events</span>  

   </h4>
   <div class="text-center" v-if="current == 1">
    <a href="javascript:;" @click="changeView(0)" class="btn btn-sm btn-success text-white  pl-5 pr-5  pt-1 pb-1 b-radius " >History</a>
    <div class="clearfix"></div>
    <router-link to="/user/add-event/" class="btn btn-sm bgc-green text-white  pl-5 pr-5 mt-1 mb-1  pt-1 pb-1 b-radius "  >Add New Event</router-link>
  </div>
  <div class="text-center" v-else>
    <a href="javascript:;" @click="changeView(1)" class="btn btn-sm btn-success text-white  pl-5 pr-5  pt-1 pb-1 b-radius " >Back To Current</a>
  </div>

  <alert></alert>
  <ContentLoader v-if="loading">
    <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
    <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
    <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
    <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
    <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
  </ContentLoader>


  <div v-else>
    <div class="clearfix"></div>

    <div class="row" v-if="events != '' && events.length > 0">

     <div class="col-sm-6 " v-for="event in events">
       <div class="card event-box mb-3">
        <h5 class="bgc-green p-2 mb-0 text-center text-white event-name">{{event.name}}</h5>
        <div class="card-image postion-relative">

          <img :src="$parent.BASE_API_PATH+'/uploads/'+event.img"  v-if="event.img != ''">

          <img :src="'../public/New/images/Rectangle 92.png'"  v-else>  
          <router-link :to="'/user/edit-event/'+event.id" class="bgc-green text-white rounded-circle" ><i class="fas fa-edit"></i></router-link>

        </div>
        <div class="card-content p-3 pt-4">

          <p class="text-center">{{event.start_date | eventDateFormat}}
          At {{event.time}} </p>


          <p class="text-center" style="word-wrap: break-word;">
            {{event.address}}
          </p>

          <!-- <p class="text-justify bgc-grey p-2" style="word-wrap: break-word;background :#f0f0f0">{{event.description}}</p> -->
        </div>
      </div>
    </div>
  </div>


  <h4 style="text-align: center;" class="text-success" v-else> No Event Added</h4>
</div>



</main>
<VFooter></VFooter>
</div>     


<div class="modal fade dir-pop-com" id="list-quo" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header dir-pop-head">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Image Caption</h4>
        <!--<i class="fa fa-pencil dir-pop-head-icon" aria-hidden="true"></i>-->
      </div>
      <div class="modal-body dir-pop-body">
        <form method="post" action="https://letmeinusa.com/user/save-image-caption" class="form-horizontal">
          <!--LISTING INFORMATION-->
          <div class="form-group has-feedback ak-field">
            <label class="col-md-12 control-label">Caption</label>
            <div class="col-md-12">
              <textarea cols="20" rows="5" name="caption" class="form-control textarea" required=""></textarea></div>
              <input type="hidden" name="image_id" value="">
            </div>

            <div class="form-group has-feedback ak-field">
              <div class="col-md-6 col-md-offset-4">
               <input type="submit" value="Save" class="pop-btn saveCaption"> </div>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
   <div id="myModal" class="modal fade event-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="POST" enctype="multipart/form-data" id="myModal">
          <div class="modal-header">
            <h4 class="modal-title" id="addManagementLabel">Edit Event</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="event_id" value="" id="event_id">
            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Image<span class="text-danger">*</span></label>

              <div class=" tz-file-upload col-sm-7">
               <div class="file-field ">
                 <div class="tz-up-btn"> <span>File</span>
                  <input type="file" name="img" class="form-control"> </div>
                </div>
              </div>

            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Event Name<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <input type="text"  parsley-type="text"  class="form-control" id="name" name="name" placeholder="Event Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Date<span class="text-danger">*</span></label>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off" class="form-control " id="start_date" name="start_date" placeholder="Start Date">
              </div>
              <div class="col-sm-1 col-2">
                <P>To</P>
              </div>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off"  class="form-control " id="end_date" name="end_date" placeholder="End Date">
              </div>
            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Time<span class="text-danger">*</span></label>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off"  class="form-control time" id="time"  name="time" placeholder="Start Time">
              </div>
              <div class="col-sm-1 col-2">
                <P>To</P>
              </div>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off" class="form-control time" id="end_time" name="end_time" placeholder="End Time">
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-sm-4 form-control-label">Address<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <textarea type="text"  parsley-type="text"  class="form-control" id="address" name="address" placeholder="Address"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-sm-4 form-control-label">Description<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <textarea type="text"  parsley-type="text" rows="5"  class="form-control" id="description" name="description" placeholder="Description"></textarea>
              </div>
            </div>
            <div id="edittimeError"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update</button>
          </div>
        </form>
      </div><!-- /.modal-content-->
    </div><!-- /.modal-dialog -->
  </div>
  <div id="addModal" class="modal fade event-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post" id="addevent" enctype="multipart/form-data" >
          <div class="modal-header">
            <h4 class="modal-title" id="addManagementLabel">Add Event</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          </div>
          <div class="modal-body">

            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Image<span class="text-danger">*</span></label>

              <div class=" tz-file-upload col-sm-7">
                <div class="file-field ">
                 <div class="tz-up-btn"> <span>File</span>
                  <input type="file" name="img" class="form-control"> </div>

                </div>
              </div>

            </div>
            <div class="form-group row">
              <label for="name" class="col-sm-4 form-control-label">Event Name<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <input type="text"  parsley-type="text"  class="form-control" id="name" name="name" placeholder="Event Name">
              </div>
            </div>

            <div class="form-group row date">
              <label for="date" class="col-sm-4 form-control-label">Date<span class="text-danger">*</span></label>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text"  class="form-control " autocomplete="off" id="modalstart_date" name="start_date" placeholder="Start Date">
              </div>
              <div class="col-sm-1 col-2">
                <P>To</P>
              </div>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text"  class="form-control " autocomplete="off" id="modalend_date" name="end_date" placeholder="End Date">
              </div>
            </div>
            <div class="form-group row">
              <label for="time" class="col-sm-4 form-control-label">Time<span class="text-danger">*</span></label>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off" class="form-control time" id="addStart_time" name="time" placeholder="Start Time">
              </div>
              <div class="col-sm-1 col-2">
                <p>To</p>

              </div>
              <div class="col-sm-3 col-5">
                <input type="text"  parsley-type="text" autocomplete="off" class="form-control time"  id="addEnd_time" name="end_time" placeholder="End Time">
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-sm-4 form-control-label">Address<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <textarea type="text"  parsley-type="text"  class="form-control" id="address" name="address" placeholder="Address"> </textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-sm-4 form-control-label">Description<span class="text-danger">*</span></label>
              <div class="col-sm-7">
                <textarea type="text"  parsley-type="text" rows="5" class="form-control" id="description" name="description" placeholder="description"></textarea>
              </div>
            </div>
            <div id="addtimeError"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="save" class="btn btn-success waves-effect waves-light">Save</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
      events: {},
    }

  },
  beforeMount(){
    this.mosque_id = this.$store.getters.getMosque.id;
    this.getData();

  },
  methods: {
    getData(){
      var dataUrl = 'v1/mosque-events/'+this.$store.getters.getMosque.id;
      axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
        this.events = result.data.data;
        this.loading = false;
      }, error => {

      });           
    },
    changeView(val){
      this.current = val;
      this.loading = true;
      if (val == 0) {
        var dataUrl = 'v1/mosque-events/'+this.$store.getters.getMosque.id+'?history=1';
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          this.events = result.data.data;
          this.loading = false;
        }, error => {

        });
      }else{
        var dataUrl = 'v1/mosque-events/'+this.$store.getters.getMosque.id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          this.events = result.data.data;
          this.loading = false;
        }, error => {

        });
      }
    }
  }
}
</script>