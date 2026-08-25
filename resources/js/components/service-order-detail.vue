<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider" style="height:auto;min-height:400px;background:#fff;padding-top:40px">
                <div class="text-center">
                    <div class=" w-100">
                                    <div v-for="(screen, key) in screens" class="single-screen-wraper d-block text-center" :id="key"
                                        @click="open(screen.id, screen.type)">
                                        <button type="button" class="btn btn-primary mb-4 mt-5" @click="ScreenDownload(key,'png','simple')">Download this Page</button>

                                        <div :class="'box  screen-' + key" :ref="handleId"
                                            :style="'width:' + screen.width + 'px;height:' + screen.height + 'px;position:relative;cursor:pointer;border: 1px solid #ddd;margin:0 auto;    border: 0;'">
                                            
                                            <!-- <div class="edit-btn" :class="'edit-screen-'+key"  v-on:click="toolbartoggle(key)"><i class="fa fa fa-pencil-alt"></i></div> -->

                                            <div v-if="(screen.backgroundColor != '') || screen.TemplatebackgroundImage != ''"
                                                :data-screenkey="key" data-slotkey="0"
                                                :style="'min-width:' + screen.width + 'px;min-height:' + screen.height + 'px;position:absolute;left:0;top:0;background:' + screen.backgroundColor + ';'"
                                                :id="'screen-' + key + '-slot-' + screen.bgid">
                                                <img :src="screen.TemplatebackgroundImage"
                                                    :style="'width:' + screen.width + 'px;height:' + screen.height + 'px;object-fit:' + screen.bgSize + ';  transform: rotate(' + screen.bgRotation + 'deg);object-position:' + screen.bgPosition"
                                                    class="bg-img" v-if="screen.TemplatebackgroundImage != ''">
                                            </div>
                                            <div v-else-if="screen.panaramic != null && slot.show" :data-screenkey="key"
                                                :data-slotkey="slotKey"
                                                :style="'min-width:' + screen.width + 'px;min-height:' + screen.height + 'px;position:absolute;left:0;top:0;background:' + screen.panaramic.backgroundColor + ';'"
                                                :id="'screen-' + key + '-slot-' + screen.bgid">
                                                <img :src="screen.panaramic.imageData"
                                                    :style="'width:' + screen.width + 'px;height:' + screen.height + 'px;object-fit:' + screen.panaramic.bgSize + ';  transform: rotate(' + screen.panaramic.bgRotation + 'deg);object-position:' + screen.panaramic.bgPosition"
                                                    class="bg-img">
                                            </div>
                                            <div v-for="(slot, slotKey) in screen.slots" :key="slotKey"
                                                v-on:contextmenu="openMenu(key, slot.slotid, 'text')"
                                                v-if="slot.type == 'text' && slot.show" :data-screenkey="key"
                                                :data-slotkey="slotKey"
                                                :style="'opacity: ' + slot.opacity + '%;transform: ' + slot.slotRoation + ';position:absolute;z-index:' + slot.zIndex + ';width:auto;top:' + slot.top + 'px;left:' + slot.left + 'px;color:' + slot.textColor + ';font-size:' + slot.fontSize + 'px;font-family:' + slot.FontName + ';text-align:' + slot.TextCenter + ';'"
                                                :data-width="slot.slotWidth" class=" makeitDraggable text-slot"
                                                data-type="text" :data-order="slot.orderNumber"
                                                :id="'parentText-screen-' + key + '-slot-' + slot.slotid">
                                                <div :style="'line-height: ' + slot.lineHeight + 'px;-webkit-text-stroke-width:' + slot.textStrikeWidth + 'px;-webkit-text-stroke-color:' + slot.textStrikeClr + ';text-decoration:' + slot.textDecoration + ';text-transform:' + slot.textTransform + ';font-style:' + slot.fontstyle + ';font-weight:' + slot.fontweight + ';text-align:' + slot.TextCenter + ';letter-spacing:' + slot.latterSpacing + 'pt; display: inline-block;font-size:' + slot.fontSize + 'px;white-space:' + slot.lineBreak + ';text-shadow:' + slot.shadow"
                                                    :id="'screen-' + key + '-slot-' + slot.slotid">
                                                    <p v-html="slot.SlotType"
                                                        :style="'line-height: ' + slot.lineHeight + 'px;'"></p>
                                                </div>
                                            </div>

                                            <div v-for="(slot, slotKey) in screen.slots" :key="slotKey"
                                                v-on:contextmenu="openMenu(key, slot.slotid, 'image')"
                                                v-if="slot.type != 'text' && slot.show" :data-screenkey="key"
                                                :data-slotkey="slotKey"
                                                :style="'opacity: ' + slot.opacity + '%;transform: ' + slot.slotRoation + ';position:absolute;box-shadow:' + slot.shadow + ';z-index:' + slot.zIndex + ';width:' + slot.slotWidth + 'px;height:' + slot.slotHeight + 'px;top:' + slot.top + 'px;left:' + slot.left + 'px;perspective: 500px;display:' + slot.display"
                                                class=" makeitDraggable image-slot" :id="'screen-' + key + '-slot-' + slot.slotid"
                                                data-type="image">
                                                <img :src="slot[currentyDevice]"
                                                    :style="'width:' + slot.slotWidth + 'px;height:' + slot.slotHeight + 'px;border:0;object-fit:' + slot.objectFit + ';object-position:' + slot.objectPosition + ';transform: ' + slot.imgRoation + ';'"
                                                    v-if="!slot.SlotType.includes('frame') && typeof slot[currentyDevice] != 'undefined' && slot[currentyDevice] != ''">
                                                <img :src="slot['global']"
                                                    :style="'width:' + slot.slotWidth + 'px;height:' + slot.slotHeight + 'px;border:0;object-fit:' + slot.objectFit + ';object-position:' + slot.objectPosition + ';transform: ' + slot.imgRoation + ';'"
                                                    v-else-if="!slot.SlotType.includes('frame') && typeof slot['global'] != 'undefined' && slot['global'] != ''">
                                                <inline-svg
                                                    v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl.includes('.svg')"
                                                    :src="slot.SlotImageUrl" :id="'svgslot' + slotKey"
                                                    :class="'svgslot' + slotKey" width="100%" fill="none" height="100%"
                                                    aria-label="My image"></inline-svg>
                                                <img :src="slot.SlotImageUrl"
                                                    :style="'width:100%;height:100%;border:0;object-fit:' + slot.objectFit + ';object-position:' + slot.objectPosition + ';transform: ' + slot.imgRoation + ';'"
                                                    v-else-if="!slot.SlotType.includes('frame') && slot.SlotImageUrl != ''">
                                                <img :src="devices[currentyDevice].colors[slot.deviceStye].url"
                                                    :style="'width:' + slot.slotWidth + 'px;height:' + slot.slotHeight + 'px;border:0;object-fit:' + slot.objectFit + ';object-position:' + slot.objectPosition + ';transform: ' + slot.imgRoation + ';'"
                                                    v-else-if="slot.SlotType.includes('frame')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                </div>
            </section>
        </main>
        <div class="full-screen-loader" v-if="fullScreenLoader">
         <div class="loader-layover"></div>
         <div class="loader-body">
             <img src="/studio/assets/img/loader.gif">
         </div>
      </div>
        <VFooter class="inner-footer"></VFooter>
    </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import html2canvas from 'html2canvas';
export default {
    components: { InfiniteLoading },
    data() {
        return {
            template_detail: {},
            screens: {},
            fullScreenLoader:false,
            fetchData: '',
            categories: [],
            tCount: 1,
            fCount: 0,
            form: {
                orientation: "all",
                paid: 0,
            },
            error_message: "",
            has_error: false,
            pages: 4,
            currentSlide: 0,
            loading: true,
            page: 1,
        };
    },
    beforeMount() {
        this.getTemplate()
    },
    methods: {
        slideTo(val) {
            this.currentSlide = val
        },
        trimTitle(word) {
            return word.replace('A0', '')
        },
        getTempCount(count) {
            return count + 1;
        },
        open(id) {
            this.$store.commit("set_playChange", true);
            if (this.template_detail.type == 'service_book') {
                this.$store.commit("set_pages", this.pages);
            }
            this.$store.commit("set_openInPlayground", id);
            this.$router.push({ path: "/playground/" + this.template_detail.category.type });
        },
        getTemplate() {
            var slug = this.$route.params.id;
            var dataUrl =
                "/service-order-detail/" + slug
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.loading = false;
                    console.log(result)
                    this.fetchData = JSON.parse(result.data.details.screens);
                    this.loadScreens();
                },
                (error) => { }
            );
        },
        loadScreens(deviceChange) {
            var screens = [];
            var mthis = this;
            var html = "";
            this.currentScreen = 0;
            $.each(this.fetchData, function (screenDKey, screen) {
                
                screen.mainWidth = screen.width;
                screen.mainHeight = screen.height;
                mthis.checkWidth = screen.mainWidth;
                screen.width = '1240'
                screen.height = '1748'

                var widthRatio = screen.width / screen.mainWidth;
                var heightRatio = screen.height / screen.mainHeight;

                var scale = Math.min(widthRatio, heightRatio);
                var slotCount = 1;
                screen.bgid = slotCount;
                slotCount++;
                screen.panaramic = null;
                $.each(screen.slots, function (slotI, slot) {

                    slot.marginTop = slot.top / screen.mainHeight;
                    slot.marginLeft = slot.left / screen.mainWidth;
                    slot.top = slot.marginTop * screen.height;
                    slot.left = (slot.marginLeft * screen.width);
                    slot.leftPercents = slot.left / screen.width * 100;
                    slot.slotWidth = slot.slotWidth  * scale;
                     slot.slotHeight = slot.slotHeight  * scale;
                    slot.MainslotWidth = slot.slotWidth;
                    slot.Mainleft = slot.left;
                    slot.Maintop = slot.top;
                    slot.MainFontSize = slot.FontSize;// Set your original font size here
                    var newFontSize = Math.floor(slot.MainFontSize * scale);
                    slot.FontSize = newFontSize;
                    slot.fontSize = newFontSize;
                    slot.slotid = slotCount;

                      if (slot.lineHeight == 100) {
                        slot.lineHeight = 'auto';
                    } else {
                        slot.lineHeight = slot.lineHeight * scale;
                    }
                  

                    slotCount++;

                })
                screens.push(screen);
                mthis.screenCount++;
            })

            this.screens = screens;
            this.$forceUpdate();
        },
        async ScreenDownload(key,type,size){
               var mthis = this;
               var blobType = 'image/'+type;
               this.fullScreenLoader = true;
               setTimeout(function(){  
                  html2canvas($('.screen-'+key)[0], {allowTaint : true,useCORS: true}).then(function(canvas) {
                     canvas.toBlob(function(blob) {
                        saveAs(blob, "service-order-"+key+"."+type); 
                        mthis.fullScreenLoader = false;
                     },blobType);

                  });
               }, 0);
               
           },
    },
};
</script>
