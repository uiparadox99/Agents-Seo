<template>
    <div>
         <VGHeader class="inner-nav"></VGHeader>
         <vue-confirm-dialog></vue-confirm-dialog>
         <main class="inner-main">
         <section class="edit-top-bar">

                <div class="bar-blocks left">
                     <a @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back </a>
                     &nbsp;
                     <a href="javascript:;" class="btn btn-danger cm-btn"><i class="fa fa-save"></i> Save now</a>
                     <a href="javascript:;" class="btn cm-btn"><i class="fa fa-cog"></i> Setup</a>
                     <a href="javascript:;" class="btn cm-btn"><i class="fa fa-image"></i> Panoramic</a>
                     <a href="javascript:;" class="btn cm-btn" data-toggle="modal" data-target="#screenShots" ><i class="fa fa-camera"></i> Screenshots</a>
                     <a href="javascript:;" class="btn cm-btn"><i class="fa fa-exchange-alt"></i> Reorder</a>
                     <a href="javascript:;" class="btn cm-link ml-1"><i class="fa fa-question-circle"></i>Help</a>
                     <a href="javascript:;" class="btn cm-link ml-1 text-danger"><i class="fa fa-lock"></i> Pro required **</a>
                </div>
                <div class="bar-blocks  right">
                    <div class="align-right">
                         <div class="phone-select">
                            <i class="fa fa-mobile-alt"></i>
                            <select v-model="currentyDevice" v-on:change="changeDevice">

                                <option v-for="(d,index) in devices" :value="index" >{{d.name}}</option>
                            </select>
                          
                        </div> &nbsp;  &nbsp; 
                        <a href="javascript:;" class="btn download-btn"><i class="fa fa-download"></i> Preview & Export</a>
                        <a href="javascript:;" class="btn  restore-btn"><i class="fa fa-redo"></i></a>

                    </div>
                </div>
            
         </section>
         <section class="screens"  id="screenWraper"  v-if="screens != ''">
      
            <div  v-for="(screen, key) in screens"  class="single-screen-wraper" :id="key" >
                <div :class="'box single-screen screen-'+key" :ref="'screen-'+key" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:relative;'"  @mouseover="mouseOver(key)" v-on:mouseleave="mouseLeave(key)" v-on:contextmenu="openMenu(key)" >
                 <ul :id="'right-click-menu-'+key" tabindex="-1" v-el="right" class="screen-right-menu"  style="display:none">
                    <li>
                        <a href="javascript:;" v-on:click="saveScreen(key)"><i class="fa fa-save"></i> Save</a>
                    </li>
                    <li>
                        <a href="javascript:;" v-on:click="refreshScreen(key)"><i class="fa fa-redo"></i> Refresh</a>
                    </li>
                    <li>
                        <a href="javascript:;" v-on:click="duplicateScreen(key)"><i class="fa fa-copy"></i> Duplicate</a>
                    </li>
                    <li>
                        <a href="javascript:;" v-on:click="ScreenDownload(key)"><i class="fa fa-download"></i> Download </a>
                    </li>
                    <li>
                        <a href="javascript:;" v-on:click="copyScreeSetting(key)"><i class="fa fa-exchange-alt"></i> Copy Settings</a>
                    </li>
                    <li>
                        <a href="javascript:;" v-on:click="removeScreen(key)"><i class="fa fa-trash text-danger"></i> Delete</a>
                    </li>
                </ul>
                    <div class="screen-loader" :id="'screen-loader-'+key" style="display:none"><img src="/screen-loader.svg"></div>
                    <div class="edit-btn" :class="'edit-screen-'+key"  v-on:click="toolbartoggle(key)"><i class="fa fa fa-pencil-alt"></i></div>
                    <div :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.backgroundColor+';border-radius: 25px;'" :id="'screen-'+key+'-slot-'+screen.bgid"   v-on:click="selectSlot(key,'0',screen.bgid)">
                        <img :src="screen.TemplatebackgroundImage" :style="'width:'+screen.width+'px;height:'+screen.height+'px;border-radius: 25px;object-fit:'+screen.bgSize+';  transform: rotate('+screen.bgRotation+'deg);object-position:'+screen.bgPosition" class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                    </div>



                 <!--    <div v-for="slot in screen.slots" v-if="slot.type == 'text'" :style="'position:absolute;z-index:999;width:'+slot.slotWidth+'px;top:'+slot.top+'px;left:'+slot.left+'px;color:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');font-size:'+slot.fontSize+'pt;font-family:'+slot.FontName+';text-align:'+slot.TextCenter+';    line-height: 80px;'" class="text-slot"  v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="text" :data-order="slot.orderNumber"> transform: rotateY(20deg) translate(0px, 0px) rotateZ(0deg) rotate3d(10, 10, 10, 0deg);-->
                    <div v-for="(slot,slotKey) in screen.slots" v-if="slot.type == 'text'" :style="'position:absolute;z-index:999;width:100%;top:'+slot.top+'px;left:0px;color:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');font-size:'+slot.fontSize+'pt;font-family:'+slot.FontName+';text-align:'+slot.TextCenter+';    line-height: 80px;padding:0 10px'" :data-width="slot.slotWidth" class="text-slot"  v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="text" :data-order="slot.orderNumber" :id="'parentText-screen-'+key+'-slot-'+slot.slotid">
                        <div :style="'line-height: '+slot.lineHeight+'%;text-align:'+slot.TextCenter+';letter-spacing:'+slot.latterSpacing+'pt; display: inline-block;font-size:'+slot.fontSize+'pt;white-space:'+slot.lineBreak+'; vertical-align: '+slot.TextPostion+';text-shadow:'+slot.shadow" :id="'screen-'+key+'-slot-'+slot.slotid"><p v-html="slot.SlotType"></p></div>
                    </div>

                      <div v-for="(slot,slotKey) in screen.slots"  v-if="typeof slot.subtitle != 'undefined' && slot.subtitle != null" :style="'position:absolute;z-index:999;width:100%;top:'+slot.subtitle.subtitle_top+'px;left:0px;color:rgb('+slot.subtitle.TextColor_RED+','+slot.subtitle.TextColor_GREEN+','+slot.subtitle.TextColor_Brown+');font-size:'+slot.subtitle.subtitle_fontSize+'pt;font-family:'+slot.subtitle.subtitle_FontName+';text-align:'+slot.subtitle.subtitle_TextCenter+';    line-height: 80px;padding:0 10px'" class="text-slot" v-on:click="selectSlot(key,slotKey,slot.slotid)"  data-type="subitle" :data-order="slot.orderNumber" :id="'parentText-screen-'+key+'-slot-subtitle'+slot.slotid">
                        <div :style="'line-height: '+slot.subtitle.subtitle_lineHeight+'%;text-align:'+slot.subtitle.subtitle_TextCenter+';letter-spacing:'+slot.subtitle.subtitle_latterSpacing+'pt;margin-top:'+slot.subtitle.subtitle_margin_top+'%; display: inline-block;font-size:'+slot.subtitle.subtitle_fontSize+'pt;white-space:'+slot.subtitle.subtitle_lineBreak+'; vertical-align: '+slot.subtitle.TextPostion+';text-shadow:'+slot.subtitle.subtitle_shadow" :id="'screen-'+key+'-slot-subtitle'+slot.slotid"><p>{{slot.subtitle.subTitleText}}</p></div>
                    </div>
                    <div v-for="(slot, slotKey) in screen.slots"  v-if="slot.type != 'text'"  :style="'transform: '+slot.slotRoation+';position:absolute;box-shadow:'+slot.shadow+';z-index:'+slot.zIndex+';width:'+slot.slotWidth+'px;top:'+slot.top+'px;left:'+slot.left+'px;perspective: 500px;display:'+slot.display" class="image-slot" :id="'screen-'+key+'-slot-'+slot.SlotType" v-on:click="selectSlot(key,slotKey,slot.SlotType.replace('inner','frame'))" data-type="image">
                        <img :src="slot[currentyDevice]" :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-if="!slot.SlotType.includes('frame') && typeof slot[currentyDevice] != 'undefined' && slot[currentyDevice] != ''" >
                        <img :src="slot['global']"  :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="!slot.SlotType.includes('frame') && typeof slot['global'] != 'undefined' && slot['global'] != ''">
                        <img :src="slot.SlotImageUrl"  :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl != ''">

                        <img :src="devices[currentyDevice].colors[slot.deviceStye].url"  :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="slot.SlotType.includes('frame')">
                    </div>
                </div>
                 <div :class="'tool-box hideAllTool hideit tool-screen-'+key" style="width:380px;position:relative;">
                    <div class="tool-header">
                        <ul>
                            <li>
                                <a href="javascript:;" v-on:click="toolbartoggle(key)"><i class="fa fa-check"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="refreshScreen(key)"><i class="fa fa-redo"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="duplicateScreen(key)"><i class="fa fa-copy"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="ScreenDownload(key)"><i class="fa fa-download"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="copyScreeSetting(key)"><i class="fa fa-exchange-alt"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="toolPanelLock(key)" :class="'tool-lock-btn-'+key"><i class="fa fa-unlock"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" v-on:click="removeScreen(key)"><i class="fa fa-trash text-danger"></i></a>
                            </li>
                        </ul> 
                    </div>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <a  href="javascript:;" :data-id="'tool-screen-'+key+'-slot-'+screen.bgid"  v-on:click="handToggle(key,'0',screen.bgid)">
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

                        <div class="panel panel-default" v-for="(slot , slotKey) in screen.slots" v-if="slot.type == 'text'">
                            <a  href="javascript:;" :data-id="'tool-screen-'+key+'-slot-'+slot.slotid"  v-on:click="handToggle(key,slotKey,slot.slotid)">
                                <div class="panel-heading">
                                    <h4 class="panel-title" v-if="slot.type == 'text'">
                                        <i class="t-icon">T<small>T</small></i> Title <span v-if="typeof slot.subtitle != 'undefined' && slot.subtitle != null">& Subtitle</span> <i :class="'fa fa-angle-down float-right angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                    </h4>
                                </div>
                            </a>
                            <div :id="'tool-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-6 pr-1">
                                            <div class="cus-select">
                                                <span>Include Subtitle</span>
                                                <select :id="'addsubtitle-tool-screen-'+key+'-slot-'+slot.slotid" :name="'addsubtitle-tool-screen-'+key+'-slot-'+slot.slotid" @change="includeSubtitle(key,slotKey,slot.slotid)">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1">
                                         <div class="cus-select">
                                            <span>Floating Position</span>
                                            <select :id="'titlefloatposition-tool-screen-'+key+'-slot-'+slot.slotid" :name="'titlefloatposition-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.TextPostion">
                                                <option value="bottom">Bottom</option>
                                                <option value="middle" selected="">Middle</option>
                                                <option value="top">Top</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row" v-if="typeof slot.subtitle != 'undefined' && slot.subtitle != null">
                                        <div class="col-6 pr-1">
                                            <div class="cus-select">
                                                <span>Title  Ratio (title v subtitle)</span>
                                                <strong class="addon">%</strong>
                                                <input type="number" min="0" :id="'titlevsubtitle-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'titlevsubtitle-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.subtitle.subtitle_margin_top" @change="titleVsubtitleRatio(key,slotKey,slot.slotid)">
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1">
                                         <div class="cus-select">
                                            <span>Title to Subtitle Padding</span>
                                             <strong class="addon">%</strong>
                                             <input type="number" min="0" :id="'subtitlemargintop-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'subtitlemargintop-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.subtitle.subtitle_margin_top" @change="updateSubtitleData(key,slotKey,slot.slotid)">
                                        </div>
                                    </div>
                                </div>
                                 <div v-if="typeof slot.subtitle != 'undefined' && slot.subtitle != null">
                                      
                                    <div class="panel panel-default shadow-panel mb-3">
                                        <a  href="javascript:;" :data-id="'title-panel-screen-'+key+'-slot-'+slot.slotid"  v-on:click="innerPanelToggle('title-panel-screen-'+key+'-slot-'+slot.slotid,'title-panel-angle-tool-screen-'+key+'-slot-'+slot.slotid)">
                                            <div class="panel-heading">
                                                <h4 class="panel-title" v-if="slot.type == 'text'">
                                                    <i class="t-icon">T</i> Title Settings <i :class="'fa fa-angle-down float-right title-panel-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                                </h4>
                                            </div>
                                        </a>
                                        <div :id="'title-panel-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                            <div class="panel-body mb-0">
                                                <div class="editor mb-3">
                                                  <quill-editor :data-slotkey="slotKey" :data-screenkey="key" :data-slotid="slot.slotid" :id="'tool-screen-'+key+'-slot-'+slot.slotid"
                                                  :options="editorOption" @focus="setSlotHeight(key,slotKey,slot.slotid)" 
                                                  @change="onEditorChange($event)" :content="slot.SlotType"/>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-6 pr-1">
                                                        <div class="cus-select">
                                                            <span>Font Family</span>
                                                            <select v-model="slot.FontName" :id="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" :name="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" >
                                                                <option v-for="f in fonts" :value="f.font" :style="'font-family:'+f.font">{{f.font}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                       <div class="cus-select">
                                                            <span>Text Align</span>
                                                            <select :id="'textalign-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textalign-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.TextCenter" >
                                                                <option value="center">Center</option>
                                                                <option value="left">Left</option>
                                                                <option value="right">Right</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label><b>Text Size</b></label>
                                                 <div class="row ">
                                                    <div class="col-12 " :id="'main-textsizematch-tool-screen-'+key+'-slot-'+slot.slotid">
                                                        <div class="cus-select">
                                                            <span>Match size</span>
                                                            <select :id="'textsizematch-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textsizematch-tool-screen-'+key+'-slot-'+slot.slotid" @change="textSizeType('textsizematch-tool-screen-'+key+'-slot-'+slot.slotid,'maunalFont-tool-screen-'+key+'-slot-'+slot.slotid)">
                                                                <option value="match">Match Title Size ({{parseFloat(slot.fontSize).toFixed(2)}}pt)</option>
                                                                <option value="manual">No - Manual Control</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1" :id="'maunalFont-tool-screen-'+key+'-slot-'+slot.slotid" style="display:none">
                                                       <div class="cus-select">
                                                            <span>Max Font Size</span>
                                                            <strong class="addon">pt</strong>
                                                            <input type="number" :id="'textsize-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textsize-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.fontSize" @change="resizeSubtitleTop(key,slotKey,slot.slotid)">
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="row form-group">
                                                    <div class="col-6 pr-1">
                                                        <div class="cus-select">
                                                            <span>Added Letter Spacing</span>
                                                            <strong class="addon">pt</strong>
                                                            <input type="number" :id="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" :name="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.latterSpacing">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                     <div class="cus-select">
                                                            <span>Line Breaking</span>
                                                            <select :id="'linebreak-tool-screen-'+key+'-slot-'+slot.slotid" :name="'linebreak-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineBreak" @change="setwrap(key,slotKey,slot.slotid)">
                                                                <option value="normal">Break</option>
                                                                <option value="nowrap">Single Line</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cus-select">
                                                    <span>Line Height</span>
                                                    <strong class="addon">%</strong>
                                                    <input type="number" :id="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" :name="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineHeight">
                                                </div>
                                                <div class="panel panel-default shadow-panel">
                                                    <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.slotid"  v-on:click="handShowBoxToggle(key,slot.slotid)">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title" v-if="slot.type == 'text'">
                                                                <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                    <div :id="'box-shadow-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                                        <div class="panel-body mb-0">
                                                            <div class="cus-select">
                                                                 <span>Shadow style</span>
                                                                 <select :id="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" :name="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" @change="checkShadowType('shadowtype-tool-screen-'+key+'-slot-'+slot.slotid)">
                                                                    <option value="none">None</option>
                                                                    <option value="color">Color</option>
                                                                </select>
                                                            </div>

                                                            <div style="display:none;" :class="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid">
                                                                <div class="background-color-picker form-group">
                                                                    <div class="row">
                                                                        <div class="col-5 pr-2">
                                                                            <div class="check-color" :style="'background:'+shadow.color" data-toggle="modal" :data-target="'#textshadowcolorPicker-'+key+'-'+slotKey">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 pl-0">
                                                                           <span>Shadow style color - Hex</span>
                                                                           <input type="text" v-model="shadow.color">
                                                                       </div>
                                                                   </div>
                                                                   </div>

                                                                    <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey">
                                                                        <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">&nbsp;</h4>

                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <color-panel v-model="shadow.color"></color-panel>
                                                                                    <br>
                                                                                 </div>
                                                                                 <div class="modal-footer">
                                                                                    <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                                                    <button type="button" class="text-success btn-none float-right" @click="setShadow(key,slotKey)" data-dismiss="modal">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            
                                                                        </div>
                                                                        <div class="col-6 pl-0">
                                                                             <div class="cus-select">
                                                                                <span>Blur</span>
                                                                                <strong class="addon">px</strong>
                                                                                <input type="number"  v-model="shadow.blur" @change="setShadow(key,slotKey)">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-6 pr-1">
                                                                                    <div class="cus-select ">
                                                                                        <span>X</span>
                                                                                        <strong class="addon">px</strong>
                                                                                        <input type="number"  v-model="shadow.x" @change="setShadow(key,slotKey)">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6 pl-1">
                                                                                     <div class="cus-select ">
                                                                                        <span>Y</span>
                                                                                        <strong class="addon">px</strong>
                                                                                        <input type="number"  v-model="shadow.y" @change="setShadow(key,slotKey)">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default shadow-panel  ">
                                        <a  href="javascript:;" :data-id="'subtitle-panel-screen-'+key+'-slot-'+slot.slotid"  v-on:click="innerPanelToggle('subtitle-panel-screen-'+key+'-slot-'+slot.slotid,'subtitle-panel-angle-tool-screen-'+key+'-slot-'+slot.slotid)">
                                            <div class="panel-heading">
                                                <h4 class="panel-title" v-if="slot.type == 'text'">
                                                    <i class="t-icon">T<small>T</small></i> Subtitle Settings <i :class="'fa fa-angle-down float-right subtitle-panel-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                                </h4>
                                            </div>
                                        </a>
                                        <div :id="'subtitle-panel-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                            <div class="panel-body mb-0">
                                             
                                                <div class="editor mb-3">
                                                  <quill-editor :data-slotkey="slotKey" :data-screenkey="key" :data-slotid="'subtitle'+slot.slotid" :id="'tool-screen-'+key+'-slot-subtitle'+slot.slotid"
                                                  :options="editorOption" @focus="setSlotHeight(key,slotKey,'subtitle'+slot.slotid)" 
                                                  @change="onEditorChange($event)" :content="slot.subtitle.subTitleText"/>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-6 pr-1">
                                                        <div class="cus-select">
                                                            <span>Font Family</span>
                                                            <select v-model="slot.subtitle.subtitle_FontName" :id="'fontfamily-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'fontfamily-tool-screen-'+key+'-slot-subtitle'+slot.slotid" @change="updateSubtitleData(key,slotKey,slot.slotid)">
                                                                <option v-for="f in fonts" :value="f.font" :style="'font-family:'+f.font">{{f.font}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                       <div class="cus-select">
                                                            <span>Text Align</span>
                                                            <select :id="'textalign-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'textalign-tool-screen-'+key+'-slot-subtitle'+slot.slotid" v-model="slot.subtitle.subtitle_TextCenter" @change="updateSubtitleData(key,slotKey,slot.slotid)">
                                                                <option value="center">Center</option>
                                                                <option value="left">Left</option>
                                                                <option value="right">Right</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label><b>Text Size</b></label>
                                                 <div class="row ">
                                                    <div class="col-12 " :id="'main-textsizematch-tool-screen-'+key+'-slot-subtitle'+slot.slotid">
                                                        <div class="cus-select">
                                                            <span>Match size</span>
                                                            <select :id="'textsizematch-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'textsizematch-tool-screen-'+key+'-slot-subtitle'+slot.slotid" @change="textSizeType('textsizematch-tool-screen-'+key+'-slot-subtitle'+slot.slotid,'maunalFont-tool-screen-'+key+'-slot-subtitle'+slot.slotid)">
                                                                <option value="match">Match Title Size ({{parseFloat(slot.subtitle.subtitle_fontSize).toFixed(2)}}pt)</option>
                                                                <option value="manual">No - Manual Control</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1" :id="'maunalFont-tool-screen-'+key+'-slot-subtitle'+slot.slotid" style="display:none">
                                                       <div class="cus-select">
                                                            <span>Max Font Size</span>
                                                            <strong class="addon">pt</strong>
                                                            <input type="number" :id="'textsize-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'textsize-tool-screen-'+key+'-slot-subtitle'+slot.slotid" v-model="slot.subtitle.subtitle_fontSize" @change="updateSubtitleData(key,slotKey,slot.slotid)">
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="row form-group">
                                                    <div class="col-6 pr-1">
                                                        <div class="cus-select">
                                                            <span>Added Letter Spacing</span>
                                                            <strong class="addon">pt</strong>
                                                            <input type="number" :id="'latterspace-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'latterspace-tool-screen-'+key+'-slot-subtitle'+slot.slotid" v-model="slot.subtitle.subtitle_latterSpacing" @change="updateSubtitleData(key,slotKey,slot.slotid)">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                     <div class="cus-select">
                                                            <span>Line Breaking</span>
                                                            <select :id="'linebreak-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'linebreak-tool-screen-'+key+'-slot-subtitle'+slot.slotid" v-model="slot.subtitle.subtitle_lineBreak" @change="setwrap(key,slotKey,'subtitle'+slot.slotid); updateSubtitleData(key,slotKey,slot.slotid);">
                                                                <option value="normal">Break</option>
                                                                <option value="nowrap">Single Line</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cus-select">
                                                    <span>Line Height</span>
                                                    <strong class="addon">%</strong>
                                                    <input type="number" :id="'lineheight-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'lineheight-tool-screen-'+key+'-slot-subtitle'+slot.slotid" @change="updateSubtitleData(key,slotKey,slot.slotid)" v-model="slot.subtitle.subtitle_lineHeight">
                                                </div>
                                                <div class="panel panel-default shadow-panel">
                                                    <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-subtitle'+slot.slotid"  v-on:click="handShowBoxToggle(key,'subtitle'+slot.slotid)">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title" v-if="slot.type == 'text'">
                                                                <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-subtitle'+slot.slotid"></i>
                                                            </h4>
                                                        </div>
                                                    </a>
                                                    <div :id="'box-shadow-screen-'+key+'-slot-subtitle'+slot.slotid" class="panel-collapse collapse">
                                                        <div class="panel-body mb-0">
                                                            <div class="cus-select">
                                                                 <span>Shadow style</span>
                                                                 <select :id="'shadowtype-tool-screen-'+key+'-slot-subtitle'+slot.slotid" :name="'shadowtype-tool-screen-'+key+'-slot-subtitle'+slot.slotid" @change="checkShadowType('shadowtype-tool-screen-'+key+'-slot-subtitle'+slot.slotid)">
                                                                    <option value="none">None</option>
                                                                    <option value="color">Color</option>
                                                                </select>
                                                            </div>

                                                            <div style="display:none;" :class="'shadowtype-tool-screen-'+key+'-slot-subtitle'+slot.slotid">
                                                                <div class="background-color-picker form-group">
                                                                    <div class="row">
                                                                        <div class="col-5 pr-2">
                                                                            <div class="check-color" :style="'background:'+shadow.color" data-toggle="modal" :data-target="'#textshadowcolorPicker-'+key+'-subtitle'+slotKey">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-7 pl-0">
                                                                           <span>Shadow style color - Hex</span>
                                                                           <input type="text" v-model="shadow.color">
                                                                       </div>
                                                                   </div>
                                                                   </div>

                                                                    <div class="modal" :id="'textshadowcolorPicker-'+key+'-subtitle'+slotKey">
                                                                        <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">&nbsp;</h4>

                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <color-panel v-model="shadow.color"></color-panel>
                                                                                    <br>
                                                                                 </div>
                                                                                 <div class="modal-footer">
                                                                                    <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                                                    <button type="button" class="text-success btn-none float-right" @click="setShadow(key,slotKey,'subtitle')" data-dismiss="modal">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            
                                                                        </div>
                                                                        <div class="col-6 pl-0">
                                                                             <div class="cus-select">
                                                                                <span>Blur</span>
                                                                                <strong class="addon">px</strong>
                                                                                <input type="number"  v-model="shadow.blur" @change="setShadow(key,slotKey,'subtitle')">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-6 pr-1">
                                                                                    <div class="cus-select ">
                                                                                        <span>X</span>
                                                                                        <strong class="addon">px</strong>
                                                                                        <input type="number"  v-model="shadow.x" @change="setShadow(key,slotKey,'subtitle')">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6 pl-1">
                                                                                     <div class="cus-select ">
                                                                                        <span>Y</span>
                                                                                        <strong class="addon">px</strong>
                                                                                        <input type="number"  v-model="shadow.y" @change="setShadow(key,slotKey,'subtitle')">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                <div v-else>
                                  
                                    <div class="editor mb-3">
                                      <quill-editor :data-slotkey="slotKey" :data-screenkey="key" :data-slotid="slot.slotid" :id="'tool-screen-'+key+'-slot-'+slot.slotid"
                                      :options="editorOption" @focus="setSlotHeight(key,slotKey,slot.slotid)" 
                                      @change="onEditorChange($event)" :content="slot.SlotType"/>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 pr-1">
                                            <div class="cus-select">
                                                <span>Font Family</span>
                                                <select v-model="slot.FontName" :id="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" :name="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" >
                                                    <option v-for="f in fonts" :value="f.font" :style="'font-family:'+f.font">{{f.font}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1">
                                           <div class="cus-select">
                                                <span>Text Align</span>
                                                <select :id="'textalign-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textalign-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.TextCenter" >
                                                    <option value="center">Center</option>
                                                    <option value="left">Left</option>
                                                    <option value="right">Right</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <label><b>Text Size</b></label>
                                     <div class="row ">
                                        <div class="col-12 " :id="'main-textsizematch-tool-screen-'+key+'-slot-'+slot.slotid">
                                            <div class="cus-select">
                                                <span>Match size</span>
                                                <select :id="'textsizematch-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textsizematch-tool-screen-'+key+'-slot-'+slot.slotid" @change="textSizeType('textsizematch-tool-screen-'+key+'-slot-'+slot.slotid,'maunalFont-tool-screen-'+key+'-slot-'+slot.slotid)">
                                                    <option value="match">Match Title Size ({{parseFloat(slot.fontSize).toFixed(2)}}pt)</option>
                                                    <option value="manual">No - Manual Control</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1" :id="'maunalFont-tool-screen-'+key+'-slot-'+slot.slotid" style="display:none">
                                           <div class="cus-select">
                                                <span>Max Font Size</span>
                                                <strong class="addon">pt</strong>
                                                <input type="number" :id="'textsize-tool-screen-'+key+'-slot-'+slot.slotid" :name="'textsize-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.fontSize" @change="resizeSubtitleTop(key,slotKey,slot.slotid)">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row form-group">
                                        <div class="col-6 pr-1">
                                            <div class="cus-select">
                                                <span>Added Letter Spacing</span>
                                                <strong class="addon">pt</strong>
                                                <input type="number" :id="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" :name="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.latterSpacing">
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1">
                                         <div class="cus-select">
                                                <span>Line Breaking</span>
                                                <select :id="'linebreak-tool-screen-'+key+'-slot-'+slot.slotid" :name="'linebreak-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineBreak" @change="setwrap(key,slotKey,slot.slotid)">
                                                    <option value="normal">Break</option>
                                                    <option value="nowrap">Single Line</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cus-select">
                                        <span>Line Height</span>
                                        <strong class="addon">%</strong>
                                        <input type="number" :id="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" :name="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineHeight">
                                    </div>
                                    <div class="panel panel-default shadow-panel">
                                        <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.slotid"  v-on:click="handShowBoxToggle(key,slot.slotid)">
                                            <div class="panel-heading">
                                                <h4 class="panel-title" v-if="slot.type == 'text'">
                                                    <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                                </h4>
                                            </div>
                                        </a>
                                        <div :id="'box-shadow-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                            <div class="panel-body mb-0">
                                                <div class="cus-select">
                                                     <span>Shadow style</span>
                                                     <select :id="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" :name="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" @change="checkShadowType('shadowtype-tool-screen-'+key+'-slot-'+slot.slotid)">
                                                        <option value="none">None</option>
                                                        <option value="color">Color</option>
                                                    </select>
                                                </div>

                                                <div style="display:none;" :class="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid">
                                                    <div class="background-color-picker form-group">
                                                        <div class="row">
                                                            <div class="col-5 pr-2">
                                                                <div class="check-color" :style="'background:'+shadow.color" data-toggle="modal" :data-target="'#textshadowcolorPicker-'+key+'-'+slotKey">

                                                                </div>
                                                            </div>
                                                            <div class="col-7 pl-0">
                                                               <span>Shadow style color - Hex</span>
                                                               <input type="text" v-model="shadow.color">
                                                           </div>
                                                       </div>
                                                       </div>

                                                        <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey">
                                                            <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">&nbsp;</h4>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <color-panel v-model="shadow.color"></color-panel>
                                                                        <br>
                                                                     </div>
                                                                     <div class="modal-footer">
                                                                        <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="text-success btn-none float-right" @click="setShadow(key,slotKey)" data-dismiss="modal">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                
                                                            </div>
                                                            <div class="col-6 pl-0">
                                                                 <div class="cus-select">
                                                                    <span>Blur</span>
                                                                    <strong class="addon">px</strong>
                                                                    <input type="number"  v-model="shadow.blur" @change="setShadow(key,slotKey)">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 pr-1">
                                                                        <div class="cus-select ">
                                                                            <span>X</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.x" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                         <div class="cus-select ">
                                                                            <span>Y</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.y" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                         <div class="panel panel-default" v-for="(slot , slotKey) in screen.slots" v-if="slot.type != 'text' && (slot.SlotType.includes('frame') || slot.SlotType.includes('image')) ">
                            <div v-if="slot.SlotType.includes('frame')">


                                <a  href="javascript:;" :data-id="'tool-screen-'+key+'-slot-'+slot.SlotType"  v-on:click="handToggle(key,slotKey,slot.SlotType)">
                                    <div class="panel-heading">
                                        <h4 class="panel-title" >
                                            <i class="fa fa-mobile-alt"></i> Device <i :class="'fa fa-angle-down float-right angle-tool-screen-'+key+'-slot-'+slot.SlotType"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div :id="'tool-screen-'+key+'-slot-'+slot.SlotType" class="panel-collapse collapse">
                                    <div class="panel-body">
                                     <div class="cus-select">
                                        <span>Device Type</span>
                                        <select :id="'devicetype-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'devicetype-tool-screen-'+key+'-slot-'+slot.SlotType" @change="changeDeviceType(key,slotKey,slot.SlotType)">
                                            <option value="full_device">Full Device</option>
                                            <option value="3D_left">3D View Left</option>
                                            <option value="3D_right">3D View Right</option>
                                            <option value="shot_only">Screenshot Only</option>
                                            <option value="shot_only_3d_left">Screenshot Only (3D Left)</option>
                                            <option value="shot_only_3d_right">Screenshot Only (3D Right)</option>
                                        </select>
                                    </div>
                                    <div class="cus-select" :id="'maindevicestyle-tool-screen-'+key+'-slot-'+slot.SlotType">
                                        <span>Device Style</span>
                                        <select :id="'devicestyle-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'devicestyle-tool-screen-'+key+'-slot-'+slot.SlotType" >
                                            <option v-for="(color,colorIndex) in devices[currentyDevice].colors" :value="colorIndex">{{color.name}}</option>
                                        </select>
                                    </div>
                                    <div class="cus-select">
                                        <span>Device orientation</span>
                                        <select :id="'deviceorientation-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'deviceorientation-tool-screen-'+key+'-slot-'+slot.SlotType" @change="changeDeviceOrientation(key,slotKey,slot.SlotType)">
                                            <option value="portrait">Portrait</option>
                                            <option value="landscape_left">Landscape Left</option>
                                            <option value="landscape_right">Landscape Right</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 pr-1">
                                            <div class="cus-select">
                                                <span>Rotation</span>
                                                <strong class="addon">o</strong>
                                                <input type="number" :id="'imgrotation-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imgrotation-tool-screen-'+key+'-slot-'+slot.SlotType" @change="changeDeviceRotation(key,slotKey,slot.SlotType)" value="0">
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1">
                                         <div class="cus-select">
                                            <span>Sizing</span>
                                            <select :id="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" @change="imageSizing(key,slotKey,slot.SlotType)">
                                                <option value="contain">Contain</option>
                                                <option value="cover_bottom">Cover - Anchor Bottom</option>
                                                <option value="cover_center">Cover - Anchor Ccnter</option>
                                                <option value="cover_top">Cover - Anchor Top</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default mb-2 shadow-panel">
                                    <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.SlotType"  v-on:click="handShowBoxToggle(key,slot.SlotType)">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.SlotType"></i>
                                            </h4>
                                        </div>
                                    </a>
                                    <div :id="'box-shadow-screen-'+key+'-slot-'+slot.SlotType" class="panel-collapse collapse">
                                         <div class="panel-body mb-0">
                                                <div class="cus-select">
                                                     <span>Shadow style</span>
                                                     <select :id="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" :name="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid" @change="checkShadowType('shadowtype-tool-screen-'+key+'-slot-'+slot.slotid)">
                                                        <option value="none">None</option>
                                                        <option value="color">Color</option>
                                                    </select>
                                                </div>

                                                <div style="display:none;" :class="'shadowtype-tool-screen-'+key+'-slot-'+slot.slotid">
                                                    <div class="background-color-picker form-group">
                                                        <div class="row">
                                                            <div class="col-5 pr-2">
                                                                <div class="check-color" :style="'background:'+shadow.color" data-toggle="modal" :data-target="'#textshadowcolorPicker-'+key+'-'+slotKey">

                                                                </div>
                                                            </div>
                                                            <div class="col-7 pl-0">
                                                               <span>Shadow style color - Hex</span>
                                                               <input type="text" v-model="shadow.color">
                                                           </div>
                                                       </div>
                                                       </div>

                                                        <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey">
                                                            <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">&nbsp;</h4>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <color-panel v-model="shadow.color"></color-panel>
                                                                        <br>
                                                                     </div>
                                                                     <div class="modal-footer">
                                                                        <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="text-success btn-none float-right" @click="setShadow(key,slotKey)" data-dismiss="modal">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                
                                                            </div>
                                                            <div class="col-6 pl-0">
                                                                 <div class="cus-select">
                                                                    <span>Blur</span>
                                                                    <strong class="addon">px</strong>
                                                                    <input type="number"  v-model="shadow.blur" @change="setShadow(key,slotKey)">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 pr-1">
                                                                        <div class="cus-select ">
                                                                            <span>X</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.x" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                         <div class="cus-select ">
                                                                            <span>Y</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.y" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>  
                                            </div>
                                </div>
                            </div>
                            <br>
                            <label>Add Screenshots</label>
                            <a href="javascript:;"  v-on:click="setCurrentScreen(key)" data-toggle="modal" data-target="#screenShots" :data-screen="key" :data-slot="slot.SlotType" class="bg-select-btn mb-0">
                                <i class="fa fa-camera"></i> Screenshots
                            </a>

                        </div>
                    </div>
                </div>
                <div v-else-if="slot.SlotType.includes('image')">
  <a  href="javascript:;" :data-id="'tool-screen-'+key+'-slot-'+slot.SlotType"  v-on:click="handToggle(key,slotKey,slot.SlotType)">
                                    <div class="panel-heading">
                                        <h4 class="panel-title" >
                                            <i class="fa fa-image"></i> Image <i :class="'fa fa-angle-down float-right angle-tool-screen-'+key+'-slot-'+slot.SlotType"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div :id="'tool-screen-'+key+'-slot-'+slot.SlotType" class="panel-collapse collapse">
                                    <div class="panel-body" >
                                      <div class="mt-2 mb-3 backgroundPreview"  v-if="slot.SlotImageUrl != ''">
                                        <img :src="slot.SlotImageUrl" style="height:100px">
                                    </div>
                                    <div class="row " v-if="slot.SlotImageUrl != ''" >
                                        <div class="col-6 pr-1">
                                         <div class="cus-select">
                                            <span>Sizing</span>
                                            <select v-if="slot.objectFit == 'contain'" :id="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" v-model="slot.objectFit" @change="imageSizing(key,slotKey,slot.SlotType)">
                                                <option value="contain">Contain</option>
                                                <option value="cover_bottom">Cover - Anchor Bottom</option>
                                                <option value="cover_center">Cover - Anchor Center</option>
                                                <option value="cover_top">Cover - Anchor Top</option>
                                            </select>
                                            <select v-else :id="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" v-model="slot.objectFit+'_'+slot.objectPosition" @change="imageSizing(key,slotKey,slot.SlotType)">
                                                <option value="contain">Contain</option>
                                                <option value="cover_bottom">Cover - Anchor Bottom</option>
                                                <option value="cover_center">Cover - Anchor Center</option>
                                                <option value="cover_top">Cover - Anchor Top</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-6 pl-1" v-bind:style="[slot.objectFit == 'cover'?{'display': 'none'} : {'display': 'block'}]" style="">
                                            <div class="cus-select">
                                                <span>Image Postion</span>
                                                <select :id="'imagePosition-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imagePosition-tool-screen-'+key+'-slot-'+slot.SlotType" v-model="slot.objectPosition">
                                                    <option value="center">Middle</option>
                                                    <option value="top">Top</option>
                                                    <option value="bottom">Bottom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 pl-1" v-bind:style="[slot.objectFit == 'contain'?{'display': 'none'} : {'display': 'block'}]" style="">
                                            <div class="cus-select">
                                                <span>Image rotation</span>
                                                <select :id="'imgrotation-tool-screen-'+key" :name="'imgrotation-tool-screen-'+key" v-model="slot.imgRoation">
                                                    <option value="rotate(0deg)">None</option>
                                                    <option value="rotate(90deg)">90*</option>
                                                    <option value="rotate(180deg)">180*</option>
                                                    <option value="rotate(270deg)">270*</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                </div>
                         
                                <div class="panel panel-default mb-4 shadow-panel" v-if="slot.SlotImageUrl != ''" >
                                    <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.SlotType"  v-on:click="handShowBoxToggle(key,slot.SlotType)">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.SlotType"></i>
                                            </h4>
                                        </div>
                                    </a>
                                    <div :id="'box-shadow-screen-'+key+'-slot-'+slot.SlotType" class="panel-collapse collapse">
                                       <div class="panel-body mb-0">
                                                <div class="cus-select">
                                                     <span>Shadow style</span>
                                                     <select :id="'shadowtype-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'shadowtype-tool-screen-'+key+'-slot-'+slot.SlotType" @change="checkShadowType('shadowtype-tool-screen-'+key+'-slot-'+slot.SlotType)">
                                                        <option value="none">None</option>
                                                        <option value="color">Color</option>
                                                    </select>
                                                </div>

                                                <div style="display:none;" :class="'shadowtype-tool-screen-'+key+'-slot-'+slot.SlotType">
                                                    <div class="background-color-picker form-group">
                                                        <div class="row">
                                                            <div class="col-5 pr-2">
                                                                <div class="check-color" :style="'background:'+shadow.color" data-toggle="modal" :data-target="'#textshadowcolorPicker-'+key+'-'+slotKey">

                                                                </div>
                                                            </div>
                                                            <div class="col-7 pl-0">
                                                               <span>Shadow style color - Hex</span>
                                                               <input type="text" v-model="shadow.color">
                                                           </div>
                                                       </div>
                                                       </div>

                                                        <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey">
                                                            <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">&nbsp;</h4>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <color-panel v-model="shadow.color"></color-panel>
                                                                        <br>
                                                                     </div>
                                                                     <div class="modal-footer">
                                                                        <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="text-success btn-none float-right" @click="setShadow(key,slotKey)" data-dismiss="modal">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                
                                                            </div>
                                                            <div class="col-6 pl-0">
                                                                 <div class="cus-select">
                                                                    <span>Blur</span>
                                                                    <strong class="addon">px</strong>
                                                                    <input type="number"  v-model="shadow.blur" @change="setShadow(key,slotKey)">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 pr-1">
                                                                        <div class="cus-select ">
                                                                            <span>X</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.x" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 pl-1">
                                                                         <div class="cus-select ">
                                                                            <span>Y</span>
                                                                            <strong class="addon">px</strong>
                                                                            <input type="number"  v-model="shadow.y" @change="setShadow(key,slotKey)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>  
                                            </div>
                                </div>
                            </div>
<!-- 
                            <label>Add Screenshots</label> -->
                               <div style="display:inline-block">
                            <a href="javascript:;"  v-on:click="setImageSlotId(key,slotKey)" data-toggle="modal" data-target="#bgModel"  :data-screen="key" :data-slot="slot.SlotType" class="bg-select-btn">
                                <i class="fa fa-image"></i> Select New Image
                            </a>
                        </div>
                               <div style="display:inline-block">
                                         <a href="javascript:;"  v-on:click="slot.SlotImageUrl = '';" v-if="slot.SlotImageUrl != ''" class="text-danger ml-2"><i class="fa fa-times"></i> &nbsp; Clear</a>
                                    </div>

                        </div>
                    </div>
                </div>
                        </div>

                    </div>
                </div>
            </div>
         </section>
         <section class="playground-bottom-section">
             <button class="cm-btn"><i class="fa fa-times"></i>  &nbsp;  Clear</button> &nbsp; 
             <router-link to="templates" class="cm-btn"><i class="fa fa-bars"></i>  &nbsp;  Goto Templates</router-link>
         </section>
        </main>
        <backgroundLayoutsModel/>
        <backgroundModel/>
        <screeShotsModel/>
        <div  id="downloadScreen" >


         <div v-if="downloadScreen != ''" :class="'box single-screen'" :style="'min-width:'+downloadScreen.width+'px;min-height:'+downloadScreen.height+'px;position:relative;'">
            <div :style="'min-width:'+downloadScreen.width+'px;min-height:'+downloadScreen.height+'px;position:absolute;left:0;top:0;backgroundColor:'+downloadScreen.backgroundColor+';border-radius: 25px;'">
                <img :src="downloadScreen.TemplatebackgroundImage" :style="'width:'+downloadScreen.width+'px;height:'+downloadScreen.height+'px;border-radius: 25px;object-fit:cover'" class="bg-img">
            </div>

            <div v-for="slot in downloadScreen.slots" v-if="slot.type == 'text'" :style="'position:absolute;z-index:999;width:'+slot.slotWidth+'px;top:'+slot.top+'px;left:'+slot.left+'px;color:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');font-size:'+slot.fontSize+'pt;font-family:'+slot.FontName+';text-align:center;    line-height: 1;'" class="" data-type="text" :data-order="slot.orderNumber">
                {{slot.SlotType}}
            </div>

            <div v-for="slot in downloadScreen.slots"  v-if="slot.type != 'text'"  :style="'position:absolute;z-index:'+slot.zIndex+';width:'+slot.slotWidth+'px;top:'+slot.top+'px;left:'+slot.left+'px;'" class="">
                <img :src="slot[currentyDevice]" :style="'width:'+slot.slotWidth+'px;border:0;'" v-if="typeof slot[currentyDevice] != 'undefined' && slot[currentyDevice] != ''">
                <img :src="slot['global']" :style="'width:'+slot.slotWidth+'px;border:0;'" v-else-if="typeof slot['global'] != 'undefined' && slot['global'] != ''">
                <img :src="slot.SlotImageUrl" :style="'width:'+slot.slotWidth+'px;border:0;'" v-else>
            </div>
        </div>
    </div>
                   <div style="position:absolute;left:-20000px">
                       
                   <div id="tempText"></div>
                   </div>
        <div class="clearfix"></div>
         <VFooter class="inner-footer"></VFooter>
    </div>
</template>


<script>
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'
import backgroundLayoutsModel from './partial_views/backgroundLayoutsModel'
import backgroundModel from './partial_views/backgroundModel'
import screeShotsModel from './partial_views/screeShotsModel'
import html2canvas from 'html2canvas';
import { VueGpickr, LinearGradient } from 'vue-gpickr';
import { Draggable } from 'draggable-vue-directive'
const gradient = new LinearGradient({
  angle: 0,
  stops: [
    ['#0359b5', 0],
    ['#f6ce01', 1]
  ]
});
export default {
    data (){
        return {
            gradient:gradient,
            loading: true,
            message: "",
            mainDataList: "",
            screens: {},
            tempscreens: {},
            layouts: {},
            fontsList: {},
            userBackgrounds: {},
            userImages: {},
            imageModelType:'',
            curentLayoutScreen: '',
            curentScreenBg: '',
            error_message: "",
            screensHtml: "",
            has_error: false,
            submitted: false,
            screenCount: 1,
            importUrl: '',
            selectedSlot: '',
            downloadScreen: '',
            currentScreen: '',
            imagesLoader: false,
            addImageLoader: false,
            selectedSlotScreen: '',
            newUserImage:null,
            currentyDevice:'iphone5',
            deviceWidth:'350',
            deviceHeight:'622.22',
            list: null,
            shadow:{
                color:'#00000033',
                blur:0,
                x:5,
                y:5,
            },
            devices:{
                iphone5:{
                    id:2,
                    name:'iOS Phones - 5.5"',
                    width:'320',
                    height:'622.22',
                    colors:{
                        matt_black:{
                            url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone5Frame.png',
                            name:'Matt Black'
                        },
                    }
                },
                 iphone6:{
                    id:1,
                     name:'iOS Phones - 6.5"',
                    width:'350',
                    height:'757.49',
                    colors:{
                         matt_black:{
                            url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone6-Frame.png',
                            name:'Matt Black'
                        },
                    }
                },
                 ipad2:{
                    id:3,
                     name:'iOS iPad Pro (2nd) - 12.9"',
                    width:'350',
                    height:'466.89',
                    colors:{
                         matt_black:{
                            url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipad-Frame.png',
                            name:'Matt Black'
                        },
                    }
                },
                 ipad3:{
                    id:4,
                     name:'iOS iPad Pro (3rd+) - 12.9"',
                    width:'350',
                    height:'466.89',
                     colors:{
                        matt_black:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipad-Frame.png',
                    }
                },

            },
            editorOption: {
            }
        }
    },
    beforeMount(){
        this.getTemplates();
    },
      directives: {
            Draggable,
        },
    components: {
        quillEditor,
        backgroundLayoutsModel,
        screeShotsModel,
        backgroundModel,
        VueGpickr
    },
    methods: {

        getTemplates(){
            var dataUrl = '/get-template/';
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                
                this.mainDataList = result.data.data
                this.fonts = result.data.fonts
                this.loading = false;
                this.loadScreens('no');
            }, error => {

            });           
        },
         getLayouts(){
            var dataUrl = '/layouts/';
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
               
                this.layouts = result.data.data
                this.loading = false;
            
            }, error => {

            });           
        },
         getFonts(){
            var dataUrl = '/fonts-list/';
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
               
                this.fontsList = result.data.data
                this.loading = false;
            
            }, error => {

            });           
        },
         getUserImages(){
            var user_id = '';
            if (this.$store.getters.isLoggedIn) {
                user_id = this.$store.getters.getUser.id;
            }
            var ip = $('meta[name=ip]').attr('content');
            var dataUrl = '/user-images?ip='+ip+'&user_id='+user_id;
            axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                this.userBackgrounds = result.data.backgrounds;

                this.userImages = result.data.images;
                this.loading = false;
            
            }, error => {

            });           
        },
        onEditorChange({ quill, html, text }) {
            var slc = quill.root.parentElement.parentElement.id.replace('tool-','');
            var slotkey = $(quill.root.parentElement.parentElement).data('slotkey');
            var screenkey = $(quill.root.parentElement.parentElement).data('screenkey');
            var slotid = $(quill.root.parentElement.parentElement).data('slotid');
            $('#'+slc).html(html);
             if(slotid.toString().includes("subtitle") && typeof this.screens[screenkey].slots[slotkey].subtitle != 'undefined' && typeof this.screens[screenkey].slots[slotkey].subtitle != null){
            this.screens[screenkey].slots[slotkey].subtitle.subTitleText = html;

             }else{
            this.screens[screenkey].slots[slotkey].SlotType = html;

             }
             if (slotid.toString().includes("subtitle") && typeof this.screens[screenkey].slots[slotkey].subtitle != 'undefined' && typeof this.screens[screenkey].slots[slotkey].subtitle != null && this.screens[screenkey].slots[slotkey].subtitle.subtitle_lineBreak == 'nowrap') {
                 
                    this.resizeFontSize(screenkey,slotkey,slotid);
                

             }else{
                       if(this.screens[screenkey].slots[slotkey].lineBreak == 'nowrap'){
                        this.resizeFontSize(screenkey,slotkey,slotid);
                        this.resizeSubtitleTop(screenkey,slotkey,slotid);
                    }else{
                        this.resizeSubtitleTop(screenkey,slotkey,slotid);
                    }
             }
           
        },
        loadScreens(deviceChange){
            var maindata = this.mainDataList;
            var screens = [];
            var mthis = this;
            var html = "";
               $.each( maindata.screens, function(screenI, mainscreen){
                if(mainscreen.device_id == mthis.devices[mthis.currentyDevice].id){

                var screen = JSON.parse(mainscreen.data);
                var mainWidth  = screen.width;
                var mainHeight  = screen.height;
                    screen.width = mthis.deviceWidth;
                    screen.height = mthis.deviceHeight;
                    screen.mainWidth = mainWidth;
                    screen.mainHeight = mainHeight;
                    var toolBox = '';
                    var slotCount = 1;
                    screen.id = mthis.screenCount;
                    screen.bgid = slotCount;
                    toolBox+='';
                    slotCount++;
               
                      $.each(screen.slots, function(slotI, slot){

                         slot.top = slot.marginTop * screen.height;
                         slot.left = slot.marginLeft * screen.width;
                         slot.leftPercents = slot.left / screen.width * 100;
                         var exactslotWidth = slot.Width  * mainWidth;
                         slot.slotWidth = slot.Width  * screen.width;
                         slot.slotHeight = slot.Height  * screen.height;
                         slot.MainslotWidth = slot.slotWidth;
                         slot.Mainleft = slot.left;
                         slot.Maintop = slot.top;
                         slot.fontSize = parseFloat(slot.FontSize / exactslotWidth *  slot.slotWidth).toFixed(2);
                         slot.slotid = slotCount;
                         slot.TextPostion = 'top';
                    /*     slot.objectPosition = 'center';*/
                         slot.display = 'block';
                    /*      slot.imgRoation  = 'rotateZ('+slot.imgRoation+'deg)';*/
                         if(slot.imgRoation == 0){
                            slot.imgRoation  = 'rotateZ(0deg)';
                         }
                            slot.MainimgRoation = slot.imgRoation;
                          var zIndex = 999 
                            if (slot.SlotType.includes('inner')) {
                                zIndex = 99;
                            }
                            if (typeof slot.deviceStye == 'undefined') {

                            slot.deviceStye = 'matt_black';
                            }

                               slot.SlotType = slot.SlotType.split('-')[0];
                            slot.zIndex = zIndex;
                          slotCount++;
                     
                   })
                      screens.push(screen);
                      mthis.screenCount++;
                }

               })
              this.screens = screens;
              if (deviceChange == 'no') {

                  this.getLayouts();
                  this.getUserImages();
              }
        },
        handToggle(screeId,slotKey,slotId){

            var selector = '#tool-screen-'+screeId+'-slot-'+slotId;
            var arrow = '.angle-tool-screen-'+screeId+'-slot-'+slotId;
          

          if($(selector).hasClass( "show" )){
            $(selector).removeClass('show');
            $(arrow).removeClass('fa-angle-up');
            $(arrow).addClass('fa-angle-down');
          }else{
                $('.panel-collapse').removeClass('show');
                $('.panel-title i.fa-angle-up').addClass('fa-angle-down');
                $('.panel-title i.fa-angle-down').removeClass('fa-angle-up');
             $(selector).addClass('show');
              $(arrow).removeClass('fa-angle-down');
            $(arrow).addClass('fa-angle-up');
          }
          this.setImageSlotHeight(screeId,slotKey,slotId)
        },
        handShowBoxToggle(screeId,slotId){
            var selector = '#box-shadow-screen-'+screeId+'-slot-'+slotId;
            var arrow = '.box-shadow-angle-tool-screen-'+screeId+'-slot-'+slotId;
          if($(selector).hasClass( "show" )){
            $(selector).removeClass('show');
            $(arrow).removeClass('fa-angle-up');
            $(arrow).addClass('fa-angle-down');
          }else{
             $(selector).addClass('show');
              $(arrow).removeClass('fa-angle-down');
            $(arrow).addClass('fa-angle-up');
          }
        },
        innerPanelToggle(id,arrow){
            var selector = '#'+id;
            var arrow = '.'+arrow;
          if($(selector).hasClass( "show" )){
            $(selector).removeClass('show');
            $(arrow).removeClass('fa-angle-up');
            $(arrow).addClass('fa-angle-down');
          }else{
             $(selector).addClass('show');
              $(arrow).removeClass('fa-angle-down');
            $(arrow).addClass('fa-angle-up');
          }
        },
        mouseOver(screeId){
            $('.edit-screen-'+screeId).show()
        },
        mouseLeave(screeId){
            this.closeMenu(screeId)
            $('.edit-screen-'+screeId).hide()
        },
        toolbartoggle(screeId){
            this.closeMenu(screeId);
            /*$('.hideit').hide();*/
            
            if ($('.tool-screen-'+screeId).is(":hidden")) {
                $('.hideAllTool').hide('slow');
                $('.tool-screen-'+screeId).show('slow');
            }else{
                $('.tool-screen-'+screeId).hide('slow')
            }
             
        },
        selectSlot(screeId,slotKey,slotId){
            this.closeMenu(screeId);
            if ($('.tool-screen-'+screeId).is(":hidden")) {
                $('.hideAllTool').hide('slow')

            }
              $('.tool-screen-'+screeId).show('slow');
              this.handToggle(screeId,slotKey,slotId);

        },
        setLayoutIndex(id){
            this.curentLayoutScreen = id;
        },
        setLayout(data,title){
            var screen = JSON.parse(data);
            var mainWidth  = screen.width;
            var mainHeight  = screen.height;
            screen.width = this.deviceWidth;
            screen.height = this.deviceHeight;
            screen.mainWidth = mainWidth;
            screen.mainHeight = mainHeight;
            var toolBox = '';
            var slotCount = 1;
            screen.id = this.screens[this.curentLayoutScreen].id;
            screen.bgid =  this.screens[this.curentLayoutScreen].bgid;
            $.each(screen.slots, function(slotI, slot){

                   slot.top = slot.marginTop * screen.height;
                   slot.left = slot.marginLeft * screen.width;
                   slot.slotWidth = slot.Width  * screen.width;
                   slot.fontSize = parseFloat(slot.FontSize / mainWidth *  slot.slotWidth).toFixed(2);
                   slot.slotid = slotCount;
                    slot.slotRoation  = 'rotate(0deg)';
                    slot.MainslotWidth = slot.slotWidth;
                         slot.Mainleft = slot.left;
                         slot.Maintop = slot.top;
                   slot.SlotType = slot.SlotType.split('-')[0];
                   var zIndex = 999 
                   if (slot.SlotType.includes('inner')) {
                    zIndex = 99;
                }
                if(slot.imgRoation == 0){
                    slot.imgRoation  = 'rotate(0deg)';
                }
                slot.MainimgRoation = slot.imgRoation;
                slot.display = 'block';
                slot.zIndex = zIndex;
                slotCount++;

            })
            this.screens[this.curentLayoutScreen] = screen;
             this.$forceUpdate();
            $('#layoutModel').modal('hide');
            $('#screen-layout-'+this.curentLayoutScreen).html(title);
            $('.modal-backdrop').remove();

        },
        setBlankLayout(title){
            var screen = this.screens[this.curentLayoutScreen];
            var mainWidth  = screen.width;
            var mainHeight  = screen.height;
            screen.width = this.deviceWidth;
            screen.height = this.deviceHeight;
            screen.mainWidth = mainWidth;
            screen.mainHeight = mainHeight;
            var toolBox = '';
            var slotCount = 1;
            screen.id = this.screens[this.curentLayoutScreen].id;
            screen.bgid =  this.screens[this.curentLayoutScreen].bgid;
            screen.slots = {};
            this.screens[this.curentLayoutScreen] = screen;
             this.$forceUpdate();
            $('#layoutModel').modal('hide');
            $('#screen-layout-'+this.curentLayoutScreen).html(title);
            $('.modal-backdrop').remove();

        },
         setBgIndex(id){
            this.imageModelType = 'bg';
            this.curentScreenBg = id;
        },
        setImageSlotId(screenId,slotindex){
              this.imageModelType = 'image';
            this.selectedSlotScreen = screenId;
            this.selectedSlot = slotindex;
        },
        setBg(link){
            this.screens[this.curentScreenBg].TemplatebackgroundImage = link;
            this.$forceUpdate();
             $('#bgModel').modal('hide');
               $('.modal-backdrop').remove();
        },
        setImageSlot(link){
            this.screens[this.selectedSlotScreen].slots[this.selectedSlot].SlotImageUrl = link;
             $('#bgModel').modal('hide');
               $('.modal-backdrop').remove();

        },
        deleteUserImage(id){
             
              this.$confirm( {
                  title: 'Delete Image',
                  message: `Are You  Sure ?. Removing this image will remove it from all of your projects`,
                  button: {
                    no: 'No',
                    yes: 'Yes'
                },
                callback: confirm => {
                    if (confirm) {
                         this.imagesLoader = true;
                           var dataUrl = '/delete-user-image?id='+id+'&type='+this.imageModelType;
                           axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {

                            $('#bg-'+id).remove();
                            this.imagesLoader = false;
                            this.getUserImages();
                        }, error => {

                        });
                    }
                }
            })
        },
        addUserNewImage(){

              let formData = new FormData();
              formData.append('image', this.newUserImage);
              formData.append('importUrl', this.importUrl);
              if(this.newUserImage !=null || this.importUrl !==null){
                this.addImageLoader = true;

                var user_id = '';
                if (this.$store.getters.isLoggedIn) {
                    user_id = this.$store.getters.getUser.id;
                }
                var ip = $('meta[name=ip]').attr('content');
                formData.append('ip', ip);
                formData.append('user_id', user_id);
                formData.append('imageType', this.imageModelType);
                axios({
                    method: "POST",
                    url: "/add-user-image",
                    data: formData,
                    headers: { "content-type": "application/json" }
                }).then(  response => {
                    var response = response.data;
                    if (response.link) {
                        if (this.imageModelType == 'bg') {
                            this.setBg(response.link);
                        }else{
                            this.setImageSlot(response.link);
                        }
                    }
                    this.addImageLoader = false;
                    this.getUserImages();
                    this.newUserImage = null;

                });
            }
        },
        setCurrentScreen(index){
            this.currentScreen = index;
            $('#screenShots .nav-link.active').removeClass('active');
            $('#screenShots .tab-content .tab-pane.active').removeClass('active');
            $('#screenShots .tab-content .tab-pane.active').removeClass('show');

              $('.tab-screen'+index).addClass('active');
            $('#tab-screen'+index).addClass('active');
            $('#tab-screen'+index).addClass('show');
        },
        addShot(file,device,key,slotKey){
var mainthis = this;
              let formData = new FormData();
              formData.append('image', file);
              formData.append('importUrl', this.importUrl);
              $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .icons').hide();
              $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .shot-loader').show();
              if(file !=null){

                var user_id = '';
                if (this.$store.getters.isLoggedIn) {
                    user_id = this.$store.getters.getUser.id;
                }
                var ip = $('meta[name=ip]').attr('content');
                formData.append('ip', ip);
                formData.append('user_id', user_id);
                formData.append('imageType','screenshot');
                formData.append('device',device);
                axios({
                    method: "POST",
                    url: "/add-user-screenshots",
                    data: formData,
                    headers: { "content-type": "application/json" }
                }).then(  response => {
                    var response = response.data;
                    if (response.link) {
                    var slots = {};
                     if (typeof mainthis.tempscreens[key] == 'undefined' ) {
                       mainthis.tempscreens[key] = {};
                   }
                    if (typeof mainthis.tempscreens[key]['slots'] == 'undefined' ) {
                       mainthis.tempscreens[key]['slots'] = {};
                   }
                     if (typeof mainthis.tempscreens[key]['slots'][slotKey] == 'undefined' ) {
                       mainthis.tempscreens[key]['slots'][slotKey] = {};
                   }
                   /* if (typeof slots[slotKey] == 'undefined' ) {
                        console.log = 'in here';
                   }*/
                     /*  slots[slotKey] = [];
                   mainthis.tempscreens[key] = slots;*/
                       mainthis.tempscreens[key]['slots'][slotKey][device] = response.link;
                       $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .shot-loader').hide();
                       $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .icons.added').show();
                       $('#'+device+'-shot-'+key+'-slot-'+slotKey).addClass('added');
                    }

                });
            }
        },
        updateShotsData(){
            $('.screen-loader').show();
            var removeLoader = false;
            var mainthis = this;
            $.each(mainthis.tempscreens, function(screenKey, screen){
                $.each(screen.slots, function(slotI, slot){
                    var slotType =    mainthis.screens[screenKey]['slots'][slotI]['SlotType'];
                   /* slotType = slotType.split('-')[0];*/
                    slotType = slotType.replace('frame','inner');
                    $.each(slot, function(slotinI, slotin){
                        $.each(mainthis.screens, function(mainscreenKey, mainscreen){
                            $.each(mainscreen.slots, function(mainslotI, mainslot){
                                if (mainslot.SlotType.includes(slotType)) {
                                    mainthis.screens[mainscreenKey]['slots'][mainslotI][slotinI] = slotin;
                                       removeLoader = true;
                                }
                            });
                        });
                    });
                });
            });
              this.$forceUpdate();
              setTimeout(function(){  $('.screen-loader').hide(); }, 3000);
                $('#screenShots').modal('hide');
               $('.modal-backdrop').remove();
        },
        showAddedImage(device,key,slotKey){
           var link =  this.tempscreens[key]['slots'][slotKey][device];
           window.open(link,'_blank');
        },
        removeAddedImage(device,key,slotKey){
            if(typeof this.screens[key]['slots'][slotKey][device] != 'undefined'){
                 this.screens[key]['slots'][slotKey][device] = '';
             }
             this.tempscreens[key]['slots'][slotKey][device] = '';
           
            $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .icons.added').hide();
            $('#'+device+'-shot-'+key+'-slot-'+slotKey+' .icons.upload').show();
            $('#'+device+'-shot-'+key+'-slot-'+slotKey).removeClass('added');

        },
        toolPanelLock(screenId){
              if($('.tool-screen-'+screenId).hasClass( "hideAllTool" )){
                $('.tool-screen-'+screenId).removeClass('hideAllTool');
                $('.tool-lock-btn-'+screenId).html('<i class="fa fa-lock"></i>');
              }else{
                 $('.tool-screen-'+screenId).addClass('hideAllTool');
                 $('.tool-lock-btn-'+screenId).html('<i class="fa fa-unlock"></i>');
              }
        },
        openMenu: function(screenId) {
            $('#right-click-menu-'+screenId).show();

            Vue.nextTick(function() {
                 $('#right-click-menu-'+screenId).focus();

                this.setMenu(event.y, event.x,screenId)
            }.bind(this));
            event.preventDefault();
        },
         setMenu: function(top, left,screenId) {
          
            var largestHeight = $('.screen-'+screenId).outerHeight() -  $('#right-click-menu-'+screenId).outerHeight() - 25;
           var  largestWidth = $('.screen-'+screenId).outerWidth() -  $('#right-click-menu-'+screenId).outerWidth() - 25;

            if (top > largestHeight) top = largestHeight;

            if (left > largestWidth) left = largestWidth;

            var top = top + 'px';
            var left = left + 'px';
             $('#right-click-menu-'+screenId).css("top",top);
             $('#right-click-menu-'+screenId).css("left",left);
        },

        closeMenu: function(screenId) {
           $('#right-click-menu-'+screenId).hide();
        },
        changeDevice(){
            $('.screen-loader').show();
            this.deviceWidth = this.devices[this.currentyDevice].width;
            this.deviceHeight = this.devices[this.currentyDevice].height;
            this.loadScreens('yes');
            /*var screens = [];
            var mthis = this;
            $.each(this.mainDataList.screens, function(screenI, screen){
               if(screen.device_id == mthis.devices[mthis.currentyDevice].id){

                    var screen = JSON.parse(screen.data);
                    var oldWidth  = screen.width;
                    var oldHeight  = screen.height;
                    screen.width = mthis.deviceWidth;
                    screen.height = mthis.deviceHeight;
                    var mainWidth = screen.mainWidth ;
                    var mainHeight = screen.mainHeight;
                    var chwidth = screen.height * oldWidth / oldHeight;
                    var chHeight = screen.width * oldHeight / oldWidth;
                    $.each(screen.slots, function(slotI, slot){

                       slot.fontSize = slot.fontSize * mainWidth /  slot.slotWidth;
                       var oldSlotWidth = slot.slotWidth;

                       slot.top = slot.top / oldHeight;
                       slot.top = slot.top * screen.height

                       slot.slotWidth = slot.slotWidth / oldWidth;
                       slot.slotWidth = slot.slotWidth * chwidth;

                       slot.Height = slot.Height * screen.height;

                       var changesWidth = oldSlotWidth - slot.slotWidth;

                       slot.left =  slot.left / oldWidth
                       slot.left =  slot.left * screen.width;
                       slot.fontSize = parseFloat(slot.fontSize / mainWidth *  slot.slotWidth).toFixed(2);

                   })
                    screens.push(screen);
                }
             })
            this.screens = screens;
            this.$forceUpdate();
            this.resetSlotHieghts()*/
            var mthis = this;
             setTimeout(function(){  mthis.$forceUpdate();  $('.screen-loader').hide(); }, 3000);
        },
        resetSlotHieghts(){
            $.each(this.screens, function(screenI, screen){
                $.each(screen.slots, function(slotI, slot){
                    $('#screen-'+screenI+'-slot-subtitle'+slot.slotid).css('height','auto');
                    $('#screen-'+screenI+'-slot-'+slot.slotid).css('height','auto');
                    $('#screen-'+screenI+'-slot-'+slot.SlotType).css('height','auto');
                    $('#screen-'+screenI+'-slot-'+slot.SlotType+' img').css('height','auto');

                })
            })
             this.$forceUpdate();

        },
        refreshScreen(screenId){
            $('#screen-loader-'+screenId).show();
            this.$forceUpdate();
            setTimeout(function(){  $('#screen-loader-'+screenId).hide(); }, 3000);
        },
        duplicateScreen(key){
              $('#screen-loader-'+key).show();
             var screens = [];
             var mthis = this;
             var keyCount = 0
             var increaseKey = key + 1;
               $.each(this.screens, function(screenI, screen){
                  if (key == keyCount) {

                     screens[keyCount] = {};
                     screens[keyCount] = screen;
                       keyCount++;
                       console.log(keyCount);
                        screens[keyCount] = {};
                        screens[keyCount] = screen;
                    keyCount++;
                      console.log(keyCount);
                 }else{
                     screens[keyCount] = {};
                    screens[keyCount] = screen;
                    keyCount++;

                 }
               })
                this.screens = screens;
                this.$forceUpdate();
                setTimeout(function(){  $('#screen-loader-'+key).hide(); }, 2000);
        },
        removeScreen(key){

              this.$confirm( {
                  title: 'Delete',
                  message: `Are you sure you want to delete this screenshot?`,
                  button: {
                    no: 'No',
                    yes: 'Yes'
                },
                callback: confirm => {
                    if (confirm) {

                            this.screens.splice(key, 1);

                      
                    }
                }
            })

        },
        changeBgStyle(key){
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
        clearbgImage(key){
            this.screens[key].TemplatebackgroundImage  = '';
        },
        setBgGradient(key){
            var gradient =  $('#gradientPicker'+key+' .vue-gpickr-preview').css('background');
            this.screens[key].backgroundColor  = gradient;
            $('#gradientPicker'+key).modal('hide');
            $('.modal-backdrop').remove();
        },

        oldScreenDownload(key){
            var mthis = this;
            let formData = new FormData();
            formData.append('screen',  JSON.stringify(this.screens[key]));
               axios({
                    method: "POST",
                    url: "/download-screenshot",
                    data: formData,
                    headers: { "content-type": "application/json" }
                }).then(  response => {
                    var response = response.data;
                    

                });
        },
        textSizeType(select,show){
            var val = $('#'+select).val();
            if (val == 'manual') {
                $('#main-'+select).addClass('col-6');
                $('#main-'+select).addClass('pr-1');
                $('#main-'+select).removeClass('col-12');
                $('#'+show).show();
            }else{
                 $('#main-'+select).removeClass('col-6');
                 $('#main-'+select).removeClass('pr-1');
                $('#main-'+select).addClass('col-12');
                $('#'+show).hide();
            }
        },
        checkShadowType(select){
              var val = $('#'+select).val();
            if (val == 'color') {
                $('.'+select).show();
            }else{
                 $('.'+select).hide();
            }
        },
        setShadow(key,slotkey,type = 'title'){
            if (type == 'subtitle' && typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null) {
                 this.screens[key].slots[slotkey].subtitle.subtitle_shadow = this.shadow.x+'px '+this.shadow.y+'px '+this.shadow.blur+'px '+this.shadow.color;
            }else{

            this.screens[key].slots[slotkey].shadow = this.shadow.x+'px '+this.shadow.y+'px '+this.shadow.blur+'px '+this.shadow.color;
            }
        },
        setSlotHeight(key,slotkey,slotid){
            if (typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null && typeof this.screens[key].slots[slotkey].subtitle.mainSlotHeight != 'undefined' && slotid.toString().includes("subtitle")) {
                var slot_height = $('#screen-'+key+'-slot-'+slotid).outerHeight();
                this.screens[key].slots[slotkey].subtitle.mainSlotHeight = slot_height;
            }else  if (typeof this.screens[key].slots[slotkey].mainSlotHeight == 'undefined') {
                var slot_height = $('#screen-'+key+'-slot-'+slotid).outerHeight();
                this.screens[key].slots[slotkey].mainSlotHeight = slot_height;
            }
        },
        setwrap(key,slotkey,slotid){

            var val = $('#linebreak-tool-screen-'+key+'-slot-'+slotid).val();
            var mainWidth =  this.screens[key].mainWidth;
            var $this = this;
                if(slotid.toString().includes("subtitle") && typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null){
                    
                        this.setSlotHeight(key,slotkey,slotid);
                    
                    if (val == 'nowrap') {
                        $('#screen-'+key+'-slot-'+slotid).css('height',this.screens[key].slots[slotkey].subtitle.mainSlotHeight);
                        this.resizeFontSize(key,slotkey,slotid);

                    }else{
                       this.screens[key].slots[slotkey].subtitle.subtitle_fontSize = 15;
                   
                   }
               }else{
                    if (val == 'nowrap') {

                        this.setSlotHeight(key,slotkey,slotid);
                    
                        $('#screen-'+key+'-slot-'+slotid).css('height',this.screens[key].slots[slotkey].mainSlotHeight);
                        this.resizeFontSize(key,slotkey,slotid);


                    }else{
                          $('#screen-'+key+'-slot-'+slotid).css('height','auto');
                       this.screens[key].slots[slotkey].fontSize = parseFloat(this.screens[key].slots[slotkey].FontSize / mainWidth * this.screens[key].slots[slotkey].slotWidth).toFixed(2);
                   }
               }
            
            this.$forceUpdate();
            this.resizeSubtitleTop(key,slotkey,slotid);

                     
        },
        resizeFontSize(key,slotkey,slotid){
             var $this = this;
                 if(slotid.toString().includes("subtitle") && typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null){
                    var fontSize = this.screens[key].slots[slotkey].subtitle.subtitle_fontSize;
                    $('#tempText').html(this.screens[key].slots[slotkey].subtitle.subTitleText);
                    $('#tempText').css('display','inline-block');
                    $('#tempText').css('font-size',this.screens[key].slots[slotkey].subtitle.subtitle_fontSize+'pt');
                    $('#tempText').css('font-family',this.screens[key].slots[slotkey].subtitle.FontName);
                 }else{
                    var fontSize = this.screens[key].slots[slotkey].fontSize;
                    $('#tempText').html(this.screens[key].slots[slotkey].SlotType);
                    $('#tempText').css('display','inline-block');
                    $('#tempText').css('font-size',this.screens[key].slots[slotkey].fontSize+'pt');
                    $('#tempText').css('font-family',this.screens[key].slots[slotkey].FontName);
                }
                for (let i = 0; i < 50; i++) {
                    if ($('#tempText').outerWidth() > $('#parentText-screen-'+key+'-slot-'+slotid).width()) { 
                        fontSize = parseFloat(fontSize) - 0.5;
                        $('#screen-'+key+'-slot-'+slotid).css('font-size',fontSize+'pt');
                        $('#tempText').css('font-size',fontSize+'pt');
                  }
                }
                if(slotid.toString().includes("subtitle") && typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null){
                     this.screens[key].slots[slotkey].subtitle.subtitle_fontSize = fontSize;
                }else{
                     this.screens[key].slots[slotkey].fontSize = fontSize;
                }
                 this.$forceUpdate();
        },
        includeSubtitle(key,slotkey,slotid){
            $('#screen-loader-'+key).show();
            var val = $('#addsubtitle-tool-screen-'+key+'-slot-'+slotid).val();
            if (val == 'yes') {
                this.screens[key].slots[slotkey].subtitle = this.screens[key].slots[slotkey];
                this.screens[key].slots[slotkey].subtitle.subtitle_top = this.screens[key].slots[slotkey].subtitle.top + $('#screen-'+key+'-slot-'+slotid).height();
                this.screens[key].slots[slotkey].subtitle.subtitle_margin_top = 3;
                this.screens[key].slots[slotkey].subtitle.subtitle_FontName = this.screens[key].slots[slotkey].FontName;
                this.screens[key].slots[slotkey].subtitle.subtitle_TextCenter = this.screens[key].slots[slotkey].TextCenter;
                this.screens[key].slots[slotkey].subtitle.subtitle_latterSpacing = this.screens[key].slots[slotkey].latterSpacing;
                this.screens[key].slots[slotkey].subtitle.subtitle_lineBreak = this.screens[key].slots[slotkey].lineBreak;
                this.screens[key].slots[slotkey].subtitle.subtitle_lineHeight = this.screens[key].slots[slotkey].lineHeight;
               this.screens[key].slots[slotkey].subtitle.subTitleText = 'Subtitle Subtitle Subtitle Subtitle'
               this.screens[key].slots[slotkey].subtitle.subtitle_fontSize = 15;
            }else{
                this.screens[key].slots[slotkey].subtitle = null;
            }
           
            this.$forceUpdate();
            $('#screen-loader-'+key).hide();
            setTimeout(function(){   }, 2000);
        },
        resizeSubtitleTop(key,slotkey,slotid){
            if(typeof this.screens[key].slots[slotkey].subtitle != 'undefined' && typeof this.screens[key].slots[slotkey].subtitle != null && typeof  this.screens[key].slots[slotkey].subtitle.subtitle_top != 'undefined' && !slotid.toString().includes("subtitle")){
           
             this.screens[key].slots[slotkey].subtitle.subtitle_top = this.screens[key].slots[slotkey].top + $('#screen-'+key+'-slot-'+slotid).height();
               this.$forceUpdate();
            }
        },
        updateSubtitleData(key,slotkey,slotid){
              $('#screen-loader-'+key).show();
           this.screens[key].slots[slotkey].subtitle.subtitle_FontName = $('#fontfamily-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_TextCenter = $('#textalign-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_fontSize = $('#textsize-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_latterSpacing = $('#latterspace-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_lineBreak = $('#linebreak-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_lineHeight = $('#lineheight-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.screens[key].slots[slotkey].subtitle.subtitle_margin_top = $('#subtitlemargintop-tool-screen-'+key+'-slot-subtitle'+slotid).val();
           this.$forceUpdate();
             $('#screen-loader-'+key).hide();
        },
        titleVsubtitleRatio(key,slotkey,slotid){
               /* slot.fontSize = parseFloat(slot.FontSize / mainWidth *  slot.slotWidth).toFixed(2);
                  var chwidth = screen.height * oldWidth / oldHeight;
                var chHeight = screen.width * oldHeight / oldWidth;

                      slot.fontSize = slot.fontSize * mainWidth /  slot.slotWidth;
                         var oldSlotWidth = slot.slotWidth;*/

        },
        setImageSlotHeight(key,slotkey,slotid){
            var height = $('#screen-'+key+'-slot-'+slotid).height();
            $('#screen-'+key+'-slot-'+slotid).css('height',height);
            $('#screen-'+key+'-slot-'+slotid+' img').css('height',height);
            if (typeof height != 'undefined' && this.screens[key].slots.length > 0) {
                this.screens[key].slots[slotkey].Height = height;
                this.$forceUpdate();
            }
        },
        imageSizing(key,slotkey,slotType){
           var val =  $('#imgSizing-tool-screen-'+key+'-slot-'+slotType).val();
            if (val == 'contain') {
                 this.screens[key].slots[slotkey].objectFit = 'contain';
                 this.screens[key].slots[slotkey].objectPosition = 'center';
                 if (slotType.includes('frame')) {
                    var cslotType = slotType.replace('frame','inner');
                    $.each(this.screens[key].slots, function(slotI, slot){
                       if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.objectFit = 'contain';
                        slot.objectPosition = 'center';
                         }
                    })
                }
            }else  if (val == 'cover_center') {
                 this.screens[key].slots[slotkey].objectFit = 'cover';
                 this.screens[key].slots[slotkey].objectPosition = 'center';
                 if (slotType.includes('frame')) {
                    var cslotType = slotType.replace('frame','inner');
                    $.each(this.screens[key].slots, function(slotI, slot){
                       if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.objectFit = 'cover';
                        slot.objectPosition = 'center';
                         }
                    })
                }
            }else  if (val == 'cover_top') {
                 this.screens[key].slots[slotkey].objectFit = 'cover';
                 this.screens[key].slots[slotkey].objectPosition = 'top';
                 if (slotType.includes('frame')) {
                    var cslotType = slotType.replace('frame','inner');
                    $.each(this.screens[key].slots, function(slotI, slot){
                       if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.objectFit = 'cover';
                        slot.objectPosition = 'top';
                         }
                    })
                }
            }else  if (val == 'cover_bottom') {
                 this.screens[key].slots[slotkey].objectFit = 'cover';
                 this.screens[key].slots[slotkey].objectPosition = 'bottom';
                 if (slotType.includes('frame')) {
                    var cslotType = slotType.replace('frame','inner');
                    $.each(this.screens[key].slots, function(slotI, slot){
                       if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.objectFit = 'cover';
                        slot.objectPosition = 'bottom';
                         }
                    })
                }
            }
            this.$forceUpdate();
        },
        changeDeviceType(key,slotkey,slotType){
            $('#screen-loader-'+key).show();
            var val = $('#devicetype-tool-screen-'+key+'-slot-'+slotType).val();
            var cslotType = slotType.replace('frame','inner');
            if (val == 'full_device') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).show();
                this.screens[key].slots[slotkey].display = 'block'; 
            /*    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].MainimgRoation; */
                 this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(24deg)',''); 
                        this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(-15deg)',''); 
                 $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)','');
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)','');
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)','');
                    }
                 });
            }else if (val == '3D_left') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).show();
                this.screens[key].slots[slotkey].display = 'block'; 
                if (this.screens[key].slots[slotkey].imgRoation.includes('rotateY(-15deg)')) {
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(-15deg)','rotateY(24deg)');
                }else if (!this.screens[key].slots[slotkey].imgRoation.includes('rotateY(24deg)')) {
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation+' rotateY(24deg)'; 
                }
                $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        if (slot.imgRoation.includes('rotateY(-15deg)')) {
                            slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)','rotateY(24deg)');
                        }else if (!slot.imgRoation.includes('rotateY(24deg)')) {
                            slot.imgRoation = slot.imgRoation+' rotateY(24deg)'; 
                        } 
                    }
                });
            }else if (val == '3D_right') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).show();
                this.screens[key].slots[slotkey].display = 'block'; 
                if (this.screens[key].slots[slotkey].imgRoation.includes('rotateY(24deg)')) {
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(24deg)','rotateY(-15deg)');
                }else if (!this.screens[key].slots[slotkey].imgRoation.includes('rotateY(-15deg)')) {
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation+' rotateY(-15deg)'; 
                }
                $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                         if (slot.imgRoation.includes('rotateY(24deg)')) {
                            slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)','rotateY(-15deg)');
                        }else if (!slot.imgRoation.includes('rotateY(-15deg)')) {
                            slot.imgRoation = slot.imgRoation+' rotateY(-15deg)'; 
                        }
                    }
                });
            }else if (val == 'shot_only') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).hide();
                this.screens[key].slots[slotkey].display = 'none';
                  this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(24deg)',''); 
                        this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotateY(-15deg)',''); 
                 $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)',''); 
                        slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)',''); 
                    }
                 });
            }else if (val == 'shot_only_3d_right') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).hide();
                this.screens[key].slots[slotkey].display = 'none';
                $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                          if (slot.imgRoation.includes('rotateY(24deg)')) {
                            slot.imgRoation = slot.imgRoation.replace('rotateY(24deg)','rotateY(-15deg)');
                        }else if (!slot.imgRoation.includes('rotateY(-15deg)')) {
                            slot.imgRoation = slot.imgRoation+' rotateY(-15deg)'; 
                        }
                    }
                });
            }else if (val == 'shot_only_3d_left') {
                $('#maindevicestyle-tool-screen-'+key+'-slot-'+slotType).hide();
                this.screens[key].slots[slotkey].display = 'none';
                $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        if (slot.imgRoation.includes('rotateY(-15deg)')) {
                            slot.imgRoation = slot.imgRoation.replace('rotateY(-15deg)','rotateY(24deg)');
                        }else if (!slot.imgRoation.includes('rotateY(24deg)')) {
                            slot.imgRoation = slot.imgRoation+' rotateY(24deg)'; 
                        }
                    }
                });
            }
            this.$forceUpdate();
            $('#screen-loader-'+key).hide();
        },
        changeDeviceOrientation(key,slotkey,slotType){
            $('#screen-loader-'+key).show();
            var $this  = this;
             var val = $('#deviceorientation-tool-screen-'+key+'-slot-'+slotType).val();
              var cslotType = slotType.replace('frame','inner');
             if(val == 'portrait'){
                
                 if (this.screens[key].slots[slotkey].imgRoation.includes('rotate(-90deg)') || this.screens[key].slots[slotkey].imgRoation.includes('rotate(90deg)')) {
                     this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(-90deg)','rotate(0deg)');
                     this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(90deg)','rotate(0deg)');
                 }
                  this.screens[key].slots[slotkey].slotWidth =  this.screens[key].slots[slotkey].MainslotWidth;
                  this.screens[key].slots[slotkey].top =  this.screens[key].slots[slotkey].Maintop;
                  this.screens[key].slots[slotkey].left =  this.screens[key].slots[slotkey].Mainleft;
                $('#screen-'+key+'-slot-'+slotType+' img').css('height','auto');
                 $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                      if (slot.imgRoation.includes('rotate(-90deg)') || slot.imgRoation.includes('rotate(90deg)')) {
                         slot.imgRoation = slot.imgRoation.replace('rotate(-90deg)','rotate(0deg)');
                         slot.imgRoation =  slot.imgRoation.replace('rotate(90deg)','rotate(0deg)');
                     }else{
                         slot.imgRoation = slot.imgRoation+' rotate(0deg)';
                     }
                      slot.slotWidth = slot.MainslotWidth;
                         slot.top = slot.Maintop;
                         slot.left = slot.Mainleft;
                          $('#screen-'+key+'-slot-'+slot.SlotType+' img').css('height','auto');
                       
                    }
                });



             }else if(val == 'landscape_right'){
                 if (this.screens[key].slots[slotkey].imgRoation.includes('rotate(0deg)') || this.screens[key].slots[slotkey].imgRoation.includes('rotate(90deg)')) {
                      this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(0deg)','rotate(-90deg)');
                      this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(90deg)','rotate(-90deg)');
                 }else{
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation+' rotate(-90deg)';
                 }
                 this.screens[key].slots[slotkey].objectFit = 'contain';
              $('#screen-'+key+'-slot-'+slotType+' img').css('height',this.screens[key].slots[slotkey].slotWidth+'px');
                 $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        if (slot.imgRoation.includes('rotate(0deg)') || slot.imgRoation.includes('rotate(90deg)')) {
                              slot.imgRoation = slot.imgRoation.replace('rotate(0deg)','rotate(-90deg)');
                              slot.imgRoation = slot.imgRoation.replace('rotate(90deg)','rotate(-90deg)');
                        }else{
                            slot.imgRoation = slot.imgRoation+' rotate(-90deg)';
                        }
                         slot.objectFit = 'contain';
                         slot.slotWidth = $this.screens[key].slots[slotkey].slotWidth;
                         slot.top = $this.screens[key].slots[slotkey].top;
                         slot.left = $this.screens[key].slots[slotkey].left;
                         $('#screen-'+key+'-slot-'+slot.SlotType+' img').css('height',slot.slotWidth+'px');
                         $('#imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType).val(slot.objectFit);
                    }
                });

             }else if(val == 'landscape_left'){

                 if (this.screens[key].slots[slotkey].imgRoation.includes('rotate(0deg)') || this.screens[key].slots[slotkey].imgRoation.includes('rotate(-90deg)')) {
                      this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(0deg)','rotate(90deg)');
                      this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace('rotate(-90deg)','rotate(90deg)');
                 }else{
                    this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation+' rotate(90deg)';
                 }
                  this.screens[key].slots[slotkey].objectFit = 'contain';
               $('#screen-'+key+'-slot-'+slotType+' img').css('height',this.screens[key].slots[slotkey].slotWidth+'px');
                 $.each(this.screens[key].slots, function(slotI, slot){
                    if (cslotType == slot.SlotType.split('-')[0]) {
                        if (slot.imgRoation.includes('rotate(0deg)') || slot.imgRoation.includes('rotate(-90deg)')) {
                             slot.imgRoation =  slot.imgRoation.replace('rotate(0deg)','rotate(90deg)');
                             slot.imgRoation = slot.imgRoation.replace('rotate(-90deg)','rotate(90deg)');
                        }else{
                            slot.imgRoation = slot.imgRoation+' rotate(90deg)';
                        }
                        slot.objectFit = 'contain';
                         slot.slotWidth = $this.screens[key].slots[slotkey].slotWidth;
                         slot.top = $this.screens[key].slots[slotkey].top;
                         slot.left = $this.screens[key].slots[slotkey].left;
                         $('#screen-'+key+'-slot-'+slot.SlotType+' img').css('height',slot.slotWidth+'px');
                         $('#imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType).val(slot.objectFit);
                    }
                });

             }
                this.$forceUpdate();
            $('#screen-loader-'+key).hide();
        },
          changeDeviceRotation(key,slotkey,slotType){
            $('#screen-loader-'+key).show();
            var $this  = this;
            var val = $('#imgrotation-tool-screen-'+key+'-slot-'+slotType).val();
            var cslotType = slotType.replace('frame','inner');
            var zRotation = "rotateZ("+val+"deg)";
            

             if (typeof this.screens[key].slots[slotkey].rotationZ != 'undefined' && this.screens[key].slots[slotkey].imgRoation.includes(this.screens[key].slots[slotkey].rotationZ)) {
                 this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation.replace(this.screens[key].slots[slotkey].rotationZ,zRotation);
                 this.screens[key].slots[slotkey].rotationZ = zRotation;
             }else{
                this.screens[key].slots[slotkey].imgRoation = this.screens[key].slots[slotkey].imgRoation+' '+zRotation;
                this.screens[key].slots[slotkey].rotationZ = zRotation;
            }
            $.each(this.screens[key].slots, function(slotI, slot){
                if (cslotType == slot.SlotType.split('-')[0]) {
                  if (typeof slot.rotationZ != 'undefined' && slot.imgRoation.includes(slot.rotationZ)) {
                     slot.imgRoation = slot.imgRoation.replace(slot.rotationZ,zRotation);
                     slot.rotationZ = zRotation;
                 }else{
                     slot.imgRoation = slot.imgRoation+' '+zRotation;
                     slot.rotationZ = zRotation;
                 }

             }
         });
        



                this.$forceUpdate();
            $('#screen-loader-'+key).hide();
        },
        ScreenDownload(key){
              $('#screen-loader-'+key).show();
            var mthis = this;
            this.resetSlotHieghts();
            var mainscreen = this.screens[key]
            var chscreen = mainscreen

              var oldWidth  = chscreen.width;
                var oldHeight  = chscreen.height;
             
                var mainWidth = chscreen.mainWidth ;
                var mainHeight = chscreen.mainHeight;
                   chscreen.width =mainWidth;
                chscreen.height = mainHeight;
                var chwidth = mainHeight * oldWidth / oldHeight;
                var chHeight = mainWidth * oldHeight / oldWidth;
                      $.each(chscreen.slots, function(slotI, slot){

                         slot.fontSize = slot.fontSize * mainWidth /  slot.slotWidth;
                         var oldSlotWidth = slot.slotWidth;

                         slot.top = slot.top / oldHeight;
                         slot.top = slot.top * mainHeight

                         slot.slotWidth = slot.slotWidth / oldWidth;
                         slot.slotWidth = slot.slotWidth * chwidth;

                         slot.Height = slot.Height * mainHeight;

                         var changesWidth = oldSlotWidth - slot.slotWidth;

                          slot.left =  slot.left / oldWidth
                         slot.left =  slot.left * mainWidth;
                         slot.fontSize = slot.fontSize / mainWidth *  slot.slotWidth;
                     
                   })
         /*   this.downloadScreen = chscreen;*/
            html2canvas($('.screen-'+key)[0], {allowTaint : true}).then(function(canvas) {
            /*     var dataURL = canvas.toDataURL();*/
                  canvas.toBlob(function(blob) {
                    saveAs(blob, "Dashboard.png"); 
                  });
                 console.log('on download here');
                 $('#screen-loader-'+key).hide();
               
            });



        }

    
    }
}
</script>