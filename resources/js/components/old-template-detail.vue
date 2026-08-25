<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider" style="height:auto;min-height:400px;background:#fff;padding-top:40px">
                <div class="container">
                    <div class="content mb-5" style="background:#fff" v-if="!loading">
                        <div class="row" v-if="template_detail.type == 'service_book'">
                            <div class="col-md-9">
                                <h2 class="mb-2">{{ trimTitle(template_detail.title) }}</h2>
                                
                              

                            </div>
                            <div class="col-md-3">
                                <div class="bg-dark p-3 rounded-lg text-white">
                                    <div class="form-group">
                                        <label>No of Pages</label>
                                        <select class="form-control" v-model="pages">
                                            <option value="4">4</option>
                                            <option value="8">8</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-block" title="Edit This Template"
                                        @click="open(template_detail.id)">Start Now</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class=" text-center">
                                    <vue-book-effects class="book-effects" :pages="pagesData">
                                        
                                    </vue-book-effects>
                                    <div id="demo" class="carousel slide bg-light" data-ride="carousel">


                                        <!-- The slideshow -->
                                        <div class="carousel-inner">
                                            <div v-for="(g, $index) in template_detail.gallery" key="1"
                                                :class="'carousel-item ' + [$index == 0 ? 'active' : '']" v-if="$index == 0">
                                                <img :src="g.image" style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/4-Page-Layout-Design-1-1.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/4-Page-Layout-Design-2.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-2-3.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-4-5.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-6-7.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-2-3.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-4-5.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-6-7.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-2-3.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-4-5.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-6-7.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-8-9.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-10-11.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-2-3.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-4-5.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-6-7.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-8-9.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-10-11.png"
                                                    style="height:600px;" />
                                            </div>
                                            <div v-for="(g, $index) in template_detail.gallery" :key="$index"
                                                :class="'carousel-item ' + [$index == 0 ? 'active' : '']"
                                                v-if="$index == template_detail.gallery.length - 1">
                                                <img :src="g.image" style="height:600px;" />
                                            </div>
                                        </div>

                                        <!-- Left and right controls -->
                                        <a class="carousel-control-prev text-dark" href="#demo" data-slide="prev" style="font-size: 45px;">
                                            <span class="carousel-control-prev-icon"><i class="fa fa-angle-left"></i></span>
                                        </a>
                                        <a class="carousel-control-next text-dark" href="#demo" data-slide="next" style="font-size: 45px;">
                                            <span class="carousel-control-next-icon"><i
                                                    class="fa fa-angle-right"></i></span>
                                        </a>

                                    </div>

                                    <div class="slides-list mt-2">
                                        <div class="preview-block" v-for="(g, $index) in template_detail.gallery" :key="$index"
                                            data-target="#demo" data-slide-to="0" v-if="$index == 0">
                                          
                                                <img :src="g.image" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="1">
                                          
                                          <img src="/assets/img/layouts/4-Page-Layout-Design-1-1.png" />
                                            
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="2">
                                          
                                                <img src="/assets/img/layouts/4-Page-Layout-Design-2.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="3">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-2-3.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="4">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-4-5.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="5">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-1-Pages-6-7.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="6">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-2-3.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="7">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-4-5.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="8">
                                          
                                                <img src="/assets/img/layouts/8-Page-Layout-Design-2-Pages-6-7.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="9">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-2-3.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="10">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-4-5.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="11">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-6-7.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="12">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-8-9.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="13">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-1-Pages-10-11.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="14">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-2-3.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="15">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-4-5.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="16">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-6-7.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="17">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-8-9.png" />
                                          
                                        </div>
                                        <div class="preview-block" data-target="#demo" data-slide-to="18">
                                          
                                                <img src="/assets/img/layouts/12-Page-Layout-Design-2-Pages-10-11.png" />
                                          
                                        </div>
                                        <div class="preview-block" v-for="(g, $index) in template_detail.gallery" :key="$index"
                                            data-target="#demo" data-slide-to="19"
                                            v-if="$index == template_detail.gallery.length - 1">
                                            <div>
                                                <img :src="g.image" />
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <br>
                                <h3 class="text-center text-primary">The thumbnail gallery above is only a guide for
                                    possible layout ideas</h3>
                                <p class="mt-3">
                                    {{ template_detail.meta_description }}
                                </p>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-7">
                                <h1 class="mt-5">{{ trimTitle(template_detail.title) }}</h1>
                                <h4 class="mb-3">
                                    {{ template_detail.meta_description }}
                                </h4>
                                <table class="table table-bordered ">
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ template_detail.category.name }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="mb-1"><i class="text-success fa fa-check"></i> Background Changeable
                                            </p>
                                            <p class="mb-1"><i class="text-success fa fa-check"></i> Colors Chanegable</p>
                                            <p class="mb-1"><i class="text-success fa fa-check"></i> Texts Editable</p>
                                            <p class="mb-0"><i class="text-success fa fa-check"></i> Logo Changeable</p>
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-secondary" title="Edit This Template"
                                    @click="open(template_detail.id)">Use This Template</button>
                            </div>
                            <div class="col-md-5 text-center">
                                <img :src="template_detail.main_image" :alt="template_detail.title" />
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
            var dataUrl =
                "/get-template-detail/" + slug
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.loading = false;
                    this.template_detail = result.data;
                    if(this.template_detail.gallery){
                   this.pagesData =  [
                        null,
                        this.template_detail.gallery[0].image,
                    '/assets/img/layouts/4-Page-Layout-Design-1-1.png',
                    '/assets/img/layouts/4-Page-Layout-Design-2.png',
                    '/assets/img/layouts/8-Page-Layout-Design-1-Pages-2-3.png',
                    '/assets/img/layouts/8-Page-Layout-Design-1-Pages-4-5.png',
                    '/assets/img/layouts/8-Page-Layout-Design-1-Pages-6-7.png',
                    '/assets/img/layouts/8-Page-Layout-Design-2-Pages-2-3.png',
                    '/assets/img/layouts/8-Page-Layout-Design-2-Pages-4-5.png',
                    '/assets/img/layouts/8-Page-Layout-Design-2-Pages-6-7.png',
                    '/assets/img/layouts/12-Page-Layout-Design-1-Pages-2-3.png',
                    '/assets/img/layouts/12-Page-Layout-Design-1-Pages-4-5.png',
                    '/assets/img/layouts/12-Page-Layout-Design-1-Pages-6-7.png',
                    '/assets/img/layouts/12-Page-Layout-Design-1-Pages-8-9.png',
                    '/assets/img/layouts/12-Page-Layout-Design-1-Pages-10-11.png',
                    '/assets/img/layouts/12-Page-Layout-Design-2-Pages-2-3.png',
                    '/assets/img/layouts/12-Page-Layout-Design-2-Pages-4-5.png',
                    '/assets/img/layouts/12-Page-Layout-Design-2-Pages-6-7.png',
                    '/assets/img/layouts/12-Page-Layout-Design-2-Pages-8-9.png',
                    '/assets/img/layouts/12-Page-Layout-Design-2-Pages-10-11.png',
                    this.template_detail.gallery[this.template_detail.gallery.length - 1].image,
                    null,
                    ]
                    }
                    this.$forceUpdate();
                },
                (error) => { }
            );
        },
    },
};
</script>
