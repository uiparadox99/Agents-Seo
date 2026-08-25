<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider" style="height:auto;min-height:100vh;background:#fff;padding-top:40px">
                <div class="container-fluid">
                    <div class="content mb-5" style="background:#fff" v-if="!loading">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <h2 class="mb-2 mobile mobile-only">{{ trimTitle(template_detail.name) }}</h2>
                               
                              
                                <div class=" text-center">
                                    <router-link :to="{path: '/highlight/'+template_detail.slug}" class="btn btn-primary mb-2"><i class="fas fa-marker"></i> Highlight Changes</router-link>
                                    <!-- <a :href="'/studio/highlight/'+template_detail.slug" class="btn btn-primary mb-2"><i class="fas fa-marker"></i> Highlight Changes</a> -->
                                    <vue-book-effects class="book-effects" :pages="pagesData"  v-slot="bookEffects">
                                        <div class="pt-1 control-buttons">
                                        <button @click="bookEffects.flipLeft" class="btn btn-warning">Previous Page</button>
                                        <h2 class="mb-2 dekstop-only">{{ trimTitle(template_detail.name) }}</h2>
                                        <button @click="bookEffects.flipRight" class="btn btn-primary">Next Page</button>
                                        <div class="book-pagination dekstop-only">
                                            <span class="page-number" v-if="bookEffects.page >= 1">{{ bookEffects.page  }}</span>
                                            <span class="page-number" v-if="bookEffects.page !== (pagesData.length - 2) && bookEffects.page != 1">{{ bookEffects.page + 1}}</span>
                                        </div>
                                        <div class="book-pagination mobile-only">
                                            <span class="page-number">{{ bookEffects.page}}</span>
                                        </div>
                                    </div>
                               
                                    </vue-book-effects>
                                  

                                </div>
                                <br>
                            
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
import VueBookEffects from 'vue-book-effects'
export default {
    components: { VueBookEffects },
    data() {
        return {
            template_detail: {},
            categories: [],
            tCount: 1,
            fCount: 0,
            form: {
                orientation: "all",
                paid: 0,
            },
            pagesData:[],
            error_message: "",
            has_error: false,
            pages: 4,
            currentSlide: 0,
            loading: true,
            page: 1,
            cus_pag_no: 1,
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
            var slug = this.$route.params.slug;
            var APIURL = '';
            if(window.location.hostname == '127.0.0.1'){
                APIURL = 'http://'+window.location.hostname+':8000';
            }else{
                APIURL = 'https://'+window.location.hostname;
            }
            var dataUrl = APIURL+"/get-preview-template/" + slug
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
                    this.pagesData.push(null)
                    $.each(imagesv, function(screenDKey, img){
                        mthis.pagesData.push('/previewTemplates/'+img);
                    })
                    this.pagesData.push(null)
                    console.log( this.pagesData);
                    this.$forceUpdate();
                },
                (error) => { }
            );
        },
    },
};
</script>
