<template>
	<div>
		<div class="modal screenshotsmodel" id="screenShots">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Device Screenshots</h4>

						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
						<p class="mt-0 mb-2">Note: Screenshots will be displayed in lower resolution until you export your finished project.</p>
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item" v-for="(screen, key) in $parent.screens">
								<a :class="'nav-link active tab-screen'+key" data-toggle="tab" :href="'#tab-screen'+key" v-if="key == 0">Screen {{screen.id}}</a>
								<a :class="'nav-link tab-screen'+key" data-toggle="tab" :href="'#tab-screen'+key" v-else>Screen {{screen.id}}</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div  v-for="(screen, key) in $parent.screens" :id="'tab-screen'+key" v-bind:class="{'active show': key == 0}" class="fade tab-pane">
								<div class="row">


									<div class="col-md-2 pr-0">
										<div class="screen-preview">
											<img :src="screen.TemplateImageUrl">
										</div>
									</div>
									<div class="col-md-10">
										<div class="device-shots-box mb-3" v-for="(slot , slotKey) in screen.slots" v-if="slot.type != 'text' && slot.SlotType.includes('frame')">
											<h2>Device - {{slot.SlotType.split('frame')[1].split('-')[0]}}</h2>
											<div class="row">
												<div class="col-6 pr-1">
													<div class="screen-upload-box" :id="'global-shot-'+key+'-slot-'+slotKey" >
												<input type="file"   ref="file" name="img" :id="'global-file-'+key+'-slot-'+slotKey"  v-on:change="handleFileUploads('global',key,slotKey)"  style="display:none">
														<div class="left"  v-on:click="clickOnFile('global',key,slotKey)">
															<h4>Global Screenshot</h4>
															<p>Default screenshot for all targets that have not been assigned <br> Aspect: Auto.</p>
														</div>
														<div class="right">
													<div class="shot-loader" style="display:none"><i class="fa fa-spinner fa-spin"></i> </div>
															<div class="icons upload" >
															 	 <i class="fa fa-upload" v-on:click="clickOnFile('global',key,slotKey)"></i>
															 </div>
															 <div class="icons added" style="display:none;">
															 	 <i class="fa fa-image" v-on:click="$parent.showAddedImage('global',key,slotKey)"></i> &nbsp; 	 <i class="fa fa-times" v-on:click="$parent.removeAddedImage('global',key,slotKey)"></i>
															 </div>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-6 pr-1">
													<div class="screen-upload-box" :id="'iphone5-shot-'+key+'-slot-'+slotKey"  >
												<input type="file"   ref="file" name="img" :id="'iphone5-file-'+key+'-slot-'+slotKey"  v-on:change="handleFileUploads('iphone5',key,slotKey)"  style="display:none">
														<div class="left" v-on:click="clickOnFile('iphone5',key,slotKey)">
															<h4>iOS Phones - 5.5"</h4>
															<p>Target iPhone 6/7/8 & Plus (without the notch)<br> Aspect: 16:9 Typical Size: 1242 X 2208</p>
														</div>
														<div class="right">
													<div class="shot-loader" style="display:none"><i class="fa fa-spinner fa-spin"></i> </div>
															 <div class="icons upload">
															 	 <i class="fa fa-upload" v-on:click="clickOnFile('iphone5',key,slotKey)"></i>
															 </div>
															  <div class="icons added" style="display:none;">
															 	 <i class="fa fa-image" v-on:click="$parent.showAddedImage('iphone5',key,slotKey)"></i> &nbsp; 	 <i class="fa fa-times" v-on:click="$parent.removeAddedImage('iphone5',key,slotKey)"></i>
															 </div>
														</div>
															<div class="clearfix"></div>
													</div>
												</div>
												<div class="col-6 pl-1">
													<div class="screen-upload-box" :id="'iphone6-shot-'+key+'-slot-'+slotKey"  >
												<input type="file"   ref="file" name="img" :id="'iphone6-file-'+key+'-slot-'+slotKey"  v-on:change="handleFileUploads('iphone6',key,slotKey)"  style="display:none">
														<div class="left" v-on:click="clickOnFile('iphone6',key,slotKey)">
															<h4>iOS Phones - 6.5"</h4>
															<p>Target iPhone X/11/12 & Max sizes (without the notch)<br> Aspect: 19.5:9 Typical Size: 1242 X 2688</p>
														</div>
														<div class="right">
													<div class="shot-loader" style="display:none"><i class="fa fa-spinner fa-spin"></i> </div>
															 <div class="icons upload">
															 	 <i class="fa fa-upload" v-on:click="clickOnFile('iphone6',key,slotKey)"></i>
															 </div>
															   <div class="icons added" style="display:none;">
															 	 <i class="fa fa-image" v-on:click="$parent.showAddedImage('iphone6',key,slotKey)"></i> &nbsp; 	 <i class="fa fa-times" v-on:click="$parent.removeAddedImage('iphone6',key,slotKey)"></i>
															 </div>
														</div>
															<div class="clearfix"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-6 pr-1">
													<div class="screen-upload-box" :id="'ipad2-shot-'+key+'-slot-'+slotKey"  >
												<input type="file"   ref="file" name="img" :id="'ipad2-file-'+key+'-slot-'+slotKey"  v-on:change="handleFileUploads('ipad2',key,slotKey)"  style="display:none">
														<div class="left" v-on:click="clickOnFile('ipad2',key,slotKey)">
															<h4>iOS iPad Pro (2nd) - 12.9"</h4>
															<p>Target iPad with button 3/4/Mini/Air/Air 2 (9.7") & iPad Pro 2nd<br> gen (12.9") <br> Aspect: 4:3 Typical Size: 2048 X 2732</p>
														</div>
														<div class="right">
													<div class="shot-loader" style="display:none"><i class="fa fa-spinner fa-spin"></i> </div>
															 <div class="icons upload">
															 	 <i class="fa fa-upload" v-on:click="clickOnFile('ipad2',key,slotKey)"></i>
															 </div>
															  <div class="icons added" style="display:none;">
															 	 <i class="fa fa-image" v-on:click="$parent.showAddedImage('ipad2',key,slotKey)"></i> &nbsp; 	 <i class="fa fa-times" v-on:click="$parent.removeAddedImage('ipad2',key,slotKey)"></i>
															 </div>
														</div>
															<div class="clearfix"></div>
													</div>
												</div>
												<div class="col-6 pl-1">
													<div class="screen-upload-box" :id="'ipad3-shot-'+key+'-slot-'+slotKey"  >
												<input type="file"   ref="file" name="img" :id="'ipad3-file-'+key+'-slot-'+slotKey"  v-on:change="handleFileUploads('ipad3',key,slotKey)"  style="display:none">
															<div class="left" v-on:click="clickOnFile('ipad3',key,slotKey)">
															<h4>iOS iPad Pro (3rd+) - 12.9"</h4>
															<p>Target iPad with button 3rd & 4th gen without button<br> Aspect: 4:3 Typical Size: 2048 X 2732 <br> &nbsp;</p>
														</div>
														<div class="right">
													<div class="shot-loader" style="display:none"><i class="fa fa-spinner fa-spin"></i> </div>
															 <div class="icons upload">
															 	 <i class="fa fa-upload" v-on:click="clickOnFile('ipad3',key,slotKey)"></i>
															 </div>
															  <div class="icons added" style="display:none;">
															 	 <i class="fa fa-image" v-on:click="$parent.showAddedImage('ipad3',key,slotKey)"></i> &nbsp; 	 <i class="fa fa-times" v-on:click="$parent.removeAddedImage('ipad3',key,slotKey)"></i>
															 </div>
														</div>
															<div class="clearfix"></div>
													</div>
												</div>
											</div>
										
										</div>
									</div>
								</div>
							</div>




						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class=" btn-none" data-dismiss="modal">Close</button>
						<button type="button" class="text-success btn-none float-right" v-on:click="$parent.updateShotsData">Save</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
	data(){
		return{
			mainData: '',
			nameData:'',
			nameLength:'',
			dropzoneOptions: {  
				url: '/formSubmit',
			}  
		}
	},
	components: {
		vueDropzone: vue2Dropzone
	},
	beforeMount(){

	},

	methods:{
		clickOnFile(device,key,slotKey){
			$("#"+device+"-file-"+key+"-slot-"+slotKey).click();
		},
		handleFileUploads(device,key,slotKey){
			var imagefile = document.querySelector('#'+device+'-file-'+key+'-slot-'+slotKey);
			var file =   imagefile.files[0];
			this.$parent.addShot(file,device,key,slotKey);
		}
	},
}
</script>