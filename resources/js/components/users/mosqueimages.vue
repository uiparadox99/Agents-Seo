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
							<h4 class="text-green">Mosque Images</h4>
							<alert></alert>
							 <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>
							<div class="ds-boar-title" v-if="mainData == null && !loading">

								<h2>
									<button class="btn btn-success"  data-toggle="modal" data-target="#addModal" style="float: right;">Add Images</button>
								</h2>
							</div>
							<div class="db-list-com tz-db-table mt-5" v-if="mainData !== null && !loading">



								<form action="" method="post" id="add-images" name="add-images" enctype="multipart/form-data" @submit.prevent="editsubmit()">
									<input type="hidden" name="image_id" v-model="image_id" id="image_id" value="">
									<input type="hidden" name="image_form" id="image_form" value="yes">
									<div class="row topSection">
										<div class="col-md-4">
											<div class="card logo-image">
												<div class="card-image">
													<a href="javascript:;" class="btn text-white bgc-green p-2 pl-5 pr-5  position-absolute mi-btn1">Logo</a>

													<img v-if="mainData.logo !=''" :src="$parent.BASE_API_PATH+'/uploads/'+mainData.logo" style="height: 217px;object-fit: fill;width: 100%;">
													<img v-else src="http://placehold.it/350x250" style="height: 230px;" class="img-responsive">

													<div class="file-upload position">
														<label for="file-input" class="bgc-green p-3 rounded-circle" style="cursor: pointer;width: 55px; height: 55px;" id="selectFile"  @click="selectFile">
															<i class="fa fa-upload text-white " aria-hidden="true"></i>
														</label>

														<input type="file" name="logo" ref="logo" id="chooseFile" v-on:change="logoChange" class="logo_update" style="display: none;" />
													</div>

												</div>
											</div>

										</div>
										<div class="col-md-8">
											<div class="card cover-image">
												<div class="card-image">
													<a href="javascript:;" class="btn text-white bgc-green p-2 pl-5 pr-5  position-absolute mi-btn2">Cover</a>
													<img v-if="mainData.logo !=''" :src="$parent.BASE_API_PATH+'/uploads/'+mainData.cover" style="width:100%;height: 217px;object-fit: cover;">
													<img v-else src="http://placehold.it/1350x500" class="img-responsive">
													<div class="file-upload position">
														<label for="file-input" id="selectcover" @click="selectcover" class="bgc-green p-3 rounded-circle"  style="cursor: pointer;width: 55px; height: 55px;">
															<i class="fa fa-upload text-white " aria-hidden="true"></i>
														</label>
														<input type="file" name="cover" ref="cover" id="choosecover"  v-on:change="coverChange" style="display: none;" class="cover_update"> 
													</div>

												</div>
											</div>
										</div>

									</div>
								</form>



								<div class="gallery mt-5 mb-5">
									<vue-dropzone ref="myVueDropzone" id="dropzone" v-on:vdropzone-sending="sendingEvent" :options="dropzoneOptions"></vue-dropzone>
								</div>
								<div class="clearfix"></div>
								<div class="uploadImages row">
							
							<div class="col-md-4 mb-2 "  v-for="gal in gallery" :id="'gal'+gal.id">
								<div class="card">
									<div class="card-image">
										<img :src="$parent.BASE_API_PATH+'/uploads/'+gal.gallery"  data-caption="" class="materialboxed w-100" height="200">
										<div class="btn-group image-btn">
											<a href="javascript:;" @click="deleteImage(gal.id)" class="btn btn-xs btn-danger " ><i class="fa fa-trash"></i></a>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<h4 v-else style="text-align: center;margin-left: 50px;" class="text-success">No Images Uploaded</h4>
				</div>
			</div>
		</div>
		<!-- GET QUOTES POPUP -->
	
				<div id="addModal" class="modal fade " role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<form action="" method="POST" id="addimages" enctype="multipart/form-data"  @submit.prevent="submit()">
								<div class="modal-header">
									<h4 class="modal-title text-success" id="addManagementLabel" >Add Images</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
								</div>
								<div class="modal-body">

									<div class="form-group row">
										<label for="name" class="col-sm-4 form-control-label">Logo Image<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											<input type="file" name="logo" ref="formlogo" v-on:change="handleFileUploads()" v-validate="'required'"  class="form-control">
											<span v-show="errors.has('logo')" class="text-danger">{{ errors.first('logo') }}</span>
										</div>
									</div>
									<div class="form-group row">
										<label for="title" class="col-sm-4 form-control-label">Cover Image<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											
											<input type="file" name="cover" ref="formcover" v-on:change="handleFileUpload()" v-validate="'required'"  class="form-control">
											<span v-show="errors.has('cover')" class="text-danger">{{ errors.first('cover') }}</span>

										</div>

									</div>
									<div class="modal-footer">
										<button type="submit" name="image" class="btn btn-success waves-effect waves-light" v-if="!submitted">Save</button>
										<button disabled="" class="btn btn-success waves-effect waves-light" v-else><i class="fa fa-spine fa-spinner"></i></button>
									</div>
								</div><!-- /.modal-content -->
							</form>
							
						</div><!-- /.modal-dialog -->
					</div>
				</div>

			</main>

			<VFooter></VFooter>
		</div>
		<div v-else>
			<VGHeader></VGHeader>

			<main class="container pt-3 pb-3">

					
						<VLSidebar></VLSidebar>
					
				
							<h4 class="text-green text-center"><button data-toggle="modal" data-target="#sidebar" class="btn btn-sm btn float-left user-bar-btn"><i class="fa fa-bars"></i></button>Mosque Images</h4>
							<alert></alert>
							<div class="text-center" v-if="mainData == null">

							
									<button class="btn btn-success"  data-toggle="modal" data-target="#addModal" style="float: right;">Add Images</button>
								
							</div>
							<div class="" v-if="mainData !== null">



								<form action="" method="post" id="add-images" name="add-images" enctype="multipart/form-data" @submit.prevent="editsubmit()">
									<input type="hidden" name="image_id" v-model="image_id" id="image_id" value="">
									<input type="hidden" name="image_form" id="image_form" value="yes">
								
											<div class="card logo-image mt-4">
												<div class="card-image">
													<a href="javascript:;" class="btn text-white bgc-green p-1 font-size-12 pl-5 pr-5 b-radius position-absolute mi-btn1">Logo</a>

													<img v-if="mainData.logo !=''" :src="$parent.BASE_API_PATH+'/uploads/'+mainData.logo" style="height: 217px;object-fit: fill;width: 100%;">
													<img v-else src="http://placehold.it/350x250" style="height: 230px;" class="img-responsive">

													<div class="file-upload position">
														<label for="file-input" class="bgc-green p-3 rounded-circle" style="cursor: pointer;width: 55px; height: 55px;" id="selectFile"  @click="selectFile">
															<i class="fa fa-upload text-white " aria-hidden="true"></i>
														</label>

														<input type="file" name="logo" ref="logo" id="chooseFile" v-on:change="logoChange" class="logo_update" style="display: none;" />
													</div>

												</div>
											</div>

									
											<div class="card cover-image mt-5">
												<div class="card-image">
													<a href="javascript:;" class="btn text-white bgc-green p-1 font-size-12 pl-5 pr-5 b-radius position-absolute mi-btn2">Cover</a>
													<img v-if="mainData.logo !=''" :src="$parent.BASE_API_PATH+'/uploads/'+mainData.cover" style="width:100%;height: 160px;object-fit: cover;">
													<img v-else src="http://placehold.it/1350x500" class="img-responsive">
													<div class="file-upload position">
														<label for="file-input" id="selectcover" @click="selectcover" class="bgc-green p-3 rounded-circle"  style="cursor: pointer;width: 55px; height: 55px;">
															<i class="fa fa-upload text-white " aria-hidden="true"></i>
														</label>
														<input type="file" name="cover" ref="cover" id="choosecover"  v-on:change="coverChange" style="display: none;" class="cover_update"> 
													</div>

												</div>
											</div>
									
								</form>



								<div class="gallery mt-5 mb-5">
									<vue-dropzone ref="myVueDropzone" id="dropzone" v-on:vdropzone-sending="sendingEvent" :options="dropzoneOptions"></vue-dropzone>
								</div>
								<div class="clearfix"></div>
								<div class="uploadImages row">
							
							<div class="col-md-4 col-6 mb-2 "  v-for="gal in gallery" :id="'gal'+gal.id">
								<div class="card">
									<div class="card-image">
										<img :src="$parent.BASE_API_PATH+'/uploads/'+gal.gallery"  data-caption="" class="materialboxed w-100" height="150">
										<div class="btn-group image-btn">
											<a href="javascript:;" @click="deleteImage(gal.id)" class="btn btn-xs btn-danger " ><i class="fa fa-trash"></i></a>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<h4 v-else style="text-align: center;margin-left: 50px;" class="text-success">No Images Uploaded</h4>
				

		<!-- GET QUOTES POPUP -->
	
				<div id="addModal" class="modal fade " role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<form action="" method="POST" id="addimages" enctype="multipart/form-data"  @submit.prevent="submit()">
								<div class="modal-header">
									<h4 class="modal-title text-success" id="addManagementLabel" >Add Images</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
								</div>
								<div class="modal-body">

									<div class="form-group row">
										<label for="name" class="col-sm-4 form-control-label">Logo Image<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											<input type="file" name="logo" ref="formlogo" v-on:change="handleFileUploads()" v-validate="'required'"  class="form-control">
											<span v-show="errors.has('logo')" class="text-danger">{{ errors.first('logo') }}</span>
										</div>
									</div>
									<div class="form-group row">
										<label for="title" class="col-sm-4 form-control-label">Cover Image<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											
											<input type="file" name="cover" ref="formcover" v-on:change="handleFileUpload()" v-validate="'required'"  class="form-control">
											<span v-show="errors.has('cover')" class="text-danger">{{ errors.first('cover') }}</span>

										</div>

									</div>
									<div class="modal-footer">
										<button type="submit" name="image" class="btn btn-success waves-effect waves-light" v-if="!submitted">Save</button>
										<button disabled="" class="btn btn-success waves-effect waves-light" v-else><i class="fa fa-spine fa-spinner"></i></button>
									</div>
								</div><!-- /.modal-content -->
							</form>
							
						</div><!-- /.modal-dialog -->
					</div>
				</div>

			</main>

			<VFooter></VFooter>
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
			editlogo:null,
			editcover:null,
			gallery: '',
			id: this.$route.params.id,
			mosque_id: this.$store.getters.getMosque.id,
			participants:'',
			image_id:'',
			error_message: "",
			error_message: "",
			has_error: false,
			submitted: false,
			loading: true,
			form:{
				mosque_id: this.$store.getters.getMosque.id,
				logo:null,
				cover:null,

			},
			dropzoneOptions: {
				url: this.$parent.API_PATH+'v1/save-gallery',
				headers: { "Authorization": this.$parent.Bearer,"X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content },
				dictDefaultMessage: 'Drag & Drop Image <br> <br> \
				<button for="file-input" class="btn btn-default text-success pr-4 pl-4" style="border:1px solid green;border-radius: 20px;">\
											<i class=" fa fa-upload " aria-hidden="true">&nbsp;</i> Click to Upload\
										</button>'
			}

		}
	},
	components: {
    vueDropzone: vue2Dropzone
  },

	beforeMount(){
		this.getData();
	},
	mounted(){
		this.runjs();
	},
	methods:{
		 sendingEvent (file, xhr, formData) {
        formData.append('mosque_id', this.mosque_id);
      },
		getData(){
			var dataUrl = 'v1/getImages/'+this.mosque_id;
			axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
				this.mainData = result.data.data.mainImage;
				this.image_id = this.mainData != null?this.mainData.id:'';
				this.gallery =  result.data.data.gallery;
				this.loading = false;
			}, error => {

			});           
		},


		handleFileUploads(){
			this.form.logo =  this.$refs.formlogo.files[0];
		},
		handleFileUpload(){
			this.form.cover =  this.$refs.formcover.files[0];
		},
		deleteImage(id){
			if(confirm('Are you sure')){
				axios({
					method: "GET",
					url: "/v1/delete-image/"+id,
					data:{},
					headers: { "content-type": "application/json" }

				}).then(  response => {
					var response = response.data;
					if (response.status) {		
					$('#gal'+id).hide('slow');	
						this.$parent.success_message = 'Image Deleted';		
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

			}
		},
		selectFile(){
			
			$("#chooseFile").click();
		},
		selectcover(){
			
			$("#choosecover").click();
		},
		coverChange(){
			this.editcover =  this.$refs.cover.files[0];
			this.editsubmit();
		},
		logoChange(){
			this.editlogo =  this.$refs.logo.files[0];
			
			this.editsubmit();
		},
		editsubmit(){
				var $this = this;
		let formData = new FormData();
		formData.append('image_id', this.image_id);
		formData.append('cover', this.editcover);
		formData.append('logo', this.editlogo);
		axios({
			method: "POST",
			url: "/v1/addImages",
			data: formData,
			headers: { "content-type": "application/json" }

		}).then(  response => {
			var response = response.data;
			if (response.status) {			
				this.mainData = response.data;
				this.image_id = this.mainData != null?this.mainData.id:'';
				this.$parent.success_message = 'Images Edited Successfully';		
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
		},
		submit(){
			var $this = this;
			this.submitted = true;
			this.$validator.validate().then(valid => {
				if (valid) {
					this.error_message = "";
					this.has_error = false;
					let formData = new FormData();
					for (var key of Object.keys(this.form)) {
						formData.append(key, this.form[key]);
					}
					axios({
						method: "POST",
						url: "/v1/addImages",
						data: formData,
						headers: { "content-type": "application/json" }

					}).then(  response => {
						var response = response.data;
						if (response.status) {			
							this.mainData = response.data;
							this.image_id = this.mainData != null?this.mainData.id:'';
							$('#addModal').modal('toggle');
							this.$parent.success_message = 'Images Added';	
							setTimeout(function() {
								$this.error_message = "";
								$this.has_error = false;
								$this.submitted = false;
							}, 5000);
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
		runjs(){

		}

	},



}
</script>
