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

      <div class="shadow p-4">
    
        <h4 class="text-green text-center">Add Ramadan Schedule</h4>

        <form action="" method="post" class="" id="addramadan"  @submit.prevent="submit()">
          <input type="hidden" name="id" :value="detail.id" v-if="detail != ''">
          <input type="hidden" name="mosque_id" :value="this.$store.getters.getMosque.id">
         <div class="row">
           <div class="col-md-6 offset-md-3 form-group text-center">
            <label>Select 1st Ramadan Date</label>
            <Datepicker name="start_date" @selected="dekstopAdd"  :disabled-dates="disabledDates" format="dd-MM-yyyy" v-model="form.start_date" input-class="datefield" id="start_date" v-validate="'required'" :class="[{ 'error': submitted && errors.has('start_date') },'  start_date']" data-vv-as="start date" placeholder="Select Date" ></Datepicker>
          <!--   <input type="text" name="start_date" value="<?php echo !is_null($ramdan)?date('d M Y',strtotime($ramdan->start_date)):'14 April 2021' ?>"  style="" parsley-type="text" id="start_date" class="form-control" placeholder="Start Date" required="" autocomplete="off"> -->
          </div>
          <!-- <div class="col-sm-6 form-group">
            <label>Ramadan Start Date (Islamic Date)</label>
            <input type="text" name="islamic_date" parsley-type="text" class="form-control " value="1442-04-01"  id="hijri-date-input" autocomplete="off" placeholder="Islamic Date " required="">
          </div> -->
          
        </div>
   
        <div class="border-1 p-3" style="border: 1px solid #ddd;border-radius: 5px;" >
          <div class="row">
            <div class="col-md-2">
              <h6 class="text-center text-success text-uppercase mb-0">RAMADAN</h6>
            </div>
            <div class="col-md-3">
              <h6 class="text-center text-success text-uppercase mb-0">DATE</h6>
            </div>
            <div class="col-md-3 ">
              <h6 class="text-center text-success text-uppercase mb-0">DAY</h6>
            </div>
               <div class="col-md-2 pr-0 pl-0">
              <h6 class="text-center text-success text-uppercase mb-0">SEHAR TIME</h6>
            </div>
               <div class="col-md-2 pl-0">
              <h6 class="text-center text-success text-uppercase mb-0">IFTAR TIME</h6>
            </div>
          </div>
          <hr>
          <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>
          <div id="rozaFields" class="p-2" v-else>
          
            <div class="row" v-if="roza.length > 0" v-for="(r,index) in roza" :key="index">
              <div class="col-sm-2 form-group text-center" >
               {{plusOne(index)}}
             </div>
             <div class="col-sm-3 form-group text-center" >
              <input type="hidden" name="single_islamic_date[]" value="">
              <input type="text" name="date[]" readonly=""  parsley-type="text" class="form-control date text-center" placeholder="Date" autocomplete="off"  :value="r.date | formateDate" required="">
            </div>
            <div class="col-sm-3 form-group pl-0 pr-0 text-center" >
              <input type="text" name="daycheck[]" readonly=""  parsley-type="text" class="form-control date text-center" placeholder="Date" autocomplete="off"  :value="r.date | ramzantDateFormat" required="">
            </div>
            <div class="col-sm-2 form-group text-center pr-1">
              <input type="text" name="sehar_time[]"  @KeyPress="changeSeharData(index)" @keyup="changeSeharData(index)" @blur="changeSeharData(index)"  parsley-type="text"  v-mask="$parent.timeMask" v-model="sehar[index]" :class="'form-control time sehar-'+index" placeholder=" Time" autocomplete="off" required="">
            </div>
            <div class="col-sm-2 pl-1 form-group">
              <input type="text" name="iftar_time[]" v-mask="$parent.timeMask"  @KeyPress="changeFajarData(index)" @keyup="changeFajarData(index)" @blur="changeFajarData(index)"  :class="'form-control time fajar-'+index" v-model="iftar[index]" placeholder=" Time" autocomplete="off"  required="">
            </div>
          </div>
         <div class="row" v-if="dekstopAddData.length > 0" v-for="r in dekstopAddData">
            <div class="col-2 form-group text-center" >
            {{r.count}}
            </div>
            <div class="col-3 form-group text-center" >
            <input type="hidden" name="single_islamic_date[]" value="">
            <input type="text" name="date[]" readonly=""  parsley-type="text" class="form-control date text-center" placeholder="Date" autocomplete="off"  :value="r.englishDateShow" required="">
           </div>
           <div class="col-3 form-group pl-0 pr-0 text-center" >
            <input type="text" name="daycheck[]" readonly=""  parsley-type="text" class="form-control date text-center" placeholder="Date" autocomplete="off"  :value="r.day" required="">
           </div>
           <div class="col-2 form-group text-center pr-1">
            <input type="text" name="sehar_time[]" @KeyPress="changeSeharData(r.count)" @keyup="changeSeharData(r.count)" @blur="changeSeharData(r.count)"  parsley-type="text" v-model="sehar[r.count]"  v-mask="$parent.timeMask" :class="'form-control time sehar-'+r.count" placeholder=" Time" autocomplete="off" required="" >
           </div>
           <div class="col-2 pl-1 form-group">
            <input type="text" name="iftar_time[]"  v-model="iftar[r.count]" v-mask="$parent.timeMask"  @KeyPress="changeFajarData(r.count)" @keyup="changeFajarData(r.count)" @blur="changeFajarData(r.count)" parsley-type="text" :class="'form-control time fajar-'+r.count" placeholder=" Time" autocomplete="off"  required="">
           </div>
         </div>
      </div>
    <div class="form-group text-center">
      <br>
      <button class="btn bgc-green text-white  pl-5 pr-5 btn-lg pt-1 pb-1 b-radius" type="submit" name="save">SAVE</button>
    </div>
    </div>
  </form>

       </div>
   </div>
  </div>
</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
     <main class="container pt-3 pb-3">
 

        <h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> Add Ramadan Schedule</h4>

        <form action="" method="post" class="" id="addramadan"  @submit.prevent="submit()">
          <input type="hidden" name="id" value="<?php echo !is_null($ramdan)?$ramdan->id:'' ?>">
            <label class="btn-block text-center">Select 1st Ramadan Date</label>
         <div class="row">
           <div class="col-6 offset-3 form-group text-center">
            <input type="text" name="start_date" value="<?php echo !is_null($ramdan)?date('d M Y',strtotime($ramdan->start_date)):'14 April 2021' ?>"  style="" parsley-type="text" id="start_date" class="form-control" placeholder="Start Date" required="" autocomplete="off">
          </div>
          <!-- <div class="col-sm-6 form-group">
            <label>Ramadan Start Date (Islamic Date)</label>
            <input type="text" name="islamic_date" parsley-type="text" class="form-control " value="1442-04-01"  id="hijri-date-input" autocomplete="off" placeholder="Islamic Date " required="">
          </div> -->
          
        </div>
<div style="">
        <div class="border-1 p-3" style="border: 1px solid #ddd;border-radius: 5px;  " >
          <div class="row">
            <!-- <div class="col-2">
              <h6 class="text-center text-success text-uppercase mb-0">RAMADAN</h6>
            </div> -->
          <!--   <div class="col-3">
              <h6 class="text-center text-success text-uppercase mb-0">DATE</h6>
            </div>
            <div class="col-3 ">
              <h6 class="text-center text-success text-uppercase mb-0">DAY</h6>
            </div> -->
            <div class="col-2">
              <h6 class="text-success"><b> رَمَضَان‎  </b></h6>            
            </div>
            <div class="col-4 p-0">
               <h6 class="text-center text-success text-uppercase mb-0">DATE</h6>
            
            </div>
               <div class="col-3 ">
              <h6 class="text-center text-success text-uppercase mb-0">SEHAR</h6>
            </div>
               <div class="col-3 ">
              <h6 class="text-center text-success text-uppercase mb-0">IFTAR</h6>
            </div>
          </div>
          <hr class="mt-1 mb-1 p-0">
          
          <div id="rozaFields" class="p-2">
            <!-- <?php if(!is_null($roza) && $roza->rowCount() > 0){ ?>
               <?php $count =1 ;  while ($r = $roza->fetchObject()) { ?> -->
                <div class="row">
            <div class="col-2 form-group text-center" >
              
              <!-- <?php echo $count; ?> -->
            </div>
                       <input type="hidden" name="single_islamic_date[]" value="">
           
            <div class="col-4 p-0 form-group text-center text-center">
          <input type="text" name="date[]" readonly=""  parsley-type="text" class="form-control font-size-15 date text-center" placeholder="Date" autocomplete="off"  value="<?php echo date('d M Y',strtotime($r->date)) ?>" required="">
      </div>
         <input type="hidden" name="daycheck[]" readonly=""  parsley-type="text" class="form-control date text-center" placeholder="Date" autocomplete="off"  value="<?php echo date('l',strtotime($r->date)) ?>" required="">
           <div class="col-3 form-group text-center text-center pr-0">
            <input type="text" name="sehar_time[]" onKeyPress="changeSeharData('<?php echo $count; ?>')" onkeyup="changeSeharData('<?php echo $count; ?>')" onblur="changeSeharData('<?php echo $count; ?>')" parsley-type="text" class="form-control font-size-15 time sehar-<?php echo $count; ?>" placeholder=" Time" value="<?php echo $r->sehar_time; ?>" autocomplete="off" required="">
           </div>
           <div class="col-3  pr-1 text-center form-group">
            <input type="text" name="iftar_time[]" parsley-type="text" onKeyPress="changeFajarData('<?php echo $count; ?>')" onkeyup="changeFajarData('<?php echo $count; ?>')" onblur="changeFajarData('<?php echo $count; ?>')" class="form-control font-size-15 time fajar-<?php echo $count; ?>" value="<?php echo $r->iftar_time; ?>" placeholder=" Time" autocomplete="off"  required="">
           </div>
         </div>
            <!-- <?php  $count++; } } ?> -->
      </div>
    </div>
    </div>
    <div class="form-group text-center">
      <br>
      <button class="btn bgc-green text-white  pl-5 pr-5 btn-lg pt-1 pb-1 b-radius" type="submit" name="save">SAVE</button>
    </div>
  </form>


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
      detail: '',
      loading:true,
      error_message: "",
      has_error: false,
      roza:{},
      sehar:[],
      iftar:[],
      submitted: false,
      dekstopAddData:{},
      disabledDates: {
        to: new Date()
      },
      form:{
        id:'',
        start_date:new Date()
      }
    }

  },
  beforeMount(){
    this.runscript();
    this.getData();
  },
   components: {
            Datepicker
        },
        created(){
          if (typeof this.$route.params.id == 'undefined' && this.$route.params.id == '') {

          }
        },
  methods: {  
    loadjs(){
            var mainthis = this;
            let externalScript = document.createElement('script')
              externalScript.setAttribute('src', 'https://d3a39i8rhcsf8w.cloudfront.net/js/jquery.mask.min.js')
              document.head.appendChild(externalScript);

          },
    getStartDate(){
      this.form.end_date = this.form.start_date;
      this.disabledendDates.to = this.form.start_date;
    },
    getData(){
      if (typeof this.$route.params.id !== 'undefined' && this.$route.params.id != '') {
        var dataUrl = 'v1/mosque-ramadan-detail/'+this.$route.params.id;
        axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
          var data = result.data.data
          this.detail = data.ramadan;
          this.form.id = data.ramadan.id;
          this.form.start_date = data.ramadan.start_date;
          this.roza = data.roza;
          var $this = this;
          $.each(data.roza, function( index, value ) {
            $this.sehar[index] = value.sehar_time;
            $this.iftar[index] = value.iftar_time;
          });
            this.loading = false;
        }, error => {

        });
      }else{
        var $this = this;
     

          if ($this.$isMobile()) {

          }else{
            $this.form.start_date = new Date('12-April-2021');
            $this.dekstopAdd();
          }
      

      }
               
    },
    dekstopAdd(){
       this.loading = true;
      this.roza = {};
      var englishDate = this.form.start_date;


      var html = '';
      var dataArray = [];
      var $this = this;
       this.dekstopAddData = {};
      for (let i = 1; i <= 30; i++) { 
        if (i != 1) {
          if (englishDate != '') {
            var date = new Date(englishDate);
            date.setDate(date.getDate() + 1);
            englishDate = date.toInputFormat();
          }
        }else{
          var date = new Date(englishDate);
          englishDate = date.toInputFormat();
        }
                var date = new Date(englishDate);
        var englishDateShow = date.toShowFormat();
        var day = date.toShowDay();
        dataArray.push({"englishDateShow":englishDateShow,"day":day,"count":i,"iftar":'',"sehar":''});
        var islamicDate = '';

      }
      this.dekstopAddData = dataArray;
      this.loading = false;

/*      $('#rozaFields').html(html);*/


    },
  plusOne(val){
    return val + 1;
  },
    submit(){
      var $this = this;
      this.submitted = true;

      this.$validator.validate().then(valid => {
        if (valid) {
          this.error_message = "";
          this.has_error = false;
          let formData = $('#addramadan').serialize();
          axios({
            method: "POST",
            url: "/v1/save-mosque-ramadan",
            data: formData
          }).then(  response => {
            var response = response.data;
            if (response.status) {      
              this.$parent.success_message = 'Ramadan Added Successfully';        
              this.$router.push({path: '/user/ramadan'});
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
    },
    fixDigit(val){
      return val.toString().length === 1 ? "0" + val : val;
    },
    runscript(){
      var $this = this;
     Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = ("0" + (this.getMonth() + 1)).slice(-2).toString(); // getMonth() is zero-based
       var dd  = $this.fixDigit(this.getDate()).toString();
       return yyyy + "-" + mm + "-" + dd; // padding
     };
     Date.prototype.toShowFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = ("0" + (this.getMonth() + 1)).slice(-2).toString(); // getMonth() is zero-based
       var dd  = $this.fixDigit(this.getDate()).toString();

       const monthNames = ["January", "February", "March", "April", "May", "June",
       "July", "August", "September", "October", "November", "December"
       ];
       var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

       /*return  weekday[this.getDay()] +", "+ dd + " "+monthNames[this.getMonth()]+" "+yyyy;*/ // padding
       return  dd +" "+monthNames[this.getMonth()]+" "+yyyy; // padding
     };
     Date.prototype.toShowDay = function() {
       var yyyy = this.getFullYear().toString();
       var mm = ("0" + (this.getMonth() + 1)).slice(-2).toString(); // getMonth() is zero-based
       var dd  = $this.fixDigit(this.getDate()).toString();

       const monthNames = ["January", "February", "March", "April", "May", "June",
       "July", "August", "September", "October", "November", "December"
       ];
       var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

       /*return  weekday[this.getDay()] +", "+ dd + " "+monthNames[this.getMonth()]+" "+yyyy;*/ // padding
       return   weekday[this.getDay()];
     };
     Date.prototype.toShowArabicFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = ("0" + (this.getMonth() + 1)).slice(-2).toString(); // getMonth() is zero-based
       var dd  = $this.fixDigit(this.getDate()).toString();

       var months = ["يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو",
       "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
       var days =["اﻷحد","اﻷثنين","الثلاثاء","اﻷربعاء","الخميس","الجمعة","السبت"];

       return  days[this.getDay()] +", "+ dd + " "+months[this.getMonth()]+" "+yyyy; // padding
     };
   },
   changeSeharData(num){
    var $this = this;
var last = 31 - num;
    var val = $('.sehar-'+num).val();

    val = val.split(':');

    if(val[1] != '' && typeof val[1] !== 'undefined' && val[1].length > 1){
      var plusval = parseInt(val[1]);
      for (let i = num; i <= last; i++) { 
        if(num != i && i > num && plusval < 59){
          plusval = parseInt(plusval + 1);
          var addthis = plusval;
          if(10 > addthis){
            addthis = '0'+addthis
          }
          if(addthis != 60){
            $this.sehar[i] = val[0]+':'+addthis;
          $('.sehar-'+i).val(val[0]+':'+addthis);
          }
        } else if(num != i && i > num && plusval == 59){
       
          var mval = parseInt(val[0]);
          mval = parseInt(mval + 1);
          if(10 > mval){
            mval = '0'+mval
          }
          val[0] = mval;
          plusval ='00';
           $this.sehar[i] = mval+':'+plusval;
          $('.sehar-'+i).val(mval+':'+plusval);
        }
      }

    }
   },
   changeFajarData(num){
      var $this = this;
     var last = 31 - num;
/*  num = parseInt(parseInt(num) - 1);
*/  var val = $('.fajar-'+num).val();

val = val.split(':');

if(val[1] != '' && typeof val[1] !== 'undefined'  && val[1].length > 1){
  var plusval = parseInt(val[1]);
  for (let i = num; i <= last; i++) { 
    if(num != i && i > num && plusval < 59){
      plusval = parseInt(plusval + 1);
      var addthis = plusval;

      if(10 > addthis ){
        addthis = '0'+addthis
      }
      $this.iftar[i] = val[0]+':'+addthis;
      $('.fajar-'+i).val(val[0]+':'+addthis);
    } else if(num != i && i > num && plusval == 59){
       
          var mval = parseInt(val[0]);
          mval = parseInt(mval + 1);
          if(10 > mval){
            mval = '0'+mval
          }
          val[0] = mval;
          plusval ='00';
          $this.iftar[i] = mval+':'+plusval;
          $('.fajar-'+i).val(mval+':'+plusval);
        }
  }

}
   }
  }
}

</script>
