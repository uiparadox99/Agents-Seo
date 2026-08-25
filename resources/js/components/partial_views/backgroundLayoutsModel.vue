<template>
  <div>
  	<div class="modal" id="layoutModel">
  		<div class="modal-dialog">
  			<div class="modal-content">

  				<!-- Modal Header -->
  				<div class="modal-header">
  					<h4 class="modal-title">Layout Selector</h4>
  					<button type="button" class="close" data-dismiss="modal">&times;</button>
  				</div>

  				<!-- Modal body -->
  				<div class="modal-body">
  					<div class="layout-box blank" v-on:click="$parent.setBlankLayout('Blank')">
  						
  					</div>
  				 <div v-for="lay in this.$parent.layouts" class="layout-box"   v-on:click="$parent.setLayout(lay.psd_data,lay.title)">
  				 	 <img :src="lay.preview_image">
  				 </div>
  				</div>

  				<!-- Modal footer -->
  				<div class="modal-footer">
  					<button type="button" class="text-danger btn-none" data-dismiss="modal">Close</button>
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
      blankData:'',
		}
	},
		
	beforeMount(){
		

	},
}
</script>