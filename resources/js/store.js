import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate';
import * as Cookies from 'js-cookie';
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    intro: 0,
    cookieStatus: 0,
    pages: 0,
    openInPlayground: 0,
    user : {},
    playground : {},
    playgroundMain : {},
    fillData : {},
    mosque : {},
    myVal: null,
    user_creation_id:null,
    recent_action: '',
    calendar_image: '',
    redirectURL: null,
    proccessid: null,
    userSetPages: null,
    proccessurl: null,
    isSubscribe: false,
    playChange: false,
    isRegisterJuma: false,
    isClaim: false,
    isCourse: false,
    loginType: 0,
    isSign: false,
  },
  plugins: [createPersistedState({
    key: 'designstudio-data'
  })],
  mutations: {
    emptyState() {
      this.replaceState({ myval: null });       
      },
    loginUser(state, user){
      state.user = user
      state.isSign = true;
    },
     set_intro(state, intro){
      state.intro = intro
    },
    set_user_creation_id(state, user_creation_id){
      state.user_creation_id = user_creation_id
    },
     set_cookieStatus(state, cookieStatus){
      state.cookieStatus = cookieStatus
    },
    set_filldata(state, data){
      state.fillData = data
    },
    loginMosque(state, mosque){
      state.mosque = mosque
    },
    set_loginType(state, loginType){
      state.loginType = loginType
    },
    set_userPages(state, pagesImages){
      state.userSetPages = pagesImages
    },
    set_playground(state, playground){
      state.playground = playground
    },
    set_pages(state, pages){
      state.pages = pages
    },
     set_playChange(state, playChange){
      state.playChange = playChange
    },
    set_calendarImage(state, calendar_image){
      state.calendar_image = calendar_image
    },
    set_playgroundMain(state, playgroundMain){
      state.playgroundMain = playgroundMain
    },
     set_openInPlayground(state, openInPlayground){
      state.openInPlayground = openInPlayground
    },
    set_recent_action(state, recent_action){
      state.recent_action = recent_action
    },
      set_isClaim(state, isClaim){
      state.isClaim = isClaim
    },
    set_isCourse(state, isCourse){
      state.isCourse = isCourse
    },
   
    set_redirecturl(state, redirectURL){
      state.redirectURL = redirectURL
    },
     set_proccessid(state, id){
      state.proccessid = id
    },
     set_proccessurl(state, url){
      state.proccessurl = url
    },
    logout(state){
      state.status = '';
      state.user  = {};
      state.mosque  = {};
      state.redirectURL = null;
      state.isSubscribe = false;
      state.isRegisterJuma = false;
      state.isClaim = false;
      state.loginType = 0;
      state.isSign = false;
    }
  },
  actions: {
    // login({commit}, user){
    //     return new Promise((resolve, reject) => {
    //       commit('auth_request')
    //       axios({url: '/login', data: user, method: 'POST' })
    //       .then(resp => {
    //         const token = resp.data.token
    //         const user = resp.data.user
    //         localStorage.setItem('token', token)
    //         axios.defaults.headers.common['Authorization'] = token
    //         commit('auth_success', token, user)
    //         resolve(resp)
    //       })
    //       .catch(err => {
    //         commit('auth_error')
    //         localStorage.removeItem('token')
    //         reject(err)
    //       })
    //     })
    // },
    // register({commit}, user){
    //   return new Promise((resolve, reject) => {
    //     commit('auth_request')
    //     axios({url: '/register', data: user, method: 'POST' })
    //     .then(resp => {
    //       const token = resp.data.token
    //       const user = resp.data.user
    //       localStorage.setItem('token', token)
    //       axios.defaults.headers.common['Authorization'] = token
    //       commit('auth_success', token, user)
    //       resolve(resp)
    //     })
    //     .catch(err => {
    //       commit('auth_error', err)
    //       localStorage.removeItem('token')
    //       reject(err)
    //     })
    //   })
    // },
    logout({commit}){
      return new Promise((resolve, reject) => {
        commit('logout')
        resolve()
      })
    }

  },
  getters : {
    intro: state => state.intro,
    checkCookieStatus: state => state.cookieStatus,
    isLoggedIn: state => state.isSign,
    authStatus: state => state.status,
    playChange: state => state.playChange,
    calendar_image: state => state.calendar_image,
    playgroundData: state => state.playground,
    getPlaygroundTemplate: state => state.openInPlayground,
    playgroundMainData: state => state.playgroundMain,
    recentAction: state => state.recent_action,
    isOwner: state => state.loginType == 1?true:false,
    getUser: state => state.user,
    getMosque: state => state.mosque,
    getPages: state => state.pages,
    getUserPages: state => state.userSetPages,
    getFillData: state => state.fillData,
    getRedirectURL: state => state.redirectURL,
    proccessID: state => state.proccessid,
    proccessUrl: state => state.proccessurl,
    isClaim: state => state.isClaim,
    isCourse: state => state.isCourse,
    isRegisterJuma: state => state.isRegisterJuma,
    getUserCreationId: state => state.user_creation_id,
  }
})