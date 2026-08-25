<template>
    <div class="app-container internal-page">
         <div class="fm-error-msg verify-email-custom-msg paused_roaster" style="display: none;z-index: 9999;">
                    <div><p> <p><span  class="roaster-html"></span><a href="https://livestarhelp.zendesk.com/hc/en-gb/articles/900001175603-Can-I-pause-my-roster-" target="_blank">Help.</a></p></div>
                </div>
   <!--    <div class="overlay-wrapper blue paused_roaster" style="display:none;">
        <div class="overlay-bx">
            <a id="close_p" class="cross-btn" href="javascript:void(0);"></a>
           
        </div>
    </div> -->

		<div class="cover-photo-wrapper" v-bind:style="{'background-image':'url(' + cover + ')','background-position':' center center','background-size':' 100%'}" >
            <div class="cover-bx s">
                        <router-link class="share-btn" v-if="showShare" :to="{name:'share', params: {username: this.$route.params.username}}">Share</router-link>

                        <a href="javascript:void(0);" class="cover-edit-btn" v-if="this.$store.getters.isLoggedIn && this.$store.state.user.username == this.$route.params.username" v-on:click="isHidden = !isHidden">Edit</a>
						<a class="signout-btn" v-if="this.$store.getters.isLoggedIn == true" href="javascript:void(0);" @click="$parent.logout()">Sign out</a>
                    </div>
        </div>
		
        
        <div class="app-content-container pw-bx-pg">

			<!--powerd by-->
			<div class="pw-bx" v-if="!this.$store.getters.isSeller && this.$store.state.user.username != this.$route.params.username"><p>Powered by <img :src="logo" alt="" class="pw-logo"></p></div>
			<!--powerd by-->

            <div v-if="loading == false">
                <FacebookLoader :speed="1" primaryColor="#2da25c" secondaryColor="#29dca8"></FacebookLoader>
            </div>
            
            <div v-else class="my-real-content" >
                <!--steps-header-->
                <div class="cover-container">
                    
                </div>
                <!--steps-header-->
                <div class="overlay-wrapper" style="display:none;" v-show="isHidden">
                    <a href="javascript:void(0);" class="c0" v-on:click="isHidden = !isHidden"><span></span><span></span></a>
                    
                    <input type="file" name="cover" ref="file" @change="onFileChange()" style="display:none;">
                    <div class="ft-btns update-c">
                        <div class="m310">
                            <button class="b-radius pull-right fl-wd-btn" @click="$refs.file.click()">UPDATE COVER PHOTO</button>
                        </div>
                    </div>
                </div>

                <!--main-content-container-->
                <div class="main-content-container" >
                    
                    
                    <div class="sc02" v-show="isHiddenPage">
                        <h3>To book and pay for a call <br class="on-mob">with @{{ this.$store.getters.getSeller.username }}, <br>please sign up or sign in</h3>    
                        <div class="max310 ca-w w3">
                            <router-link :to="{path: '/register'}" class="bg-pink fl-wd-btn b-radius">FOLLOWER SIGN UP</router-link>
                            <router-link :to="{path: '/login'}" class="bg-pink fl-wd-btn b-radius">FOLLOWER SIGN IN</router-link>
                        </div>
                    </div>
                        
                    <div class="pro-info-container" v-show="!isHiddenPage">
                        <div class="profile-pic"><img v-bind:src="this.$store.getters.getSeller.profile" alt="" /></div>
                        <a href="javascript:;" class="pull-right edp" @click="editProfile(true)" v-if="this.$store.getters.isLoggedIn && this.$store.state.user.username == this.$route.params.username">Edit Profile</a>
                        <div class="username"><router-link style="color: unset;" class="edit-text" :to="{name: 'view-profile', params: {username: this.$store.getters.getSeller.username}}" > @{{ this.$store.getters.getSeller.username }}</router-link>   </div>
                        <div class="heading-1"><h1>{{ this.$store.getters.getSeller.name }} <a href="javascript:;" v-if="this.$store.getters.isLoggedIn && this.$store.state.user.username == this.$route.params.username && this.$store.getters.isSeller" class="bg-pink b-radius  pull-right text-uppercase roster-button" @click="change_roster_status"> <i class="glyphicon glyphicon-pause" v-if="roaster != 1"></i> <i class="glyphicon glyphicon-play" v-else></i><span> <span v-if="roaster != 1">pause</span><span v-else>Unpause</span> my roster</span></a></h1> </div>
                        <!-- This line comment out due to instagram login functionaltiy disabaled -->
                        <!-- <div class="followers"><h4>{{ this.$store.state.followers }} followers</h4></div> -->
                        <p v-if="this.$store.state.vcheckProfile.location">{{ this.$store.getters.getSeller.city && this.$store.getters.getSeller.city.name }}, {{ this.$store.getters.getSeller.country && this.$store.getters.getSeller.country.name }}</p>
                        <div class="t-border b-border" v-if="this.$store.state.vcheckProfile.interest">
                            <p>Book a live video call with {{ this.$store.getters.getSeller.name }}. {{ this.$store.getters.getSeller.name }} loves to talk about:</p>
                            <ul class="listing-ul">
                                <li v-for="i in this.$store.getters.getSeller.interest">{{ i.value }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <p v-if="this.$store.state.vcheckProfile.fees">${{ this.$store.getters.getSeller.rate_per_minute }} per minute 
                                    <a href="javascript:;" class="edit-text" v-if="this.$store.getters.isSeller" @click="editProfile()">edit</a>
                                </p>
                                <div class="rating-star">
                                    <div v-for="s in stars" :class="['stars', s<=fillStars?'active':'no-active']"></div>
                                    <div class="rating-points">{{ totalReviews }}</div>
                                </div>
                            </div>
                            <!-- <div class="col-xs-6"><router-link class="bg-pink fl-wd-btn b-radius" :to="{name: 'user-listing', params: { username: this.$store.getters.getSeller.username } }">Check Availability</router-link></div> -->

                            <div class="col-xs-6" v-if="this.$store.getters.isLoggedIn && this.$store.state.user.username == this.$route.params.username"><router-link class="bg-pink b-radius btn2 pull-right sm-wd-btn view-p-btn" to="my-bookings">My Bookings</router-link></div>
							
                            <div class="col-xs-12" v-else-if="!this.$store.getters.isSeller && this.$store.state.vuser.type == 0"><div class="max310 ca-w w-50"><a href="javascript:;" class="bg-pink fl-wd-btn b-radius  pull-left" @click="openLink">Check Availability</a></div></div>
                            <!--faq and help-->
                    <div class="clearfix"></div>
                    <!-- <VFooter></VFooter> -->
                    <!--faq and help--> 
                        </div>
                    </div>
                </div>
                
                <!-- error message -->
                <div class="fm-error-msg" v-show="error_message != ''">
                    <div><p v-html="error_message">Email and/or password <br>is incorrect. Please try <br>again.</p></div>
                </div>
                <div class="fm-error-msg all-changes-saved" v-show="success_message != ''">
                    <div><p v-html="success_message">Email and/or password <br>is incorrect. Please try <br>again.</p></div>
                </div>
                <!-- error message -->

                <div class="clearfix"></div>
                <!-- <div class="alert alert-warning" style="margin-top: 30px;" v-if="error_message != ''" v-text="error_message"></div> -->
                <!--main-content-container-->
            </div>

        </div>
        <div class=" header-jan22 overlapFooter" v-if="!this.$store.getters.isSeller && this.$store.state.user.username != this.$route.params.username">
           <div class="clearfix"></div>
           <VFooter></VFooter>
       </div>
         <div class=" header-jan22" v-else>
           <div class="clearfix"></div>
           <VFooter></VFooter>
       </div>
        
    </div>
</template>

<script>
import { FacebookLoader } from 'vue-content-loader'
import * as Cookies from 'js-cookie';
    export default {
        components: {
            FacebookLoader
        },
        data(){
            return {
                cover: this.$store.state.cover?this.$store.state.cover:"/assets/images/cover-placeholder.jpg",
                logo: this.$parent.BASE_PATH+'/assets/images/ft-logo2.jpg',
                loading: false,
                isHidden: false,
                roaster: 0,
                isHiddenPage: false,
                showShare: false,
                totalReviews: 0,
                error_message: "",
                success_message: "",
                stars: 5,
                fillStars: 0,
                form: {
                    cover: null
                }
            }
        },
        beforeMount(){
            this.updateProfile(this.$route.params.username);
            this.getFeedback(this.$route.params.username);
            this.$store.commit('set_redirecturl', '/'+this.$route.params.username+"/listings");
   
            if(this.$store.state.success_msg != ''){
                this.success_message = this.$store.state.success_msg;
                this.$store.commit('set_success_msg', '');
                var vm = this;
                setTimeout(function() {
                    vm.error_message = "";
                    vm.success_message = "";
                }, 2500)
            }
        },
        methods: {
            change_roster_status(){
                if (this.roaster == 1) {
                    var newStatus = 0;
                }else{
                    var newStatus = 1;
                }

                  var reqURL = "/update-roaster-status?username="+this.$route.params.username+"&status="+newStatus;
                  axios({ method: "post", "url":reqURL, "headers": { "content-type": "application/json" } }).then(result => {
                
                    if (result.status) {
                        this.roaster = newStatus;
                        if (newStatus == 1) {
                            $('.roaster-html').html('Your roster is now paused. Your Followers cannot book any more calls with you until you unpause it. Please note this does not cancel existing bookings. ');
                        }else{
                              $('.roaster-html').html('Your roster is now unpaused. Your Followers can now book calls. You can change your roster by clicking Edit Profile. ');

                        }
                            $('.paused_roaster').fadeIn().addClass('open');
                            setTimeout(function() {
                                $('.paused_roaster').fadeOut().removeClass('open');
                            }, 5000);
                        
                     

                    }
                        
                    }, error => {
                });
            },
            openLink(){
                if(this.$store.getters.authStatus == "success"){
                    this.$router.push({name: 'user-listing', params: { username: this.$route.params.username } });
                }else{
                    this.$store.commit('set_redirecturl', '/'+this.$route.params.username+"/listings");
                    // this.$router.push({path:'/fan-pre-booking'});
                    this.isHiddenPage = true;
                }
            },
            editProfile(main = false){
                if (main) {
                    this.$store.commit('set_isEdit', true);
                    this.$store.commit('set_redirecturl', '/'+this.$route.params.username);
                    this.$router.push({path:'/welcome'});
                }else{
                    this.$store.commit('set_isEdit', true);
                    this.$store.commit('set_redirecturl', '/'+this.$route.params.username);
                    this.$router.push({path:'/fees'});
                }
            },
            
            onFileChange() {
              this.form.cover = this.$refs.file.files[0];
              let formData = new FormData();
                formData.append('cover', this.form.cover);
                this.isHidden = false;
                axios({ method: "POST", "url":'/profile', "data": formData, "headers": { "content-type": "multipart/form-data" } }).then(result => {
                        var resp = result.data;
                        if(resp.status){
                            if (resp.data.cover != null) {
                                this.cover = resp.data.cover;
                                this.$store.commit('set_cover', resp.data.cover);
                            }
                        }else{
                            this.error_message = resp.message;
                            let vm = this;
                            setTimeout(function() {
                                vm.error_message = "";
                            }, 10000)
                        }
                    }, error => {
                });
            },
            updateProfile(username){
                var checkURL = "/check-profile-detail?username="+username;
                var profileURL = "/profile-detail?username="+username;
              /*  if(typeof username === 'undefined'){
                    var username = this.$store.getters.getSeller.username
                    var checkURL = "/check-profile";
                    var profileURL = "/profile";
                }*/

                var token = "";
                var client_id = "";

                axios({ method: "GET", "url": profileURL, "headers": { "content-type": "application/json" } }).then(result => {
                        if(!result.data.status){
                            this.$router.push({path:'/notFound'});
                        }
                        let profile = result.data.data;
                        if (result.data.data.cover != null) {
                            this.cover = result.data.data.cover;
                            this.$store.commit('set_cover', result.data.data.cover);
                        }else{
                             this.cover = '/assets/images/cover-placeholder.jpg';
                                this.$store.commit('set_cover', '/assets/images/cover-placeholder.jpg');
                        }
                        // show share button if account type is seller
                        if(profile.type == 0){
                            this.showShare = true;
                        }
                        this.roaster = profile.roaster_status;
                        

                        // Comment out these lines becuase we are disbaled the instagram login functionality

                        // client_id = result.data.data.instagram.client_id;
                        // token = result.data.data.instagram.access_token;

                        // this.getCover(client_id, token);

                        // this.$store.commit('set_followers', result.data.data.instagram.followed_by);
                        this.$store.commit('vupdate_profie', profile);
                        this.loading = true;
                    }, error => {
                        this.$router.push({path:'/notFound'});
                }); 

                axios({ method: "GET", "url":checkURL, "headers": { "content-type": "application/json" } }).then(result => {

                        this.$store.commit('vupdate_checks', result.data);
                    }, error => {
                        this.$router.push({path:'/notFound'});
                });


                axios({ method: "GET", "url":checkURL, "headers": { "content-type": "application/json" } }).then(result => {

                        this.$store.commit('vupdate_checks', result.data);
                    }, error => {
                        this.$router.push({path:'/notFound'});
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
            },
            getFeedback(username){
                axios({ method: "GET", "url":'/get-stars/'+username, "headers": { "content-type": "application/json" } }).then(result => {
                        this.$store.commit('set_feedback', result.data);
                        this.fillStars = result.data.stars;
                        this.totalReviews = result.data.count;
                    }, error => {
                        this.$router.push({path:'/notFound'});
                });
            }
        },
        beforeRouteLeave(to, from, next){
            this.updateProfile(this.$route.params.username);
            this.getFeedback(this.$route.params.username);
            next();
        }
    };
</script>
