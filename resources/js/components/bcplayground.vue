<template>
    <div>
       <vue-confirm-dialog></vue-confirm-dialog>
       <main class="inner-main mobile-only">
          <div class="mobile-msg">
             <i class="fa fa-exclamation-triangle"></i>
             <h4>Screen is too small</h4>
             <p>You must be on a larger device to enter the design studio editor!</p>
          </div>
       </main>
       <div class="side-tool-bar dekstop-only">
          <div class="logo">
             <a href="/"><img src="/studio/assets/img/logo-small.svg"></a>
          </div>
          
          <ul>
             <li class=" sidelinks"  v-on:click="handToggle(0,'111',111,'sidelink')" title="Templates"><img src="/studio/assets/img/template-icon.svg"><br> <span>Templates</span></li>
             <li class=" sidelinks" v-on:click="handToggle(0,'112',112,'sidelink')" title="Shapes"><img src="/studio/assets/img/shapes-icon.svg"><br> <span>Shapes</span></li>
             <li class=" sidelinks"  v-on:click="handToggle(0,'1',2,'sidelink')" title="Typography"><img src="/studio/assets/img/text-icon.svg"><br> <span>Text</span></li>
             <li  class=" sidelinks" v-on:click="handToggle(0,'0',1,'sidelink')" title="Background"><img src="/studio/assets/img/background-icon.svg"><br> <span>Background</span></li>
             <li class=" sidelinks" @click="showDropdown('layers',1)"  title="Layers"><img src="/studio/assets/img/layers-icon.svg"><br> <span>Layers</span></li>
          </ul>
       </div>
       <main class="tool-main dekstop-only" style="margin-top:70px;">
          <nav class="navbar tool-nav navbar-expand-md main-nav navigation fixed-top sidebar-left">
             <div class="container-fluid">
                <button class="navbar-toggler" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
                <a href="javascript:;"  @click="$router.back()" class="nav-link scrollto"><i class="fas fa-arrow-left"></i> Back</a>
          
                <div class="collapse navbar-collapse" id="main-navbar">
                   <ul class="nav navbar-nav  ml-auto">
                      <li class="nav-link" v-if="history.length > 0">
                           <button class="undoredo" v-if="history[current_view_stat - 1] != undefined" @click="undoRedoState('undo')"><i class="fa fa-undo"></i></button>
                           <button class="undoredo" v-else disabled><i class="fa fa-undo"></i></button>
                            <button class="undoredo" v-if="history[current_view_stat + 1] != undefined" @click="undoRedoState('redo')"><i class="fa fa-redo"></i></button>
                           <button class="undoredo" v-else disabled><i class="fa fa-redo"></i></button>
                      </li>
                       <li class="nav-link" v-else>
                          <button class="undoredo" disabled><i class="fa fa-undo"></i></button>
                         <button class="undoredo"  disabled><i class="fa fa-redo"></i></button>
                      
                      </li>
                   </ul>
                   <ul class="nav navbar-nav ml-auto">
                      <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="javascript:;" @click="showDropdown('layers',1)" data-toggle="dropdown">
                         <img src="/studio/assets/img/layers-icon.svg" style="    height: 30px;">
                         </a>
                         <div class="menu layers" v-if="layersDropdown" >
                          <div v-for="(screen, key) in screens"  :id="key">
                         
                            <a v-for="(slot,slotKey) in screen.slots" v-if="slot.type == 'text'" href="javascript:;"  class=" dropdown-item "  data-type="text">
                            <span class="preview"  v-on:click="selectSlot(key,slotKey,slot.slotid)"> {{slot.SlotType}}</span> 
                            <span class="icon" @click="showHideslot(key,slotKey,false)" v-if="slot.show"><i class="fa fa-eye text-primary"></i></span> 
                            <span class="icon" @click="showHideslot(key,slotKey,true)" v-else><i class="fa fa-eye-slash text-primary"></i></span> 
                            <span class="icon"  @click="removeSlot(key,slotKey)"><i class="fa fa-trash text-danger"></i></span>
                            </a>
                            <a  v-for="(slot, slotKey) in screen.slots"  v-if="slot.type == 'image'" href="javascript:;"  :id="'headersvgslot'+slotKey"  class="dropdown-item"   data-type="image">
                                 <inline-svg   v-if="slot.SlotImageUrl.includes('.svg')"
                                  :src="slot.SlotImageUrl" 
                                  :class="'headersvgslot'+slotKey"
                                  v-on:click="selectSlot(key,slotKey,slot.slotid)"
                                  width="100%" 
                                  height="100%"
                               ></inline-svg>
                            <img :src="slot.SlotImageUrl" v-else  v-on:click="selectSlot(key,slotKey,slot.slotid)">  
                            <span class="icon" @click="showHideslot(key,slotKey,false)" v-if="slot.show"><i class="fa fa-eye text-primary"></i></span> 
                            <span class="icon" @click="showHideslot(key,slotKey,true)" v-else><i class="fa fa-eye-slash text-primary"></i></span> 
                            <span class="icon" @click="removeSlot(key,slotKey)"><i class="fa fa-trash text-danger"></i></span>
                            </a>
                         </div>
                         </div>
                      </li>
                      <li class="nav-item dropdown" v-if="mainDataList.type != 'business_cards' && screens[0].mainWidth != undefined && screens[0].mainWidth > 2000">
                         <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',1)" data-toggle="dropdown">
                         
                         <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                         </svg>&nbsp; &nbsp;Download <span v-if="screens.length > 1">Side 1</span> </a>
                         <div class="menu dowloadone" v-if="downloadDropdown">
                            <a class="dropdown-item" href="javascript:;" v-for="(size,sizeKey) in PrintSizes" :key="sizeKey" @click="ScreenDownload(0,'png',sizeKey)">
                            <i class="first-icon fa fa-image" ></i> <span><strong>{{sizeKey}}</strong><br>{{size.widthM}} X {{size.heightM}} mm</span><i class="fa fa-download"></i>
                            </a>
                         </div>
                      </li>
                      <li class="nav-item dropdown" v-else>
                         <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',1)" data-toggle="dropdown">
                         
                         <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                         </svg>&nbsp; &nbsp;Download <span v-if="screens.length > 1">Side 1</span> </a>
                         <div class="menu dowloadone" v-if="downloadDropdown">
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(0,'png','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>PNG</strong><br>High Quality image</span><i class="fa fa-download"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(0,'jpeg','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>JPG</strong><br>Small file size image</span><i class="fa fa-download"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(0,'webp','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>WEBP</strong><br>Compress image for web</span><i class="fa fa-download"></i>
                            </a>
                         </div>
                      </li>
                      <li class="nav-item dropdown" v-if="screens.length > 1 && mainDataList.type != 'business_cards' && screens[0].mainWidth != undefined && screens[0].mainWidth > 2000">
                         <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',2)" data-toggle="dropdown">
                         
                         <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                         </svg>&nbsp; &nbsp;Download <span v-if="screens.length > 1">Side 2</span> </a>
                         <div class="menu dowloadone" v-if="downloadDropdownTwo">
                            <a class="dropdown-item" href="javascript:;" v-for="(size,sizeKey) in PrintSizes" :key="sizeKey" @click="ScreenDownload(1,'png',sizeKey)">
                            <i class="first-icon fa fa-image" ></i> <span><strong>{{sizeKey}}</strong><br>{{size.widthM}} X {{size.heightM}} mm</span><i class="fa fa-download"></i>
                            </a>
                         </div>
                      </li>
                      <li class="nav-item dropdown" v-else-if="screens.length > 1">
                         <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',2)" data-toggle="dropdown">
                         
                         <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                         </svg>&nbsp; &nbsp;Download Side 2 </a>
                         <div class="menu dowloadone" v-if="downloadDropdownTwo">
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(1,'png','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>PNG</strong><br>High Quality image</span><i class="fa fa-download"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(1,'jpeg','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>JPG</strong><br>Small file size image</span><i class="fa fa-download"></i>
                            </a>
                            <a class="dropdown-item" href="javascript:;" @click="ScreenDownload(1,'webp','simple')">
                            <i class="first-icon fa fa-image" ></i> <span><strong>WEBP</strong><br>Compress image for web</span><i class="fa fa-download"></i>
                            </a>
                         </div>
                      </li>
                   </ul>
                </div>
             </div>
          </nav>
          <div class="row m-0" @click="hideDropdown">
             <div class="col-2 p-0 side-panels" style="height:92.8vh;overflow-y:scroll">
                <div class="panel-group" id="accordion">
                   <div class="panel  panel-default" style="">
                      <div :id="'tool-screen-0-slot-111'" class="panel-collapse  collapse show">
                         <div class="panel-body p-3" >
                        
                               <div class="input-group" v-if="$route.params.slug != 'meme'" >
                                  <input name="template" class="form-control" placeholder="Search Template" v-on:keyup="getTemplatesData" v-on:keypress="getTemplatesData" v-model="templateSearch">
                                  <div class="input-group-append" @click="getTemplatesData">
                                     <span class="input-group-text"><i class="fa fa-search"></i></span>
                                  </div>
                               </div>
                                   <div class="templatesLoader text-center mt-3" v-if="templatesLoader"><i class="fa fa-spinner fa-spin"></i></div>
                            <div v-else-if="showtempslist">
                               <div  v-for="(cat,catkey) in newtemplates" :class="'mt-3 tempcats temp-cats-'+catkey">
                                  <h5>{{cat.name}} <a href="javascript:;" @click="showallcatstemplates(cat.id,cat.name)" class="float-right"><small>See All</small></a></h5>
                                  <ul class=" tool-templates-list" >
                                     <li class="" v-for="template in cat.templatesonlytwo.slice(0,2)" @click="selectTemplate(template)">
                                        <img :src="template.main_image" class="w-100">
                                     </li>
                                  </ul>
                               </div>
                            </div>
                            <div v-else>
                               <h5 class="mt-3">{{selectedCat.name}} <a href="javascript:;" v-if="$route.params.slug != 'meme'" @click="backtolist" class="float-right"><small>Back </small></a></h5>
                               <ul class=" tool-templates-list"  >
                                  <li class="" v-for="template in selectedCat.templates" @click="selectTemplate(template)">
                                     <img :src="template.main_image" class="w-100" v-bind:style="[$route.params.slug == 'meme' ? {height: '150px','object-fit': 'fill'} : '' ]">
                                  </li>
                               </ul>
                               <infinite-loading @infinite="catstemplatesonscroll"></infinite-loading>
                            </div>
                         </div>
                      </div>
                   </div>
                     <div class="panel  panel-default" style="">
                      <div :id="'tool-screen-0-slot-112'" class="panel-collapse  collapse">
                         <div class="panel-body p-3" >
                          
                               <div class="input-group">
                                  <input name="template" class="form-control" placeholder="Search Shape" v-on:keyup="getShapes" v-on:keypress="getShapes" v-model="shapeSearch">
                                  <div class="input-group-append" @click="getShapes">
                                     <span class="input-group-text"><i class="fa fa-search"></i></span>
                                  </div>
                               </div>
                                 <div class="templatesLoader text-center mt-3" v-if="shapesLoader"><i class="fa fa-spinner fa-spin"></i></div>
                            <div v-else-if="showshapeslist">
                               <div  v-for="(cat,catkey) in shapes" :class="'mt-3 tempcats temp-cats-'+catkey">
                                  <h5>{{cat.name}} <a href="javascript:;" @click="showallcatsShapes(cat.id,cat.name)" class="float-right"><small>All</small></a></h5>
                                  <ul class=" tool-templates-list" >
                                     <li class="" v-for="template in cat.shapesonlytwo" @click="selectShape(template)">
                                        <img :src="template.image" class="w-100">
                                     </li>
                                  </ul>
                               </div>
                            </div>
                            <div v-else>
                               <h5 class="mt-3">{{selectedShapeCat.name}} <a href="javascript:;" @click="backtolist" class="float-right"><small>Back </small></a></h5>
                               <ul class=" tool-templates-list"  >
                                  <li class="" v-for="template in selectedShapeCat.templates" @click="selectShape(template)">
                                     <img :src="template.image" class="w-100">
                                  </li>
                               </ul>
                               <infinite-loading @infinite="catsShapesonscroll"></infinite-loading>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div  v-for="(screen, key) in screens" :class="'tool-box  tool-screen-'+key" style="position:relative;">
                   <!-- <div class="tool-header">
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
                            <a href="javascript:;" v-on:click="ScreenDownload(key,JSON.stringify(screen))"><i class="fa fa-download"></i></a>
                         </li>
                         <li>
                            <a href="javascript:;" v-on:click="setCurrentScreen(key)" data-toggle="modal" data-target="#copySettingsModal"><i class="fa fa-exchange-alt"></i></a>
                         </li>
                         <li>
                            <a href="javascript:;" v-on:click="toolPanelLock(key)" :class="'tool-lock-btn-'+key"><i class="fa fa-unlock"></i></a>
                         </li>
                         <li>
                            <a href="javascript:;" v-on:click="removeScreen(key)"><i class="fa fa-trash text-danger"></i></a>
                         </li>
                      </ul>
                      </div> -->
                   <div class="panel-group" id="accordion">
                      <div class="panel  panel-default" style="">
                         <div :id="'tool-screen-'+key+'-slot-'+screen.bgid" class="panel-collapse collapse">
                            <div class="panel-body">
                               <label>Background Image</label>
                               <div v-if="screen.TemplatebackgroundImage != ''">
                                  <div class="mt-2 mb-3 backgroundPreview">
                                     <img :src="screen.TemplatebackgroundImage" style="height:100px">
                                  </div>
                                  <div class="row">
                                     <div class="col-6 pr-1">
                                        <div class="cus-select">
                                           <span class="text-white">Sizing</span>
                                           <select :id="'bgsizing-tool-screen-'+key" :name="'bgsizing-tool-screen-'+key" v-model="screen.bgSize">
                                              <option value="contain">Contain</option>
                                              <option value="cover">Fit to screen</option>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="col-6 pl-1" v-if="screen.bgSize != 'cover'">
                                        <div class="cus-select">
                                           <span class="text-white">Image Position</span>
                                           <select :id="'bgpostion-tool-screen-'+key" :name="'bgpostion-tool-screen-'+key" v-model="screen.bgPosition">
                                              <option value="bottom">Bottom</option>
                                              <option value="center">Middle</option>
                                              <option value="top">Top</option>
                                           </select>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="cus-select">
                                     <span class="text-white">Image rotation</span>
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
                                  <a href="javascript:;"  v-on:click="clearbgImage(key)" v-if="screen.TemplatebackgroundImage != ''" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> &nbsp; Clear</a>
                               </div>
                               <label class="mt-2">Background Style</label>
                               <div class="cus-select">
                                  <span class="text-white">Background style</span>
                                  <select :id="'bgstyle-tool-screen-'+key" :name="'bgstyle-tool-screen-'+key"  v-on:click="changeBgStyle(key)">
                                     <option value="">None</option>
                                     <option value="color" v-if="screen.backgroundColor != '#ffffff' && screen.backgroundColor.length >= 7" selected>Color</option>
                                     <option value="color" v-else>Color</option>
                                     <option value="gradient">Gradient</option>
                                  </select>
                               </div>
                               <div :id="'color-picker-'+key"  class="background-color-picker" v-bind:style="[screen.backgroundColor == '#ffffff' ? {display: 'none'} : {display: 'none'} ]">
                                  <div class="row">
                                     <div class="col-5 pr-2">
                                        <div class="check-color"  :style="'background:'+screen.backgroundColor" data-toggle="modal" :data-target="'#colorPicker'+key"></div>
                                     </div>
                                     <div class="col-7 pl-0">
                                        <span>Background style color - Hex</span>
                                        <input type="text" v-model="screen.backgroundColor">
                                     </div>
                                  </div>
                                  <div class="modal" :id="'colorPicker'+key" style="z-index:105099999999">
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
                                  <div class="modal" :id="'gradientPicker'+key"  style="z-index:105099999999">
                                     >
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
                      <div class="panel show panel-default" v-for="(slot , slotKey) in screen.slots" v-if="slot.type == 'text'">
                         <div :id="'tool-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse  collapse">
                            <div class="panel-body">
                               <div class="row">
                                 
                               </div>
                              
                               <div>
                                  <h4>Text Editor</h4>
                                  <div class="mb-3">
                                     <quill-editor :data-slotkey="slotKey" :data-screenkey="key" :data-slotid="slot.slotid" :id="'tool-screen-'+key+'-slot-'+slot.slotid"
                                        :options="editorOption" @focus="setSlotHeight(key,slotKey,slot.slotid)" 
                                        @change="onEditorChange($event)" :content="slot.SlotType"/>
                                  </div>
                                  <div class="text-center">
                                     <button type="button" @click="addTextSlot(key,slotKey)" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i> &nbsp; Add New Text</button>
                                  </div>
                                  <hr>
                                  <h4>Text</h4>
                                  <div class="row mb-3">
                                     <div class="col-8 pr-0">
                                        <select class="form-control select2" v-model="slot.FontName" :id="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" :name="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" >
                                           <option v-for="f in fonts" :value="f.font" :style="'font-family:'+f.font">{{f.font}}</option>
                                        </select>
                                     </div>
                                     <div class="col-4">
                                        <select class="form-control" v-model="slot.fontSize">
                                           <option v-for="i in 100" :value="i" v-bind:key="i">{{i}}</option>
                                        </select>
                                     </div>
                                  </div>
                                  <div class="row mb-3">
                                     <div class="col-6 pr-1 letter-specing">
                                          <div class="input-group">
                                        <input type="number" class="form-control" min="0" max="30" :id="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" :name="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.latterSpacing">
                                           <div class="input-group-append">
                                     <span class="input-group-text"><img src="/studio/assets/img/letter-specing.svg"></span>
                                  </div>
                                  </div>
                                     </div>
                                     <div class="col-6 pl-1 line-hieght">
                                         <div class="input-group">
                                          <input type="number" class="form-control" :id="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" :name="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineHeight">
                                         <div class="input-group-append" >
                                     <span class="input-group-text"><img src="/studio/assets/img/line-hieght.svg"></span>
                                  </div>
                                  </div>
                                     </div>
                                  </div>
                                  <ul class="text-toolbar m-3">
                                     <li @click="textTools(key,slotKey,'bold')"><i class="fa fa-bold"></i></li>
                                     <li @click="textTools(key,slotKey,'italic')"><i class="fa fa-italic"></i></li>
                                     <li @click="textTools(key,slotKey,'underline')"><i class="fa fa-underline"></i></li>
                                     <li @click="textTools(key,slotKey,'left')"><i class="fa fa-align-left"></i></li>
                                     <li @click="textTools(key,slotKey,'center')"><i class="fa fa-align-center"></i></li>
                                     <li @click="textTools(key,slotKey,'right')"><i class="fa fa-align-right"></i></li>
                                     <li @click="textTools(key,slotKey,'uppercase')"><img src="/studio/assets/img/uppercase.svg"></li>
                                     <li @click="textTools(key,slotKey,'lowercase')"><img src="/studio/assets/img/lowercase.svg"></li>
                                  </ul>
                                  <h4>Color</h4>
                                  <div class="current-color">
                                     <label>Default Color</label>
                                     <ul class="colors">
                                        <li @click="changecolor(key,slotKey,slot.TextColor_RED,slot.TextColor_GREEN,slot.TextColor_Brown)"  :style="'background:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');'"></li>
                                     </ul>
                                  </div>
                                  <div class="current-color">
                                     <label>Current Color</label>
                                     <ul class="colors">
                                        <li :style="'background:'+slot.textColor"></li>
                                     </ul>
                                  </div>
                                   <div class="new-color">
                                     <label>New Colors</label>
                                     <ul class="colors">
                                        <li class="position-absolute" data-toggle="modal" :data-target="'#textcolorPicker-'+key+'-'+slotKey"><i class="fa fa-plus"></i></li>
                                         <!-- <li :style="'background:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');'"></li> -->
                                        <li class="ml-38" @click="changecolor(key,slotKey,'0','0','0')" :style="'background:rgb(0,0,0);'"></li>
                                        <li @click="changecolor(key,slotKey,'255','255','255')" :style="'background:rgb(255,255,255);'"></li>
                                        <li @click="changecolor(key,slotKey,'103','103','103')" :style="'background:rgb(103,103,103);'"></li>
                                        <!-- <li @click="changecolor(key,slotKey,'134','134','134')" :style="'background:rgb(134,134,134);'"></li> -->
                                        <li @click="changecolor(key,slotKey,'181','181','181')" :style="'background:rgb(181,181,181);'"></li>
                                        <li @click="changecolor(key,slotKey,'224','224','224')" :style="'background:rgb(224,224,224);'"></li>
                                        <li @click="changecolor(key,slotKey,'225','163','95')" :style="'background:rgb(225,163,95);'"></li>
                                        <li @click="changecolor(key,slotKey,'225','112','106')" :style="'background:rgb(225,112,106);'"></li>
                                        <li @click="changecolor(key,slotKey,'225','130','207')" :style="'background:rgb(225,130,207);'"></li>
                                        <li @click="changecolor(key,slotKey,'214','135','235')" :style="'background:rgb(214,135,235);'"></li>
                                        <li @click="changecolor(key,slotKey,'159','112','255')" :style="'background:rgb(159,112,255);'"></li>
                                        <li @click="changecolor(key,slotKey,'100','138','255')" :style="'background:rgb(100,138,255);'"></li>
                                        <li @click="changecolor(key,slotKey,'66','95','255')" :style="'background:rgb(66,95,255);'"></li>
                                        <li @click="changecolor(key,slotKey,'106','229','255')" :style="'background:rgb(106,229,255);'"></li>
                                     </ul>
                                  </div>
                                   <div class="modal" :id="'textcolorPicker-'+key+'-'+slotKey"  style="z-index:105099999999">
                                                 >
                                                 <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                    <div class="modal-content">
                                                       <div class="modal-header">
                                                          <h4 class="modal-title">&nbsp;</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       </div>
                                                       <div class="modal-body">
                                                          <color-panel v-model="slot.textColor"></color-panel>
                                                          <br>
                                                       </div>
                                                       <div class="modal-footer">
                                                          <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                          <button type="button" class="text-success btn-none float-right" @click="setColor(key,slotKey)" data-dismiss="modal">Save</button>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
 
                                  
                                      <div class="mb-3" :id="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" >
                                        <label>Opacity</label>
                                        <input type="range" class="form-control" min="1" max="100" :id="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" :name="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.opacity" >
                                     </div>
                                     <div class="row mb-3">
                                                 <div class="col-6 pr-1">
                                     <button type="button" @click="flipSlot(key,slotKey,'horizental')" style="font-size:13px" class="btn btn-block btn-secondary btn-sm"><img src="/studio/assets/img/flip-horizental.svg"> &nbsp; Flip Horizontal</button> 
                                          </div>
                                          <div class="col-6 pl-1">
                                     <button type="button" @click="flipSlot(key,slotKey,'vertical')" style="font-size:13px" class="btn btn-block btn-secondary btn-sm"><img src="/studio/assets/img/flip-vertical.svg"> &nbsp; Flip Vertical</button>
                                          </div>
                                     </div>
                                      
                                  <div class="panel panel-default shadow-panel">
                                     <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.slotid"  v-on:click="handShowBoxToggle(key,slot.slotid)">
                                        <div class="panel-heading">
                                           <h4 class="panel-title" v-if="slot.type == 'text'">
                                              <i class="fa fa-border-style"></i> Shadow Effect <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                           </h4>
                                        </div>
                                     </a>
                                     <div :id="'box-shadow-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                        <div class="panel-body mb-0">
                                           <div class="cus-select">
                                              <span class="text-white">Shadow style</span>
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
                                              <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey"  style="z-index:105099999999">
                                                 >
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
                                              
                                                 <div class="col-12">
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
                      <div class="panel panel-default" v-for="(slot , slotKey) in screen.slots" v-if="slot.type == 'image'  ">
                         <div>
                            <div :id="'tool-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                               <div class="panel-body" >
                                  <div class="mt-2 mb-3 backgroundPreview"  v-if="slot.SlotImageUrl != ''">
                                       <inline-svg  
                                         v-if="slot.SlotImageUrl.includes('.svg')"
                                        :src="slot.SlotImageUrl" 
                                        width="100%" 
                                        height="100%"
                                        aria-label="Tool Slot Image"
                                     ></inline-svg>
                                     <img :src="slot.SlotImageUrl" style="height:100px" v-else>
                                  </div>
                                  <div class="row " v-if="slot.SlotImageUrl != ''" >
                                     <div class="col-6 pr-1">
                                        <div class="cus-select">
                                           <span class="text-white">Sizing</span>
                                           <select v-if="slot.objectFit == 'contain'" :id="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imgSizing-tool-screen-'+key+'-slot-'+slot.SlotType" v-model="slot.objectFit" @change="imageSizing(key,slotKey,slot.SlotType)">
                                              <option value="contain">Contain</option>
                                              <!-- <option value="cover_bottom">Cover - Anchor Bottom</option> -->
                                              <option value="cover_center">Fit</option>
                                              <!-- <option value="cover_top">Cover - Anchor Top</option> -->
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
                                           <span class="text-white">Image Postion</span>
                                           <select :id="'imagePosition-tool-screen-'+key+'-slot-'+slot.SlotType" :name="'imagePosition-tool-screen-'+key+'-slot-'+slot.SlotType" v-model="slot.objectPosition">
                                              <option value="center">Middle</option>
                                              <option value="top">Top</option>
                                              <option value="bottom">Bottom</option>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="col-6 pl-1" v-bind:style="[slot.objectFit == 'contain'?{'display': 'none'} : {'display': 'block'}]" style="">
                                        <div class="cus-select">
                                           <span class="text-white">Image rotation</span>
                                           <select :id="'imgrotation-tool-screen-'+key" :name="'imgrotation-tool-screen-'+key" v-model="slot.imgRoation">
                                              <option value="rotate(0deg)">None</option>
                                              <option value="rotate(90deg)">90*</option>
                                              <option value="rotate(180deg)">180*</option>
                                              <option value="rotate(270deg)">270*</option>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="col-6 pr-1 mb-3" >
                                           <label class="text-white">Width</label>
                                           <input type="number" v-model="slot.slotWidth" class="form-control">
                                     </div>
                                      <div class="col-6 pl-1 mb-3" >
                                           <label class="text-white">Height</label>
                                           <input type="number" v-model="slot.slotHeight" class="form-control">
                                     </div>
                                  </div>
                                  <div class="new-color" v-if="slot.SlotImageUrl.includes('.svg')">
                                     <label>Change Color</label>
                                     <ul class="colors">
                                        <li class="position-absolute" data-toggle="modal" :data-target="'#svgcolorPicker-'+key+'-'+slotKey"><i class="fa fa-plus"></i></li>
                                         <!-- <li :style="'background:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');'"></li> -->
                                        <li class="ml-38" @click="changesvgcolor(key,slotKey,'0','0','0')" :style="'background:rgb(0,0,0);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'255','255','255')" :style="'background:rgb(255,255,255);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'103','103','103')" :style="'background:rgb(103,103,103);'"></li>
                                        <!-- <li @click="changesvgcolor(key,slotKey,'134','134','134')" :style="'background:rgb(134,134,134);'"></li> -->
                                        <li @click="changesvgcolor(key,slotKey,'181','181','181')" :style="'background:rgb(181,181,181);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'224','224','224')" :style="'background:rgb(224,224,224);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'225','163','95')" :style="'background:rgb(225,163,95);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'225','112','106')" :style="'background:rgb(225,112,106);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'225','130','207')" :style="'background:rgb(225,130,207);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'214','135','235')" :style="'background:rgb(214,135,235);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'159','112','255')" :style="'background:rgb(159,112,255);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'100','138','255')" :style="'background:rgb(100,138,255);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'66','95','255')" :style="'background:rgb(66,95,255);'"></li>
                                        <li @click="changesvgcolor(key,slotKey,'106','229','255')" :style="'background:rgb(106,229,255);'"></li>
                                     </ul>
                                       <div class="modal" :id="'svgcolorPicker-'+key+'-'+slotKey"  style="z-index:105099999999">
                                                 >
                                                 <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                    <div class="modal-content">
                                                       <div class="modal-header">
                                                          <h4 class="modal-title">&nbsp;</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       </div>
                                                       <div class="modal-body">
                                                          <color-panel v-model="slot.textColor"></color-panel>
                                                          <br>
                                                       </div>
                                                       <div class="modal-footer">
                                                          <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                          <button type="button" class="text-success btn-none float-right" @click="changesvgcolor(key,slotKey,'save','save','save')" data-dismiss="modal">Save</button>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                          <label>Change Stroke Color</label>
                                        <ul class="colors">
                                        <li class="position-absolute" data-toggle="modal" :data-target="'#svgstrokecolorPicker-'+key+'-'+slotKey"><i class="fa fa-plus"></i></li>
                                         <!-- <li :style="'background:rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+');'"></li> -->
                                        <li class="ml-38" @click="changesvgstrokecolor(key,slotKey,'0','0','0')" :style="'background:rgb(0,0,0);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'255','255','255')" :style="'background:rgb(255,255,255);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'103','103','103')" :style="'background:rgb(103,103,103);'"></li>
                                        <!-- <li @click="changesvgstrokecolor(key,slotKey,'134','134','134')" :style="'background:rgb(134,134,134);'"></li> -->
                                        <li @click="changesvgstrokecolor(key,slotKey,'181','181','181')" :style="'background:rgb(181,181,181);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'224','224','224')" :style="'background:rgb(224,224,224);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'225','163','95')" :style="'background:rgb(225,163,95);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'225','112','106')" :style="'background:rgb(225,112,106);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'225','130','207')" :style="'background:rgb(225,130,207);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'214','135','235')" :style="'background:rgb(214,135,235);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'159','112','255')" :style="'background:rgb(159,112,255);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'100','138','255')" :style="'background:rgb(100,138,255);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'66','95','255')" :style="'background:rgb(66,95,255);'"></li>
                                        <li @click="changesvgstrokecolor(key,slotKey,'106','229','255')" :style="'background:rgb(106,229,255);'"></li>
                                     </ul>
                                   
                                                <div class="modal" :id="'svgstrokecolorPicker-'+key+'-'+slotKey"  style="z-index:105099999999">
                                                 >
                                                 <div class="modal-dialog" style="    max-width: fit-content;    min-height: fit-content;">
                                                    <div class="modal-content">
                                                       <div class="modal-header">
                                                          <h4 class="modal-title">&nbsp;</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                       </div>
                                                       <div class="modal-body">
                                                          <color-panel v-model="slot.textColor"></color-panel>
                                                          <br>
                                                       </div>
                                                       <div class="modal-footer">
                                                          <button type="button" class=" btn-none" data-dismiss="modal">Close</button>
                                                          <button type="button" class="text-success btn-none float-right" @click="changesvgstrokecolor(key,slotKey,'save','save','save')" data-dismiss="modal">Save</button>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                  </div>
                                  <div class="mb-3"  :id="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" v-if="slot.SlotImageUrl != ''">
                                        <label>Opacity</label>
                                        <input type="range" class="form-control" min="1" max="100" :id="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" :name="'opacity-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.opacity" >
                                     </div>
                                  <div class="panel panel-default mb-4 shadow-panel" v-if="slot.SlotImageUrl != ''" >
                                     <a  href="javascript:;" :data-id="'box-shadow-screen-'+key+'-slot-'+slot.slotid"  v-on:click="handShowBoxToggle(key,slot.slotid)">
                                        <div class="panel-heading">
                                           <h4 class="panel-title">
                                              <i class="fa fa-border-style"></i> Shadow Settings <i :class="'fa fa-angle-down float-right box-shadow-angle-tool-screen-'+key+'-slot-'+slot.slotid"></i>
                                           </h4>
                                        </div>
                                     </a>
                                     <div :id="'box-shadow-screen-'+key+'-slot-'+slot.slotid" class="panel-collapse collapse">
                                        <div class="panel-body mb-0">
                                           <div class="cus-select">
                                              <span class="text-white">Shadow style</span>
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
                                              <div class="modal" :id="'textshadowcolorPicker-'+key+'-'+slotKey"  style="z-index:105099999999">
                                                 >
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
                                                 <div class="col-12">
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
                                  <div style="display:inline-block">
                                     <a href="javascript:;"  v-on:click="setImageSlotId(key,slotKey)" data-toggle="modal" data-target="#bgModel"  :data-screen="key" :data-slot="slot.SlotType" class="bg-select-btn">
                                     <i class="fa fa-image"></i> Select New Image
                                     </a>
                                  </div>
                                  <div style="display:inline-block">
                                     <a href="javascript:;"  v-on:click="slot.SlotImageUrl = '';" v-if="slot.SlotImageUrl != ''" class="btn btn-sm btn-danger ml-1"><i class="fa fa-times"></i> &nbsp; Clear</a>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-10 p-0 main-tool-area" style="height:92.8vh;overflow-y:scroll;    background: #f2f2f2" >
                <section class="screen"  id="screenWraper"  v-if="screens != ''"  v-bind:style="[$route.params.slug == 'meme' ? {'margin-top': '50px'} : '' ]">
                   <div  v-for="(screen, key) in screens"  class="single-screen-wraper" :id="key" >
                      <div  :class="'box single-screen screen-'+key" :ref="handleId" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:relative;'"  @mouseover="mouseOver(key)" v-on:mouseleave="mouseLeave(key)"  >
                         <div class="screen-loader" :id="'screen-loader-'+key" style="display:none"><img src="/studio/assets/img/loader.gif"></div>
                         <!-- <div class="edit-btn" :class="'edit-screen-'+key"  v-on:click="toolbartoggle(key)"><i class="fa fa fa-pencil-alt"></i></div> -->
                         <div v-if="(screen.backgroundColor != '' && screen.backgroundColor != '#ffffff') || screen.TemplatebackgroundImage != ''" :data-screenkey="key" data-slotkey="0" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid"   v-on:click="selectSlot(key,'0',screen.bgid)">
                            <img  :src="screen.TemplatebackgroundImage" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.bgSize+';  transform: rotate('+screen.bgRotation+'deg);object-position:'+screen.bgPosition" class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                         </div>
                         <div    v-else-if="screen.panaramic != null && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.panaramic.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid"   v-on:click="selectSlot(key,'0',screen.bgid)">
                            <img  :src="screen.panaramic.imageData" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.panaramic.bgSize+';  transform: rotate('+screen.panaramic.bgRotation+'deg);object-position:'+screen.panaramic.bgPosition" class="bg-img">
                         </div>
                         <div v-for="(slot,slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'text')"  v-if="slot.type == 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;z-index:'+slot.zIndex+';width:auto;top:'+slot.top+'px;left:'+slot.left+'px;color:'+slot.textColor+';font-size:'+slot.fontSize+'px;font-family:'+slot.FontName+';text-align:'+slot.TextCenter+';'" :data-width="slot.slotWidth" class=" makeitDraggable text-slot"  v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="text" :data-order="slot.orderNumber" :id="'parentText-screen-'+key+'-slot-'+slot.slotid">
                            <div :style="'line-height: '+slot.lineHeight+'px;-webkit-text-stroke-width:'+slot.textStrikeWidth+'px;-webkit-text-stroke-color:'+slot.textStrikeClr+';text-decoration:'+slot.textDecoration+';text-transform:'+slot.textTransform+';font-style:'+slot.fontstyle+';font-weight:'+slot.fontweight+';text-align:'+slot.TextCenter+';letter-spacing:'+slot.latterSpacing+'pt; display: inline-block;font-size:'+slot.fontSize+'px;white-space:'+slot.lineBreak+';text-shadow:'+slot.shadow" :id="'screen-'+key+'-slot-'+slot.slotid">
                               <p v-html="slot.SlotType" :style="'line-height: '+slot.lineHeight+'px;'"></p>
                            </div>
                         </div>
                      
                         <div   v-for="(slot, slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'image')"  v-if="slot.type != 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;box-shadow:'+slot.shadow+';z-index:'+slot.zIndex+';width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;top:'+slot.top+'px;left:'+slot.left+'px;perspective: 500px;display:'+slot.display" class=" makeitDraggable image-slot" :id="'screen-'+key+'-slot-'+slot.slotid" v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="image">
                            <img  :src="slot[currentyDevice]" :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-if="!slot.SlotType.includes('frame') && typeof slot[currentyDevice] != 'undefined' && slot[currentyDevice] != ''" >
                            <img  :src="slot['global']"  :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="!slot.SlotType.includes('frame') && typeof slot['global'] != 'undefined' && slot['global'] != ''">
                            <inline-svg  
                            v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl.includes('.svg')"
                               :src="slot.SlotImageUrl" 
                               :id="'svgslot'+slotKey"
                               :class="'svgslot'+slotKey"
                               width="100%" 
                               fill="none"
                               height="100%"
                               aria-label="My image"
                            ></inline-svg>
                            <img :src="slot.SlotImageUrl"  :style="'width:100%;height:100%;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl != ''">
                            <img :src="devices[currentyDevice].colors[slot.deviceStye].url"  :style="'width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="slot.SlotType.includes('frame')">
                         </div>
                         <ul v-for="(slot, slotKey) in screen.slots" :key="slotKey" :id="'right-click-menu-'+key+'-'+slot.slotid" tabindex="-1" v-el="right" class="screen-right-menu"  style="display:none">
                            <!-- <li>
                               <a href="javascript:;" v-on:click="saveScreen(key)"><i class="fa fa-save"></i> Save</a>
                            </li>
                            <li>
                               <a href="javascript:;" v-on:click="refreshScreen(key)"><i class="fa fa-redo"></i> Refresh</a>
                            </li>
                            <li>
                               <a href="javascript:;" v-on:click="duplicateScreen(key)"><i class="fa fa-copy"></i> Duplicate</a>
                            </li>
                            <li>
                               <a href="javascript:;" v-on:click="ScreenDownload(key,JSON.stringify(screen))"><i class="fa fa-download"></i> Download </a>
                            </li>
                            <li>
                               <a href="javascript:;" v-on:click="setCurrentScreen(key)" data-toggle="modal" data-target="#copySettingsModal"><i class="fa fa-exchange-alt"></i> Copy Settings</a>
                            </li> -->
                            <li>
                                <a href="javascript:;"  @click="showHideslot(key,slotKey,false)">
                               <span class="icon" ><i class="fa fa-eye"></i> Hide it</span> 
                            </a>
                            </li> 
                            <li>
                               <a href="javascript:;" v-on:click="removeSlot(key,slotKey)"><i class="fa fa-trash text-danger"></i> Delete</a>
                            </li>
                         </ul>
                      </div>
                   </div>
                </section>
             </div>
          </div>
       </main>
       <div class="full-screen-loader" v-if="fullScreenLoader">
          <div class="loader-layover"></div>
          <div class="loader-body">
              <img src="/studio/assets/img/loader.gif">
          </div>
       </div>
       <backgroundLayoutsModel/>
       <backgroundModel/>
       <screeShotsModel/>
       <div style="position:absolute;left:-20000px">
          <div id="tempText"></div>
       </div>
       <div class="clearfix"></div>
      
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
    import InfiniteLoading from 'vue-infinite-loading';
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
                showtempslist: true,
                showshapeslist:true,
                templatesLoader: true,
                shapesLoader:true,
                templatespage:2,
                shapespage:2,
                downloadDropdown: false,
                layersDropdown: false,
                fullScreenLoader: true,
                recent_action: "",
                message: "",
                templateSearch:'',
                shapeSearch:'',
                mainDataList: "",
                screens: {},
                history: [],
                tempscreens: {},
                undoCount:0,
                handleId: "screen-0",
                newtemplates: {},
                selectedShapeCat:{},
                shapes: {},
                fontsList: {},
                userBackgrounds: {},
                userImages: {},
                imageModelType:'',
                curentLayoutScreen: '',
                curentScreenBg: '',
                error_message: "",
                calendar_image: this.$store.getters.calendar_image,
                screensHtml: "",
                has_error: false,
                cookieStatus: true,
                submitted: false,
                screenCount: 1,
                importUrl: '',
                selectedSlot: '',
                downloadScreen: '',
                downloadDropdownTwo: '',
                currentScreen: '',
                current_view_stat: '',
                imagesLoader: false,
                selectedCat:{},
                addImageLoader: false,
                selectedSlotScreen: '',
                newUserImage:null,
                currentyDevice:'iphone6',
                deviceWidth:'',
                deviceHeight:'',
                list: null,
                draggableValue: {
                     boundingElement:'undefined',
                     resetInitialPos:false,
                      onDragEnd: this.onPosChanged,
                 },
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
                        width:'350',
                        orignal_width:'1242',
                        orignal_height:'2208',
                        height:'622.22',
                        colors:{
                            matt_black:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone5Frame.png',
                                name:'Matt Black'
                            },
                             gold:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone5FrameGold.png',
                                name:'Rose Gold'
                            },
                        }
                    },
                     iphone6:{
                        id:1,
                         name:'iOS Phones - 6.5"',
                        width:'700',
                        height:'1000',
                        orignal_width:'1242',
                        orignal_height:'2688',
                        colors:{
                             matt_black:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone6-Frame.png',
                                name:'Matt Black'
                            },
                            gold:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/iphone6FrameGold.png',
                                name:'Rose Gold'
                            },
                        }
                    },
                     ipad2:{
                        id:3,
                         name:'iOS iPad Pro (2nd) - 12.9"',
                        width:'350',
                        height:'466.89',
                        orignal_width:'2048',
                        orignal_height:'2732',
                        colors:{
                             matt_black:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipad-Frame.png',
                                name:'Matt Black'
                            },
                            blue:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipadFrameBlue.png',
                                name:'Blue'
                            },
                        }
                    },
                     ipad3:{
                        id:4,
                         name:'iOS iPad Pro (3rd+) - 12.9"',
                        width:'350',
                        height:'466.89',
                        orignal_width:'2048',
                        orignal_height:'2732',
                         colors:{
                            matt_black:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipad-Frame.png',
                                name:'Matt Black'
                            },
                            blue:{
                                url:'https://appscreens.s3.us-east-2.amazonaws.com/deviceFrames/ipadFrameBlue.png',
                                name:'Blue'
                            },
                        }
                    },
    
                },
                PrintSizes:{
                    A0:{
                        width:'9933',
                        height:'14043',
                        widthM:'841',
                        heightM:'1189',
                    },
                    A1:{
                        width:'7016',
                        height:'9933',
                        widthM:'594',
                        heightM:'841',
                    },
                    A2:{
                        width:'4961',
                        height:'7016',
                        widthM:'420',
                        heightM:'594',
                    },
                    A3:{
                        width:'3508',
                        height:'4961',
                        widthM:'297',
                        heightM:'420',
                    },
                    A4:{
                        width:'2480',
                        height:'3508',
                        widthM:'210',
                        heightM:'297',
                    },
                    A5:{
                        width:'1748',
                        height:'2480',
                        widthM:'148',
                        heightM:'210',
                    },
                    A6:{
                        width:'1240',
                        height:'1748',
                        widthM:'105',
                        heightM:'148',
                    },
                },
                editorOption: {
                }
            }
        },
        beforeMount(){
           $('.modal-backdrop').remove();
            this.getTemplatesData();
            this.getShapes();
            this.getTemplates();
            if(this.$route.params.slug == 'meme'){
             this.showallcatstemplates(2,'Meme Templates')
            }
        },
        mounted(){
            this.draggableValue.boundingElement = this.$refs['screen-0'];
          //   if (!this.$store.getters.intro) {
          //     $('#introModel').modal('show');
          // }
          // if (!this.$store.getters.checkCookieStatus) {
          //     this.cookieStatus = true;
          // }else{
          //   this.cookieStatus = true;
          // }
        },
        directives: {
            Draggable,
        },
        components: {
            quillEditor,
            backgroundLayoutsModel,
            screeShotsModel,
            backgroundModel,
            InfiniteLoading,
            VueGpickr
        },
        beforeRouteLeave: function() {
            this.$store.commit('set_playground',this.screens);
            this.$store.commit('set_playgroundMain',this.mainDataList);
            this.$router.go();
        },
        methods: {
            onPosChanged: function(positionDiff, absolutePosition, event) {
             //   if(typeof event != 'undefined'){
             //      var selector = event.path[2];
             //      console.log(event.path);
             //      $(selector).css('position','absolute');
             //      var left  =  absolutePosition.left - 650;
             //      var top  =  absolutePosition.top - 122;
             //      $(selector).css('left',left);
             //      $(selector).css('position',top);
             //   }
                //  console.log("postion", positionDiff);
                //  console.log("event", event);
                //  console.log("left corner", absolutePosition.left);
                //  console.log("top corner", absolutePosition.top);
             },
             showDropdown(type,count){
                if(type == 'download'){
                   if(count == 1){
                      if(this.downloadDropdown){
                         this.downloadDropdown = false;
                      }else{
                         this.downloadDropdown =true;
                      }
                   }else{
                      if(this.downloadDropdownTwo){
                         this.downloadDropdownTwo = false;
                      }else{
                         this.downloadDropdownTwo =true;
                      }
                   }
                }
                if(type == 'layers'){
                   if(this.layersDropdown){
                      this.layersDropdown = false;
                   }else{
                      this.layersDropdown =true;
                   }
                }
             },
              hideDropdown(){
               
                      this.downloadDropdown =false;
                
                      this.layersDropdown =false;
                      $('.screen-right-menu').hide()
                 
             },
            cookieClickedAccept(){
                    this.$store.commit('set_cookieStatus',1);
            },
            cookieClickedDecline(){
    
            },
            getTemplates(){
               if (this.$store.getters.getPlaygroundTemplate != '' && this.$store.getters.getPlaygroundTemplate > 0) {
                var dataUrl = '/get-template/'+this.$store.getters.getPlaygroundTemplate;
             }else{
                  var dataUrl = '/get-template';
             }
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                    
                    this.fonts = result.data.fonts
                    this.loading = false;
    
                   // if (this.$store.getters.playgroundData.length > 0 && this.$store.getters.playChange) {
                   //    this.$confirm( {
                   //       title: 'Playground',
                   //       message: `You already have another active project in the playground. Do you want to overwrite this with this template?`,
                   //       button: {
                   //          no: 'No',
                   //          yes: 'Yes'
                   //       },
                   //       callback: confirm => {
                   //          if (confirm) {
                   //              this.mainDataList = result.data.data
                   //            this.loadScreens('no');
                   //              this.$store.commit('set_playChange',false);
                   //          }else{
                   //              this.mainDataList = this.$store.getters.playgroundMainData;
                   //            this.screens = this.$store.getters.playgroundData;
                           
                   //          }
                   //       }
                   //    })
                   // }else if (this.$store.getters.playgroundData.length > 0) {
                   //  this.mainDataList = this.$store.getters.playgroundMainData;
                   //  this.screens = this.$store.getters.playgroundData;
                   // }else{
                        this.mainDataList = result.data.data
                        this.loadScreens('no');
                   // }
                }, error => {
    
                });           
            },
             getTemplatesData(){
                 this.templatesLoader = true;
                var dataUrl = '/templates/'+this.$route.params.slug+'?name='+this.templateSearch;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    this.newtemplates = result.data
                    this.templatesLoader = false;
                
                }, error => {
    
                });           
            },
             getShapes(){
                      this.shapesLoader = true;
                var dataUrl = '/shapes?name='+this.shapeSearch;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    this.shapes = result.data
                    this.shapesLoader = false;
                
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
            showallcatstemplates(catid,catname){
               this.templatesLoader = true;
               this.showtempslist = false;
                 this.selectedCat.name = catname;
                 this.selectedCat.id = catid;
                 var dataUrl = '/single-category-tempates/'+catid;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    this.selectedCat.templates = result.data.data
                     this.$forceUpdate();
                    this.templatesLoader = false;
                
                }, error => {
    
                }); 
            },
            catstemplatesonscroll($state){
                 var catid =  this.selectedCat.id;
                 var dataUrl = '/single-category-tempates/'+catid+'?page='+this.templatespage;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    var templatesdata = result.data.data
                    if (templatesdata.length) {
                       this.templatespage += 1;
                         this.selectedCat.templates.push(...templatesdata);
                            this.$forceUpdate();
                         $state.loaded();
                     } else {
                         $state.complete();
                     }
                
                }, error => {
    
                }); 
            },
            selectTemplate(template){
             //  this.history.push(this.screens);
               this.fullScreenLoader =true;
                 this.mainDataList = template
                        this.loadScreens('no');
            },
             showallcatsShapes(catid,catname){
               this.shapesLoader = true;
               this.showshapeslist = false;
                 this.selectedShapeCat.name = catname;
                 this.selectedShapeCat.id = catid;
                 var dataUrl = '/single-category-shapes/'+catid;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    this.selectedShapeCat.templates = result.data.data
                      this.$forceUpdate();
                    this.shapesLoader = false;
                
                }, error => {
    
                }); 
            },
            catsShapesonscroll($state){
                 var catid =  this.selectedShapeCat.id;
                 var dataUrl = '/single-category-shapes/'+catid+'?page='+this.shapespage;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                    var templatesdata = result.data.data
                    if (templatesdata.length) {
                       this.shapespage += 1;
                         this.selectedShapeCat.templates.push(...templatesdata);
                            this.$forceUpdate();
                         $state.loaded();
                     } else {
                         $state.complete();
                     }
                
                }, error => {
    
                }); 
            },
            addTextSlot(key,slotKey){
             //  this.history.push(this.screens);
             var mthis = this;
             var newslotid = this.screens[key].slots[this.screens[key].slots.length - 1].slotid + 1;
             let slot = this.screens[key].slots[slotKey];
             var newslot = {
                "FontName": slot.FontName,
                "FontSize": slot.FontSize,
                "Height": slot.Height,
                "MainimgRoation": undefined,
                "Mainleft": 30,
                "MainslotWidth": slot.MainslotWidth,
                "Maintop": 20,
                "SlotType": "New Text",
                "TextCenter": "left",
                "TextColor_Brown": 255,
                "TextColor_GREEN": 255,
                "TextColor_RED": 255,
                "TextPostion": "top",
                "textColor":slot.textColor,
                "TextRole": "new text",
                "opacity":100,
                "Width": slot.Width,
                "Z-index": 0,
                "deviceStye": "matt_black",
                "display": "block",
                "textDecoration":'none',
                "textTransform":'none',
                "fontstyle":'normal',
                "fontweight":'normal',
                "fontSize": slot.fontSize,
                "imgRoation": "rotate(0deg)",
                "latterSpacing": "0",
                "layerStyling": "",
                "left": 30,
                "leftPercents": 5,
                "lineBreak": "normal",
                "lineHeight": "auto",
                "marginBottom": 0,
                "marginLeft": 30,
                "marginRight": 0,
                "marginTop": 20,
                "rotation": "0",
                "shadow": "none",
                "show": true,
                "slotHeight": slot.slotHeight,
                "slotWidth": slot.slotWidth,
                "slotid": newslotid,
                "title": "",
                "top": 20,
                "transform": {
                "tx": 358.2126696832579,
                "ty": 239.379821958457,
                "xx": 1,
                "xy": 0,
                "yx": 0,
                "yy": 1,
                },
                "type": "text",
                "zIndex": 99999999999999
             }
             this.screens[key].slots.push(newslot);
               this.$forceUpdate();
               setTimeout(function(){  
                  mthis.$forceUpdate();
                      mthis.fullScreenLoader = false;
                       $('.makeitDraggable').draggable({
                          containment: "parent",
                          start: function( event, ui ) {
                         
 
                        
                         },
                          stop: function(event, ui) {
                           var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
 
                            var top = $(event.target).css('top').replace('px','');
                            var left = $(event.target).css('left').replace('px','');
                             var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].top = mthis.screens[screenkey].slots[slotkey].top
                              pushdata[screenkey]['slots'][slotkey].left = mthis.screens[screenkey].slots[slotkey].left
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
                            mthis.current_view_stat =  mthis.history.length
                            mthis.screens[screenkey].slots[slotkey].top = top;
                            mthis.screens[screenkey].slots[slotkey].left = left;
 
                             
                         }
                      }).resizable({
                         handles: "ne, se, sw, nw",
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                              var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var width = $(event.target).css('width').replace('px','');
                            var height = $(event.target).css('height').replace('px','');
 
                               var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].slotWidth = mthis.screens[screenkey].slots[slotkey].slotWidth
                              pushdata[screenkey]['slots'][slotkey].slotHeight = mthis.screens[screenkey].slots[slotkey].slotHeight
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
 
                            mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                            mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                           
                         }
                      }).rotatable({
                         wheelRotate:false,
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                               var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var transform = $(event.target).css('transform');
                         }
                      });
                      
 
                      }, 2000);
            },
            selectShape(template){
             //  this.history.push(this.screens);
             var newslotid = this.screens[0].slots.length + 2;
               var mthis = this;
               mthis.fullScreenLoader = true;
               var slot = {"SlotType":"Imageshape"+template.id,
               "SlotImageUrl":template.image,
               "slotImageWidth":template.width,
               "slotImageHeight":template.height,
               "Width":template.width,
               "Height":template.height,
               "marginTop":0,
               "marginLeft":0,
               "Z-index":9999,
               "marginBottom":0,
               "objectFit":"cover",
               "show":true,
               "shadow":"none",
               "deviceStye":"matt_black",
               "deviceType":"full_device",
               "imgRoation":"rotate(0deg)",
               "objectPosition":"center",
               "type":"image",
               "top":25,
               "left":30,
               "leftPercents":0,
               "slotWidth":template.width,
               "slotHeight":template.height,
               "MainslotWidth":template.width,
               "Mainleft":0,
               "opacity":100,
               "Maintop":0,
               "fontSize":"NaN",
               "slotid":newslotid,
               "TextPostion":"top",
               "display":"block",
               "MainimgRoation":"rotateZ(0deg)",
               "title":"Shape - "-template.id,
               "zIndex":"77777777777"
               }
               this.screens[0].slots.push(slot);
               this.$forceUpdate();
                      mthis.fullScreenLoader = false;
               setTimeout(function(){  
                      // console.log(mthis.$refs[mthis.handleId][0]);
                       $('.makeitDraggable').draggable({
                          containment: "parent",
                          start: function( event, ui ) {
                         
 
                        
                         },
                          stop: function(event, ui) {
                           var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
 
                            var top = $(event.target).css('top').replace('px','');
                            var left = $(event.target).css('left').replace('px','');
                             var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].top = mthis.screens[screenkey].slots[slotkey].top
                              pushdata[screenkey]['slots'][slotkey].left = mthis.screens[screenkey].slots[slotkey].left
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
                            mthis.current_view_stat =  mthis.history.length
                            mthis.screens[screenkey].slots[slotkey].top = top;
                            mthis.screens[screenkey].slots[slotkey].left = left;
 
                             
                         }
                      }).resizable({
                         handles: "ne, se, sw, nw",
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                              var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var width = $(event.target).css('width').replace('px','');
                            var height = $(event.target).css('height').replace('px','');
 
                               var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].slotWidth = mthis.screens[screenkey].slots[slotkey].slotWidth
                              pushdata[screenkey]['slots'][slotkey].slotHeight = mthis.screens[screenkey].slots[slotkey].slotHeight
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
 
                            mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                            mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                           
                         }
                      }).rotatable({
                         wheelRotate:false,
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                               var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var transform = $(event.target).css('transform');
                         }
                      });
                      
 
                      }, 1000);
               
            },
            
            backtolist(){
                     this.showshapeslist = true;
                     this.showtempslist = true;
                      this.templatespage = 2;
                      this.shapespage = 2;
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
            resizeScreens(size){
                var maindata = this.mainDataList;
                var screens = [];
                var mthis = this;
                var html = "";
                this.currentScreen = 0;
                var mainscreen = maindata;
                
                $.each(this.screens, function(screenDKey, screen){
                   screen.title = mainscreen.title;
                   if(size == 'edit'){
                      if(mainscreen.type != 'business_cards'){
                         if(mainscreen.orientation == 'landscape'){
                            screen.width = '850'
                            screen.height = '601.13'
                         }else if(screen.width > 750){
                            screen.width = '800'
                            screen.height = '1132.2'
                         }
                      }
                   }else{
                      screen.width = mthis.PrintSizes[size].width;
                      screen.height = mthis.PrintSizes[size].height;
                   }
                   
                   var widthRatio = screen.width / screen.mainWidth;
                   var heightRatio = screen.height / screen.mainHeight;
                   var scale = Math.min(widthRatio, heightRatio);
 
                   var slotCount = 1;
                   screen.id = mthis.screenCount;
                   screen.bgid = slotCount;
                   slotCount++;
                   screen.panaramic = null;
                   $.each(screen.slots, function(slotI, slot){
 
                      var newFontSize = Math.floor(slot.MainFontSize * scale);
                      slot.FontSize = newFontSize;
                      slot.fontSize = newFontSize;
 
                      slot.top = slot.marginTop * screen.height;
                      slot.left = slot.marginLeft * screen.width;
                      slot.leftPercents = slot.left / screen.width * 100;
                      slot.slotWidth = slot.Width  * screen.width;
                      slot.slotHeight = slot.Height  * screen.height;
                      slot.MainslotWidth = slot.slotWidth;
                      slot.Mainleft = slot.left;
                      slot.Maintop = slot.top;
 
                      slot.slotid = slotCount;
                   
                      slotCount++;
 
                   })
                   screens.push(screen);
                   mthis.screenCount++;
                })
            
                this.screens = screens;
                this.current_view_stat = 1;
                this.$forceUpdate();
                if(size == 'edit'){
                   setTimeout(function(){  
                      mthis.fullScreenLoader = false;
                      $('.makeitDraggable').draggable({
                            containment: "parent",
                            start: function( event, ui ) {
                            },
                            stop: function(event, ui) {
                            var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
 
                            var top = $(event.target).css('top').replace('px','');
                            var left = $(event.target).css('left').replace('px','');
                            var pushdata = []
                            pushdata[screenkey] = []
                            pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                            pushdata[screenkey]['slots'][slotkey].top = mthis.screens[screenkey].slots[slotkey].top
                            pushdata[screenkey]['slots'][slotkey].left = mthis.screens[screenkey].slots[slotkey].left
                            mthis.$set(mthis.history,mthis.history.length,pushdata);
                            mthis.undoCount = 0;
                            mthis.current_view_stat =  mthis.history.length
                            mthis.screens[screenkey].slots[slotkey].top = top;
                            mthis.screens[screenkey].slots[slotkey].left = left;
                               
                         }
                      }).resizable({
                         handles: "ne, se, sw, nw",
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                            var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var width = $(event.target).css('width').replace('px','');
                            var height = $(event.target).css('height').replace('px','');
 
                            var pushdata = []
                            pushdata[screenkey] = []
                            pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                            pushdata[screenkey]['slots'][slotkey].slotWidth = mthis.screens[screenkey].slots[slotkey].slotWidth
                            pushdata[screenkey]['slots'][slotkey].slotHeight = mthis.screens[screenkey].slots[slotkey].slotHeight
                            mthis.$set(mthis.history,mthis.history.length,pushdata);
                            mthis.undoCount = 0;
 
                            mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                            mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                            
                         }
                      }).rotatable({
                         wheelRotate:false,
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                            var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var transform = $(event.target).css('transform');
                         }
                      })
                      
                      mthis.$forceUpdate();
                         mthis.draggableValue.boundingElement = mthis.$refs[mthis.handleId][0];
                   }, 4000);
                }
            },
            loadScreens(deviceChange){
                var maindata = this.mainDataList;
                var screens = [];
                var mthis = this;
                var html = "";
                this.deviceWidth = this.devices[this.currentyDevice].width;
                this.deviceHeight = this.devices[this.currentyDevice].height;
                this.currentScreen = 0;
                if (deviceChange == 'yes') {
                      $.each( this.screens, function(ascreenI, ascreen){
                        $.each( maindata.screens, function(screenI, mainscreen){
                            if(mainscreen.device_id == mthis.devices[mthis.currentyDevice].id && ascreen.title == mainscreen.title){
                                  var screen = JSON.parse(mainscreen.data);
                                  var mainWidth  = screen.width;
                                  var mainHeight  = screen.height;
                                  screen.title = mainscreen.title;
                                  ascreen.width = mthis.deviceWidth;
                                  ascreen.height = mthis.deviceHeight;
                                  ascreen.mainWidth = mainWidth;
                                  ascreen.mainHeight = mainHeight;
                                  $.each(screen.slots, function(slotI, slot){
                                    $.each(ascreen.slots, function(aslotI, aslot){
                                        if (aslot.SlotType == slot.SlotType.split('-')[0]) {
                                             aslot.top = slot.marginTop * ascreen.height;
                                             aslot.left = slot.marginLeft * ascreen.width;
                                             aslot.leftPercents = aslot.left / ascreen.width * 100;
                                             var exactslotWidth = slot.Width  * mainWidth;
                                             aslot.slotWidth = slot.Width  * ascreen.width;
                                             aslot.slotHeight = slot.Height  * ascreen.height;
                                             aslot.MainslotWidth = aslot.slotWidth;
                                             aslot.Mainleft = aslot.left;
                                             aslot.Maintop = aslot.top;
                                             aslot.fontSize = parseFloat(slot.FontSize / exactslotWidth *  aslot.slotWidth).toFixed(2);
                                        }
    
                                   })
                                  })
                            }
                        })
                      });
                }else{
    
    
                   var mainscreen = maindata;
                   var datascreen = [];
                    datascreen.push(JSON.parse(maindata.psd_data));
                    if(maindata.psd_2_data != '' && maindata.psd_2_data != null){
                     datascreen.push(JSON.parse(maindata.psd_2_data));
                    }
                    $.each(datascreen, function(screenDKey, screen){
                      screen.title = mainscreen.title;
                      screen.mainWidth = screen.width;
                      screen.mainHeight = screen.height;
                      if(mainscreen.type != 'business_cards'){
                         if(mainscreen.orientation == 'landscape'){
                            screen.width = '850'
                            screen.height = '601.13'
                         }else if(screen.width > 750){
                            screen.width = '800'
                            screen.height = '1132.2'
                         }
                      }
                        
                      var widthRatio = screen.width / screen.mainWidth;
                      var heightRatio = screen.height / screen.mainHeight;
 
                      var scale = Math.min(widthRatio, heightRatio);
 
                      var slotCount = 1;
                      screen.id = mthis.screenCount;
                      screen.bgid = slotCount;
                      slotCount++;
                      screen.panaramic = null;
                      $.each(screen.slots, function(slotI, slot){
    
                         slot.top = slot.marginTop * screen.height;
                         slot.left = slot.marginLeft * screen.width;
                         slot.leftPercents = slot.left / screen.width * 100;
                         slot.slotWidth = slot.Width  * screen.width;
                         slot.slotHeight = slot.Height  * screen.height;
                         slot.MainslotWidth = slot.slotWidth;
                         slot.Mainleft = slot.left;
                         slot.Maintop = slot.top;
                         slot.MainFontSize = slot.FontSize;// Set your original font size here
                         var newFontSize = Math.floor(slot.MainFontSize * scale);
 
                         slot.FontSize = newFontSize;
                         slot.fontSize =newFontSize;
                         slot.slotid = slotCount;
                         slot.opacity = 100;
                         slot.textTransform = 'none';
                         slot.textDecoration = 'none';
                         slot.fontstyle = 'normal';
                         slot.textColor = 'rgb('+slot.TextColor_RED+','+slot.TextColor_GREEN+','+slot.TextColor_Brown+')';
                         slot.fontweight = 'normal';
                         slot.TextPostion = 'top';
                         slot.shadow = 'none';
                         if(slot.slotRoation == '' ){
                            slot.slotRoation  = 'rotate(0deg)';
                         }
                         if(typeof slot.slotRoation == 'undefined' ){
                            slot.slotRoation  = 'rotate(0deg)';
                         }
                          
                         slot.display = 'block';
                         slot.show = true;
                         slot.SlotType = slot.SlotType.replace('image','Image');
                         var orignalImName = slot.SlotType;
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
                         slot.title = '';
    
                         if(slot.type == 'image'){
                            var number = slot.SlotType.split('-')[1];
                            var title = slot.SlotType.split('-')[0];
                            slot.title = title;
                            number = number.split('_')[0];
                     
                            slot.SlotType = slot.SlotType.split('-')[0]+number;
                            
                            zIndex = 0;
                            for (let index = 0; index <= number; index++) {
                               zIndex = zIndex+'7';
                            }
                         }else if(slot.type == 'text'){
                            zIndex = 99999999999999;
                         }
    
                         if(orignalImName.includes('Calendar') && mthis.calendar_image != ''){
                            slot.SlotImageUrl = mthis.calendar_image;
                            slot.objectFit = 'contain';
                         }
                         if(slot.lineHeight == 100){
                            slot.lineHeight = 'auto';
                         }else{
                            slot.lineHeight = slot.lineHeight * scale;
                         }
                   
                         slot.textStrikeWidth = '';
                         slot.textStrikeClr = '';
                         if(slot.layerStyling != '' && slot.layerStyling != undefined && typeof slot.layerStyling != 'undefined'){
                            if(slot.layerStyling.FrFX && slot.layerStyling.FrFX != '' && slot.layerStyling.FrFX != undefined && typeof slot.layerStyling.FrFX != 'undefined'){
                
                               var textStrikeClr = '';
                               var textStrikeWidth = '';
                                  $.each(slot.layerStyling.FrFX, function(ind, fr){
                                     if(ind.trim() == 'Sz'){
                                        textStrikeWidth = fr.value;
                                     }
                                     if(ind.trim() == 'Clr'){
                                     var rd = ''
                                     var grn = ''
                                     var bl = ''
                                        $.each(fr, function(cli, cr){
                                        if(cli.trim() == 'Rd'){
                                           rd = cr;
                                        }
                                           if(cli.trim() == 'Grn'){
                                           grn = cr;
                                        }
                                           if(cli.trim() == 'Bl'){
                                           bl = cr;
                                        }
                                        })
                                        textStrikeClr = 'rgb('+rd+','+grn+','+bl+')';
                                     }
                                  })
                                  slot.textStrikeWidth = textStrikeWidth;
                                  slot.textStrikeClr = textStrikeClr;
                            }
                         }
                            if(slot.layerStyling != '' && slot.layerStyling != undefined && typeof slot.layerStyling != 'undefined'){
                               if(slot.layerStyling.DrSh && slot.layerStyling.DrSh != '' && slot.layerStyling.DrSh != undefined && typeof slot.layerStyling.DrSh != 'undefined'){
                   
                                  var shadow_color = '';
                                  var blur = '';
                                  var distance = '';
                                    $.each(slot.layerStyling.DrSh, function(ind, fr){
                                     if(ind.trim() == 'Sz'){
                                        textStrikeWidth = fr.value;
                                     }
                                      if(ind.trim() == 'Clr'){
                                       var rd = ''
                                       var grn = ''
                                       var bl = ''
                                               $.each(fr, function(cli, cr){
                                                 if(cli.trim() == 'Rd'){
                                                    rd = cr;
                                                 }
                                                   if(cli.trim() == 'Grn'){
                                                    grn = cr;
                                                 }
                                                  if(cli.trim() == 'Bl'){
                                                    bl = cr;
                                                 }
                                               })
                                         shadow_color = 'rgb('+rd+' '+grn+' '+bl+' / '+slot.layerStyling.DrSh.Opct.value+'%)';
                                      }
                                       if(ind.trim() == 'Dstn'){
                                        distance= fr.value+'px';
                                     }
                                     if(ind.trim() == 'blur'){
                                        blur= fr.value+'px';
                                     }
                                    })
                                     slot.shadow = shadow_color+' '+distance+' '+distance+' '+blur;
                                  
                               }
                            }
                            if(slot.textStrikeWidth != ''){
                               slot.textColor = 'transparent';
                            }
                            slot.imgRoation= 'rotate(0deg)';
      
                            slot.zIndex = zIndex;
                            slotCount++;
    
                        })
                          screens.push(screen);
                          mthis.screenCount++;
                         })
            
                  this.screens = screens;
                  this.current_view_stat = 1;
                  this.$forceUpdate();
                    setTimeout(function(){  
                      mthis.fullScreenLoader = false;
                      // console.log(mthis.$refs[mthis.handleId][0]);
                      $('.makeitDraggable').draggable({
                          containment: "parent",
                          start: function( event, ui ) {
                         
 
                        
                         },
                          stop: function(event, ui) {
                           var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
 
                            var top = $(event.target).css('top').replace('px','');
                            var left = $(event.target).css('left').replace('px','');
                             var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].top = mthis.screens[screenkey].slots[slotkey].top
                              pushdata[screenkey]['slots'][slotkey].left = mthis.screens[screenkey].slots[slotkey].left
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
                            mthis.current_view_stat =  mthis.history.length
                            mthis.screens[screenkey].slots[slotkey].top = top;
                            mthis.screens[screenkey].slots[slotkey].left = left;
 
                             
                         }
                      }).resizable({
                         handles: "ne, se, sw, nw",
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                              var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var width = $(event.target).css('width').replace('px','');
                            var height = $(event.target).css('height').replace('px','');
 
                               var pushdata = []
                             pushdata[screenkey] = []
                             pushdata[screenkey]['slots'] = []
                            pushdata[screenkey]['slots'][slotkey] = {}
                              pushdata[screenkey]['slots'][slotkey].slotWidth = mthis.screens[screenkey].slots[slotkey].slotWidth
                              pushdata[screenkey]['slots'][slotkey].slotHeight = mthis.screens[screenkey].slots[slotkey].slotHeight
                                mthis.$set(mthis.history,mthis.history.length,pushdata);
                               mthis.undoCount = 0;
 
                            mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                            mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                           
                         }
                      }).rotatable({
                         wheelRotate:false,
                         start: function( event, ui ) {
                         },
                         stop: function( event, ui ) {
                               var  screenkey = $(event.target).data('screenkey');
                            var slotkey = $(event.target).data('slotkey');
                            var transform = $(event.target).css('transform');
                         }
                      })
                      
                      mthis.$forceUpdate();
                                 mthis.draggableValue.boundingElement = mthis.$refs[mthis.handleId][0];
                      }, 4000);
                }   
                  if (deviceChange == 'no') {
    
                      this.getUserImages();
                  }
            },
            showHideslot(screenKey,slotKey,show){
             //  this.history.push(this.screens);
                var pushdata = []
                pushdata[screenKey] = []
                pushdata[screenKey]['slots'] = []
                pushdata[screenKey]['slots'][slotKey] = {}
                pushdata[screenKey]['slots'][slotKey].show = this.screens[screenKey].slots[slotKey].show
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                
               this.screens[screenKey].slots[slotKey].show = show;
               this.$forceUpdate();
            },
            removeSlot(screenKey,slotKey){
             //  this.history.push(this.screens);
               var pushdata = []
                pushdata[screenKey] = []
                pushdata[screenKey]['slots'] = []
                pushdata[screenKey]['slots'][slotKey] = this.screens[screenKey].slots[slotKey]
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
               this.screens[screenKey].slots.splice(slotKey, 1);
                this.$forceUpdate();
            },
            handToggle(screeId,slotKey,slotId,type = null){
    
                var selector = '#tool-screen-'+screeId+'-slot-'+slotId;
                var arrow = '.angle-tool-screen-'+screeId+'-slot-'+slotId;
              
    
             //  if($(selector).hasClass( "show" )){
             //    $(selector).removeClass('show');
             //    $(arrow).removeClass('fa-angle-up');
             //    $(arrow).addClass('fa-angle-down');
             //  }else{
                    $('.panel-collapse').removeClass('show');
                    $('.panel-title i.fa-angle-up').addClass('fa-angle-down');
                    $('.panel-title i.fa-angle-down').removeClass('fa-angle-up');
                 $(selector).addClass('show');
                  $(arrow).removeClass('fa-angle-down');
                $(arrow).addClass('fa-angle-up');
              
              if(type == 'sidelink'){
                     if($('.sidelinks').removeClass('active')){
    
                        $(event.target).addClass('active');
                     }
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
                if ($('.tool-screen-'+screeId).is(":hidden")) {
                    $('.hideAllTool').hide('slow')
    
                }
                  $('.tool-screen-'+screeId).show('slow');
                  this.handToggle(screeId,slotKey,slotId);
    
            },
             setBgIndex(id){
                if (id == 'panoramic') {
                   $('#bgModel').show();
                }
                this.imageModelType = 'bg';
                this.curentScreenBg = id;
                
            },
            setImageSlotId(screenId,slotindex){
                  this.imageModelType = 'image';
                this.selectedSlotScreen = screenId;
                this.selectedSlot = slotindex;
            },
            setBg(link){
             
             if (this.curentScreenBg == 'panoramic') {
                 this.$refs.setupModalComp.setBgImage(link);
                $('#bgModel').hide();
             }else{
                  var pushdata = []
                pushdata[this.curentScreenBg] = {}
                pushdata[this.curentScreenBg].TemplatebackgroundImage = this.screens[this.curentScreenBg].TemplatebackgroundImage
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                //  this.history.push(this.screens);
                   this.fullScreenLoader = true;
                this.screens[this.curentScreenBg].TemplatebackgroundImage = link;
                this.$forceUpdate();
                $('#bgModel').modal('hide');
                $('.modal-backdrop').remove();
                var mthis = this;
                setTimeout(function(){  
                      mthis.fullScreenLoader = false;
                      }, 1000);
             }
             
            },
            setImageSlot(link){
             //  this.history.push(this.screens);
                  this.fullScreenLoader = true;
                  var mthis = this;
                    var pushdata = []
                pushdata[this.selectedSlotScreen] = []
                pushdata[this.selectedSlotScreen]['slots'] = []
                pushdata[this.selectedSlotScreen]['slots'][this.selectedSlot] = {}
                pushdata[this.selectedSlotScreen]['slots'][this.selectedSlot].SlotImageUrl = this.screens[this.selectedSlotScreen].slots[this.selectedSlot].SlotImageUrl
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                this.screens[this.selectedSlotScreen].slots[this.selectedSlot].SlotImageUrl = link;
                 $('#bgModel').modal('hide');
                   $('.modal-backdrop').remove();
                     setTimeout(function(){  
                      mthis.fullScreenLoader = false;
                      }, 1000);
    
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
                this.$refs.copysettingcomp.autoSelectScreen();
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
                                    if (mainslot.SlotType.includes(slotType) && screenKey == mainscreenKey) {
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
            openMenu: function(screenId,slotid,type) {
             $('.screen-right-menu').hide();
                $('#right-click-menu-'+screenId+'-'+slotid).show();
      $('#right-click-menu-'+screenId+'-'+slotid).focus();
    
                    this.setMenu(event.y, event.x,screenId,slotid,type)
                // Vue.nextTick(function() {
                   
                // }.bind(this));
                event.preventDefault();
            },
             setMenu: function(top, left,screenId,slotid,type) {
              if(type == 'text'){
                var largestHeight = $('#parentText-screen-'+screenId+'-slot-'+slotid).css('top').replace('px','') ;
                var  largestWidth = parseInt(parseInt($('#parentText-screen-'+screenId+'-slot-'+slotid).css('left').replace('px','')) +  parseInt($('#parentText-screen-'+screenId+'-slot-'+slotid).outerWidth()) + 5);
              }else{
                var largestHeight = $('#screen-'+screenId+'-slot-'+slotid).css('top').replace('px','') ;
                var  largestWidth = parseInt(parseInt($('#screen-'+screenId+'-slot-'+slotid).css('left').replace('px','')) +  parseInt($('#screen-'+screenId+'-slot-'+slotid).outerWidth()) + 5);
              }
               
    
                var top = largestHeight + 'px';
                var left = largestWidth + 'px';
                 $('#right-click-menu-'+screenId+'-'+slotid).css("top",top);
                 $('#right-click-menu-'+screenId+'-'+slotid).css("left",left);
            },
    
            closeMenu: function(screenId) {
               $('#right-click-menu-'+screenId).hide();
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
                   this.screens[key].backgroundColor  = '';
                    $('#color-picker-'+key).hide();
                    $('#gradient-picker-'+key).hide();
                }
            },
            clearbgImage(key){
              var pushdata = []
                pushdata[key] = {}
                pushdata[key].TemplatebackgroundImage = this.screens[key].TemplatebackgroundImage
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
 
                this.screens[key].TemplatebackgroundImage  = '';
            },
            setBgGradient(key){
             //  this.history.push(this.screens);
              var pushdata = []
                pushdata[key] = {}
                pushdata[key].backgroundColor = this.screens[key].backgroundColor
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                var gradient =  $('#gradientPicker'+key+' .vue-gpickr-preview').css('background');
                this.screens[key].backgroundColor  = gradient;
                $('#gradientPicker'+key).modal('hide');
                $('.modal-backdrop').remove();
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
               var pushdata = []
                pushdata[key] = []
                pushdata[key]['slots'] = []
                pushdata[key]['slots'][slotkey] = {}
                pushdata[key]['slots'][slotkey].shadow = this.screens[key].slots[slotkey].shadow
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
             //  this.history.push(this.screens);
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
                /*var height = $('#screen-'+key+'-slot-'+slotid).height();
                $('#screen-'+key+'-slot-'+slotid).css('height',height);
                $('#screen-'+key+'-slot-'+slotid+' img').css('height',height);
                if (typeof height != 'undefined' && this.screens[key].slots.length > 0) {
                    this.screens[key].slots[slotkey].Height = height;
                    this.$forceUpdate();
                }*/
            },
            imageSizing(key,slotkey,slotType){
             //  this.history.push(this.screens);
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
            sorted(){
                this.$forceUpdate();
            },
            async ScreenDownload(key,type,size){
                this.fullScreenLoader = true;
                this.downloadDropdown = false;
                var mthis = this;
                var blobType = 'image/'+type;
                if(size != 'simple'){
                   await this.resizeScreens(size);
                }
                setTimeout(function(){  
                   html2canvas($('.screen-'+key)[0], {allowTaint : true,useCORS: true}).then(function(canvas) {
                      canvas.toBlob(function(blob) {
                         saveAs(blob, "poster."+type); 
                          if(size != 'simple'){
                            mthis.resizeScreens('edit');
                          }else{
                            mthis.$forceUpdate();
                            mthis.fullScreenLoader = false;
                          }
                        
                            
 
                      },blobType);
 
                   });
                }, 0);
                
            },
            textTools(key,slotKey,task){
             //  this.history.push(this.screens);
             if(task == 'bold'){
                if(this.screens[key].slots[slotKey].fontweight == 'bold'){
                   this.screens[key].slots[slotKey].fontweight = 'normal';
                }else{
                   this.screens[key].slots[slotKey].fontweight = 'bold';
                }
             }
               if(task == 'italic'){
                if(this.screens[key].slots[slotKey].fontstyle == 'italic'){
                   this.screens[key].slots[slotKey].fontstyle = 'normal';
                }else{
                   this.screens[key].slots[slotKey].fontstyle = 'italic';
                }
             }
              if(task == 'underline'){
                if(this.screens[key].slots[slotKey].textDecoration == 'underline'){
                   this.screens[key].slots[slotKey].textDecoration = 'none';
                   $('#parentText-screen-'+key+'-slot-'+this.screens[key].slots[slotKey].slotid+' p').css('text-decoration','none');
                }else{
                   this.screens[key].slots[slotKey].textDecoration = 'underline';
                    $('#parentText-screen-'+key+'-slot-'+this.screens[key].slots[slotKey].slotid+' p').css('text-decoration','underline');
                }
             }
 
              if(task == 'left'){
                   this.screens[key].slots[slotKey].TextCenter = 'left';
                
             }
 
              if(task == 'center'){
                  this.screens[key].slots[slotKey].TextCenter = 'center';
             }
 
              if(task == 'right'){
                 this.screens[key].slots[slotKey].TextCenter = 'right';
             }
 
 
 
              if(task == 'uppercase'){
                if( this.screens[key].slots[slotKey].textTransform == 'uppercase'){
                    this.screens[key].slots[slotKey].textTransform = 'none'
                }else{
                    this.screens[key].slots[slotKey].textTransform = 'uppercase'
                }
             }
 
              if(task == 'lowercase'){
               if( this.screens[key].slots[slotKey].textTransform == 'lowercase'){
                    this.screens[key].slots[slotKey].textTransform = 'none'
                }else{
                    this.screens[key].slots[slotKey].textTransform = 'lowercase'
                }
             }
            },
            changecolor(key,slotKey,r,g,b){
               var pushdata = []
                pushdata[key] = []
                pushdata[key]['slots'] = []
                pushdata[key]['slots'][slotKey] = {}
                pushdata[key]['slots'][slotKey].textColor = this.screens[key].slots[slotKey].textColor
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
             //  this.history.push(this.screens);
             this.screens[key].slots[slotKey].textColor = 'rgb('+r+','+g+','+b+')';
            },
            changesvgcolor(key,slotKey,r,g,b){
             //  this.history.push(this.screens);
            
             var slotid  = this.screens[key].slots[slotKey].slotid;
             if(r == 'save'){
                  var pushdata = []
                pushdata[key] = []
                pushdata[key]['slots'] = []
                pushdata[key]['slots'][slotKey] = {}
                pushdata[key]['slots'][slotKey].textColor = this.screens[key].slots[slotKey].textColor
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                var color = this.screens[key].slots[slotKey].textColor;
             }else{
                var color = 'rgb('+r+','+g+','+b+')';
             }
             $('#screen-'+key+'-slot-'+slotid+' svg circle').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg ellipse').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg line').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg polygon').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg polyline').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg rect').css('fill',color);
             $('#screen-'+key+'-slot-'+slotid+' svg path').css('fill',color);
 
 
              $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg circle').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg ellipse').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg line').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg polygon').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg polyline').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg rect').css('fill',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg path').css('fill',color);
 
 
              $('#headersvgslot'+slotKey+' svg circle').css('fill',color);
             $('#headersvgslot'+slotKey+' svg ellipse').css('fill',color);
             $('#headersvgslot'+slotKey+' svg line').css('fill',color);
             $('#headersvgslot'+slotKey+' svg polygon').css('fill',color);
             $('#headersvgslot'+slotKey+' svg polyline').css('fill',color);
             $('#headersvgslot'+slotKey+' svg rect').css('fill',color);
             $('#headersvgslot'+slotKey+' svg path').css('fill',color);
 
            },
            changesvgstrokecolor(key,slotKey,r,g,b){
             //  this.history.push(this.screens);
            
             var slotid  = this.screens[key].slots[slotKey].slotid;
             if(r == 'save'){
                  var pushdata = []
                pushdata[key] = []
                pushdata[key]['slots'] = []
                pushdata[key]['slots'][slotKey] = {}
                pushdata[key]['slots'][slotKey].textColor = this.screens[key].slots[slotKey].textColor
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
                var color = this.screens[key].slots[slotKey].textColor;
             }else{
                var color = 'rgb('+r+','+g+','+b+')';
             }
 
 
              $('#screen-'+key+'-slot-'+slotid+' svg circle').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg ellipse').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg line').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg polygon').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg polyline').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg rect').css('stroke',color);
             $('#screen-'+key+'-slot-'+slotid+' svg path').css('stroke',color);
 
 
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg circle').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg ellipse').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg line').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg polygon').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg polyline').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg rect').css('stroke',color);
             $('#tool-screen-'+key+'-slot-'+slotid+' .backgroundPreview svg path').css('stroke',color);
 
 
             $('#headersvgslot'+slotKey+' svg circle').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg ellipse').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg line').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg polygon').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg polyline').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg rect').css('stroke',color);
             $('#headersvgslot'+slotKey+' svg path').css('stroke',color);
            },
            flipSlot(key,slotKey,task){
             //  this.history.push(this.screens);
                var pushdata = []
                pushdata[key] = []
                pushdata[key]['slots'] = []
                pushdata[key]['slots'][slotKey] = {}
                pushdata[key]['slots'][slotKey].slotRoation = this.screens[key].slots[slotKey].slotRoation
                this.$set(this.history,this.history.length,pushdata);
                this.undoCount = 0;
             var al = this.screens[key].slots[slotKey].slotRoation.split(' ');
             var horizental = 'scaleX(1)';
             var vertical = 'scaleY(1)';
             if(task == 'horizental'){
                if(!al.includes('scaleX(-1)')){
                   horizental = 'scaleX(-1)';
                }
             }else{
                if(!al.includes('scaleY(-1)')){
                   vertical = 'scaleY(-1)';
                }
             }
             this.screens[key].slots[slotKey].slotRoation = horizental+' '+vertical;
            },
            undoRedoState(type){
             if(type == 'redo'){
                var index = this.current_view_stat + 1
             }else{
                 if(this.undoCount == 0){
                    var pushdata = []
                           var mthis = this;
                $.each(this.screens, function(sci, sc){
                     pushdata[sci] = []
                      pushdata[sci]['slots'] = []
                   $.each(sc.slots, function(sli, sl){
                        
                              pushdata[sci]['slots'][sli] =sl
                               
                   })
                })
                 mthis.$set(mthis.history,this.current_view_stat,pushdata);
 
                }
                var index = this.current_view_stat - 1
                this.undoCount = this.undoCount + 1
             }
            
            var mthis = this;
              var history_data = this.history[index];
            
           
                $.each(history_data, function(sci, sc){
                   if(typeof sc.TemplatebackgroundImage != 'undefined'){
                      mthis.screens[sci].TemplatebackgroundImage = sc.TemplatebackgroundImage
                   }
                    if(typeof sc.backgroundColor != 'undefined'){
                      mthis.screens[sci].backgroundColor = sc.backgroundColor
                   }
                  if(sc['slots'].length > 0){
                   $.each(sc['slots'], function(sli, sl){
                      if(typeof sl != 'undefined'){
                         $.each(sl, function(obk, ob){
                            mthis.screens[sci].slots[sli][obk] = ob;
 
                         })
                      }
                       
                   })
                  }
                })
             
              this.current_view_stat = index;
              this.$forceUpdate();
            },
            stateChange(){
                console.log(this.current_view_stat);
             this.history = this.history.slice(0,this.current_view_stat - 1);
             console.log(this.history);
             this.history[this.current_view_stat] = this.screens;
             console.log(this.history);
              this.screens = this.history[this.current_view_stat - 1];
              this.current_view_stat = this.current_view_stat - 1;
            }
    
        
        }
    }
 </script>