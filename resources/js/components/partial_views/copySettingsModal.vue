<template>
	<div>
		<div class="modal copysettingsmodal" id="copySettingsModal">
			<div class="modal-dialog" style="max-width:600px;min-height:auto">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Copy Screenshot Settings</h4>

						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
						<br>
						<div class="row">
							<div class="col-md-3">
								<b>Copy from</b>
							</div>
							<div class="col-md-9">
								<select class="form-control" v-model="copy_from">
									<option v-for="(screen,key) in $parent.screens" :value="key">Screenshot {{count(key)}}</option>
								</select>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">
								<b>Copy to</b>
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-6" v-for="(screen,key) in $parent.screens" v-if="key != copy_from">
										<label><input type="checkbox" name="screenshot" value="1" v-model="copy_to[key]"> Screenshot {{count(key)}}</label>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-3">
								<b>Copy Settings</b>
							</div>
							<div class="col-md-9">
								<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.all"> All</label>
								<hr>
								<div v-if="!settings.all">
									<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.elements"> Elements & Layout</label>
									<hr>
									<div class="row">
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.background_settings"> Background Settings</label>
										</div>
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.all_text"> All Text</label>
										</div>
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.text_styles"> Text Styles</label>
										</div>
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.device_style"> Device style</label>
										</div>
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.device_screenshots"> Device screenshots</label>
										</div>
										<div class="col-md-6">
											<label class="mb-0"><input type="checkbox" name="screenshot" value="1" v-model="settings.device_type"> Device type</label>
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
						<button type="button" class="text-success btn-none float-right" v-on:click="copySettings">Copy</button>
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
			copy_from:this.$parent.currentScreen,
			copy_to: {},
			settings:{
				all:0,
				elements:0,
				background_settings:0,
				all_text:0,
				text_styles:0,
				device_style:0,
				device_screenshots:0,
				device_type:0,
			},
			nameData:'',
			nameLength:'',
		}
	},
	mounted(){

	},

	methods:{
		autoSelectScreen(){
			this.copy_from = this.$parent.currentScreen;
			this.$forceUpdate();
		},
		count(c){
			return c + 1;
		},
		copySettings(){

			var notanycopyto = 0;
			$.each(this.copy_to, function(copky, copyto){
				if (copyto) {
					notanycopyto = 1;
				}
			});
			if (!notanycopyto) {
				this.$alert("You must select at least one screenshot to copy settings to",'Error','error');
				return false
			}
			var notanysetting = 0;
			$.each(this.settings, function(seky, setting){
				if (setting) {
					notanysetting = 1;
				}
			});
			if (!notanysetting) {
				this.$alert("You must select at least one setting type to copy",'Error','error');
				return false
			}
			var from = this.$parent.screens[this.copy_from];
			var mthis = this;
			$.each(this.copy_to, function(toKey, to){
				$('#screen-loader-'+toKey).show();
			})
			 var screens = [];
			$.each(this.$parent.screens, function(screenKey, screen){
				if (typeof mthis.copy_to[screenKey]  !== 'undefined' && mthis.copy_to[screenKey]) {
					if (mthis.settings.all) {
						screen = from;
					}else{
						if (mthis.settings.elements) {
							screen.slots = from.slots;
						}
						if (mthis.settings.background_settings) {
							screen.TemplatebackgroundImage = from.TemplatebackgroundImage;
							screen.bgSize = from.bgSize;
							screen.bgPosition = from.bgPosition;
							screen.bgRotation = from.bgRotation;
							screen.backgroundColor = from.backgroundColor;
						}
						if (mthis.settings.all_text) {
								$.each(screen.slots, function(slotKey, slot){
									if (slot.type == 'text') {
										$.each(from.slots, function(fromslotKey, fromslot){
											if (fromslot.type == 'text') {
												slot.SlotType = fromslot.SlotType;
											}
										})
									}
								})
						}
						if (mthis.settings.text_styles) {
								$.each(screen.slots, function(slotKey, slot){
									if (slot.type == 'text') {
										$.each(from.slots, function(fromslotKey, fromslot){
											if (fromslot.type == 'text') {
												slot.TextPostion = fromslot.TextPostion;
												slot.FontName = fromslot.FontName;
												slot.TextCenter = fromslot.TextCenter;
												slot.fontSize = fromslot.fontSize;
												slot.latterSpacing = fromslot.latterSpacing;
												slot.lineBreak = fromslot.lineBreak;
												slot.lineHeight = fromslot.lineHeight;
												slot.shadow = fromslot.shadow;
											}
										})
									}
								})
						}
						if (mthis.settings.device_style) {
								$.each(screen.slots, function(slotKey, slot){
									if (slot.type == 'image' && slot.SlotType.includes('frame')) {
										$.each(from.slots, function(fromslotKey, fromslot){
											if (fromslot.type == 'image'  && fromslot.SlotType.includes('frame')) {
												slot.deviceStye = fromslot.deviceStye;
											}
										})
									}
								})
						}
						if (mthis.settings.device_type) {
								$.each(screen.slots, function(slotKey, slot){
									if (slot.type == 'image' && slot.SlotType.includes('frame')) {
										$.each(from.slots, function(fromslotKey, fromslot){
											if (fromslot.type == 'image'  && fromslot.SlotType.includes('frame')) {
												slot.deviceType = fromslot.deviceType;
												slot.imgRoation = fromslot.imgRoation;
											}
										})
									}
								})
						}
						if (mthis.settings.device_screenshots) {
								$.each(screen.slots, function(slotKey, slot){
									if (slot.type == 'image' && slot.SlotType.includes('inner')) {
										$.each(from.slots, function(fromslotKey, fromslot){
											if (fromslot.type == 'image'  && fromslot.SlotType.includes('inner')) {
												slot.SlotImageUrl = fromslot.SlotImageUrl;
													$.each(mthis.$parent.devices, function(dKey, device){
														if (typeof fromslot[dKey] !== 'undefined') {
															slot[dKey] = fromslot[dKey];
														}
													})
											}
										})
									}
								})
						}
					}
				}
				screens.push(screen);
			})
			  $('#copySettingsModal').modal('hide');
               $('.modal-backdrop').remove();
			setTimeout(function(){  
				mthis.$parent.screens = screens;
				mthis.$forceUpdate();
				mthis.$parent.$forceUpdate();
				$.each(mthis.copy_to, function(toKey, to){
					$('#screen-loader-'+toKey).hide();
				})
			}, 3000);
			


		}
	},
}
</script>