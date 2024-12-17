import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {
        path: '/',
        name: 'branch',
        component: () => import("@/views/BranchView.vue"),
      },
      {
        path: '/joinFunctionDisplay',
        name: 'joinFunctionDisplay',
        component: () => import("@/views/JoinFuncDisplay.vue"),
      },
      {
        path: '/store/:storeID',
        name: 'ProductView',
        component: () => import("@/views/ProductView.vue"),
        props: true,
      },
      {
        path: '/purchase/:storeID',
        name: 'purchaseView',
        component: () => import("@/views/PurchaseView.vue"),
      },
      {
        path: '/:pathMatch(.*)*',
        redirect: '/',
      },]
})

export default router