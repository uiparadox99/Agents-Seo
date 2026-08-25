<template>
  <div>
    <div v-if="!$isMobile()">
      <VGHeader></VGHeader>
     <main class="container pt-5 pb-5">
	<div class="alert alert-success alert-dismissible " role="alert" id="showAutoSuccess" style="display: none;    position: absolute;
    left: 0;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&#10006;</span>
					</button>
					Auto Updated !
				</div>
<!-- <?php if (!empty($_GET['admin_mosques_id'])) { ?>
<style type="text/css">
	.sticky{
		background-color: #fff;
	}
	.sticky th{
		  position: sticky;
		  background-color: #fff;
		  z-index: 999;
  top: 0; 
	}
	.sticky td{
		  position: sticky;
		  background-color: #fff;
		    z-index: 999;
  top: 47px; 
	}
	.fajar{
		background-color: #afaf08 !important; 
	}
	.zohar{
		background-color: #ea5e5e !important;
	}
	.asar{
		background-color: #c55cc5 !important;
	}
	.magrib{
		background-color: #9292e8 !important;
	}
	.isha{
		background-color: #f3a8b5 !important;
	}
</style>
<?php } ?> -->
	<div class="row">

		<div class="col-md-12">
			<!-- <?php $showMonth = $month;  if ($showMonth < 10) { $showMonth = '0'.$showMonth; } $sendMonth = $showMonth; $showMonth = '01'.'-'.$showMonth.'-'.date('Y'); $showMonth = date('M',strtotime($showMonth)); ?>
			 <?php include"../portal/includes/display-alert.php" ?> -->
			<div class="shadow p-4" style="position: relative;">
				<form action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure this is <?php echo $showMonth .' '. date('Y') ?> data & want to upload it?')">
					
			
				<div class="row">
					<div class="col-md-4 pt-3">
						<h5 class="text-success">Import  Timings With Excel Sheet</h5>
						<p class="text-danger">Please Upload File in Given Formate</p>
					</div>

					<div class="col-md-4">
						<input type="hidden" name="month" value="<?php echo $sendMonth ?>">
						<label>Excel File For <span style="text-transform: capitalize;">
                            <!-- <?php echo $showMonth .' '. date('Y') ?> -->
                            </span></label>
						<input type="file" name="file" class="form-control pl-1 pt-1 pb-1" required="" placeholder="Excel File">
					</div>
					<div class="col-md-2">
						<label>&nbsp;</label>
						<button type="submit" name="import" class="btn btn-success btn-block">Import Now</button>
					</div>
					<div class="col-md-2">
						<label class="text-center btn-block">Example Formate</label>
						<a href="<?php echo BASE_PATH ?>public/Example-Prayers-Timing-Import.xlsx" download="" class="btn btn-success btn-block">Download</a>
					</div>
				</div>
					</form>
				<div class="" id="loaderNamaz" style="display: none;">
					<i class="fa fa-spinner fa-spin"></i>
				</div>
				<div class="alert alert-success alert-dismissible " role="alert" id="showSuccess" style="display: none;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&#10006;</span>
					</button>
					Prayers Timings Updated Successfully !
				</div>
			
					<h3 class="text-green jr-h-res">Namaz Timing <span style="color: black;font-size: 14px;">	Changes will be saved automatically !</span> 

						<!-- <?php if (!empty($_GET['admin_mosques_id'])) { ?>
					 <a href="<?php echo BASE_PATH ?>portal/add-mosque.php?id=<?php echo $_GET['admin_mosques_id'] ?>" class="btn btn-success float-right">Back </a>
					<?php }else{ ?> -->
							 <a href="javascript:;" class="btn btn-success float-right" onclick="goBack(this)">Back </a>
					<!-- <?php } ?> -->
					<SMALL class="float-right">
                        <!-- <?php echo $detail->name ?> -->
                         &nbsp;</SMALL> 
					</h3>
					<div class="clearfix"></div>
					
				
				
				
					<!-- <?php ini_set('max_input_vars', 5000); ?> -->
			
				<ul class="nav nav-tabs namaz-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 1?'active':''; ?>"  href="namaz-timing<?php echo !empty($_GET['admin_mosques_id'])?'?admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">January</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 2?'active':''; ?>"  href="namaz-timing?month=2<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">February</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 3?'active':''; ?>"  href="namaz-timing?month=3<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">March</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 4?'active':''; ?>"  href="namaz-timing?month=4<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">April</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 5?'active':''; ?>"  href="namaz-timing?month=5<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">May</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 6?'active':''; ?>"  href="namaz-timing?month=6<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">June</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 7?'active':''; ?>"  href="namaz-timing?month=7<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">July</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 8?'active':''; ?>"  href="namaz-timing?month=8<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">August</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 9?'active':''; ?>"  href="namaz-timing?month=9<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">September</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 10?'active':''; ?>"  href="namaz-timing?month=10<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">October</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 11?'active':''; ?>"  href="namaz-timing?month=11<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">November</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $month == 12?'active':''; ?>"  href="namaz-timing?month=12<?php echo !empty($_GET['admin_mosques_id'])?'&admin_mosques_id='.$_GET['admin_mosques_id']:'' ?>">December</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content namaz-timming-content">
<!-- 
					<?php
						if ($month == 1) {
						   	include 'partials/jan.php';
						}
						if ($month == 2) {
						   	include 'partials/feb.php';
						}
						if ($month == 3) {
						   	include 'partials/march.php';
						}
						if ($month == 4) {
						   	include 'partials/april.php';
						}
						if ($month == 5) {
						   	include 'partials/may.php';
						}
						if ($month == 6) {
						   	include 'partials/june.php';
						}
						if ($month == 7) {
						   	include 'partials/july.php';
						}
						if ($month == 8) {
						   	include 'partials/auguest.php';
						}
						if ($month == 9) {
						   	include 'partials/sep.php';
						}
						if ($month == 10) {
						   	include 'partials/oct.php';
						}
						if ($month == 11) {
						   	include 'partials/nov.php';
						}
						if ($month == 12) {
						   	include 'partials/dec.php';
						}
					?> -->
					
					

				</div>
				<div class="mt-3">
					<!-- <button onclick="submitForms()"  class="btn btn-success">Save Timings</button> -->
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

	<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn "><i class="fa fa-bars"></i></button> Namaz Timing </h4>
	<form action="" method="post">
	<div class="text-center">
		<label>Select Date</label>
		<input type="text" name="date" value="<?php echo !empty($nextDay) && $nextDay['date']?date('d-m-Y',strtotime('+1 day'.$nextDay['date'])):''; ?>" required="" class="form-control date" style="width: 70%;margin: 0 auto;" autocomplete="off" placeholder="Date">
	</div>
		<table class="table t-style b-radius text-center  mt-3 namaz-table">
			<thead >
              <tr>
                <th class="bgc-green text-white pt-1 pb-1 font-size-15  " >Namaz</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-15 " >Start Time</th>
                <th class="bgc-green text-white pt-1 pb-1 font-size-15">Salah Time</th>
              </tr>
            </thead>
            <tbody class="table-bordered">
            	<tr id="jan_" data-number="1">
					
					<td>Sunrise</td>
            		<td colspan="2">
					
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_sunrise_start" name="sunrice" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['sunrice']?$nextDay['sunrice']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	<!-- 	<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_sunrise_jamaat" name="sunrise_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['sunrise_jamaat']?$nextDay['sunrise_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td> -->
            	</tr>
            	<tr id="jan_" data-number="1">
            		<td>Fajar</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_fajar_start" name="fajar_start" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['fajar_start']?$nextDay['fajar_start']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_fajar_jamaat" name="fajar_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['fajar_jamaat']?$nextDay['fajar_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	</tr>
            	<tr id="jan_" data-number="1">
            		<td>Zohar</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_zohar_start" name="zohar_start" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['zohar_start']?$nextDay['zohar_start']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_zohar_jamaat" name="zohar_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['zohar_jamaat']?$nextDay['zohar_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	</tr>
            	<tr id="jan_" data-number="1">
            		<td>Asar</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_asar_start" name="asar_start" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['asar_start']?$nextDay['asar_start']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_asar_jamaat" name="asar_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['asar_jamaat']?$nextDay['asar_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	</tr>
            	<tr id="jan_" data-number="1">
            		<td>Magrib</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_magrib_start" name="mugrib_start" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['mugrib_start']?$nextDay['mugrib_start']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>

            		</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_magrib_jamaat" name="mugrib_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['mugrib_jamaat']?$nextDay['mugrib_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	</tr>
            	<tr id="jan_" data-number="1">
            		<td>Isha</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_isha_start" name="isha_start" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['isha_start']?$nextDay['isha_start']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            		<td>
            			<span class="time-action"><span class="add-btn" onclick="addInVal(this)"><i class="fa fa-plus"></i>	</span></span>
            			<input type="text" id="jan_1_isha_jamaat" name="isha_jamaat" class="form-control time" value="<?php echo !empty($nextDay) && $nextDay['isha_jamaat']?$nextDay['isha_jamaat']:''; ?>">
            			<span class="time-action"><span class="minus-btn"  onclick="minusInVal(this)"><i class="fa fa-minus"></i></span></span>
            		</td>
            	</tr>

            </tbody>
		</table>
		<input type="hidden" name="copy">
		<input type="hidden" name="update" value="1">
		<div class="mt-3">
			<div class="row">
				<div class="col-4">
			<button type="submit"  class="btn btn-success btn-sm text-uppercase ml-2 pr-4 pl-4">Save</button>
			</div>
			<div class="col-8">
			<button type="submit" onclick="$('input[name=copy]').val(1)" class="btn btn-success btn-sm text-uppercase pl-4 pr-4">Save & Copy Next Day</button>
		</div>
		</div>
	</div>
	</form>

	

</main>

      <VFooter></VFooter>
    </div>
  </div>
</template>
