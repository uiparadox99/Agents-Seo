<template>
    <div>
        <VGHeader></VGHeader>
        <main>
            <section class="tool-slider slider">
                <div class="container">
                    <div class="content">
                        <h1>Trending Meme's Generator</h1>
                        <h4>
                            Deliver an excellent message and grasp your audience’s interest with beautiful poster templates
provided on our platform. Explore the unfastened poster templates divided into a couple of classes,
along with the gym, seasonal sale, Christmas, new year, etc., and layout posters for any form of event.
                        </h4>
                    </div>
                </div>
            </section>
            <section  class="title-sec container d-2" id="memes-section">
                <h2>Thosands of Free Meme Templates</h2>
                <p>
                  Get right of entry to a huge variety of poster templates categorized in exclusive classes and pick out a
layout that fits your requirements. Explore a class associated with your event’s nature and make a choice
from unfastened templates for posters.
                </p>
            </section>
            <section class="categories container pt-3 pb-3" >
                <div v-if="loading" class="text-center">
                    <i class="fa fa-spin fa-spinner" style="font-size:100px"></i>
                </div>
                <div v-else>
 <div >
                        <a href="javascript:;" @click="black" v-if="page > 1" style="margin-right:30px" class="btn btn-secondary" ><i class="fa fa-arrow-left"></i> Back</a>
                        <buttton class="btn btn-primary float-right" @click="next">Next <i class="fa fa-arrow-right"></i></buttton>
                    </div>
                    <div class="clearfix"></div><br>
                
                <div class="card-columns">
                    <div
                        v-for="(item, $index) in templates"
                        :key="$index"
                        class="template-preview-box card"
                    >
                        <a href="javascript:;" @click="open(item.id)" :title="item.title">
                            <img :src="item.preview_image" :alt="item.title" />
                            <!-- <h3>{{ item.name }}</h3> -->
                        </a>
                    </div>
                </div>
                    <div class="text-center mt-3">
                        <a href="javascript:;" @click="black" v-if="page > 1" style="margin-right:30px" class="btn btn-secondary" ><i class="fa fa-arrow-left"></i> Back</a>
                        <buttton class="btn btn-primary" @click="next">Next <i class="fa fa-arrow-right"></i></buttton>
                    </div>
                </div>
                <!-- <infinite-loading @infinite="getTemplates"></infinite-loading> -->
            </section>
             <section  class="title-sec container d-2">
                <h2>How To Make A Meme ?</h2>
                <p>Poster designing does not call for the help of an expert designer. You can search out templates provided
on our online poster maker and achieve the system by following an easy set of instructions.</p>
            </section>
            <section class="how-to-make container">
               <div class="row">
                  <div class="col-md-4">
                     <div class="step-box b-1">
                        <div class="content">
                           <h4>Choose</h4>
                           <p>Select a free meme template from thoursands of options provided on our meme generator. You don’t have to be proffesional for crafting a meme</p>
                        </div>
                     </div>
                     </div>
                        <div class="col-md-4">
                       <div class="step-box b-2">
                        <div class="content">
                           <h4>Modify</h4>
                           <p>Alter the selected meme design template as you desire. You can make unlimited changes to the design elements, including icons, text, and graphics unless you’re satisfied.</p>
                        </div>
                     </div>
                      </div>
                        <div class="col-md-4">
                       <div class="step-box b-3">
                        <div class="content">
                           <h4>Download</h4>
                           <p>After the completion of the customization process, click the download button to save the free meme on your device instantaneously. You don’t even need to get registered!</p>
                        </div>
                     </div>
                  </div>
                     
                 
               </div>
            </section>
            <section  class="title-sec container d-2 pb-0 mb-0 mt-3">
                <h2 class="mb-0">Our Reviews</h2>
            </section>
            <section class="review d-1 ">
                <div class="container">

                         <div class="row">
                             <div class="col-md-3 col-6">
                                    <div class="review-box">
                                        <strong>Paulina Ceballos</strong>
                                        <p>By far the easiest way to create memes/content online</p>
                                    </div>
                             </div>
                             <div class="col-md-3 col-6">
                                    <div class="review-box">
                                        <strong>Kim Parker Russell</strong>
                                        <p>Customizable and easy-to-use. Tracking information is also very cool.</p>
                                    </div>
                             </div>
                             <div class="col-md-3 col-6">
                                    <div class="review-box">
                                        <strong>Marko</strong>
                                        <p>Easy to use, Trending data to create meme</p>
                                    </div>
                             </div>
                             <div class="col-md-3 col-6">
                                    <div class="review-box">
                                        <strong>Ahmad Reza</strong>
                                        <p>I create new meme templates in seconds</p>
                                    </div>
                             </div>
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
            templates: [],
            tCount: 1,
            loading:true,
            search: "",
            fCount: 0,
            form: {
                orientation: "all",
                paid: 0,
            },
            error_message: "",
            has_error: false,
            loading: true,
            page: 1,
        };
    },
    mounted() {
        this.getTemplates();

        if (
            typeof this.$route.query.calendar_image != "undefined" &&
            this.$route.query.calendar_image != ""
        ) {
            this.$store.commit(
                "set_calendarImage",
                this.$route.query.calendar_image
            );
        }
    },
    methods: {
        getTempCount(count) {
            return count + 1;
        },
        open(id) {
            this.$store.commit("set_playChange", true);
            this.$store.commit("set_openInPlayground", id);
            this.$router.push({ path: "/playground/meme" });
        },
        searchit() {
            if (this.search != "") {
                this.page = 1;
                var dataUrl =
                    "/get-templates-catgories/meme?search=" +
                    this.search +
                    "&page=" +
                    this.page;
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
                        }
                        this.templates = templatesdata;
                    },
                    (error) => {}
                );
            }
        },
        black(){
            this.page = this.page - 1;
            this.getTemplates()
            
        },
        next(){
            this.page = this.page + 1;
            this.getTemplates()
            
        },
        getTemplates() {
             this.loading = true;
              var dataUrl =
                "/get-templates-list/meme-templates?page=" + this.page;
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.loading = false;
                    var templatesdata = result.data.data;
                    if (templatesdata.length) {
                        this.templates = templatesdata;
                    } else {

                    }
                     $('html, body').animate({
                        scrollTop: $("#memes-section").offset().top
                    }, 1000);
                },
                (error) => {}
            );
        },
    },
};
</script>
