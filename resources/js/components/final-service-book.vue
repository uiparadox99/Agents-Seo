<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider" style="height:auto;min-height:85vh;background:#fff;padding-top:40px">
                <div class="container">
                    <div class="content mb-5" style="background:#fff"  v-if="!loading">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="mb-1">{{ trimTitle(template_detail.title) }}</h2>
                                <p class="mb-3">Preview Your Designed Service of Order</p>
                                <div class="d-flex w-100"
                                    style="  gap: 15px; flex-wrap: wrap;align-items: center;justify-content: left;">
                                    <div v-for="(screen, key) in screens" class="single-screen-wraper" :id="key"
                                        @click="open(screen.id, screen.type)">
                                        <div :class="'box  screen-' + key" :ref="handleId"
                                            :style="'min-width:' + screen.width + 'px;min-height:' + screen.height + 'px;position:relative;cursor:pointer;border: 1px solid #ddd;'">
                                            <div class="screen-loader" :id="'screen-loader-' + key" style="display:none"><img
                                                    src="/studio/assets/img/loader.gif"></div>
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
                            <div class="col-md-4 ">
                                <div class="bg-dark p-3 rounded-lg text-white" v-if="ref != ''">
                                    <h3 class="text-center mb-2">Ref # {{ ref }}</h3>
                                    <p class="text-center"> Order has been placed this is your ref number our team will contact you as soon as possible</p>
                                    <br>
                                    <h5>Your Details</h5>
                                    <table class="table table-bordered table-striped text-white">
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ form.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ form.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ form.phone }}</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <a href="/" class="btn btn-block btn-primary">Go Back to Home</a>
                                </div>
                                <form class="bg-dark p-3 rounded-lg text-white" @submit.prevent="placeOrder()" v-else>
                                    <h3 class="text-center mb-2">Your Details</h3>
                                    <div class="form-group">
                                        <label>Your Name</label>
                                        <input type="text" v-model="form.name" required class="form-control" placeholder="Enter Your Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" v-model="form.email" required class="form-control" placeholder="Enter Your Email">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" v-model="form.phone" required class="form-control" placeholder="Enter Your Phone" maxlength="13">
                                    </div>
                                    
                                    <button class="btn btn-primary btn-block" type="submit">Place Your Order</button>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div v-else class="text-center content">
                        <i class="fa fa-spinner  fa-spin" style="font-size:150px;"></i>
                    </div>
                </div>
            </section>
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
            template_detail: {},
            screens: {},
            categories: [],
            tCount: 1,
            fCount: 0,
            ref:'',
            form: {
                name: "",
                email: '',
                phone: '',
                userScreens:this.$store.getters.getUserPages.userScreens
            },
            error_message: "",
            has_error: false,
            pages: 4,
            currentSlide: 0,
            loading: false,
            page: 1,
        };
    },
    beforeMount() {
        this.template_detail = this.$store.getters.getUserPages.templatedata
        // this.screens = this.$store.getters.getUserPages.userScreens
        this.loadScreens('no');
    },
    methods: {
        placeOrder() {
        // get the redirect object
        var $this = this;
         this.error_message = "";
         this.has_error = false;
         this.loading = true;
             axios({
              method: "POST",
              url: "/place-service-order",
              data: JSON.stringify(this.form),
              headers: { "content-type": "application/json" }
             }).then(  response => {
              var response = response.data;
              if (response.status) {
                $this.ref = response.ref;
               
              }else{
                this.has_error = true;
                  this.error_message = response.message;
                  setTimeout(function() {
                    $this.error_message = "";
                        $this.has_error = false;
                  }, 2500);
              }
              $this.loading = false;
            });
      },
        slideTo(val) {
            this.currentSlide = val
        },
        trimTitle(word) {
            return word.replace('A0', '')
        },
        loadScreens(deviceChange) {
            var screens = [];
            var mthis = this;
            var html = "";
            this.currentScreen = 0;
            $.each(this.$store.getters.getUserPages.userScreens, function (screenDKey, screen) {
                screen.mainWidth = screen.width;
                screen.mainHeight = screen.height;
                mthis.checkWidth = screen.mainWidth;
                screen.width = '170'
                screen.height = '241.19'

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
        }
    },
};
</script>
