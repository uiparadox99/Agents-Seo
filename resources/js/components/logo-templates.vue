<template>
	<div>
		<VGHeader class="inner-nav"></VGHeader>
		<main class="overflow-hidden position-relative container-fluid" style="padding: 30px;margin:150px 0;">
			<div class="row mb-5">
				<div class="col-md-6 offset-md-3 text-center">
					<b class="text-success">Perfect design, For you</b>
					<h1>Templates & Inspiration</h1>
					<h5>Select from our stuning range of inpirational templates </h5>
					<!-- <div class="row mt-3">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="cus-select">
								<span style="top: 0;left: 0;color: #a8a8a8;font-size: 11px;">Orientation</span>
								<select  v-model="form.orientation" style="padding: 15px 0px 5px 0px;background: #ffffff;height: 46px;">
									<option value="all">All</option>
									<option value="portrait">Portrait</option>
									<option value="landscape">Landscape</option>
								</select>
							</div>
						</div>
						<div class="col-2 pl-0" style="text-align:left">
							<label style="display: block;margin-top: 15px;"><input type="checkbox" name="free_only" v-model="form.paid" value="1"> Free only</label>
						</div>
					</div> -->
				</div>
			</div>
			<div class="row">


			<div v-for="(item, $index) in templates" :key="$index" class="template-preview-box col-md-4">

				<!-- <h3 v-if="paid == 1">Template {{getTempCount($index)}} | {{item.title}} <button class="btn btn-success float-right" @click="open(item.id)">Open in playground</button></h3> -->
				<h3 >{{item.title}} <button class="btn btn-success float-right" @click="open(item.id)">Edit</button></h3>
			
				<img :src="item.main_image" @click="open(item.id)">
			</div>
						</div>
		<infinite-loading @infinite="getTemplates"></infinite-loading>	
		</main>
		<VFooter class="inner-footer"></VFooter>
	</div>
</template>


<script>
import InfiniteLoading from 'vue-infinite-loading';
export default {
	components: { InfiniteLoading },
	data(){
		return{
			templates:[],
			tCount:1,
			fCount:0,
			form:{
				orientation:'all',
				paid:0,
			},
			error_message: "",
			has_error: false,
			loading: true,
			page:1,
		}
	},
	mounted(){
          /* this.getTemplates();*/
			
		  if(typeof this.$route.query.calendar_image != 'undefined' && this.$route.query.calendar_image != ''){
			  this.$store.commit('set_calendarImage',this.$route.query.calendar_image);
		  }
       },
	methods:{
		getTempCount(count){
			return count + 1;
		},
		open(id){
			  this.$store.commit('set_playChange',true);
			  this.$store.commit('set_openInPlayground',id);
			  this.$router.push({path: '/playground'});
		},
		 getTemplates($state){
               var dataUrl = '/get-templates-list?page='+this.page;
               axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                   this.loading = false;
                    var templatesdata = result.data.data;
                    if (templatesdata.length) {
                    	this.page += 1;
                    	this.templates.push(...templatesdata);
                    	$state.loaded();
                    } else {
                    	$state.complete();
                    }
                
               }, error => {
   
               });           
           },

	},
}
</script>

