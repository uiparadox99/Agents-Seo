<template>
	<div>
		<div class="modal screenshotsmodel" id="reorderScreenShots">
			<div class="modal-dialog" style="max-width:90vw;min-height:50vh">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Reorder Screenshots</h4>

						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
					<draggable v-model="$parent.screens" group="people" @start="drag=true" @end="drag=false" class="m-0" @change="$parent.sorted">
						 <div v-for="(screen,screenKey) in $parent.screens" :key="screenKey" class="screen-box"> 
						   <img :src="screen.TemplateImageUrl" style="width:100%;">
						</div>
					</draggable>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class=" btn-none" data-dismiss="modal">Close</button>
						<button type="button" class="text-success btn-none float-right"  data-dismiss="modal">Save</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
	data(){
		return{
			mainData: '',
			nameData:'',
			nameLength:'',
		}
	},
	components: {
            draggable,
        },
	beforeMount(){

	},

	methods:{
	},
}
</script>