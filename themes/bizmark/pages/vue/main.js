import Vue from 'vue'
import App from './App' 
// import vClickOutside from 'v-click-outside'
import router from './router/index'
import Vuelidate from 'vuelidate'
 

// Vue.use(vClickOutside)
Vue.use(Vuelidate)

Vue.config.productionTip = false

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')