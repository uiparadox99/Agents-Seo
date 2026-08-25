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
        <h2 class="text-green jr-res" style = "font-size:25px">Give live khutba to your subscribers</h2>
        <div class="mt-3 app-size"><a href="https://apps.apple.com/gb/app/mosque-finder-prayer-times-uk/id1508742465" target="_blank"><img class="w-25" src="/assets/New/images/Apple-Play-Icon.png" alt=""></a>  <a href="https://play.google.com/store/apps/details?id=com.techpedia.mosquefinder&hl=en" target="_blank"><img class="w-25" src="/assets/New/images/Google-Play-Icon.png" alt=""></a>
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

<table style="width: 500px;display: none;">
  <tr>
    <td>Date: </td><td><input autocomplete="off" type="text" id="datetime" /></td>
    <td>Duration: </td><td><select name="duration" id="duration"><option value="">-</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></td>
  </tr>
  <tr>
    <td>Agent Name: </td><td><input autocomplete="off" type="text" id="names" value="<?php echo $_SESSION['user_name'] ?>" /></td>
    <td>Agent Short URL: </td><td><input autocomplete="off" type="text" id="shortagent" value="teacher"  /></td>
  </tr>
  <tr>
    <td>Visitor Name: </td><td><input autocomplete="off" type="text" id="visitorName" value="subcribers"  /></td>
    <td>Visitor Short URL: </td><td><input autocomplete="off" type="text" id="shortvisitor" value="subcribers" /></td>
  </tr>
  <tr>
    <td>Room: </td><td><input autocomplete="off" type="text" id="roomName" value="<?php echo 'liveKhutba-'.$_SESSION['login_mosque_slug'] ?>" /></td>
    <td>Password: </td><td><input autocomplete="new-password" type="password" id="roomPass" /></td>
  </tr>
  <tr>
    <td colspan="4">
      <a href="#" id="generateBroadcastLink" class="generateButton">Generate Broadcast</a>
      <a href="#" id="saveLink" class="generateButton">Save Link</a> 
      <a href="#" id="generateLink" class="generateButton">Generate Video</a>
    </td>
  </tr>
</table>
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
        <h2 class="text-green jr-res" style = "font-size:25px">Give live khutba to your subscribers</h2>
        <div class="mt-3 app-size"><a href="https://apps.apple.com/gb/app/mosque-finder-prayer-times-uk/id1508742465" target="_blank"><img class="w-25" src="<?php echo BASE_PATH; ?>public/New/images/Apple-Play-Icon.png" alt=""></a>  <a href="https://play.google.com/store/apps/details?id=com.techpedia.mosquefinder&hl=en" target="_blank"><img class="w-25" src="<?php echo BASE_PATH; ?>public/New/images/Google-Play-Icon.png" alt=""></a>
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

<table style="width: 500px;display: none;">
  <tr>
    <td>Date: </td><td><input autocomplete="off" type="text" id="datetime" /></td>
    <td>Duration: </td><td><select name="duration" id="duration"><option value="">-</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></td>
  </tr>
  <tr>
    <td>Agent Name: </td><td><input autocomplete="off" type="text" id="names" value="<?php echo $_SESSION['user_name'] ?>" /></td>
    <td>Agent Short URL: </td><td><input autocomplete="off" type="text" id="shortagent" value="teacher"  /></td>
  </tr>
  <tr>
    <td>Visitor Name: </td><td><input autocomplete="off" type="text" id="visitorName" value="subcribers"  /></td>
    <td>Visitor Short URL: </td><td><input autocomplete="off" type="text" id="shortvisitor" value="subcribers" /></td>
  </tr>
  <tr>
    <td>Room: </td><td><input autocomplete="off" type="text" id="roomName" value="<?php echo 'liveKhutba-'.$_SESSION['login_mosque_slug'] ?>" /></td>
    <td>Password: </td><td><input autocomplete="new-password" type="password" id="roomPass" /></td>
  </tr>
  <tr>
    <td colspan="4">
      <a href="#" id="generateBroadcastLink" class="generateButton">Generate Broadcast</a>
      <a href="#" id="saveLink" class="generateButton">Save Link</a> 
      <a href="#" id="generateLink" class="generateButton">Generate Video</a>
    </td>
  </tr>
</table>
      <VFooter></VFooter>
    </div>
  </div>
</template>
