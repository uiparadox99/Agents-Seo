<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider" style="height:auto;min-height:100vh;background:#fff;padding-top:40px">
                <div class="container">
                    <div class="content mb-5" style="background:#fff" v-if="!loading">
                        <div class=" text-center">
                            <h2 class="mb-2">{{ trimTitle(template_detail.name) }}</h2>
                            <h2 class="mb-3 text-primary">Highlight Changes</h2>
                        <button v-for="(pimg, key) in pagesData" :key="key" :class="pageActive == key ?'btn btn-primary mr-3 mb-3':'btn btn-secondary mr-3 mb-3'" :id="'home-tab' + key" @click="intializePainter(key,pimg)" type="button" role="tab" aria-selected="true">Page {{ key + 1
                                    }}</button>
                        </div>
                         <div id="painterCanvas" style="position: relative;min-height: 105vh;overflow: hidden;">
                                    <!-- <img :src="pimg" :id="'pageImg'+key"> -->
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
// import { ImageEditorPlugin } from "@syncfusion/ej2-vue-image-editor";
// import { ButtonPlugin } from '@syncfusion/ej2-vue-buttons';
// import { Browser } from "@syncfusion/ej2-base";
// Vue.use(ImageEditorPlugin);
// Vue.use(ButtonPlugin);
import Painterro from 'painterro'
export default {
    data() {
        return {
            toolbar: [],
            template_detail: {},
            categories: [],
            tCount: 1,
            fCount: 0,
            form: {
                orientation: "all",
                paid: 0,
            },
            pagesData: [],
            painterro: [],
            error_message: "",
            has_error: false,
            pages: 4,
            currentSlide: 0,
            loading: true,
            pageActive: 0,
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
        created: function () {
            if (Browser.isDevice) {
                this.$refs.imageEditorObj.open('flower.png');
            } else {
                this.$refs.imageEditorObj.open('bridge.png');
            }
        },
        drawClick: function (event) {
            this.$refs.imageEditorObj.ej2Instances.freeHandDraw(true);
        },
        btnClick: function (event) {
            this.$refs.imageEditorObj.ej2Instances.deleteShape('pen_1');
        },
        getTemplate() {
            var mthis = this;
            var slug = this.$route.params.slug;
            var APIURL = '';
            if (window.location.hostname == '127.0.0.1') {
                APIURL = 'http://' + window.location.hostname + ':8000';
            } else {
                APIURL = 'https://' + window.location.hostname;
            }
            var dataUrl = APIURL + "/get-preview-template/" + slug
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    var mthis = this;
                    this.loading = false;
                    this.template_detail = result.data.detail;
                    var imagesv = result.data.detail.images.split(',');
                    $.each(imagesv, function (screenDKey, img) {
                        mthis.pagesData.push('/previewTemplates/' + img);
                    })
                    this.$forceUpdate();
                    
                    this.intializePainter(0,'/previewTemplates/'+imagesv[0]);
                },
                (error) => { }
            );
        },
        intializePainter(imgKey,img){
            var mthis = this;
            this.pageActive = imgKey;
           var token = $('meta[name="csrf-token"]').attr('content');
            setTimeout(function(){
            $('#painterCanvas').html('');
            var APIURL = '';
            if(window.location.hostname == '127.0.0.1'){
                APIURL = 'http://'+window.location.hostname+':8000';
            }else{
                APIURL = 'https://'+window.location.hostname;
            }
       
        const painterro = Painterro({
                            id:"painterCanvas",
                            toolbarPosition:"top",
                            hiddenTools:['crop','resize','rotate','brush','open','close','bucket','setting'],
                            saveHandler: function (image, done) {
                            // of course, instead of raw XHR you can use fetch, jQuery, etc
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", APIURL+"/save-highlighted-template");
                            xhr.setRequestHeader("Content-Type", "application/json");
                            xhr.send(JSON.stringify({
                                _token:token,
                                image: image.asDataURL(),
                                id:mthis.template_detail.id,
                                image_key:imgKey
                            }));
                            xhr.onload = function (e) {
                                done(true);
                                $('#painterCanvas').removeAttr('hidden');
                                $('#painterCanvas').html('<h2 class="text-center">Page Saved!</h2><p class="text-center">Click on page button if you want to edit again</p>');
                                
                                mthis.$router.push({ path: "/oss/" + mthis.template_detail.slug });
                            }
                            },
                            activeColor: '#00b400'  // change active color to green
                        });
                        painterro.show(img);
         
        },1000)
        },
        getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        var dataURL = canvas.toDataURL("image/png");
        return dataURL.replace(/^data:image\/?[A-z]*;base64,/);
        }
    },
};
</script>
