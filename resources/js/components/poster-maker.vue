<template>
    <div>
        <VGHeader></VGHeader>
        <main>
            <section class="tool-slider slider">
                <div class="container">
                    <div class="content">
                        <h1>Choose
                            <span v-if="slug == 'service_book'">Service Book</span>
                            <span v-else>Poster</span>
                            Style
                        </h1>
                        <h4 v-if="slug == 'service_book'">
                            Introducing our Funeral Service Book Design Generator Tool – a compassionate solution to honor
                            your loved ones with grace and dignity. Create personalized, heartfelt service books
                            effortlessly, offering a loving tribute through customizable layouts, serene themes, and
                            thoughtful designs. 
                        </h4>
                        <h4 v-else>
                            Deliver an outstanding message and snatch your audience’s interest with lovely poster templates
                            provided on our platform. Explore the unfastened poster templates divided into more than one
                            category
                            which include gym, seasonal sale, Christmas, new year, etc, and layout posters for any sort of
                            event.
                        </h4>
                    </div>
                </div>
            </section>
            <section class="category-search container  mb-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form id="search-cat" @submit.prevent="searchit">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Search here"
                                    v-model="search" />
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- <section  class="title-sec container d-2">
                <h2>Choose desired category to make design</h2>
                <p>
                    Lay your fingers at the sizeable variety of live performance poster templates presented via way of means
of us and choose a layout that suits your needs. Customize the template with superior enhancing
features. Save the changed template to your tool with some clicks instantly
                </p>
            </section> -->
            <section class="categories container pt-3 pb-3">
                <div class="row">
                    <div v-for="(item, $index) in templates" :key="$index" class="template-preview-box col-md-4">
                        <a :href="'/studio/poster-templates/' + slug + '/' + item.slug" :title="item.name">
                            <img :src="item.image" :alt="item.name" />
                            <h3 class="mt-3">{{ item.name }}</h3>
                        </a>
                    </div>
                </div>
                <infinite-loading @infinite="getTemplates"></infinite-loading>
            </section>
            <section class="title-sec container d-2" v-if="slug == 'posters'">
                <h2>How To Make A Poster ?</h2>
                <p>Poster designing now does not call for the help of an expert designer. You can get hold of templates
                    provided on our on our line poster maker and achieve the manner through following an easy set of
                    instructions.</p>
            </section>
            <section class="how-to-make container"  v-if="slug == 'posters'">
                <div class="row">
                    <div class="col-md-4">
                        <div class="step-box b-1">
                            <div class="content">
                                <h4>Choose</h4>
                                <p>Select a free poster template from dozens of categories provided on our poster maker. You
                                    don’t have to acquire design skills for crafting a poster from scratch.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box b-2">
                            <div class="content">
                                <h4>Modify</h4>
                                <p>Alter the selected poster design template as you desire. You can make unlimited changes
                                    to the design elements, including icons, text, and graphics unless you’re satisfied.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box b-3">
                            <div class="content">
                                <h4>Download</h4>
                                <p>After the completion of the customization process, click the download button to save the
                                    free poster template on your device instantaneously. You don’t even need to get
                                    registered!</p>
                            </div>
                        </div>
                    </div>


                </div>
            </section>
            <section class="title-sec container d-2 pb-0 mb-0 mt-3">
                <h2 class="mb-0">Our Reviews</h2>
            </section>
            <section class="review d-1 ">
                <div class="container">

                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="review-box">

                                <strong>Andrew C.</strong>
                                <p>Personally, It is easy to use and wide range of design options for free which is totaly
                                    insane. Bless you guys!!</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="review-box">

                                <strong>Brandi S.</strong>
                                <p>I know that I can come to this site and easily find a template which saves lots of time
                                    and that I Love.</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="review-box">

                                <strong>Haywood Nicholas W.</strong>
                                <p>Saves a lot of money no need to hire a person i can create professional design on my own
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="review-box">

                                <strong>David S.</strong>
                                <p>The ease of being able to create a professional quality poster, is amplified to a new
                                    level on this website!</p>
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
            search: "",
            fCount: 0,
            slug: '',
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
        this.slug = this.$route.params.slug;
    },
    methods: {
        getTempCount(count) {
            return count + 1;
        },
        open(id) {
            this.$store.commit("set_playChange", true);
            this.$store.commit("set_openInPlayground", id);
            this.$router.push({ path: "/playground" });
        },
        searchit() {
            var type = this.$route.params.slug;
            var slugURL = 'poster-maker';
            if (type == 'service_book') {
                slugURL = 'service_book';
            }
            if (this.search != "") {
                this.page = 1;
                var dataUrl =
                    "/get-templates-catgories/" + slugURL + "?search=" +
                    this.search +
                    "&page=" +
                    this.page + "&type=" + type;
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
                    (error) => { }
                );
            }
        },
        beforeRouteLeave: function () {
            this.$router.go();
        },
        getTemplates($state) {
            var type = this.$route.params.slug
            var slugURL = 'poster-maker';
            if (type == 'service_book') {
                slugURL = 'service_book';
            }
            var dataUrl =
                "/get-templates-catgories/" + slugURL + "?search=" +
                this.search +
                "&page=" +
                this.page + "&type=" + type;
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
                        this.templates.push(...templatesdata);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                },
                (error) => { }
            );
        },
    },
};
</script>
