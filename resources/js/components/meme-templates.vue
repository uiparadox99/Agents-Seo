<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main>
            <section class="templates-slider slider">
                <div class="container">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-7">
                                <h1>Trending Meme Templates</h1>
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
                    </div>
                </div>
            </section>
            <section class="title-sec container d-2">
                <h2>Chose The Best Meme Template</h2>
                <p>
                    Lay your hands on the extensive range of concert poster
                    templates offered by us and pick a design that matches your
                    needs. Customize the template with advanced editing
                    features. Save the modified template on your device with a
                    few clicks instantly
                </p>
            </section>
            <section class="container pt-3 pb-3">
                <div class="row">
                    <div
                        v-for="(item, $index) in templates"
                        :key="$index"
                        class="template-preview-box col-md-4"
                        @mouseover="mouseover(item.id)"
                        @mouseleave="mouseout(item.id)"
                    >
                        <img :src="item.main_image" @click="open(item.id)" />
                        <div
                            class="hover-content"
                            :id="'hovercontent' + item.id"
                        >
                            <button
                                type="button"
                                class="btn"
                                data-toggle="modal"
                                :data-target="'#template' + item.id"
                            >
                                <i class="fa fa-eye"></i>
                            </button>

                            <button class="btn" @click="open(item.id)">
                                <i class="fas fa-box"></i>
                            </button>
                        </div>
                        <div class="modal" :id="'template' + item.id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Preview</h4>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                        >
                                            &times;
                                        </button>
                                    </div>

                                    <div class="modal-body p-5">
                                        <img
                                            :src="item.main_image"
                                            @click="open(item.id)"
                                            style="
                                                max-height: 500px;
                                                object-fit: contain;
                                            "
                                        />
                                        <br />
                                        <div class="text-center">
                                            <button
                                                class="btn btn-danger"
                                                @click="open(item.id)"
                                            >
                                                Use This Template
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <infinite-loading
                spinner="spiral"
                @infinite="getTemplates"
            ></infinite-loading>
			<section class="container">
				<div class="other-categories">
					<div class="heading">
						<h2>Select Meme Design By Categories</h2>
						<p>Explore the copious amount of premium poster designs available under various categories for all events and select a design that fits your requirements.</p>
					</div>
					<ul>
						<li v-for="(cat,index) in categories" v-bind:key="index">
							<router-link v-if="templates[0] != undefined && templates[0] != '' && templates[0].categories_id == cat.id" class="active" :to="'/poster-templates'+cat.slug">{{cat.name}}</router-link>
							<router-link v-else :to="'/poster-templates/'+cat.slug">{{cat.name}}</router-link>
						</li>
					</ul>
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
            categories: [],
            tCount: 1,
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
        /* this.getTemplates();*/
		this.getCategories();
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
        mouseover(id) {
            $("#hovercontent" + id).show("slow");
        },
        mouseout(id) {
            $("#hovercontent" + id).hide("slow");
        },
		getCategories(){
			 var dataUrl =
                    "/get-templates-catgories/meme?getAll=all";
                axios({
                    method: "GET",
                    url: dataUrl,
                    headers: { "content-type": "application/json" },
                }).then(
                    (result) => {
                         this.categories = result.data.data;
                    },
                    (error) => {}
                );
		},
        getTemplates($state) {
            var category = this.$route.params.slug;
            var dataUrl =
                "/get-templates-list/" + category + "?page=" + this.page;
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
                (error) => {}
            );
        },
    },
};
</script>
