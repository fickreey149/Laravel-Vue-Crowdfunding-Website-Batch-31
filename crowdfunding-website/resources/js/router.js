import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue';
import Donations from './views/Donations.vue';
import Campaigns from './views/Campaigns.vue';
import Campaign from './views/Campaign.vue';
import Social from './views/Social.vue';


Vue.use(Router)

const router = new Router({
    mode : 'history',
    routes : [
        {
            path : '/',
            name : 'home',
            alias : '/home',
            component : Home
        },
        {
            path : '/donations',
            name : 'donations',
            component : Donations
        },
        {
            path : '/campaigns',
            name : 'campaigns',
            component : Campaigns
        },
        {
            path : '/campaign/:id',
            name : 'campaign',
            component : Campaign
        },
        {
            path : '/social/:provider/callback',
            name : 'social',
            component : Social
        },
        {
            path : '*',
            redirect : '/'
        }
    ]
})

export default router