<template>
	<div>
		<div class="modal copysettingsmodal" id="introModel">
			<div class="modal-dialog" style="max-width:40vw;min-height:50vh">
				<div class="modal-content" style="    overflow-y: hidden;">

					<!-- Modal Header -->
					<div class="modal-header">
<!-- 						<h4 class="modal-title">Copy Screenshot Settings</h4> -->

						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
						<div v-if="stepcount == 1" class="text-center">
							<div class="intro-icon"><i class="fa fa-desktop"></i></div>
							<h3>Quick Hints & Tips</h3>
							<p>Here are a few quicks hints and tips to get you started!</p>
						</div>
						<div v-if="stepcount == 2" class="text-center">
							<div class="intro-icon"><i class="fa fa-exchange-alt"></i></div>
							<h3>Low Quality Display?</h3>
							<p>Please note that the editor is displayed at <b>Lower Quality</b>. Only when you <b>export your project</b> will you receive the crispest quality screenshots!</p>
						</div>
						<div v-if="stepcount == 3" class="text-center">
							<div class="intro-icon"><i class="fa fa-download"></i></div>
							<h3>Export Results</h3>
							<p>To view your progress or export your screenshots ready for upload, <br><b>"Preview & Export"</b></p>
						</div>
						<div v-if="stepcount == 4" class="text-center">
							<div class="intro-icon"><i class="fa fa-map-marker-alt"></i></div>
							<h3>Translations & Localization</h3>
							<p>You can export your project into over <b>35 languages.</b> Whilst exporting,  select the relevant languages and watch the magic happen.</p>
						</div>
						<div v-if="stepcount == 5" class="text-center">
							<div class="intro-icon"><i class="fa fa-comments"></i></div>
							<h3>Question or Issues?</h3>
							<p>Please ping us a message in the chat window, or via email at <br> <b class="text-success">support@appscreens.com</b></p>
						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class=" btn-none" data-dismiss="modal" v-on:click="setintro('1')">Skip</button>
					
							<ul class="bottom-dots">
								<li v-on:click="setstep(1)" class="intro-dot" v-bind:class="{'active': stepcount == 1}" ></li>
								<li v-on:click="setstep(2)" class="intro-dot" v-bind:class="{'active': stepcount == 2}" ></li>
								<li v-on:click="setstep(3)" class="intro-dot" v-bind:class="{'active': stepcount == 3}" ></li>
								<li v-on:click="setstep(4)" class="intro-dot" v-bind:class="{'active': stepcount == 4}" ></li>
								<li v-on:click="setstep(5)" class="intro-dot" v-bind:class="{'active': stepcount == 5}" ></li>
							</ul>
				
						<button type="button" class=" btn-none float-right" v-on:click="setintro('1')" v-if="stepcount == 5"><b>Done</b></button>
						<button class="text-success btn-none float-right" v-on:click="movetonext" v-else><b>Next</b></button>
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
			stepcount:1,
		}
	},
	mounted(){

	},

	methods:{
		setstep(c){
			this.stepcount = c;
		},
		movetonext(){
			this.stepcount = parseInt(parseInt(this.stepcount) + 1);
			this.$forceUpdate();
		},
		setintro(status){

			this.$store.commit('set_intro', status);
			 $('#introModel').modal('hide');
			 $('.modal-backdrop').remove();
		}
	},
}
</script>