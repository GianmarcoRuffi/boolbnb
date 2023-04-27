import Vue from 'vue';

import VueRouter from 'vue-router';

Vue.use(VueRouter);
import HomeComponent from './pages/HomeComponent';
import ResearchComponent from './pages/ResearchComponent';
import ApartmentComponent from './pages/ApartmentComponent';

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeComponent
        },
        {
            path: '/research/:userInput',
            name: 'research',
            component: ResearchComponent
        },
        {
            path: '/apartment/:slug',
            name: 'apartment',
            component: ApartmentComponent
        }
    ]

});
export default router;