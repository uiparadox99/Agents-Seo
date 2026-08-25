<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider">
                <div class="container">
                    <!-- <div class="content">
                        <div class="row">
                            <div class="col-md-7">
                                <h1>{{ page_title }} Templates</h1>
                                <h4>
                                    Deliver an impressive message and grab your
                                    a udience’s attention with stunning poster
                                    templates offered on our platform. Explore
                                    the free poster templates divided into
                                    multiple categories, such as gym, seasonal
                                    sale, Christmas, new year, etc., and design
                                    posters for any kind of event.
                                </h4>
                            </div>
                            <div class="col-md-5">
                                <img
                                    src="/studio/assets/img/poster-templates-slider-preview.png"
                                />
                            </div>
                        </div>
                    </div> -->
                </div>
            </section>
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
                <div class="">
                    <div class="toggle">
                        <input type="radio" name="sizeBy" v-model="form.orientation" value="portrait" id="sizeWeight"
                            @change="orientationChange" checked="checked" />
                        <label for="sizeWeight">Portrait Templates</label>
                        <input type="radio" name="sizeBy" v-model="form.orientation" value="landscape"
                            @change="orientationChange" id="sizeDimensions" />
                        <label for="sizeDimensions">Landscape Templates</label>
                    </div>
                </div>
            </section>
            <section class="container pt-3 pb-3">
                <div class="row"  v-if="type == 'service_book'"> 
                    <div v-for="(item, $index) in templates" :key="$index"
                        class="template-preview-box col-md-4" @mouseover="mouseover(item.id)"
                        @mouseleave="mouseout(item.id)">
                        <a :href="'/studio/template/' + item.slug">
                            <img :src="item.preview_image" :alt="item.title" />
                        </a>
                    </div>
                    </div>
                    <div class="row"  v-else> 
                    <div v-for="(item, $index) in templates" :key="$index" class="template-preview-box col-md-4"
                        @mouseover="mouseover(item.id)" @mouseleave="mouseout(item.id)">
                        <img :src="item.preview_image" :alt="item.title" @click="open(item.id)" />
                        <div class="hover-content" :id="'hovercontent' + item.id">
                            <!-- <a class="btn" title="view detail" data-toggle="tooltip"
                                :href="'/studio/template/' + item.slug">
                                <i class="fa fa-eye"></i>
                            </a> -->

                            <button class="btn" data-toggle="tooltip" title="Use this template"
                                @click="open(item.id, item.type)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <infinite-loading spinner="spiral" @infinite="getTemplates"></infinite-loading>
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
                        <li v-for="(cat, index) in categories" v-bind:key="index">
                            <a v-if="templates[0] != undefined &&
                                templates[0] != '' &&
                                templates[0].categories_id == cat.id
                                " class="active" :title="cat.name" :href="'/studio/poster-templates' + cat.slug">{{
        cat.name }}</a>
                            <a v-else :href="'/studio/poster-templates/' + cat.slug" :title="cat.name">{{ cat.name }}</a>
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
            page_title: "Poster",
            form: {
                orientation: "portrait",
                paid: 0,
            },
            type: this.$route.params.type,
            error_message: "",
            has_error: false,
            loading: true,
            page: 1,
        };
    },
    mounted() {
        var type = this.$route.params.type;
        if (type == "posters") {
            this.page_title = "Poster";
        }
        if (type == "flayers") {
            this.page_title = "Flayer";
        }
        if (type == "business_cards") {
            this.page_title = "Business Cards";
        }
    },
    methods: {
        getTempCount(count) {
            return count + 1;
        },
        open(id, type) {
            this.$store.commit("set_playChange", true);
            this.$store.commit("set_openInPlayground", id);
            if (type == 'posters') {
                type = 'poster-maker'
            }
            this.$router.push({ path: "/playground/" + type });
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
        orientationChange() {
            this.page = 1;
            var category = this.$route.params.slug;
            var type = this.$route.params.type;
            var dataUrl =
                "/get-templates-list/" +
                type +
                "/" +
                category +
                "?page=" +
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
                },
                (error) => { }
            );
        },
        getCategories() {
            var dataUrl = "/get-templates-catgories/poster-maker?getAll=all";
            axios({
                method: "GET",
                url: dataUrl,
                headers: { "content-type": "application/json" },
            }).then(
                (result) => {
                    this.categories = result.data;
                },
                (error) => { }
            );
        },
        getTemplates($state) {
            var category = this.$route.params.slug;
            var type = this.$route.params.type;
            var dataUrl =
                "/get-templates-list/" +
                type +
                "/" +
                category +
                "?page=" +
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
