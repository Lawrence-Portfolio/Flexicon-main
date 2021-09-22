import Vue from 'vue'
import VueRouter from 'vue-router'
    Vue.use(VueRouter)

import Step1 from '../components/pages/Step-1'
import Step2 from '../components/pages/Step-2'
import Step3 from '../components/pages/Step-3'
import Step4 from '../components/pages/Step-4'

import Substep1 from '../components/pages/Substep-1'
import Substep2 from '../components/pages/Substep-2'

const routes = [
    { 
        path: '/',
        name: 'Step-1',
        component: Step1
    },
    { 
        path: '/step-2',
        name: 'Step-2',
        component: Step2
    },
    { 
        path: '/step-3',
        name: 'Step-3',
        component: Step3
    },
    { 
        path: '/step-4',
        name: 'Step-4',
        component: Step4
    },
    { 
        path: '/substep-1',
        name: 'Substep-1',
        component: Substep1
    },
    { 
        path: '/substep-2',
        name: 'Substep-2',
        component: Substep2
    }
]

const router = new VueRouter({ routes })

export default router