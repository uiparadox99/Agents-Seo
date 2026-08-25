<template>
  	  <div class="panel panel-default">
                            <a  href="javascript:;" :data-id="'tool-screen-'+key+'-slot-'+screen.bgid"  v-on:click="handToggle(key,screen.bgid)">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-cog"></i> Layouts & Background <i :class="'fa fa-angle-down float-right angle-tool-screen-'+key+'-slot-'+screen.bgid"></i>
                                    </h4>
                                </div>
                            </a>
                            <div :id="'tool-screen-'+key+'-slot-'+screen.bgid" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <label>Screenshot Layout</label>
                                    <a href="javascript:;" class="layout-select-btn"  v-on:click="setLayoutIndex(key)"  data-toggle="modal" data-target="#layoutModel">
                                        <small>Layout Template</small>
                                        <p><span :id="'screen-layout-'+key">Dual Device Perpective - Title Top</span> <i class="fa fa-columns float-right"></i></p>
                                    </a>

                                    <label>Background Image</label>
                                    <div v-if="screen.TemplatebackgroundImage != ''">
                                        <div class="mt-2 mb-3 backgroundPreview">
                                            <img :src="screen.TemplatebackgroundImage" style="height:100px">
                                        </div>

                                        <div class="row">

                                            <div class="col-6 pr-1">
                                             <div class="cus-select">
                                                <span>Sizing</span>
                                                <select :id="'bgsizing-tool-screen-'+key" :name="'bgsizing-tool-screen-'+key" v-model="screen.bgSize">
                                                    <option value="contain">Contain</option>
                                                    <option value="cover">Cover - Anchor Ccnter</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1" v-if="screen.bgSize != 'cover'">
                                            <div class="cus-select">
                                                <span>Image Position</span>
                                                <select :id="'bgpostion-tool-screen-'+key" :name="'bgpostion-tool-screen-'+key" v-model="screen.bgPosition">
                                                    <option value="bottom">Bottom</option>
                                                    <option value="center">Middle</option>
                                                    <option value="top">Top</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="cus-select">
                                        <span>Image rotation</span>
                                        <select :id="'bgrotation-tool-screen-'+key" :name="'bgrotation-tool-screen-'+key" v-model="screen.bgRotation">
                                            <option value="0">None</option>
                                            <option value="90">90*</option>
                                            <option value="180">180*</option>
                                            <option value="270">270*</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display:inline-block">
                                    <a href="javascript:;"  v-on:click="setBgIndex(key)" data-toggle="modal" data-target="#bgModel" :data-screen="key" :data-slot="screen.bgid" class="bg-select-btn">
                                        <i class="fa fa-image"></i> Select New Background
                                    </a>  
                                </div>
                                    <div style="display:inline-block">
                                         <a href="javascript:;"  v-on:click="clearbgImage(key)" v-if="screen.TemplatebackgroundImage != ''" class="text-danger ml-2"><i class="fa fa-times"></i> &nbsp; Clear</a>
                                    </div>
                                    
                                    <label>Background Style</label>

                                     <div class="cus-select">
                                        <span>Background style</span>
                                        <select :id="'bgstyle-tool-screen-'+key" :name="'bgstyle-tool-screen-'+key"  v-on:click="changeBgStyle(key)">
                                            <option value="none">None</option>
                                            <option value="color" v-if="screen.backgroundColor != '#ffffff' && screen.backgroundColor.length <= 7" selected>Color</option>
                                            <option value="color" v-else>Color</option>
                                            <option value="gradient">Gradient</option>
                                        </select>
                                    </div>
                                    <div :id="'color-picker-'+key"  class="background-color-picker" v-bind:style="[screen.backgroundColor == '#ffffff' ? {display: 'none'} : {display: 'none'} ]">
                                        <div class="row">
                                            <div class="col-5 pr-2">
                                                <div class="check-color" :style="'background:'+screen.backgroundColor" data-toggle="modal" :data-target="'#colorPicker'+key">
                                                    
                                                </div>
                                            </div>
                                              <div class="col-7 pl-0">
                                                 <span>Background style color - Hex</span>
                                                 <input type="text" v-model="screen.backgroundColor">
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
                                                             <color-panel v-model="screen.backgroundColor"></color-panel>
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
                                      <div :id="'gradient-picker-'+key"  class="background-color-picker" v-bind:style="[screen.backgroundColor == '#ffffff' ? {display: 'none'} : {display: 'none'} ]">
                                        <div class="check-color" :style="'background:'+screen.backgroundColor" data-toggle="modal" :data-target="'#gradientPicker'+key">
                                                    
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
                                                            <button type="button" class="text-success btn-none float-right" v-on:click="setBgGradient(key)">Save</button>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                       
                                    </div>

                                </div>
                            </div>
                        </div>
</template>

<script>
export default {
	props: ['screen'],
  	data(){
		return{
		}
	},
		
	beforeMount(){
		

	},
}
</script>