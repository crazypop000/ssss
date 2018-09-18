
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import router from './router/routes'
import VueResource from 'vue-resource'
import Layouts from './components/layouts'
import Buefy from 'buefy'
import 'buefy/lib/buefy.css'

Vue.use(VueResource)
Vue.use(Layouts)
Vue.use(Buefy)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router,
    data: {
    	isSidebarOpen: true,
	    showLoading: false,
	    currentUser: {}
    },
    created() {
    	this.getCurrentUser()
    },
    methods: {
    	getCurrentUser() {
    		this.$http.get('/currentUser')
				.then(response => {
					this.currentUser = response.body
				}, error => {
					console.log(error)
				})
    	}
    }
});

