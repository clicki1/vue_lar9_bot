import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router';

const routes = [
    {
        path: '/vue',
        component: () => import("./components/Index.vue"),
        name: "base.index",

    },

    //messages
    {
        path: '/vue/messages',
        component: () => import("./components/Message/view/Index.vue"),
        name: "messages.index",
    },
    {
        path: '/vue/messages/create',
        component: () => import("./components/Message/view/Create.vue"),
        name: "messages.create",
    },
    {
        path: '/vue/messages/:id/edit',
        component: () => import("./components/Message/view/Edit.vue"),
        name: "messages.edit",
    },
    {
        path: '/vue/messages/:id',
        component: () => import("./components/Message/view/Show.vue"),
        name: "messages.show",
    },

    //categories
    {
        path: '/vue/categories',
        component: () => import("./components/Category/view/Index.vue"),
        name: "categories.index",
    },
    {
        path: '/vue/categories/create',
        component: () => import("./components/Category/view/Create.vue"),
        name: "categories.create",
    },
    {
        path: '/vue/categories/:id/edit',
        component: () => import("./components/Category/view/Edit.vue"),
        name: "categories.edit",
    },
    {
        path: '/vue/categories/:id',
        component: () => import("./components/Category/view/Show.vue"),
        name: "categories.show",
    },

    //tags
    {
        path: '/vue/tags',
        component: () => import("./components/Tag/view/Index.vue"),
        name: "tags.index",
    },
    {
        path: '/vue/tags/create',
        component: () => import("./components/Tag/view/Create.vue"),
        name: "tags.create",
    },
    {
        path: '/vue/tags/:id/edit',
        component: () => import("./components/Tag/view/Edit.vue"),
        name: "tags.edit",
    },
    {
        path: '/vue/tags/:id',
        component: () => import("./components/Tag/view/Show.vue"),
        name: "tags.show",
    },

    //results
    {
        path: '/vue/results',
        component: () => import("./components/Result/view/Index.vue"),
        name: "results.index",
    },
    {
        path: '/vue/results/create',
        component: () => import("./components/Result/view/Create.vue"),
        name: "results.create",
    },
    {
        path: '/vue/results/:id/edit',
        component: () => import("./components/Result/view/Edit.vue"),
        name: "results.edit",
    },
    {
        path: '/vue/results/:id',
        component: () => import("./components/Result/view/Show.vue"),
        name: "results.show",
    },

    //graphic
    {
        path: '/vue/graphics',
        component: () => import("./components/Graphic/view/Index.vue"),
        name: "graphics.index",
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

export default router;

