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
            <a href="/"><img src="https://agents.com.pk/images/agents-icon.png"></a>
         </div>
         <ul>
            <!-- <li class=" sidelinks"  v-on:click="handToggle(0,'111',111,'sidelink')" title="Templates"><img src="/studio/assets/img/template-icon.svg"><br> <span>Templates</span></li> -->
            <li class=" sidelinks" v-on:click="handToggle(0,'112',112,'sidelink')" title="Shapes"><img src="/studio/assets/img/shapes-icon.svg"><br> <span>Shapes</span></li>
            <li class=" sidelinks"  v-on:click="handToggle(0,'1',2,'sidelink')" title="Typography"><img src="/studio/assets/img/text-icon.svg"><br> <span>Text</span></li>
            <li  class=" sidelinks active" v-on:click="handToggle(0,'0',1,'sidelink')" title="Background"><img src="/studio/assets/img/background-icon.svg"><br> <span>Background</span></li>
            <li class=" sidelinks" @click="showDropdown('layers',1)"  title="Layers"><img src="/studio/assets/img/layers-icon.svg"><br> <span>Layers</span></li>
            <li class=" sidelinks" data-toggle="modal" data-target="#HelpModal" title="Help"><img src="/studio/assets/img/info.svg"><br> <span>Help</span></li>
         </ul>
      </div>
      <main class="tool-main dekstop-only" style="margin-top:70px;">
         <nav class="navbar tool-nav navbar-expand-md main-nav navigation fixed-top sidebar-left">
            <div class="container-fluid">
               <button class="navbar-toggler" type="button"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
               <a href="javascript:;"  @click="$router.back()" class="nav-link scrollto"><i class="fas fa-arrow-left"></i> Back</a>
         
               <div class="collapse navbar-collapse" id="main-navbar">
                  <ul class="nav navbar-nav  ml-auto">
                     <li class="nav-link">
                          <button class="undoredo" @click="undo" :disabled="undoStack.length === 0"><i class="fa fa-undo"></i></button>
                           <button class="undoredo"  @click="redo" :disabled="redoStack.length === 0"><i class="fa fa-redo"></i></button>
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
                   <li class="nav-item" v-if="user_creation_id != null">
                     <div class="" style="border:1px solid #fff;padding:8px;color:white;border-radius: 5px;">
                       <span>Editing Link:</span> http://starprinters.co.uk/studio/playground/service_book/{{ user_creation_id }}
                     </div>
                   </li>
                   <li class="nav-item">
                        <button @click="saveUserData()" class="btn btn-primary mt-2 btn-sm" id="saveButton"><i class="fa fa-file"></i> <span>Save</span></button>
                     </li>
                  </ul>
                  <ul class="nav navbar-nav ml-auto" v-if="!$route.params.editId">
                    
                     <li class="nav-item dropdown" v-if="mainDataList.type != 'service_book' && mainDataList.type != 'business_cards' && screens.length > 0 && screens[0].mainWidth != undefined && screens[0].mainWidth > 2000">
                        <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',1)" data-toggle="dropdown">
                        
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                        </svg>&nbsp; &nbsp;Download here<span v-if="screens.length > 1">Side 1</span> </a>
                        <div class="menu dowloadone" v-if="downloadDropdown">
                           <a class="dropdown-item" href="javascript:;" v-for="(size,sizeKey) in PrintSizes" :key="sizeKey" @click="ScreenDownload(0,'png',sizeKey)" v-if="checkWidth >= size.width">
                           <i class="first-icon fa fa-image" ></i> <span><strong>{{sizeKey}}</strong><br>{{size.widthM}} X {{size.heightM}} mm</span><i class="fa fa-download"></i>
                           </a>
                        </div>
                     </li>
                     <li class="nav-item dropdown" v-else-if="mainDataList.type != 'service_book'">
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

                     <li class="nav-item dropdown" v-if="mainDataList.type != 'service_book' && screens.length > 1 && mainDataList.type != 'business_cards' && screens.length > 0 && screens[0].mainWidth != undefined && screens[0].mainWidth > 2000">
                        <a class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle" href="javascript:;" @click="showDropdown('download',2)" data-toggle="dropdown">
                        
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.4505 12.9717C19.186 12.9717 18.9324 13.0771 18.7453 13.2646C18.5583 13.4522 18.4533 13.7065 18.4533 13.9717V17.9717C18.4533 18.237 18.3482 18.4913 18.1612 18.6788C17.9742 18.8664 17.7205 18.9717 17.456 18.9717H3.49465C3.23017 18.9717 2.97652 18.8664 2.7895 18.6788C2.60248 18.4913 2.49741 18.237 2.49741 17.9717V13.9717C2.49741 13.7065 2.39235 13.4522 2.20533 13.2646C2.01831 13.0771 1.76466 12.9717 1.50017 12.9717C1.23569 12.9717 0.982034 13.0771 0.795015 13.2646C0.607996 13.4522 0.50293 13.7065 0.50293 13.9717V17.9717C0.50293 18.7674 0.818128 19.5305 1.37919 20.0931C1.94024 20.6557 2.7012 20.9717 3.49465 20.9717H17.456C18.2495 20.9717 19.0104 20.6557 19.5715 20.0931C20.1325 19.5305 20.4477 18.7674 20.4477 17.9717V13.9717C20.4477 13.7065 20.3427 13.4522 20.1557 13.2646C19.9686 13.0771 19.715 12.9717 19.4505 12.9717ZM9.7673 14.6817C9.86214 14.7728 9.97397 14.8441 10.0964 14.8917C10.2158 14.9446 10.3448 14.972 10.4753 14.972C10.6058 14.972 10.7349 14.9446 10.8543 14.8917C10.9767 14.8441 11.0885 14.7728 11.1834 14.6817L15.1723 10.6817C15.3601 10.4934 15.4656 10.238 15.4656 9.97174C15.4656 9.70544 15.3601 9.45004 15.1723 9.26174C14.9846 9.07344 14.7299 8.96765 14.4643 8.96765C14.1987 8.96765 13.944 9.07344 13.7563 9.26174L11.4726 11.5617V1.97174C11.4726 1.70652 11.3675 1.45217 11.1805 1.26463C10.9935 1.0771 10.7398 0.971741 10.4753 0.971741C10.2109 0.971741 9.9572 1.0771 9.77018 1.26463C9.58316 1.45217 9.4781 1.70652 9.4781 1.97174V11.5617L7.19442 9.26174C7.10143 9.1685 6.99105 9.09454 6.86956 9.04408C6.74808 8.99362 6.61787 8.96765 6.48637 8.96765C6.35488 8.96765 6.22467 8.99362 6.10319 9.04408C5.9817 9.09454 5.87132 9.1685 5.77833 9.26174C5.68535 9.35498 5.6116 9.46567 5.56128 9.58749C5.51095 9.70931 5.48505 9.83988 5.48505 9.97174C5.48505 10.1036 5.51095 10.2342 5.56128 10.356C5.6116 10.4778 5.68535 10.5885 5.77833 10.6817L9.7673 14.6817Z" fill="white"/>
                        </svg>&nbsp; &nbsp;Download <span v-if="screens.length > 1">Side 2</span> </a>
                        <div class="menu dowloadone" v-if="downloadDropdownTwo">
                           <a class="dropdown-item" href="javascript:;" v-for="(size,sizeKey) in PrintSizes" :key="sizeKey" @click="ScreenDownload(1,'png',sizeKey)" v-if="checkWidth >= size.width">
                           <i class="first-icon fa fa-image" ></i> <span><strong>{{sizeKey}}</strong><br>{{size.widthM}} X {{size.heightM}} mm</span><i class="fa fa-download"></i>
                           </a>
                        </div>
                     </li>
                     <li class="nav-item dropdown" v-else-if="screens.length > 1 && mainDataList.type != 'service_book'">
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
                     <li class="nav-item dropdown" v-if="mainDataList.type == 'service_book'">
                        <button type="button" class="nav-link btn btn-warning pt-1 pb-1 mt-0 text-white dropdown-toggle"  @click="serviceBookConintue()" >Continue...</button>
                     
                     </li>
                     </ul>
               </div>
            </div>
         </nav>
         <div class="row m-0" @click="hideDropdown">
            <div class="col-2 p-0 side-panels" style="height:92.8vh;overflow-y:scroll">
               <div class="panel-group" id="accordion">
                  <div class="panel  panel-default" style="">
                     <div :id="'tool-screen-0-slot-111'" class="panel-collapse  collapse ">
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
                                 <h5>{{cat.name}} <a href="javascript:;" @click="showallcatsShapes(cat.id,cat.name)" class="float-right text-white">Show All</a></h5>
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
                           <a href="javascript:;" v-on:click="ScreenDownload(key,JSON.stringify(screen))"><i class="fa fa-download"></i></a>
                        </li>
                        <li>
                           <a href="javascript:;" v-on:click="setCurrentScreen(key)" data-toggle="modal" data-target="#copySettingsModal"><i class="fa fa-exchange-alt"></i></a>
                        </li>
                        <li>
                           <a href="javascript:;" v-on:click="toolPanelLock(key)" :class="'tool-lock-btn-'+key"><i class="fa fa-unlock"></i></a>
                        </li>
                     </ul>
                     </div> -->
                  <div class="panel-group" id="accordion">
                     <div class="panel  panel-default" style="">
                        <div :id="'tool-screen-'+key+'-slot-'+screen.bgid" class="panel-collapse collapse show">
                           <div class="panel-body">
                           <h4 v-if="key == 1">Back Side BG</h4>
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
                                    <option value="color" v-if="screen.backgroundColor && screen.backgroundColor.length >= 7" selected>Color</option>
                                    <option value="color" v-else>Color</option>
                                    <option value="gradient">Gradient</option>
                                 </select>
                              </div>
                              <div :id="'color-picker-'+key"  class="background-color-picker" :style="screen.TemplatebackgroundImage != ''?'display:none':''">
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
                              <div :id="'gradient-picker-'+key"  class="background-color-picker" :style="(screen.backgroundColor && screen.backgroundColor.length >= 7) || screen.TemplatebackgroundImage != ''?'display:none':''" >
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
                                 <!-- <h4>Text</h4> -->
                                 <div class="row mb-3">
                                    <div class="col-8 pr-0">
                                       <h6>Font Family</h6>
                                       <select class="form-control select2" v-model="slot.FontName" :id="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" :name="'fontfamily-tool-screen-'+key+'-slot-'+slot.slotid" >
                                          <option v-for="f in fonts" :value="f.font" :style="'font-family:'+f.font">{{f.font}}</option>
                                       </select>
                                    </div>
                                    <div class="col-4">
                                       <h6>Size</h6>
                                       <input class="form-control" type="number"  v-model="slot.fontSize">
                                    </div>
                                 </div>
                                 <div class="row mb-3">
                                    <div class="col-6 pr-1 letter-specing">
                                       <h6>Letter Spacing</h6>
                                         <div class="input-group">
                                       <input type="number" class="form-control" min="0" max="30" :id="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" :name="'latterspace-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.latterSpacing">
                                          <div class="input-group-append">
                                    <span class="input-group-text"><img src="/studio/assets/img/letter-specing.svg"></span>
                                 </div>
                                 </div>
                                    </div>
                                    <div class="col-6 pl-1 line-hieght">
                                           <h6>Line Height</h6>
                                        <div class="input-group">
                                         <input type="number" class="form-control" :id="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" :name="'lineheight-tool-screen-'+key+'-slot-'+slot.slotid" v-model="slot.lineHeight">
                                        <div class="input-group-append" >
                                    <span class="input-group-text"><img src="/studio/assets/img/line-hieght.svg"></span>
                                 </div>
                                 </div>
                                    </div>
                                 </div>
                                 <h6>Text Style</h6>
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
                                       <li class="ml-38" @click="changesvgcolor(key,slotKey,'0','0','0')" :style="'background:rgb(0,0,0);'"></li>
                                       <li @click="changesvgcolor(key,slotKey,'255','255','255')" :style="'background:rgb(255,255,255);'"></li>
                                       <li @click="changesvgcolor(key,slotKey,'103','103','103')" :style="'background:rgb(103,103,103);'"></li>
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
               <div class="instruction-box"  v-if="mainDataList.type == 'business_cards' && instruction_box">
                  <h4>Instructions <button class="btn btn-sm btn-danger" type="button" v-on:click="instruction_box = false"><i class="fa fa-times"></i></button></h4>
                  <hr>
                  <ul class="mt-2">
                     <li><b>Change Text:</b> Click on the text in canvas and tools will open on left side</li>
                     <li><b>Change Logo:</b> Click logo in canvas 'Select new image' button will appear in sidebar </li>
                     <li><b>Change Background:</b> Click on background in canvas or there is a background option in left tool bar</li>
                     <li><b>Hide Something:</b> Right click on desired text or images in canvas box will open with hide or delete options.</li>
                  </ul>
               </div>
               <div class="pages-list"   v-if="mainDataList.type == 'service_book' && instruction_box">
                  <ul>
                     <li>Pages</li>
                     <li v-for="(screen, key) in screens" :key="key"><a :href="'#'+key" :class="{ 'active-link': activeLink === key }" @click="activeLink = key">{{key+1}}</a></li>
                  </ul>
               </div>  
               <section class="screen"  id="screenWraper"  v-if="screens != ''"  v-bind:style="[$route.params.slug == 'meme' ? {'margin-top': '50px'} : '' ]">
                  <button type="button" style="position:absolute;top:30%;right:20px;z-index:9" class="btn btn-warning" v-if="mainDataList.type == 'business_cards'" data-toggle="modal" data-target="#fillDataModel">+ Fill Data</button>
                  <div  v-for="(screen, key) in screens"  class="single-screen-wraper" :id="key" >
                     <div v-if="mainDataList.type == 'service_book'">
                        <h4 >Page No #{{ key+1 }}</h4>
                        
                        <button type="button" class="btn btn-primary mt-1 mb-3" @click="addImageSlot(key)">+ Add Image</button> 
                     </div>
                     <div  :class="'box single-screen screen-'+key" :ref="handleId" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:relative;'"  @mouseover="mouseOver(key)" v-on:mouseleave="mouseLeave(key)"  >
                        <!-- <div :style="'width:'+parseInt(screen.width - 42)+'px;height:'+parseInt(screen.height - 42)+'px;border:2px dashed white;position:absolute;top:21px;left:21px;z-index:9'"> </div> -->
                        <div class="screen-loader" :id="'screen-loader-'+key" style="display:none"><img src="/studio/assets/img/loader.gif"></div>
                        <!-- <div class="edit-btn" :class="'edit-screen-'+key"  v-on:click="toolbartoggle(key)"><i class="fa fa fa-pencil-alt"></i></div> -->
                        <!-- <div v-if="(screen.backgroundColor != '') || screen.TemplatebackgroundImage != ''" :data-screenkey="key" data-slotkey="0" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.backgroundColor+';'" >
                           <img  :src="screen.TemplatebackgroundImage" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.bgSize+';  transform: rotate('+screen.bgRotation+'deg);object-position:'+screen.bgPosition" class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                        </div> -->
                        <div v-if="(screen.backgroundColor != '') || screen.TemplatebackgroundImage != ''" :data-screenkey="key" data-slotkey="0" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid"   v-on:click="selectSlot(key,'0',screen.bgid)">
                           <img  :src="screen.TemplatebackgroundImage" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.bgSize+';  transform: rotate('+screen.bgRotation+'deg);object-position:'+screen.bgPosition" class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                        </div>
                        <div v-else-if="screen.panaramic != null && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.panaramic.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid"   v-on:click="selectSlot(key,'0',screen.bgid)">
                           <img  :src="screen.panaramic.imageData" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.panaramic.bgSize+';  transform: rotate('+screen.panaramic.bgRotation+'deg);object-position:'+screen.panaramic.bgPosition" class="bg-img">
                        </div>
                        <div v-for="(slot,slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'text')"  v-if="slot.type == 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;z-index:'+slot.zIndex+';width:auto;top:'+slot.top+'px;left:'+slot.left+'px;color:'+slot.textColor+';font-size:'+slot.fontSize+'px;font-family:'+slot.FontName+';text-align:'+slot.TextCenter+';'" :data-width="slot.slotWidth" class=" makeitDraggable text-slot"  v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="text" :data-order="slot.orderNumber" :id="'parentText-screen-'+key+'-slot-'+slot.slotid">
                           <div :style="'line-height: '+slot.lineHeight+'px;-webkit-text-stroke-width:'+slot.textStrikeWidth+'px;-webkit-text-stroke-color:'+slot.textStrikeClr+';text-decoration:'+slot.textDecoration+';text-transform:'+slot.textTransform+';font-style:'+slot.fontstyle+';font-weight:'+slot.fontweight+';text-align:'+slot.TextCenter+';letter-spacing:'+slot.latterSpacing+'pt; display: inline-block;font-size:'+slot.fontSize+'px;white-space:'+slot.lineBreak+';text-shadow:'+slot.shadow" :id="'screen-'+key+'-slot-'+slot.slotid">
                              <p v-html="slot.SlotType" :style="'line-height: '+slot.lineHeight+'px;'"></p>
                           </div>
                        </div>
                     
                        <div v-for="(slot, slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'image')"  v-if="slot.type != 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;box-shadow:'+slot.shadow+';z-index:'+slot.zIndex+';width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;top:'+slot.top+'px;left:'+slot.left+'px;perspective: 500px;display:'+slot.display" class=" makeitDraggable image-slot" :id="'screen-'+key+'-slot-'+slot.slotid" v-on:click="selectSlot(key,slotKey,slot.slotid)" data-type="image">
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
                        <div class="watermark" style="width: 20%;position: absolute;z-index: 999999;bottom: 5%;right: 5%;"><img src="/assets/watermark.png" style="width:100%"></div>
                  
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
      <fillDataModel/>
      <screeShotsModel/>
      <HelpModal/>
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
   import fillDataModel from './partial_views/fillDataModel'
   import HelpModal from './partial_views/HelpModal'
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
                activeLink: 0,
               showshapeslist:true,
               templatesLoader: true,
               shapesLoader:true,
               templatespage:2,
               shapespage:2,
               downloadDropdown: false,
               layersDropdown: false,
               fullScreenLoader: true,
               instruction_box: true,
               recent_action: "",
               message: "",
               templateSearch:'',
               shapeSearch:'',
               mainDataList: {},
               screens: [],
               undoStack: [], // Stack to store previous states
               redoStack: [],
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
               user_creation_id: this.$store.getters.getUserCreationId,
               fillData: this.$store.getters.getFillData,
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
               userCountry: '',
               userIP: '',
               newUserImage:null,
               currentyDevice:'iphone6',
               deviceWidth:'',
               checkWidth:'',
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
           window.addEventListener('beforeunload', this.saveExistedData);
       },
       mounted(){
      
           this.draggableValue.boundingElement = this.$refs['screen-0'];
         //   if (!this.$store.getters.intro) {
         //     $('#introModel').modal('show');
         // }
         this.fetchUserLocation();
         if (!this.$store.getters.checkCookieStatus) {
             this.cookieStatus = true;
         }else{
           this.cookieStatus = true;
         }
       },
       created() {
         document.addEventListener('keydown', this.handleKeyDown);
       
      },

      beforeDestroy() {
         document.removeEventListener('keydown', this.handleKeyDown);
         window.removeEventListener('beforeunload', this.saveExistedData);
      },
       directives: {
           Draggable,
       },
       components: {
           quillEditor,
           backgroundLayoutsModel,
           screeShotsModel,
           fillDataModel,
           backgroundModel,
           HelpModal,
           InfiniteLoading,
           VueGpickr
       },
       beforeRouteLeave: function() {
         this.$store.commit('set_playground',this.screens);
         this.$store.commit("set_playChange", true);
           this.$store.commit('set_playgroundMain',this.mainDataList);
           this.$router.go();
       },
       saveExistedData: function(event) {
           this.$store.commit('set_playground',this.screens);
              this.$store.commit("set_playChange", true);
           this.$store.commit('set_playgroundMain',this.mainDataList);
       },
       methods: {
         async fetchUserLocation() {
            try {
            // Make a request to ipinfo.io to get user IP and country info
            const response = await axios.get('https://ipinfo.io/json');
            
            // Extract user IP and country from the response data
            this.userIP = response.data.ip;
            this.userCountry = response.data.country;
            
            // Now you can send this information via Axios to your desired endpoint
            this.sendUserLocation();
            } catch (error) {
            console.error('Error fetching user location:', error);
            }
         },
           onPosChanged: function(positionDiff, absolutePosition, event) {
          
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
            if(this.$route.params.editId && this.$route.params.editId != undefined && this.$route.params.editId != ''){
           
               var slug = this.$route.params.editId;
               var mthis = this;
            var dataUrl =
                "/user-creation-detail/" + slug
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                  mthis.user_creation_id = this.$route.params.editId
                  mthis.$store.commit("set_user_creation_id", mthis.$route.params.editId);
                  mthis.loading = false;
                  mthis.screens = JSON.parse(result.data.details.screens);
                  mthis.mainDataList.type = 'service_book'
                    mthis.$forceUpdate();
                    setTimeout(function(){  
                     mthis.fullScreenLoader = false;
                     // console.log(mthis.$refs[mthis.handleId][0]);
                     $('.makeitDraggable').draggable({
                         containment: "parent",
                         start: function( event, ui ) {
                        

                       
                        },
                         stop: function(event, ui) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                          var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                          
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;

                            
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                             var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                           

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                          
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                              var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var transform = $(event.target).css('transform');
                        }
                     })
                     
                     mthis.$forceUpdate();
                                mthis.draggableValue.boundingElement = mthis.$refs[mthis.handleId][0];
                     }, 4000);
                },
                (error) => { }
            );
            }else{

           if (this.$store.getters.getPlaygroundTemplate != '' && this.$store.getters.getPlaygroundTemplate > 0) {
               var dataUrl = '/get-template/'+this.$store.getters.getPlaygroundTemplate;
            }else{
                 var dataUrl = '/get-template';
            }
               axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                   
                   this.fonts = result.data.fonts
                   this.loading = false;
   
                  if (this.$store.getters.playgroundData.length > 0 && this.$store.getters.playChange) {
                     this.fullScreenLoader = false;
                     this.$confirm( {
                        title: 'Editor',
                        message: `You already have another active project in the editor. Do you want to overwrite it?`,
                        button: {
                           no: 'No',
                           yes: 'Yes'
                        },
                        callback: confirm => {
                           if (confirm) {
                               this.mainDataList = result.data.data
                               this.fullScreenLoader = true;
                             this.loadScreens('no');
                               this.$store.commit('set_playChange',false);
                               this.$store.commit("set_user_creation_id", null);

                           }else{
                           var mthis = this;
                            this.mainDataList = this.$store.getters.playgroundMainData;
                             this.screens = this.$store.getters.playgroundData;
                             this.checkWidth = this.screens[0].mainWidth
                             setTimeout(function(){  
                                 $('.makeitDraggable').draggable({
                                    containment: "parent",
                                    start: function( event, ui ) {
                                    

                                 
                                    },
                                    stop: function(event, ui) {
                                          const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
                                         mthis.undoStack.push(screensCopy);
                                       mthis.redoStack = [];
                                    var  screenkey = $(event.target).data('screenkey');
                                       var slotkey = $(event.target).data('slotkey');

                                       var top = $(event.target).css('top').replace('px','');
                                       var left = $(event.target).css('left').replace('px','');
                                    
                                       mthis.screens[screenkey].slots[slotkey].top = top;
                                       mthis.screens[screenkey].slots[slotkey].left = left;

                                       
                                    }
                                 }).resizable({
                                    handles: "ne, se, sw, nw",
                                    start: function( event, ui ) {
                                    },
                                    stop: function( event, ui ) {
                                          const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
                                        mthis.undoStack.push(screensCopy);
                                       mthis.redoStack = [];
                                       var  screenkey = $(event.target).data('screenkey');
                                       var slotkey = $(event.target).data('slotkey');
                                       var width = $(event.target).css('width').replace('px','');
                                       var height = $(event.target).css('height').replace('px','');

                                       

                                       mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                                       mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                                    
                                    }
                                 }).rotatable({
                                    wheelRotate:false,
                                    start: function( event, ui ) {
                                    },
                                    stop: function( event, ui ) {
                                          const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
                                     mthis.undoStack.push(screensCopy);
                                       mthis.redoStack = [];
                                          var  screenkey = $(event.target).data('screenkey');
                                       var slotkey = $(event.target).data('slotkey');
                                       var transform = $(event.target).css('transform');
                                    }
                                 })
                                 
                                    mthis.$forceUpdate();
                                 mthis.draggableValue.boundingElement = mthis.$refs[mthis.handleId][0];
                              }, 3000);
                           }
                        }
                     })
                  // }else if (this.$store.getters.playgroundData.length > 0) {
                  //    this.fullScreenLoader = true;
                  //  this.mainDataList = this.$store.getters.playgroundMainData;
                  //  this.screens = this.$store.getters.playgroundData;
                  }else{
                     this.fullScreenLoader = true;
                       this.mainDataList = result.data.data
                       this.loadScreens('no');
                  }
               }, error => {
   
               });   
               
            }
           },
            getTemplatesData(){
                this.templatesLoader = true;
               var dataUrl = '/templates/'+this.$route.params.slug+'?from=starprinter&name='+this.templateSearch;
               axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                  
                   this.newtemplates = result.data
                   this.templatesLoader = false;
               
               }, error => {
   
               });           
           },
            getShapes(){
                     this.shapesLoader = true;
               var dataUrl = '/shapes?from=starprinter&name='+this.shapeSearch;
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
                var dataUrl = '/single-category-tempates/'+catid+'?from=starprinter&type='+this.$route.params.slug;
               axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                  
                   this.selectedCat.templates = result.data.data
                    this.$forceUpdate();
                   this.templatesLoader = false;
               
               }, error => {
   
               }); 
           },
           catstemplatesonscroll($state){
                var catid =  this.selectedCat.id;
                var dataUrl = '/single-category-tempates/'+catid+'?from=starprinter&type='+this.$route.params.slug+'&page='+this.templatespage;
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
           textslotdata(){
            return {
               "FontName": 'Inter',
               "FontSize": '100',
               "Height": '30',
               "MainimgRoation": undefined,
               "Mainleft": 0.0953,
               "MainslotWidth": '100',
               "Maintop": 0.06720,
               "SlotType": "New Text",
               "TextCenter": "left",
               "TextColor_Brown": 0,
               "TextColor_GREEN": 0,
               "TextColor_RED": 0,
               "TextPostion": "top",
               "textColor":'#000000',
               "TextRole": "Add Text Here",
               "opacity":100,
               "Width": 100,
               "Z-index": 0,
               "deviceStye": "matt_black",
               "display": "block",
               "textDecoration":'none',
               "textTransform":'none',
               "fontstyle":'normal',
               "fontweight":'normal',
               "fontSize": '100',
               "imgRoation": "rotate(0deg)",
               "latterSpacing": "0",
               "layerStyling": "",
               "left": 0.0953,
               "leftPercents": 5,
               "lineBreak": "normal",
               "lineHeight": "auto",
               "marginBottom": 0,
               "marginLeft": 0.0953,
               "marginRight": 0,
               "marginTop": 0.06720,
               "rotation": "0",
               "shadow": "none",
               "show": true,
               "slotHeight": '40',
               "slotWidth": '150',
               "slotid": 1,
               "title": "",
               "top": 0.06720,
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
            };
           },
           addTextSlot(key,slotKey){
                const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
            this.redoStack = [];
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
            };
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
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                          var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                          
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;

                            
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                             var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                         

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                          
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                              var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var transform = $(event.target).css('transform');
                        }
                     });
                     

                     }, 2000);
           },
           addImageSlot(key){
                const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
            this.redoStack = [];
            var mthis = this;
            var newslotid = this.screens[key].slots[this.screens[key].slots.length - 1].slotid + 1;
            var newslot = {
                        "SlotImageUrl": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATYAAAE0CAYAAACmdB+iAAAAAXNSR0IArs4c6QAAFVFJREFUeF7t3eWS48gWRWH3MDMz4/u/xfydGGZmZugbu26oQq2RLdlZVZ196lNEx0Bb6cx1jpaSJF945ZVXLm4cCCCAQCECF4itUDQ1BQEEjggQm0RAAIFyBIitXEg1CAEEiE0OIIBAOQLEVi6kGoQAAsQmBxBAoBwBYisXUg1CAAFikwMIIFCOALGVC6kGIYAAsckBBBAoR4DYyoVUgxBAgNjkAAIIlCNAbOVCqkEIIEBscgABBMoRILZyIdUgBBAgNjmAAALlCBBbuZBqEAIIEJscQACBcgSIrVxINQgBBIhNDiCAQDkCxFYupBqEAALEJgcQQKAcAWIrF1INQgABYpMDCCBQjgCxlQupBiGAALHJAQQQKEeA2MqFVIMQQIDY5AACCJQjQGzlQqpBCCBAbHIAAQTKESC2ciHVIAQQIDY5gAAC5QgQW7mQahACCBCbHEAAgXIEiK1cSDUIAQSITQ4ggEA5AsRWLqQahAACxCYHEECgHAFiKxdSDUIAAWKTAwggUI4AsZULqQYhgACxyQEEEChHgNjKhVSDEECA2OQAAgiUI0Bs5UKqQQggQGxyAAEEyhEgtnIh1SAEECA2OYAAAuUIEFu5kGoQAggQmxxAAIFyBIitXEg1CAEEiE0OIIBAOQLEVi6kGoQAAsQmBxBAoBwBYisXUg1CAAFikwMIIFCOALGVC6kGIYAAsckBBBAoR4DYyoVUgxBAgNjkAAIIlCNAbOVCqkEIIEBscgABBMoRILZyIdUgBBAgNjmAAALlCBBbuZBqEAIIEJscQACBcgSIrVxINQgBBIhNDiCAQDkCxFYupBqEAALEJgcQQKAcAWIrF1INQgABYpMDCCBQjgCxlQupBiGAALHJAQQQKEeA2MqFVIMQQIDY5AACCJQjQGzlQqpBCCBAbHIAAQTKESC2ciHVIAQQIDY5gAAC5QgQW7mQahACCBCbHEAAgXIEiK1cSDUIAQSITQ4ggEA5AsRWLqQahAACxCYHEECgHAFiKxdSDUIAAWKTAwggUI4AsZULqQYhgACxyQEEEChHgNjKhVSDEECA2OQAAgiUI0Bs5UKqQQggQGxyAAEEyhEgtnIh1SAEECA2OYAAAuUIEFu5kGoQAggQmxxAAIFyBIitXEg1CAEEiE0OIIBAOQLEVi6kGoQAAsQmBxBAoBwBYisXUg1CAAFikwMIIFCOALGVC6kGIYAAsckBBBAoR4DYyoVUgxBAgNjkAAIIlCNAbOVCqkEIIEBscgABBMoRILZyIdUgBBAgNjmAAALlCBBbuZBqEAIIEJscQACBcgSIrVxINQgBBIhNDiCAQDkCxFYupBqEAALEJgcQQKAcAWIrF1INQgABYpMDCCBQjgCxlQupBiGAALHJAQQQKEeA2MqFVIMQQIDY5AACCJQjQGzlQqpBCCBAbHIAAQTKESC2ciHVIAQQIDY5gAAC5QgQW7mQahACCBCbHEAAgXIEiK1cSDUIAQSITQ4ggEA5AsRWLqQahAACxCYHEECgHAFiKxdSDUIAgZJiu++++zYPP/zw5qqrrjqO8M8//7x5++23N//8889BUb/99ts3jz/++Obaa689Pv+nn37avPPOOweXeVBFOj/p1ltv3Tz55JPHnML7o48+2nzzzTed11z1KhEoKbYE6Kmnntrceeedx7G6ePHi5osvvth88skne8fv6quv3jz99NObXLTD8ddff20++OCDzQ8//LB3eZVPILbK0b1y2lZWbDfffPNRz+H6668/jsaff/65+fDDD/eW0UMPPbS5//77j3uALZK8clLjsJoS22HcnHWyBMqKLZgeeOCBzYMPPnjJkPTHH3/cvPXWW6sp5kJ94oknNtddd50h6ApqxLYCko+cOoHSYgu9Z599dnPbbbcdg/z33383n3322ebzzz9fBfeZZ57ZZH5tOA7t9a36sgIfIrYCQSzQhPJim+tx/fHHH0cLCb///vvOEE57fJHil19+edA8XYFcWdUEYluFyYdOmUB5sYVfVkizUjpeJf3uu+8277777la8N9xwwya9tfEcXYaxOefQldVTjmUXxRNbF2E495U4F2LLqmZWScdD0sgpK6RfffXVbBJk4eGuu+4yBN3zEiG2PYH5+KkQOBdiC7m5fWi//fbbUQ9sOiS99957j3p5EWKONUPQfDbnRYZZaBjOHc7P3Fy2hmQom3/fdbz88sub9BhzZFvJe++9t8meuV1H9tjdc889Rx/Jqm3mED/99NNLThl/Zig3PdL0ZvN9Fy5cOGprhurZd5btMfsea8U2/dzXX399tH0m7LLgk3hdc801R3XK8ffff29+/fXXozql5zw+smJ99913H7dhYJ645saVstcciVkY3nHHHUdl5b+H7x/KTD0Si5T7yy+/rCn2qJwhN8J7GDkkTsmFjB4Sr9xsx7HP97z55ps7v2NX3qW8lP/tt98e1fc8jTTOjdiSHZFVLoIhWZNYSfpsARmOJHR6dzfeeOPx/1sagqbMzMflQlw6cmHk4ty1eHFWYkvC50IeS3iofySSi2rfi6FFbPnOSG28CXrKM/UJu/zJlp5HH3306J/bjsT4+++/P5LmrrbsE8NBcuH38ccf7yw3o4TUcbhRbatnbiYpKzk6fHZJbJHlEq/h+1J+mK2V/FIe9/7350psuYAzb3bLLbccxyWiSdIn+XM89thjRxf7IL/c8d5///2tPab0gtJbGN/Zl4Keiy0XRcqdO85CbMNFPie1ln16h4otvdnEZa4+U0aJWZ5myM1kfAPaJbf0lCOOuWNuDnYphvn7uRvj+Lz0/CK18VahXeUm11LmMK+7S2yH1Dkxz001uwKqH+dKbAlmki0yGveuhgSa/l2GZUmE6ZBuSIq55MpFl6FFhnIZqqQ3kScg8mec4LuGt2chtqENQ48mbUydMpSOnPLfa4da44vkULGN65PvTc8iN5v03jJUTr3G0stQeujZZUph+HzKyY0m54xjnGFpHn+bTjvkJvbII49cUnbKy40n35/P53szNE4M0wMbL0JFRpnOmLKa6/mHb3r/qWtEntxIryt5Nyf0bWKbbhhPm9MjS96lzqlLvj/1DYvxAtjS3HIV4Z07sc31ypJwWUhI8o4XGHZt5p1ewCk3z6Om9ze3jSRSi1DH5U97i0NSnZXYlnochyR5i9h2yX46jTD0mHIxZyphOsyczqlue2Z1uk9xadphbv51bl9kev757HBExOkxRpjTI3VNz24soHxmTmzTJ2oSw9xEtw2JI8zUJZIbRhXb5pYPiXev55xLsSXYzz333Oamm246jkvuvLnDD3fjpSHoNHHXJMvc9ybRszgwPs5KbNt6Gy3J2iK29GKyv3DuyAWduc9xr3eJ+Xhz9tyCylR+a5//HctwrtxpXYcbZ4bD2470SCO3uZHE+Jxp3u1iNpw3fdZ5303qLflwuc49l2IL7LkhyBCEpSFoEuX5558/nt/ZJ1FyF8/QZyzQ6VDmrMS27+Nla5L0ULGtufhffPHFS25GWekbL/xM67e0UhyZZNEgskw80kPaJtZx2eNy8/+n9Zhu7E5P/o033ljEN91iNNdjGzNILzTtn+sFTr9sWqcMWTM0r3qcW7EloNsm/pfugrnT5/nR4e66T88nUnzhhReOV77mhkhnJbZhi8VJJvehYktvKYsp060c47qllz28YWXNzWQqoJNq71K54zfLpEe3a+Fi3L7p67amYpvmXaY8Xn/99VUr15kCSc4O85L7nHuS+XFWZZ1rsc1N8GYSNkPDXRPn0wRce0cegjq+QOeGMmchtm173VoT71CxrbnQxtzWvOdtSUBr2zosHqRtWbkdenjD+VNhpjc/rLxHwFnBXbPNYspuKra59wyubcP0c2v3Rx5a/uU+71yLbei1DRtb899Le4fymaxKpWs/TMauOWfbUGbujn5exfbqq6/uvB5OW2wRVlYoM0eWm1565ON5122Vm4ptHL99hovTx/imeTXNuxZ5ZOEqPeSq7xMkttGO/cshtnznrgtj7Z11aT5pKvEee2yXS2wRWaSRHtM++xG39dgOuTENZe168uCkxZb5uawqVzyI7TKILXMd2V+Uw1D0/69az1D0cogtizkRxtJTI8PjSZmiyNB0/HbmpR7b2lejT+dfl3ps+44UKgpsW5uI7QCxZeiapflhZfM059jWDmX02P6b4ktzbJmMz/aJ8RaS3Ggyz5rHu/Inwp0O15bKPa05tunKZur32muvnSdfrW4rsR0gtpZV0ek8ytKq6JpJ8kR7aUHCUPS/Q/7p9orhec3h8bptV9G4xz03lXDoquj0hjntkaWXGBEPvcu10xSrbVDog8R2gNhOex/bdFvD0qraVJZr3u5hjm2zeemll473Iu7DY7qfbjoUPXQf27QnOBVb4pwfFRoekt9nK0khZ61qCrEdILaQPaknD+b2zE1fZ760EXV6IRHb/3N/acg4nqhfs0E4Zc5tuZiKbfrkwZrnM7f9vOP0tUWHvidwyJFhXjdzhVk8SC+14kFsB4rtpJ4VTW9sunN8Ks1dv7OQ3fN5kmH8qh9iWye2ac8rN5nsYdz2eqPIIX+mD6zPbfyde0tMYj03zI0II+Hpm0rmFge2vVcwzyhv23uZIW6etR0vkOT50m1vl6kgOmI7UGwJfsvbPXa9umguebPvKMmYiygT2hFaVlazEXT8toltK63m2P47xza9gSQmmZBPDzkCiuAinexty588pD63HWROEnObv1Ne5JkYRlopOzHM3Nncquy2Vc+5vEvZqXPqkvOyIJKnDVL2NEfWbEK/0uVGbA1iG2RxyPvYll5+mAnqyGvNvqpckHkUaXifmR7buh7b3O9arLmgc2MZP32wTUBzq667yp++iGHXdo598mP8nbveMrKm7VfKZ4itUWwJ9D5vX13zBt2UOfe6mbmkytxQegDpaWQLSs4jtnViy6cinwzll95wm88OveZsah2/aWTXr56lp5fyp68kmsYy8UtvK3vqhqHu0j61DIuTe0t78Ibvynfk9UZLr5m/UuS1q57EdgJiC+DcwbPZMxfK9DcPWt49n+FEkjevWBrewR9xpczh3fv5Z3qNxHZpqi8tHgyfDtdIIhKaPgc6xC497Lx0dJh/2+eB/F2/eRApZo41D8oPb9xdK7alvEueDL8VMX4RZwVxLbXh3IttCZC/R+CsCExXt5d+IvKs6nUlfg+xXYlRU+euCQy951Ry+HWyvKF56RgvZtijtkRr998TWxs/ZyPwHwLTJwTW/OLXdBV17RMn8M8TIDaZgcAJE5g+IbD0u7SZU8t8YObYhlXwNTI84WqXKo7YSoVTY3ohMN2gm6Hl+Ne3hj1yWRya/pLUmrcD99LOXutBbL1GRr2uaAJzG3TXNGj41ak8SeA4nACxHc7OmQjsJJCtI+m5pVe2ZqP12j2OsC8TILZlRj6BQBOBiC17HPMIVTbTjiU37JPLo1Z5lCurqI52AsTWzlAJCCDQGQFi6ywgqoMAAu0EiK2doRIQQKAzAsTWWUBUBwEE2gkQWztDJSCAQGcEiK2zgKgOAgi0EyC2doZKQACBzggQW2cBUR0EEGgnQGztDJWAAAKdESC2zgKiOggg0E6A2NoZKgEBBDojQGydBUR1EECgnQCxtTNUAgIIdEaA2DoLiOoggEA7AWJrZ6gEBBDojACxdRYQ1UEAgXYCxNbOUAkIINAZAWLrLCCqgwAC7QSIrZ2hEhBAoDMCxNZZQFQHAQTaCRBbO0MlIIBAZwSIrbOAqA4CCLQTILZ2hkpAAIHOCBBbZwFRHQQQaCdAbO0MlYAAAp0RILbOAqI6CCDQToDY2hkqAQEEOiNAbJ0FRHUQQKCdALG1M1QCAgh0RoDYOguI6iCAQDsBYmtnqAQEEOiMALF1FhDVQQCBdgLE1s5QCQgg0BkBYussIKqDAALtBIitnaESEECgMwLE1llAVAcBBNoJEFs7QyUggEBnBIits4CoDgIItBMgtnaGSkAAgc4IEFtnAVEdBBBoJ0Bs7QyVgAACnREgts4CojoIINBOgNjaGSoBAQQ6I0BsnQVEdRBAoJ0AsbUzVAICCHRGgNg6C4jqIIBAOwFia2eoBAQQ6IwAsXUWENVBAIF2AsTWzlAJCCDQGQFi6ywgqoMAAu0EiK2doRIQQKAzAsTWWUBUBwEE2gkQWztDJSCAQGcEiK2zgKgOAgi0EyC2doZKQACBzggQW2cBUR0EEGgnQGztDJWAAAKdESC2zgKiOggg0E6A2NoZKgEBBDojQGydBUR1EECgnQCxtTNUAgIIdEaA2DoLiOoggEA7AWJrZ6gEBBDojACxdRYQ1UEAgXYCxNbOUAkIINAZAWLrLCCqgwAC7QSIrZ2hEhBAoDMCxNZZQFQHAQTaCRBbO0MlIIBAZwSIrbOAqA4CCLQTILZ2hkpAAIHOCBBbZwFRHQQQaCdAbO0MlYAAAp0RILbOAqI6CCDQToDY2hkqAQEEOiNAbJ0FRHUQQKCdALG1M1QCAgh0RoDYOguI6iCAQDsBYmtnqAQEEOiMALF1FhDVQQCBdgLE1s5QCQgg0BkBYussIKqDAALtBIitnaESEECgMwLE1llAVAcBBNoJEFs7QyUggEBnBIits4CoDgIItBMgtnaGSkAAgc4IEFtnAVEdBBBoJ0Bs7QyVgAACnREgts4CojoIINBOgNjaGSoBAQQ6I0BsnQVEdRBAoJ0AsbUzVAICCHRGgNg6C4jqIIBAOwFia2eoBAQQ6IwAsXUWENVBAIF2AsTWzlAJCCDQGQFi6ywgqoMAAu0EiK2doRIQQKAzAsTWWUBUBwEE2gkQWztDJSCAQGcEiK2zgKgOAgi0EyC2doZKQACBzggQW2cBUR0EEGgnQGztDJWAAAKdESC2zgKiOggg0E6A2NoZKgEBBDojQGydBUR1EECgnQCxtTNUAgIIdEaA2DoLiOoggEA7AWJrZ6gEBBDojACxdRYQ1UEAgXYCxNbOUAkIINAZAWLrLCCqgwAC7QSIrZ2hEhBAoDMCxNZZQFQHAQTaCRBbO0MlIIBAZwSIrbOAqA4CCLQTILZ2hkpAAIHOCBBbZwFRHQQQaCdAbO0MlYAAAp0RILbOAqI6CCDQToDY2hkqAQEEOiNAbJ0FRHUQQKCdALG1M1QCAgh0RoDYOguI6iCAQDsBYmtnqAQEEOiMALF1FhDVQQCBdgLE1s5QCQgg0BkBYussIKqDAALtBIitnaESEECgMwLE1llAVAcBBNoJEFs7QyUggEBnBIits4CoDgIItBMgtnaGSkAAgc4I/A/cZ7sy6AXbnwAAAABJRU5ErkJggg==",
                        "slotImageWidth": 407,
                        "slotImageHeight": 406,
                        "SlotType": "Image11",
                        "Width": 0.38798856053384173,
                        "Height": 0.2728494623655914,
                        "marginTop": 40,
                        "marginLeft": 30,
                        "Z-index": 0,
                        "marginBottom": 0,
                        "layerStyling": "",
                        "objectFit": "cover",
                        "shadow": "none",
                        "deviceStye": "matt_black",
                        "deviceType": "full_device",
                        "imgRoation": "rotate(0deg)",
                        "objectPosition": "center",
                        "type": "image",
                        "top": 40,
                        "left": 30,
                        "leftPercents": 30.695900857959963,
                        "slotWidth": 310.39084842707337,
                        "slotHeight": 308.75918010752684,
                        "MainslotWidth": 310.39084842707337,
                        "Mainleft": 60,
                        "Maintop": 80,
                        "FontSize": null,
                        "fontSize": null,
                        "slotid": newslotid,
                        "opacity": 100,
                        "textTransform": "none",
                        "textDecoration": "none",
                        "fontstyle": "normal",
                        "textColor": "rgb(undefined,undefined,undefined)",
                        "fontweight": "normal",
                        "TextPostion": "top",
                        "slotRoation": "rotate(0deg)",
                        "display": "block",
                        "show": true,
                        "MainimgRoation": "rotateZ(0deg)",
                        "title": "Image",
                        "lineHeight": null,
                        "textStrikeWidth": "",
                        "textStrikeClr": "",
                        "zIndex": "0777"
                     };
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
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                          var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                          
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;

                            
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                             var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                         

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                          
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                              var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var transform = $(event.target).css('transform');
                        }
                     });
                     

                     }, 2000);
           },
           selectShape(template){
                const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
            this.redoStack = [];
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
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                          var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                           
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;

                            
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];

                             var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                          

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                          
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
                  var resizeWidth  = screen.width;
                  var resizeHeight  = screen.height;
                  if(size == 'edit'){
                     if(mainscreen.type != 'business_cards'){
                        if(mainscreen.orientation == 'landscape'){
                           screen.width = '850'
                           screen.height = '601.13'
                        }else if(screen.width > 750){
                           screen.width = '800'
                           screen.height = '1131.61'
                        }
                     }
                  }else{
                     screen.width = mthis.PrintSizes[size].width;
                     screen.height = mthis.PrintSizes[size].height;
                  }
                  
                  var widthRatio = screen.width / resizeWidth;
                  var heightRatio = screen.height / resizeHeight;
                  var scale = Math.min(widthRatio, heightRatio);

                  var slotCount = 1;
                  screen.id = mthis.screenCount;
                  screen.bgid = slotCount;
                  slotCount++;
                  screen.panaramic = null;
                  $.each(screen.slots, function(slotI, slot){

                     var newFontSize = Math.floor(slot.fontSize * scale);
                     slot.FontSize = newFontSize;
                     slot.fontSize = newFontSize;
                     
                    slot.marginTop = slot.top / resizeHeight;
                    slot.marginLeft = slot.left / resizeWidth;

                     slot.top = slot.marginTop * screen.height;
                     slot.left = slot.marginLeft * screen.width;
                     slot.slotWidth = slot.slotWidth  * scale;
                     slot.slotHeight = slot.slotHeight  * scale;
                     slot.MainslotWidth = slot.slotWidth;
                     slot.Mainleft = slot.left;
                     slot.Maintop = slot.top;

                     slot.slotid = slotCount;

                     if(slot.lineHeight == 100){
                        slot.lineHeight = 'auto';
                     }else{
                        slot.lineHeight = slot.lineHeight * scale;
                     }
                  
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
                                 const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                           var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                          
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;
                              
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];

                           var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                           
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
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
                 
                   if(maindata.type == 'service_book'){
                     console.log(this.$store.getters.getPages)
                     for (let i = 0; i < this.$store.getters.getPages - 2; i++) {
                           let newscreen =JSON.parse(maindata.psd_2_data);
                           if(typeof newscreen.inbg != 'undefined' && newscreen.inbg != ''){
                              newscreen.TemplatebackgroundImage  = newscreen.inbg;
                           }
                           // newscreen.TemplatebackgroundImage  = '';
                           // newscreen.backgroundColor  = '#ffffff';
                           newscreen.slots = [];
                           newscreen.slots.push(mthis.textslotdata());
                           datascreen.push(newscreen);
                     }
                   }
                   if(maindata.psd_2_data != '' && maindata.psd_2_data != null && maindata.type != 'business_cards'){
                    datascreen.push(JSON.parse(maindata.psd_2_data));
                   }
                   $.each(datascreen, function(screenDKey, screen){
                     screen.title = mainscreen.title;
                     screen.mainWidth = screen.width;
                     screen.mainHeight = screen.height;
                     mthis.checkWidth = screen.mainWidth;
                     // if(mainscreen.type == 'service_book'){
                     //    screen.width = '559'
                     //    screen.height = '794'
                     // }else 
                     if(mainscreen.type != 'business_cards'){
                        if(mainscreen.orientation == 'landscape'){
                           screen.width = '850'
                           screen.height = '601.13'
                        }else if(screen.width > 750){
                           if(mainscreen.type == 'service_book'){
                              screen.width = '540.82'
                           screen.height = '765'
                           }else{
                           screen.width = '800'
                           screen.height = '1131.61'
                           }
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
                           if((slot.title == 'logo' || slot.title == 'logo2') && mthis.fillData.logo != ''){
                            slot.SlotImageUrl = mthis.fillData.logo;
                           }
                        }else if(slot.type == 'text'){
                           zIndex = 99999999999999;
                           if(slot.TextRole == 'business' && mthis.fillData.business != ''){
                            slot.SlotType = mthis.fillData.business;
                           }
                           if(slot.TextRole == 'person' && mthis.fillData.person != ''){
                            slot.SlotType = mthis.fillData.person;
                           }
                           if(slot.TextRole == 'designation' && mthis.fillData.designation != ''){
                            slot.SlotType = mthis.fillData.designation;
                           }
                           if(slot.TextRole == 'phone' && mthis.fillData.phone != ''){
                            slot.SlotType = mthis.fillData.phone;
                           }
                           if(slot.TextRole == 'email' && mthis.fillData.email != ''){
                            slot.SlotType = mthis.fillData.email;
                           }
                           if(slot.TextRole == 'address' && mthis.fillData.address != ''){
                            slot.SlotType = mthis.fillData.address;
                           }
                           if(slot.TextRole == 'website' && mthis.fillData.website != ''){
                            slot.SlotType = mthis.fillData.website;
                           }
                             if(slot.TextRole == 'tagline' && (mthis.fillData.tagline != undefined && mthis.fillData.tagline != '')){
                            slot.SlotType = mthis.fillData.tagline;
                           }
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
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                          var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');

                           var top = $(event.target).css('top').replace('px','');
                           var left = $(event.target).css('left').replace('px','');
                          
                           mthis.screens[screenkey].slots[slotkey].top = top;
                           mthis.screens[screenkey].slots[slotkey].left = left;

                            
                        }
                     }).resizable({
                        handles: "ne, se, sw, nw",
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
                             var  screenkey = $(event.target).data('screenkey');
                           var slotkey = $(event.target).data('slotkey');
                           var width = $(event.target).css('width').replace('px','');
                           var height = $(event.target).css('height').replace('px','');

                           

                           mthis.screens[screenkey].slots[slotkey].slotWidth = width;
                           mthis.screens[screenkey].slots[slotkey].slotHeight = height;
                          
                        }
                     }).rotatable({
                        wheelRotate:false,
                        start: function( event, ui ) {
                        },
                        stop: function( event, ui ) {
                              const screensCopy = JSON.parse(JSON.stringify(mthis.screens));
              mthis.undoStack.push(screensCopy);
                             mthis.redoStack = [];
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
              this.screens[screenKey].slots[slotKey].show = show;
              this.$forceUpdate();
           },
           removeSlot(screenKey,slotKey){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
                     const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                   this.redoStack = [];
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
                 this.fullScreenLoader = true;
                 var mthis = this;
                     const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                 this.redoStack = [];
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
                     const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                   this.redoStack = [];
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];

               this.screens[key].TemplatebackgroundImage  = '';
           },
           setBgGradient(key){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
   
                        
           },
           resizeFontSize(key,slotkey,slotid){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
           imageSizing(key,slotkey,slotType){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
           async saveUserData(){
            var mthis = this;
            $('#saveButton span').html('saving..');
            var form = {};
                form.existing_id = this.$store.getters.getUserCreationId;
               form.userScreens = this.screens;
               form.userIP = this.userIP;
               form.userCountry = this.userCountry;
               axios({
                  method: "POST",
                  url: "/save-user-creations",
                  data: JSON.stringify(form),
                  headers: { "content-type": "application/json" }
                  }).then(  response => {
                  var response = response.data;
                  if (response.status) {
                     mthis.$store.commit("set_user_creation_id", response.added_id);
                     mthis.user_creation_id = response.added_id;
                     $('#saveButton span').html('Save');
                  }else{
                     $('#saveButton span').html('Error');
                  }
               });
           },
           async ScreenDownload(key,type,size){
               this.fullScreenLoader = true;
               this.downloadDropdown = false;
               var mthis = this;
               var blobType = 'image/'+type;
               if(size != 'simple'){
                  await this.resizeScreens(size);
               }
               $('.watermark').show();
               var form = {};
               form.userScreens = this.screens;
               form.userIP = this.userIP;
               form.userCountry = this.userCountry;
               axios({
                  method: "POST",
                  url: "/save-user-creations",
                  data: JSON.stringify(form),
                  headers: { "content-type": "application/json" }
                  }).then(  response => {
                  var response = response.data;
                  if (response.status) {
                     
                  }else{
                     
                  }
               });
               setTimeout(function(){  
                  html2canvas($('.screen-'+key)[0], {allowTaint : true,useCORS: true}).then(function(canvas) {
                     canvas.toBlob(function(blob) {
                        saveAs(blob, "poster."+type); 
                         if(size != 'simple'){
                           $('.watermark').hide();
                           mthis.resizeScreens('edit');
                         }else{
                           $('.watermark').hide();
                           mthis.$forceUpdate();
                           mthis.fullScreenLoader = false;
                         }
                       
                           

                     },blobType);

                  });
               }, 0);
               
           },
           serviceBookConintue(){
               var mthis = this;
               var pagesImages = []
               var promises = []; // Array to store promises
               var setscreens = {
                  "userScreens" : this.screens,
                  "templatedata" : this.mainDataList,
                  
               }
               mthis.$store.commit("set_userPages", setscreens);
               window.location = '/studio/final-service-book';
            //    $.each(this.screens, function(key, slot){
            //             var promise = new Promise(function(resolve, reject) {
            //       html2canvas($('.screen-'+key)[0], { allowTaint: true, useCORS: true }).then(function(canvas) {
            //             console.log(canvas.toDataURL("image/png"))
            //             pagesImages.push(canvas.toDataURL("image/png"));
            //             resolve(); // Resolve the promise when canvas data is ready
            //       });
            //    });
            //    promises.push(promise); // Push each promise into the array
            // });

            // Promise.all(promises)
            //    .then(function() {
            //       console.log(pagesImages);
            //       mthis.fullScreenLoader = false;
            //       mthis.$store.commit("set_userPages", pagesImages);
            //    })
            //    .catch(function(error) {
            //       console.error("Error capturing canvas data:", error);
            //    });
                     
               
           },
           textTools(key,slotKey,task){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
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
            const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
            this.screens[key].slots[slotKey].textColor = 'rgb('+r+','+g+','+b+')';
           },
           changesvgcolor(key,slotKey,r,g,b){
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
           
            var slotid  = this.screens[key].slots[slotKey].slotid;
            if(r == 'save'){
           
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
                  const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
                this.redoStack = [];
            var slotid  = this.screens[key].slots[slotKey].slotid;
            if(r == 'save'){
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
                const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
            this.redoStack = [];
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
           undo() {
              if (this.undoStack.length > 0) {
               this.redoStack.push(this.screens.slice());
               this.screens = this.undoStack.pop();
               this.$forceUpdate();
               }
            },
            redo() {
               if (this.redoStack.length > 0) {
                   const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
               this.screens = this.redoStack.pop();
               this.$forceUpdate();
               }
            },
            changeState() {
               return new Promise((resolve) => {
                   const screensCopy = JSON.parse(JSON.stringify(this.screens));
              this.undoStack.push(screensCopy);
               console.log('State changed');
               this.redoStack = [];
               setTimeout(() => {
                  resolve(); 
               }, 1000); 
               });
            },
            handleKeyDown(event) {
               // Check if Ctrl (or Command key on Mac) is pressed
               const isCtrlPressed = event.ctrlKey || event.metaKey;

               // Check for undo (Ctrl + Z) key press
               if (isCtrlPressed && event.key === 'z') {
                  event.preventDefault(); // Prevent the default behavior (e.g., browser undo)
                  this.undo(); // Call your undo function here
               }

               // Check for redo (Ctrl + Y) key press
               if (isCtrlPressed && event.key === 'y') {
                  event.preventDefault(); // Prevent the default behavior (e.g., browser redo)
                  this.redo(); // Call your redo function here
               }
            },
   
       
       }
   }
</script>