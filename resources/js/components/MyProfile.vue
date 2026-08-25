<template>
    
    <div class="app-container">
        <div class="app-content-container">
            <div v-if="loading == false">
                <FacebookLoader :speed="1" primaryColor="#01ad7b" secondaryColor="#29dca8"></FacebookLoader>
            </div>
            <div v-else class="my-real-content">
                <!--steps-header-->
                <div class="cover-container">
                    <div class="cover-bx s" v-bind:style="{ 'background-image': 'url(' + cover + ')' }">
                        <router-link v-if="this.$store.getters.isSeller" class="share-btn" to="/share">Share</router-link>
                        
                        <a href="javascript:void(0);" class="cover-edit-btn" v-on:click="isHidden = !isHidden">Edit</a>
                    </div>
                </div>
                <!--steps-header-->

                <div class="overlay-wrapper" style="display:none;" v-show="isHidden">
                    <div class="ft-btns update-c"><button class="bg-pink b-radius next-btn pull-right fl-wd-btn">UPDATE COVER PHOTO</button></div>
                </div>
                
                <!--main-content-container-->
                <div class="main-content-container">
                    <div class="pro-info-container">
                        <div class="profile-pic"><img v-bind:src="this.$store.state.user.profile" alt="" />

                        </div>
                        
                        <!-- <a href="javascript:void(0);" class="edit-pro" >Edit Profile</a> -->
                        <div class="username">@{{ this.$store.state.user.username }}</div>
                        <div class="heading-1"><h1>{{ this.$store.state.user.name }}</h1></div>
                        <div class="followers"><h4>{{ this.$store.state.followers }} followers</h4></div>
                        <p v-if="this.$store.state.checkProfile.location">{{ this.$store.state.user.city?this.$store.state.user.city.name:'' }}, {{ this.$store.state.user.country?this.$store.state.user.country.name:'' }}</p>
                        <div class="t-border b-border" v-if="this.$store.state.checkProfile.interest">
                            <p>Book a live video call with {{ this.$store.state.user.name }} . {{ this.$store.state.user.name }} loves to talk about:</p>
                            <ul class="listing-ul">
                                <li v-for="i in this.$store.state.user.interest">{{ i.value }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <p v-if="this.$store.state.checkProfile.fees">${{ this.$store.state.user.rate_per_minute }} minute 
                                    <!-- <router-link class="edit-text" v-if="this.$store.getters.isSeller" to="fees">edit</router-link> -->
                                </p>
                                <!-- <div class="rating-star">
                                    <div class="stars active"></div>
                                    <div class="stars active"></div>
                                    <div class="stars active"></div>
                                    <div class="stars active"></div>
                                    <div class="stars no-active"></div>
                                    <div class="rating-points">12</div>
                                </div> -->
                            </div>
                            <!-- <center>  <router-link to="bank-account" v-if="this.$store.getters.isSeller">Update Bank Details</router-link></center> -->
                            <div class="col-xs-6" v-if="this.$store.getters.isLoggedIn"><router-link class="bg-pink fl-wd-btn b-radius" to="my-bookings">My Bookings</router-link></div>
                            <div class="col-xs-6" v-if="!this.$store.getters.isLoggedIn"><router-link class="bg-pink fl-wd-btn b-radius" :to="{name: 'user-listing', params: { username: this.$store.state.user.username } }">Check Availability</router-link></div>
                        </div>
                    </div>    
                    
                </div>
                <!--main-content-container-->
            </div>
        </div>
         <div class=" header-jan22">
         <div class="clearfix"></div>
      <VFooter></VFooter>
    </div>
    </div>
</template>

<script>
import { FacebookLoader } from 'vue-content-loader'
    export default {
        components: {
            FacebookLoader
        },
        data (){
            return {
                loading: false,
                cover: "",
                isHidden: false
            }
        },
        beforeMount(){

            if(this.$store.state.user.username != this.$route.params.username|| ($.isEmptyObject(this.$store.state.user) || $.isEmptyObject(this.$store.state.checkProfile))){
                this.updateProfile();
            }else{
                this.cover = this.$store.state.cover;
            }
        },
        methods: {
            updateProfile(){
                var username = this.$route.params.username;
                var checkURL = "/check-profile-detail?username="+username;
                var profileURL = "/profile-detail?username="+username;
                let $this = this;

                if(typeof username === 'undefined'){
                    var username = this.$store.state.user.username
                    var checkURL = "/check-profile";
                    var profileURL = "/profile";
                }
                axios({ method: "GET", "url":checkURL, "headers": { "content-type": "application/json" } }).then(result => {
                        this.$store.commit('update_checks', result.data);
                    }, error => {
                        this.$router.push({path:'/login'});
                });

                axios({ method: "GET", "url":this.$parent.BASE_API_PATH+'insta/index.php?username='+username, "headers": { "content-type": "application/json" } }).then(result => {
                        client_id = result.data.data.instagram.client_id;
                        token = result.data.data.instagram.access_token;

                        this.getCover(client_id, token);
                        this.$store.commit('set_followers', result.data.data.instagram.followed_by);
                    }, error => {
                        this.loading = true;
                });

                axios({ method: "GET", "url": profileURL, "headers": { "content-type": "application/json" } }).then(result => {
                        if(!result.data.status){
                            this.$router.push({path:'/login'});
                        }
                        this.$store.commit('update_profie', result.data.data);
                        this.loading = true;
                    }, error => {
                        this.$router.push({path:'/login'});
                });             
            },
            getCover(client_id, token){
                var vm = this;
                axios({ method: "GET", "url": this.$parent.BASE_API_PATH+'insta/index.php?token='+token+'&client_id='+client_id, "headers": { "content-type": "application/json" } }).then(result => {

                        if (result.status == 200) {
                            if(this.$store.state.cover == null){
                                var cover = "";
                                $.each(result.data.data, function(i, v){
                                    console.log(v.images.standard_resolution.url);
                                    if(typeof v.images.standard_resolution !== "undefined"){
                                        vm.cover = cover = v.images.standard_resolution.url;
                                        return false;
                                    }
                                })
                                if (cover.length) {
                                    this.$store.commit('set_cover', cover);
                                }else{
                                    this.cover = "/assets/images/cover-placeholder.jpg";
                                }
                            }
                        }
                    }, error => {
                        this.loading = true;
                });
            }
        }
    }
</script>
