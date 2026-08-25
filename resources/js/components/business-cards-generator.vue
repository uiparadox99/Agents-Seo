<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
         
            <section class="title-sec container d-2">
                <h2>Chose The Best {{ page_title }} Template</h2>
                <p>
                    Lay your hands on the extensive range of concert poster
                    templates offered by us and pick a design that matches your
                    needs. Customize the template with advanced editing
                    features. Save the modified template on your device with a
                    few clicks instantly
                </p>
                <br />
                <!-- <div class="">
                    <div class="toggle">
                        <input
                            type="radio"
                            name="sizeBy"
                            v-model="form.orientation"
                            value="landscape"
                             @change="orientationChange"
                            id="sizeDimensions"
                        />
                        <label for="sizeDimensions">Landscape Templates</label>
                        <input
                            type="radio"
                            name="sizeBy"
                            v-model="form.orientation"
                            value="portrait"
                            id="sizeWeight"
                            @change="orientationChange"
                            checked="checked"
                        />
                        <label for="sizeWeight">Portrait Templates</label>
                    
                    </div>
                </div> -->
                <div class="bg-dark text-white pl-3 pr-3 pt-4 pb-4 text-left rounded-3 cards-filters" style="border-radius: 15px;">
                        <div class="row">
                            <!-- <div class="col-md-3 mb-3">
                                <input type="file"  @change="handleImageUpload" id="logo" accept="image/*" class="form-control" placeholder="Logo">
                            </div> -->
                            <div class="col-md-3 mb-3">
                                <span class="input-star"  v-if="fillData.business == ''">*</span>
                                <input type="text" class="form-control" v-model="fillData.business" placeholder="Business Name" :style="fillData.business != ''?'color:green':''">
                            </div>
                             <div class="col-md-3 mb-3">
                                <span class="input-star"  v-if="fillData.phone == ''">*</span>
                                <input type="text"  @input="handleNumericInput" maxlength="13" class="form-control" v-model="fillData.phone" placeholder="Phone Number"  :style="fillData.phone != ''?'color:green':''">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" maxlength="30" class="form-control" v-model="fillData.person" placeholder="Person Name"  :style="fillData.person != ''?'color:green':''">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" maxlength="30" class="form-control" v-model="fillData.designation" placeholder="Designation"  :style="fillData.designation != ''?'color:green':''">
                            </div>
                            <div class="col-md-5 mb-3">
                                <input type="text" maxlength="100" class="form-control" v-model="fillData.address" placeholder="Address"  :style="fillData.address != ''?'color:green':''">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="email" class="form-control" v-model="fillData.email" placeholder="Email Address"  :style="fillData.email != ''?'color:green':''">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" max="30" class="form-control"  v-model="fillData.website" placeholder=" Website"  :style="fillData.website != ''?'color:green':''">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" maxlength="60" class="form-control" v-model="fillData.tagline" placeholder="Company Slogan"  :style="fillData.tagline != ''?'color:green':''">
                            </div>
                            
                            <div class="col-md-2 mb-3 offset-md-4">
                                <select class="form-control" v-model="searchCategory">
                                    <option value="all">Select Style</option>
                                    <option   v-for="(cat, index) in categories"
                            v-bind:key="index" :value="cat.slug">{{ cat.slug }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                    <button type="button" @click="filterData" class="btn btn-primary btn-block">Generate Now</button>
                            </div>
                        </div>
                
            </div>
            </section>
            <section class="container-fluid pt-3 pb-3">
                <div class="d-flex w-100 " style="  gap: 15px; flex-wrap: wrap;align-items: center;justify-content: center;">
                    <div  v-for="(screen, key) in screens"  class="single-screen-wraper" :id="key" @click="open(screen.id,screen.type)">
                     <div  :class="'box single-screen screen-'+key" :ref="handleId" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:relative;cursor:pointer;border: 1px solid #ddd;'"  >
                        <div class="screen-loader" :id="'screen-loader-'+key" style="display:none"><img src="/studio/assets/img/loader.gif"></div>
                        <!-- <div class="edit-btn" :class="'edit-screen-'+key"  v-on:click="toolbartoggle(key)"><i class="fa fa fa-pencil-alt"></i></div> -->
                      
                        <div v-if="(screen.backgroundColor != '') || screen.TemplatebackgroundImage != ''" :data-screenkey="key" data-slotkey="0" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid">
                           <img  :src="screen.TemplatebackgroundImage" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.bgSize+';  transform: rotate('+screen.bgRotation+'deg);object-position:'+screen.bgPosition" class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                        </div>
                        <div    v-else-if="screen.panaramic != null && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'min-width:'+screen.width+'px;min-height:'+screen.height+'px;position:absolute;left:0;top:0;background:'+screen.panaramic.backgroundColor+';'" :id="'screen-'+key+'-slot-'+screen.bgid">
                           <img  :src="screen.panaramic.imageData" :style="'width:'+screen.width+'px;height:'+screen.height+'px;object-fit:'+screen.panaramic.bgSize+';  transform: rotate('+screen.panaramic.bgRotation+'deg);object-position:'+screen.panaramic.bgPosition" class="bg-img">
                        </div>
                        <div v-for="(slot,slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'text')"  v-if="slot.type == 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;z-index:'+slot.zIndex+';width:auto;top:'+slot.top+'px;left:'+slot.left+'px;color:'+slot.textColor+';font-size:'+slot.fontSize+'px;font-family:'+slot.FontName+';text-align:'+slot.TextCenter+';'" :data-width="slot.slotWidth" class=" makeitDraggable text-slot"  data-type="text" :data-order="slot.orderNumber" :id="'parentText-screen-'+key+'-slot-'+slot.slotid">
                           <div :style="'line-height: '+slot.lineHeight+'px;-webkit-text-stroke-width:'+slot.textStrikeWidth+'px;-webkit-text-stroke-color:'+slot.textStrikeClr+';text-decoration:'+slot.textDecoration+';text-transform:'+slot.textTransform+';font-style:'+slot.fontstyle+';font-weight:'+slot.fontweight+';text-align:'+slot.TextCenter+';letter-spacing:'+slot.latterSpacing+'pt; display: inline-block;font-size:'+slot.fontSize+'px;white-space:'+slot.lineBreak+';text-shadow:'+slot.shadow" :id="'screen-'+key+'-slot-'+slot.slotid" title="Add Your Text">
                              <p v-html="slot.SlotType" :style="'line-height: '+slot.lineHeight+'px;'"></p>
                           </div>
                        </div>
                     
                        <div   v-for="(slot, slotKey) in screen.slots" :key="slotKey"  v-on:contextmenu="openMenu(key,slot.slotid,'image')"  v-if="slot.type != 'text' && slot.show" :data-screenkey="key" :data-slotkey="slotKey" :style="'opacity: '+slot.opacity+'%;transform: '+slot.slotRoation+';position:absolute;box-shadow:'+slot.shadow+';z-index:'+slot.zIndex+';width:'+slot.slotWidth+'px;height:'+slot.slotHeight+'px;top:'+slot.top+'px;left:'+slot.left+'px;perspective: 500px;display:'+slot.display" class=" makeitDraggable image-slot" :id="'screen-'+key+'-slot-'+slot.slotid" data-type="image" title="Add Your Image">
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
                           <img :src="slot.SlotImageUrl"  :style="'width:100%;height:100%;border:0;object-fit:'+slot.objectFit+';object-position:'+slot.objectPosition+';transform: '+slot.imgRoation+';'" v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl != ''" :alt="slot.SlotType">
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
                </div>
            </section>
            <infinite-loading
                spinner="spiral"
                @infinite="getTemplates"
            ></infinite-loading>
            <!-- <section class="container">
                <div class="other-categories">
                    <div class="heading">
                        <h2>Select Poster Design By Categories</h2>
                        <p>
                            Explore the copious amount of premium poster designs
                            available under various categories for all events
                            and select a design that fits your requirements.
                        </p>
                    </div>
                    <ul>
                        <li
                            v-for="(cat, index) in categories"
                            v-bind:key="index"
                        >
                            <a
                                v-if="
                                    templates[0] != undefined &&
                                    templates[0] != '' &&
                                    templates[0].categories_id == cat.id
                                "
                                class="active"
                                :title="cat.name"
                                :href="'/studio/poster-templates' + cat.slug"
                                >{{ cat.name }}</a
                            >
                            <a
                                v-else
                                :href="'/studio/poster-templates/' + cat.slug"
                                :title="cat.name"
                                >{{ cat.name }}</a
                            >
                        </li>
                    </ul>
                </div>
            </section> -->
        </main>
        <VFooter class="inner-footer"></VFooter>
    </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
export default {
    components: { InfiniteLoading },
    data() {
        return {
            templates: [],
            categories: [],
            tCount: 1,
            fCount: 0,
            searchCategory: this.$route.params.slug,
            page_title: "Poster",
            AdFiltersClass:'d-none',
            form: {
                orientation: "landscape",
                paid: 0,
            },
            fillData:{
                business:this.$route.query.business_name != undefined?this.$route.query.business_name:'',
                logo:'',
                person:'',
                designation:'',
                phone:'',
                tagline:'',
                email:'',
                address:'',
                website:'',
            },
            type:this.$route.params.type,
            error_message: "",
            has_error: false,
            loading: true,
            screens:[],
            page: 1,
        };
    },
    mounted() {
        this.page_title = "Business Cards";
        this.getCategories();
    },
    methods: {
         handleNumericInput() {
      // Remove non-numeric characters from the input
      this.fillData.phone = this.fillData.phone.replace(/[^0-9]/g, '');
    },
        getTempCount(count) {
            return count + 1;
        },
        open(id,type) {
            this.$store.commit("set_playChange", true);
            this.$store.commit("set_openInPlayground", id);
            this.$store.commit("set_filldata", this.fillData);
            if(type == 'posters'){
                type = 'poster-maker'
            }
            this.$router.push({ path: "/playground/"+type });
        },
        mouseover(id) {
            $("#hovercontent" + id).show();
        },
        mouseout(id) {
            $("#hovercontent" + id).hide();
        },
        beforeRouteLeave: function () {
            this.$router.go();
        },
        handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = () => {
            this.fillData.logo = reader.result;
            };

            reader.readAsDataURL(file);
        }
        },
        orientationChange() {
            this.page = 1;
            var category = this.$route.params.slug;
            var type = this.$route.params.type;
            var mthis = this;
            var dataUrl =
                "/get-templates-list/" +
                type +
                "/" +
                category +
                "?from=starprinter&page=" +
                this.page +
                "&orientation=" +
                this.form.orientation;
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.loading = false;
                    var templatesdata = result.data.data;
                    if (templatesdata.length) {
                        this.page += 1;
                        this.templates = templatesdata;
                       
                    } else {
                        this.page = 1;
                        this.templates = [];
                        
                    }
                    mthis.loadScreens('no');
                    mthis.$forceUpdate();
                },
                (error) => {}
            );
        },
        getCategories() {
            var dataUrl = "/get-templates-catgories/business_cards?from=starprinter&getAll=all";
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.categories = result.data;
                },
                (error) => {}
            );
        },
        showfilters(){
            if(this.AdFiltersClass == 'd-none'){
                this.AdFiltersClass = 'd-block';
            }else{
                this.AdFiltersClass = 'd-none';
            }
        },
        getTemplates($state) {
            var category = this.searchCategory;
            var type = 'business_cards';
            var mthis = this;
            var dataUrl =
                "/get-templates-list/" +
                type +
                "/" +
                category +
                "?from=starprinter&page=" +
                this.page +
                "&orientation=" +
                this.form.orientation;
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.loading = false;
                    var templatesdata = result.data.data;
                    if (templatesdata.length) {
                        if(this.page > 1){
                            this.page += 1;
                            this.templates.push(...templatesdata);
                        }else{
                            this.page += 1;
                            this.templates = templatesdata;
                        }
                        this.loadScreens('no');
                        if($state != 'no'){
                             $state.loaded();
                         }   
                    } else {
                        if($state == 'no'){
                        this.templates = [];
                        this.loadScreens('no');
                        }
                        if($state != 'no'){
                        $state.complete();
                    }   
                    mthis.$forceUpdate();
                    }
                },
                (error) => {}
            );
        },
        filterData(){
            this.page = 0;
            this.getTemplates('no');
        },
        containsWord(string, word) {
            // Create a regular expression pattern with word boundaries
            const pattern = new RegExp(`\\b${word}\\b`, 'i'); // 'i' for case-insensitive matching

            // Use the test method to check if the pattern exists in the string
            return pattern.test(string);
        },
        loadScreens(deviceChange){
               var maindata = this.templates;
               var screens = [];
               var mthis = this;
               var html = "";
               this.currentScreen = 0;
            
   
   
                  var mainscreen = maindata;
              
                //    if(maindata.psd_2_data != '' && maindata.psd_2_data != null){
                //     datascreen.push(JSON.parse(maindata.psd_2_data));
                //    }
                   $.each(maindata, function(screenDKey, screen){
                    var cardData = screen;
                    screen = JSON.parse(screen.psd_data);
                     screen.title = mainscreen.title;
                     screen.mainWidth = screen.width;
                     screen.mainHeight = screen.height;
                     mthis.checkWidth = screen.mainWidth;
                     screen.width = '321.259'
                    screen.height = '207.874'
                       
                     var widthRatio = screen.width / screen.mainWidth;
                     var heightRatio = screen.height / screen.mainHeight;

                     var scale = Math.min(widthRatio, heightRatio);

                     var slotCount = 1;
                     screen.id = cardData.id;
                     screen.type = cardData.type;
                     screen.bgid = slotCount;
                     slotCount++;
                     screen.panaramic = null;
                     $.each(screen.slots, function(slotI, slot){
   
                        slot.top = slot.marginTop * screen.height;
                        slot.left = (slot.marginLeft * screen.width);
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
                           if(number != undefined){
                           number = number.split('_')[0];
                        }else{
                            number = '';
                        }
                           slot.SlotType = slot.SlotType.split('-')[0]+number;
                           zIndex = 0;
                           for (let index = 0; index <= number; index++) {
                              zIndex = zIndex+'7';
                           }
                           if(mthis.containsWord(slot.title,'logo') && mthis.fillData.logo != ''){
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
                           if(slot.TextRole == 'tagline' && mthis.fillData.tagline != ''){
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
                  
               });  
           }
    },
};
</script>
