<template>
	<div>
		<div class="modal " id="setupModal">
			<div class="modal-dialog" style="max-width:50vw;min-height:auto">
				<div class="modal-content">

					<!-- Modal Header -->
					<!-- <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div> -->

					<!-- Modal body -->
					<div class="modal-body">

						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link" v-bind:class="{'active': panoramic == false}" data-toggle="tab" :href="'#projectstup'"><i class="fa fa-cog"></i> Project Setup</a>
								
							</li>
							<li>
								<a class="nav-link" v-bind:class="{'active': panoramic == true}" data-toggle="tab" :href="'#panoramicbackground'"><i class="fa fa-image"></i> Panoramic Background</a>
							</li>
						</ul>
						<div class="tab-content">
							<br>
							<div id="projectstup"  class="fade tab-pane"  v-bind:class="{'active show':!panoramic}">
								<div class="row">
									<div class="col-md-3">
										<b>App</b>
									</div>
									<div class="col-md-7">

										<select class="form-control" v-model="app">
											<option value="">App</option>
											<option v-for="app in setupApps">{{app.name}}</option>
										</select>
									</div>
									<div class="col-md-2">
										<a class="cm-btn btn btn-block" onclick="$('#appsModel').show();">Add <i class="fa fa-mobile"></i></a>
										<div class="modal " id="appsModel">
											<div class="modal-dialog" style="max-width:50vw;min-height:50vh;    margin: 10.75rem auto;">
												<div class="modal-content" style="    overflow-y: hidden;">

													<!-- Modal Header -->
													<div class="modal-header">
														<h4 class="modal-title">Manage Apps</h4>
														<button type="button" class="close" onclick="$('#appsModel').hide();">&times;</button>
													</div>

													<!-- Modal body -->
													<div class="modal-body">
														<div class="row">
															<div class="col-4 ">
																<ul class="app-list">
																	<li class="new"><i class="fa fa-plus"></i> Add new</li>
																	<li v-for="app in setupApps">{{app.name}}</li>
																</ul>
															</div>
															<div class="col-8 pl-0">
																<div class="app-info">
																	<h5>App Info</h5>
																	<div class="cus-select form-group">
																		<span>App Name</span>
																		<input type="text" name="project" v-model="add_new.app_name">
																	</div>
																	<div class="cus-select form-group">
																		<span>Apple Bundle Id</span>
																		<input type="text" name="project" v-model="add_new.apple_bundle_id">
																	</div>
																	<div class="cus-select form-group">
																		<span>Apple App Id</span>
																		<input type="text" name="project" v-model="add_new.apple_app_id">
																	</div>
																	<div class="cus-select form-group">
																		<span>Android Id</span>
																		<input type="text" name="project" v-model="add_new.android_id">
																	</div>
																	<p>Provide at least one the apple Ids and we'll grab the icon !</p>
																	<div class="float-right">
																		<a href="javascript:;" onclick="$('#appsModel').hide();" class="text-danger">Clear</a> &nbsp;&nbsp;
																		<a href="javascript:;" class="">Save</a>
																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>
														</div>
													</div>

													<!-- Modal footer -->
												<!-- 	<div class="modal-footer">
														<button type="button" class=" btn-none" onclick="$('#appsModel').hide();">close</button>

													</div> -->

												</div>
											</div>
										</div>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-3">
										<b>Name</b>
									</div>
									<div class="col-md-9 ">
										<div class="cus-select">
											
											<span>Project name</span>
											<input type="text" name="project" v-model="project">
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-3">
										<b>Output Devices</b>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-6">
												<small><b>Android</b></small>
												<div  class="form-group" v-for="d in setupDevices.android">

													<label><input type="checkbox" name="screenshot" value="1" > {{d.name}}</label>
												</div>
											</div>
											<div class="col-md-6">
												<small><b>IOS</b></small>
												<div  class="form-group" v-for="d in setupDevices.ios">

													<label><input type="checkbox" name="screenshot" value="1" > {{d.name}}</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-3">
										<b>Scene orientations</b>
									</div>
									<div class="col-md-9 ">
										<div class="cus-select">
											
											<span>Design orientation</span>
											<select class="form-control" v-model="orientation">
												<option value="portrait">Portrait</option>
												<option value="landscape">Landscape</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div id="panoramicbackground"  class="fade tab-pane" v-bind:class="{'active show':panoramic}">
								<div class="row">
									<div class="col-md-3">
										<b>Background</b>
									</div>
									<div class="col-md-9">
										<label>Background Image</label><br>
										<div v-if="pana.TemplatebackgroundImage != ''">
											<div class="mt-2 mb-3 backgroundPreview">
												<img :src="pana.TemplatebackgroundImage" style="height:100px">
											</div>

										<!-- 	<div class="row">

												<div class="col-6 pr-1">
													<div class="cus-select">
														<span>Sizing</span>
														<select  v-model="pana.bgSize">
															<option value="contain">Contain</option>
															<option value="cover">Cover - Anchor Ccnter</option>
														</select>
													</div>
												</div>
												<div class="col-6 pl-1" v-if="pana.bgSize != 'cover'">
													<div class="cus-select">
														<span>Image Position</span>
														<select  v-model="pana.bgPosition">
															<option value="bottom">Bottom</option>
															<option value="center">Middle</option>
															<option value="top">Top</option>
														</select>
													</div>
												</div>

											</div>
											<div class="cus-select">
												<span>Image rotation</span>
												<select v-model="pana.bgRotation">
													<option value="0">None</option>
													<option value="90">90*</option>
													<option value="180">180*</option>
													<option value="270">270*</option>
												</select>
											</div> -->
										</div>
										<div style="display:inline-block">
											<a href="javascript:;"  v-on:click="$parent.setBgIndex('panoramic')"class="bg-select-btn">
												<i class="fa fa-image"></i> Select New Background
											</a>  
										</div>
										<div style="display:inline-block">
											<a href="javascript:;"  v-on:click="setupClearbgImage(key)" v-if="pana.TemplatebackgroundImage != ''" class="text-danger ml-2"><i class="fa fa-times"></i> &nbsp; Clear</a>
										</div>
										<br>
										<label>Background Style</label>

										<div class="cus-select">
											<span>Background style</span>
											<select  :id="'bgstyle-tool-screen-'+key"  v-on:click="SetupChangeBgStyle(key)">
												<option value="none">None</option>
												<option value="color" v-if="pana.backgroundColor != '#ffffff' && pana.backgroundColor.length <= 7" selected>Color</option>
													<option value="color" v-else>Color</option>
													<option value="gradient">Gradient</option>
												</select>
											</div>
											<div :id="'color-picker-'+key"  class="background-color-picker" v-bind:style="[pana.backgroundColor == '#ffffff' ? {display: 'none'} : {display: 'none'} ]">
												<div class="row">
													<div class="col-5 pr-2">
														<div class="check-color" :style="'background:'+pana.backgroundColor" data-toggle="modal" :data-target="'#colorPicker'+key">

														</div>
													</div>
													<div class="col-7 pl-0">
														<span>Background style color - Hex</span><br>
														<input type="text" v-model="pana.backgroundColor">
													</div>
												</div>

												<div class="modal" :id="'colorPicker'+key">
													<div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">&nbsp;</h4>

																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<color-panel v-model="pana.backgroundColor"></color-panel>
																<br>
															</div>
															<div class="modal-footer">
																<button type="button" class=" btn-none" data-dismiss="modal">Close</button>
																<button type="button" class="text-success btn-none float-right" data-dismiss="modal">Save</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div :id="'gradient-picker-'+key"  class="background-color-picker" v-bind:style="[pana.backgroundColor == '#ffffff' ? {display: 'none'} : {display: 'none'} ]">
												<div class="check-color" :style="'background:'+pana.backgroundColor" data-toggle="modal" :data-target="'#gradientPicker'+key">

												</div>

												<div class="modal" :id="'gradientPicker'+key">
													<div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
														<div class="modal-content">

															<!-- Modal Header -->
															<div class="modal-header">
																<h4 class="modal-title">&nbsp;</h4>

																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<vue-gpickr v-model="gradient" class="gradientPicker" />
																<br>
																<br>
															</div>
															<div class="modal-footer">
																<button type="button" class=" btn-none" data-dismiss="modal">Close</button>
																<button type="button" class="text-success btn-none float-right" v-on:click="setupSetBgGradient(key)">Save</button>
															</div>
														</div>
													</div>
												</div>


											</div>
										</div>
									</div>
								</div>
							</div>
							<hr>
						</div>

						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class=" btn-none" data-dismiss="modal">Close</button>
							<button type="button" class="text-success btn-none float-right" v-on:click="updateSettings">update</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</template>

	<script>
	import { VueGpickr, LinearGradient } from 'vue-gpickr';
	const defaultGradient = new LinearGradient({
		angle: 0,
		stops: [
		['#0359b5', 0],
		['#f6ce01', 1]
		]
	});
	export default {
		data(){
			return{
				gradient:defaultGradient,
				app: '',
				key: 'panoramic',
				project: 'Template 1',
				orientation: 'portrait',
				panoramic: false,
				panaAdded:false,
				projects: {},
				pana: {
					TemplatebackgroundImage:'',
					imageData:'',
					bgSize:'cover',
					bgPosition:'center',
					bgRotation:'0',
					imgWidth:'',
					imgHeight:'',
					bgid:'',
					backgroundColor:'#ffffff',
				},
				setupDevices: {
					android:{},
					ios:{},
				},
				setupApps: [],
				add_new:{
					app_name:'',
					apple_bundle_id:'',
					apple_app_id:'',
					android_id:'',
				},
			}
		},
		components: {
           VueGpickr
       },
		beforeMount(){

		},

		methods:{
			SetupChangeBgStyle(key){
				var val = $('#bgstyle-tool-screen-'+key).val();
				if (val == 'color') {
					$('#gradient-picker-'+key).hide();
					$('#color-picker-'+key).show();
				}else if(val == 'gradient'){
					$('#color-picker-'+key).hide();
					$('#gradient-picker-'+key).show();
				}else{
					$('#color-picker-'+key).hide();
					$('#gradient-picker-'+key).hide();
				}
			},
			setupClearbgImage(key){
				this.pana.TemplatebackgroundImage  = '';
						this.$forceUpdate();
			},
			setupSetBgGradient(key){
				var gradient =  $('#gradientPicker'+key+' .vue-gpickr-preview').css('background');
				this.pana.backgroundColor  = gradient;
				$('#gradientPicker'+key).modal('hide');
				$('.modal-backdrop').remove();
			},
			panoTabActive(){
				this.panoramic = true;
				this.$forceUpdate();
			},
			setBgImage(link){
				this.pana.TemplatebackgroundImage = link;
				this.$forceUpdate();

				var mthis = this;
				var img = new Image();

				img.src = link;
				img.onload = function() {
					var width = this.width;
					var height = this.height;
					mthis.pana.imgWidth = width;
					mthis.pana.imgHeight = height;

					var drW = parseInt(parseInt(350) * mthis.$parent.screens.length);
					axios({
						method: "GET",
						url: "/panoramic-image?link="+mthis.pana.TemplatebackgroundImage+"&width="+width+"&height="+height+"&resize_width="+drW,
						headers: { "content-type": "application/json" }
					}).then(response => {
						var output = response.data.output;
						mthis.pana.imageData = output;
						mthis.panaAdded= true;
					});
					/*var canvas = document.createElement("canvas");

					var ctx = canvas.getContext("2d");
					ctx.drawImage(img, 0, 0, drW, height);*/

				
				};

				
			},
			updateSettings(){
				var mthis = this;
				$('#setupModal').modal('hide');
					        $('.modal-backdrop').remove();
				if (this.panaAdded) {
				$('.screen-loader').show();
				     setTimeout(function(){
					var setupPostion = mthis.pana.bgPosition;
					var mainPaina = mthis.pana;
					$.each(mthis.$parent.screens, function(key, screen){
						screen.panaramic  = {};
						screen.panaramic.backgroundColor  = mainPaina.backgroundColor;
						screen.panaramic.bgRotation  = mainPaina.bgRotation;
						screen.panaramic.bgSize  = mainPaina.bgSize;
						screen.panaramic.imageData  = mainPaina.imageData;
						screen.panaramic.TemplatebackgroundImage  = mainPaina.TemplatebackgroundImage;
						if (key == 0) {
							screen.panaramic.bgPosition = '0';
						}else{
							var chPostion = parseInt(parseInt(key) * 350)+'px 0';
							screen.panaramic.bgPosition = '-'+chPostion;
							chPostion = '';
							/*$.each(mthis.$parent.devices, function(dkey, device){
								if (screen.device_id == device.id) {
									var position = parseInt(parseInt(key) * parseInt(device.orignal_width));
									screen.pana.bgPosition = position+'px 0px,'+mthis.pana.bgPosition;
								}
							})*/
						}
					})
					       
					   
				     mthis.$parent.$forceUpdate();
						$('.screen-loader').hide();
						this.panaAdded = false;
				  }, 7000);
				}
			},
		},
	}
	</script>