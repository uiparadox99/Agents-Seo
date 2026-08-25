<template>
  <div>
  	<div class="modal" id="bgModel" style="z-index: 15509999999999;">
  		<div class="modal-dialog">
  			<div class="modal-content">

  				<!-- Modal Header -->
  				<div class="modal-header">
  					<h4 class="modal-title"></h4>
  					<button type="button" class="close" onclick="$('#bgModel').hide()" data-dismiss="modal">&times;</button>
  				</div>

  				<!-- Modal body -->
  				<div class="modal-body">
  				  <ul class="nav nav-tabs" role="tablist">
  				  	<li class="nav-item">
  				  		<a class="nav-link active" data-toggle="tab" href="#yourImages">Your Images</a>
  				  	</li>
  				  	<li class="nav-item">
  				  		<a class="nav-link" data-toggle="tab" href="#addimage">Add Image</a>
  				  	</li>
  				  </ul>

  				  <!-- Tab panes -->
  				  <div class="tab-content">
  				  	<div id="yourImages" class=" tab-pane active"><br>
  				  		<h3 class="text-center">Images</h3>

  				  		<div v-if="$parent.imagesLoader" class="loader" >
  				  			 <i class="fa fa-spinner fa-spin"></i>
  				  		</div>
  				  		<div class="background-images-list" v-else>
  				  			<div v-if="$parent.imageModelType == 'bg'" v-for="bg in $parent.userBackgrounds" class="image-box"    :id="'bg-'+bg.id">
  				  				<a href="javascript:;" class="bg-delete-btn" v-on:click="$parent.deleteUserImage(bg.id)"><i class="fa fa-times"></i></a>
  				  				<img :src="bg.image" v-on:click="$parent.setBg(bg.image)">
  				  			</div>
  				  			<div v-if="$parent.imageModelType == 'image'" v-for="img in $parent.userImages" class="image-box"    :id="'img-'+img.id">
  				  				<a href="javascript:;" class="bg-delete-btn" v-on:click="$parent.deleteUserImage(img.id)"><i class="fa fa-times"></i></a>
  				  				<img :src="img.image" v-on:click="$parent.setImageSlot(img.image)">
  				  			</div>
  				  		</div>
  				  	</div>
  				  	<div id="addimage" class=" tab-pane fade"><br>
  				  		<div v-if="$parent.addImageLoader" class="loader" >
  				  			 <i class="fa fa-spinner fa-spin"></i>
  				  		</div>
  				  		<div class="row" v-else>
  				  			<div class="col-md-6 pr-2">
  				  				<div class="add-image-box">
  				  					<h2>Add from File</h2>
  				  					  <input type="file"   ref="file" name="img" id="yourfile"  v-on:change="handleFileUploads()"  style="display:none">
  				  					<div class="text-center">
  				  						<button v-on:click="clickOnFile"> Add from file <i class="fa fa-image"></i></button>
  				  					</div>
  				  				</div>
  				  			</div>
  				  			<div class="col-md-6 pl-2">
  				  				<div class="add-image-box">
  				  					<h2>Import from URL</h2>
  				  					  <input name="importUrl" v-model="$parent.importUrl" placeholder="URL">
  				  					<div class="text-center">
  				  						<button v-on:click="$parent.addUserNewImage"> Add from file <i class="fa fa-image"></i></button>
  				  					</div>
  				  				</div>
  				  			</div>
  				  		</div>
  				  	</div>
  				  </div>
  				</div>

  				<!-- Modal footer -->
  				<div class="modal-footer">
  					<button type="button" class="text-danger btn-none" onclick="$('#bgModel').hide()" data-dismiss="modal">Close</button>
  				</div>

  			</div>
  		</div>
  	</div>
  </div>
</template>

<script>
export default {
  	data(){
		return{
      mainData: '',
      nameData:'',
		nameLength:'',
		}
	},
		
	beforeMount(){

	},

	methods:{
		clickOnFile(){
			$("#yourfile").click();
		},
		handleFileUploads(){
			this.$parent.newUserImage =  this.$refs.file.files[0];
			this.$parent.addUserNewImage();
		}
	},
}
</script>