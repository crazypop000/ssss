import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
    // base: '/app',
    linkActiveClass: 'active',
	routes: [
	    // { path: '/', redirect: '/pages' },
	    {
	      path: '/',
	      name: 'search',
	      component: require('../components/pages/Search.vue')
	    },
	    // {
	    //   path: '/',
	    //   name: 'dashboard',
	    //   component: require('../components/pages/Dashboard.vue')
	    // },
	    {
	      path: '/materials',
	      name: 'materials',
	      component: require('../components/pages/materials/Materials.vue')
	    },
	    {
	      path: '/user-management',
	      name: 'user_management',
	      component: require('../components/pages/users/UserManagement.vue')
	    },
	    {
	      path: '/tools',
	      name: 'tools',
	      component: require('../components/pages/tools/Tool.vue')
	    }
    ]
})

router.beforeEach((to, from, next) => {
    if (!to.matched.length && to.fullPath !== '/login') {
        router.back()
    } else {
        next();
    }
})

export default router