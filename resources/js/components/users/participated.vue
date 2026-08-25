<template>
  <div>

<html lang="en">
<head>
  <title>Event</title>
  <!-- META TAGS -->
<!-- 
  <?php 
  include"../includes/links.php";
  include"../includes/funtions.php"; 
  ?> -->
  <link href="https://letmeinusa.com/public/plugins/dropzone/dropzone.css" rel="stylesheet">

  <link href="https://letmeinusa.com/public/css/custom.css" rel="stylesheet">

</head>
<body data-ng-app="" class="template-user-listing-images-20">
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <div id="location-pickr-map"></div>
  <!--TOP SEARCH SECTION-->
 <VDHeader></VDHeader> 
  <!--DASHBOARD-->
  <section>
    <div class="tz">
     <!--LEFT SECTION-->
    <VLSidebar></VLSidebar>
     <!--CENTER SECTION-->
     <div class="tz-2 " >
       <div class="tz-2-com tz-2-main">
        <h4>Participated Jummah</h4>
        <div class="db-list-com tz-db-table">
          <div class="ds-boar-title"></div>
          <table class="table table-bordered">
            <thead>
              <tr>
               <th>Date</th>                
               <th>Start</th>                
               <th>Jammat</th>                
               <!--     <th>Action</th>    -->
             </tr>

           </thead>
           <tbody>
            <!-- <?php  if ($stmtpn->rowCount()) { ?>
             <?php  while($r = $stmtpn->fetchObject()){ ?>
              <tr>
                <td><?php echo date('d M Y',strtotime($r->date)); ?></td>
                <td><?php echo $r->start; ?></td>
                <td><?php echo $r->jamaat; ?></td>
               
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
  </div>
</div>
</div>
<!-- GET QUOTES Popup END -->

<!--RIGHT SECTION-->

</section>



   </body>

   </html>

     <VFooter></VFooter>
    </div>
  
</template>