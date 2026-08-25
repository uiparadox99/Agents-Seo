<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
     
<main class="container pt-5 pb-5">
  <div class="row">
    <div class="col-md-3 mb-5">
    <VLSidebar></VLSidebar>
   </div>

   <div class="col-md-9" style = "text-align:center">
    <div class="p-4 shadow mb-3" style="position: relative;">
     <div class="row">
      <div class="col-md-11">
        <h2 class="text-green jr-res" style = "font-size:25px">Give live Adhan to your subscribers</h2>
        <div class="mt-3 app-size"><a href="https://apps.apple.com/gb/app/mosque-finder-prayer-times-uk/id1508742465" target="_blank"><img class="w-25" src="/assets/New/images/Apple-Play-Icon.png" alt=""></a>  <a href="https://play.google.com/store/apps/details?id=com.techpedia.mosquefinder&hl=en"target="_blank"><img class="w-25" src="/assets/New/images/Google-Play-Icon.png" alt=""></a>
</div>
     <!--    <p>Click on the button below to start.</p>
        <button class="btn btn-success" id="StartKhutba">Start Now</button> -->
        
      </div>
    </div>
    <div id="loader" class="liveLoader" style="display: none;">
         <p class="mb-0">  Preparing Setup For You</p>
         <i class="fa fa-spinner fa-spin"></i>
        </div>
  </div>
</div>


</div>
</main>
      <VFooter></VFooter>
    </div>
    <div v-if="$isMobile()">
      <VGHeader></VGHeader>
    
<main class="container pt-5 pb-5">
  <div class="row">
    <div class="col-md-3 mb-5">
     <VLSidebar></VLSidebar>
   </div>

   <div class="col-md-9" style = "text-align:center">
    <div class="p-4 shadow mb-3" style="position: relative;">
     <div class="row">
      <div class="col-md-11">
        <h2 class="text-green jr-res" style = "font-size:25px">Give live Adhan to your subscribers</h2>
        <div class="mt-3 app-size"><a href="https://apps.apple.com/gb/app/mosque-finder-prayer-times-uk/id1508742465" target="_blank"><img class="w-25" src="assets/New/images/Apple-Play-Icon.png" alt=""></a>  <a href="https://play.google.com/store/apps/details?id=com.techpedia.mosquefinder&hl=en" target="_blank"><img class="w-25" src="assets/New/images/Google-Play-Icon.png" alt=""></a>
</div>
     <!--    <p>Click on the button below to start.</p>
        <button class="btn btn-success" id="StartKhutba">Start Now</button> -->
        
      </div>
    </div>
    <div id="loader" class="liveLoader" style="display: none;">
         <p class="mb-0">  Preparing Setup For You</p>
         <i class="fa fa-spinner fa-spin"></i>
        </div>
  </div>
</div>


</div>
</main>
      <VFooter></VFooter>
    </div>
  </div>
</template>
