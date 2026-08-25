/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import store from './store'
import Axios from 'axios'
import routes from './router/routes'
import VueAnalytics from 'vue-analytics';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import VueConfirmDialog from 'vue-confirm-dialog'
import {ColorPicker, ColorPanel} from 'one-colorpicker'
import VueSimpleAlert from "vue-simple-alert";
// import moment from 'moment'
 

import {InlineSvgPlugin} from 'vue-inline-svg';

Vue.use(InlineSvgPlugin);
Vue.use(ColorPanel)

Vue.use(ColorPicker)
Vue.use(VueSimpleAlert);
Vue.use(NProgress, { showSpinner: true });
Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)
Vue.component('v-select', vSelect)

// Production Configrations
Vue.config.productionTip = false
Vue.config.devtools = false

Vue.config.debug = true
Vue.config.silent = true

let production = (window.location.hostname == "127.0.0.1"?false:true);

const PRE_API_PATH = (!production) ? 'https://smallseotricks.com/api/v1' : 'https://smallseotricks.com/api/v1';
const API_PATH = (!production) ? 'https://smallseotricks.com/' : 'https://smallseotricks.com/';
const BASE_PATH = (!production) ? 'https://smallseotricks.com/' : 'https://smallseotricks.com/';
const Bearer = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImRiZDcwNzQzMmE3YzM4ZGQ5MjgyZGNlNGIyNmIzZTI4M2IyN2E5MzY0NDcyMzc1MTYxOTdlYTdjOWVmMGY0N2NlOGJiMjBmYjU4MDI1MmE1In0.eyJhdWQiOiIzIiwianRpIjoiZGJkNzA3NDMyYTdjMzhkZDkyODJkY2U0YjI2YjNlMjgzYjI3YTkzNjQ0NzIzNzUxNjE5N2VhN2M5ZWYwZjQ3Y2U4YmIyMGZiNTgwMjUyYTUiLCJpYXQiOjE2MjAwMjc4NTMsIm5iZiI6MTYyMDAyNzg1MywiZXhwIjoxNjUxNTYzODUzLCJzdWIiOiI1Iiwic2NvcGVzIjpbXX0.RmRvGknHymBJRVP4mzf6bUZ0qHnDFKCDhAQMKS0QkyTrTFz0AzbQJ_hKVGl7qrVQTK0OsgQ94VD1CoJU0CpMU5GtxAktvwldAqELXPbWUpeaqljHe8PR1_hyIPClcDJVvJZbJE9gTiv1q9fawYj5ApDlFO6anImJNLR4l-llH2PCDeHH63-zSppA98FskYgfrbth96xaHxauxZ3eWnxLxznoW2tami3sv4znmJ4noga1NxGbPVqLr2KWLMsZKz7Fi-__MI30b9eVT-d1r02mxLtoKyQ-_qy9grVYKptlZnWZQdAO6cwVEag8_6E3663qRmJPXOXwa4upHjpOwLI8HYyFnT3gb5Stfrjgv3hV5MsKe3152ziGPUJ0pT2MZ6Lz6NA8ZydZPJxKoqO4jRQbS9kw26_ThZ5QS9Esh5azmEsyTyetSfamyf-EzStHaA-FJX8VgFFPZxzv2T2kwEH1yGYKXXffTGZN9Qfg_A17qsJYFWITu_etwyTVofsF1YCVrEqGsLtKorBdABfYoXluiUImVa5t3s0KrPcUFzF5dSn3489ymL3mFXL4-3ptutzEBoVKCbu5RljEilQ7fSeD2n3v048PxPpzeiahgQvUmqTYyeg-_r6HkL6h3ppdMnTEKr6dxDpRnKYamJwSKh1J71RCc6OQZOl0wVUhEMT0nHo';


window.axios.defaults.baseURL = PRE_API_PATH;

Vue.prototype.$http = Axios;
/*Vue.use(VueAuthenticate, {
    baseUrl: API_PATH, // Your API domain

    providers: {
        instagram: {
            clientId: 'ed17d72961b14fbb80b62871de4d547b',
            clientSecret: 'ca2b6ed63c0c4785bdf26463c395897a',
            redirectUri: BASE_PATH + '/auth/callback', // Your client app URL,
            url: '/instagram/callback'
        }
    },



})

var vueAuth = VueAuthenticate.factory(Vue.prototype.$http, {
    baseUrl: BASE_PATH
})*/

const token = Bearer
window.axios.defaults.headers.common['Authorization'] = Bearer;
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

Vue.use(VueRouter)
Vue.component('VHeader', require('./include/Header.vue').default);
Vue.component('VLogin', require('./include/LoginModel.vue').default);
Vue.component('VGHeader', require('./include/GeneralHeader.vue').default);
Vue.component('VFooter', require('./include/Footer.vue').default);
Vue.component('alert', require('./include/alertMessage.vue').default);
Vue.component('partialAlert', require('./include/partialAlert.vue').default);
    // Global registration

const router = new VueRouter({
    base: '/studio/',
    mode: 'history',
    routes, // short for `routes: routes`
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return window.scrollTo({ top: document.querySelector(to.hash).offsetTop, behavior: 'smooth' });
        }
        return window.scrollTo({ top: 0, behavior: 'smooth' });
    }
})
Vue.mixin({
    beforeRouteLeave(to, from, next) {

        if (!to.path.startsWith(from.path) && (from.path != '/availability' && to.path != '/cart' && from.path != '/cart')) {
            this.$destroy();
        }
        next();

    }
});
router.beforeEach((to, from, next) => {
    NProgress.start();

    /*if (!to.matched.length) {
        next('/notFound');
    }*/

    // close menu when change route
    $(".mob-menu").removeClass("open");
    $(".mm-w").hide();




    if (store.getters.isLoggedIn && to.path == '/login') {
        next('/');
        return
    }



    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }

    if (to.matched.some(record => record.meta.onlyOwner)) {
        if (store.getters.isOwner == 1) {
            next();
            return
        }
        next('/');
    }
    if (to.matched.some(record => record.meta.onlyUser)) {
        if (store.getters.isOwner == 0) {
            next();
            return
        }
        next('/');
    }

});

router.afterEach(() => {
    NProgress.done();
})

axios.interceptors.request.use(function(config) {
    // Do something before request is sent
    NProgress.start();
    return config;
}, function(error) {
    // Do something with request error
    NProgress.done();
    return Promise.reject(error);
});

axios.interceptors.response.use(function(response) {
    // Do something with response data
    NProgress.done();
    return response;
}, function(error) {
    // Do something with response error
    NProgress.done();
    if (error.response.status === 401) {
        /* window.axios.defaults.headers.common['Authorization'] = "";
         window.location = '/livestar/login';*/
    } else {
        return Promise.reject(error);
    }
    return Promise.reject(error);
});


// show progressbar on router change/
if (production) {
    Vue.use(VueAnalytics, {
        id: 'G-TFHXB779SF',
        router
    });
}
const app = new Vue({
    el: '#app',
    router,
    store,
    data() {
        return {
            error_message: "",
            success_message: "",
            timeMask: this.timeMasking,
            BASE_PATH: BASE_PATH,
            API_PATH: PRE_API_PATH,
            Bearer: Bearer,
            BASE_API_PATH: API_PATH,

        }
    },
    methods: {
        logout() {
            var redirect = '/';
            this.$store.dispatch('logout').then(() => {

                $('#loginModel').modal('hide');
                 $('.modal-backdrop').remove();
            });
        },

           accountNeeded(action){
               if (action == 'addscreenshots') {
                   this.$confirm( {
                        title: 'Account Needed',
                        message: `You must create an account to upload screenshots for your displayed devices. This is 100% obligation free and does not require any subscriptions, credit card or scary stuff!`,
                        button: {
                          no: 'Cancel',
                          yes: 'Sign me up'
                      },
                      callback: confirm => {
                          if (confirm) {
                              this.$store.commit('set_recent_action',action);
                                this.recent_action = action
                               $('#loginModel').modal('show');
                          }else{

                          }
                      }
                  })
               }else if(action != ''){
                   this.$confirm( {
                        title: 'Account Needed',
                        message: `You must sign in /  sign up for an account to save your progress. Do you want to sign up now?`,
                        button: {
                          no: 'No',
                          yes: 'Yes'
                      },
                      callback: confirm => {
                          if (confirm) {
                            this.$store.commit('set_recent_action',action);
                                this.recent_action = action
                               $('#loginModel').modal('show');
                          }else{

                          }
                      }
                  })
               }else{
                  $('#loginModel').modal('show');
               }
           },
      },
});