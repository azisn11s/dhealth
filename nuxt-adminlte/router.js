import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m)

const routes = [
  {
    path: '/',
    redirect: 'home'
  },
  {
    path: '/home',
		name: 'home',
		component: page('index')
  },
  {
    path: '/login',
    component: page('auth/login')
  },
  {
    path: '/register',
    component: page('auth/register'),
  },
  {
    path: '/forgot',
    component: page('auth/forgot-password')
  },

  // User
  {
    path: '/user',
    name: 'user.index',
    component: page('user/index'),
  },
  {
    path: '/user/create',
    name: 'user.create',
    component: page('user/create')
  },
  // {
  //   path: '/user/:id',
  //   name: 'user.detail',
  //   component: page('user/detail')
  // },
  {
    path: '/user/:id/edit',
    name: 'user.edit',
    component: page('user/edit')
  },

  // Roles
  {
    path: '/roles',
    name: 'role.index',
    component: page('role/index'),
  },
  {
    path: '/roles/create',
    name: 'role.create',
    component: page('role/create'),
  },
  {
    path: '/roles/:id/edit',
    name: 'role.edit',
    component: page('role/edit')
  },
  {
    path: '/roles/:id/features',
    name: 'role.features',
    component: page('role/features')
  },

  // Resep Obat
  {
    path: '/resep',
    name: 'resep.index',
    component: page('resep/index'),
  },
  {
    path: '/resep/create',
    name: 'resep.create',
    component: page('resep/create'),
  },
  

];

export function createRouter() {
  return new Router({
    routes,
    base: process.env.baseRoute || "/",
    mode: 'history',
  })
}
