import Vue from 'vue';
import VueRouter from 'vue-router';
import Routes from './routes';

Vue.use(VueRouter);

export default new VueRouter({
    routes: Routes,
    mode: 'history'
});