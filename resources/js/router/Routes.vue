<script>
export default [
	  { 
			path: '/design',
			component: require('./../components/LandingPage.vue').default,
	  },
	  { 
			path: '/tools',
			component: require('./../components/LandingPage.vue').default,
	  },
	  { 
			path: '/',
			name: 'main',
			component: require('./../components/LandingPage.vue').default,
	  },
      { 
	  	path: '/playground/:slug',
	  	component: require('./../components/playground.vue').default,
	  },
	  { 
	  	path: '/playground/:slug/:editId',
	  	component: require('./../components/playground.vue').default,
	  },
	  { 
	  	path: '/template/:slug',
	  	component: require('./../components/template-detail.vue').default,
	  },
	  { 
	  	path: '/oss/:slug',
	  	component: require('./../components/oss.vue').default,
	  },
	  { 
	  	path: '/highlight/:slug',
	  	component: require('./../components/highlight.vue').default,
	  },
	  
	  { 
	  	path: '/design/:slug',
	  	name: 'poster-maker',
	  	component: require('./../components/poster-maker.vue').default,
	  },
	  { 
	  	path: '/service-order-detail/:id',
	  	name: 'service-order-detail',
	  	component: require('./../components/service-order-detail.vue').default,
	  },
	  { 
	  	path: '/user-creation-detail/:id',
	  	name: 'user-creation-detail',
	  	component: require('./../components/user-creation-detail.vue').default,
	  },
	  { 
	  	path: '/poster-templates/:type/:slug',
	  	name: 'poster-templates',
	  	component: require('./../components/poster-templates.vue').default,
	  },
	  { 
	  	path: '/business-cards-generator/:slug',
	  	name: 'business-cards-generator',
	  	component: require('./../components/business-cards-generator.vue').default,
	  },
	  { 
	  	path: '/templates',
	  	name: 'templates',
	  	component: require('./../components/templates.vue').default,
	  },
	  { 
			path: '/final-service-book',
			component: require('./../components/final-service-book.vue').default,
	  },

	  ];
	  </script>