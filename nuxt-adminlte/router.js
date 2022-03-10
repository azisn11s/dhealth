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

  // Territories
  {
    path: '/territories',
    name: 'territory.index',
    component: page('territory/index'),
  },
  {
    path: '/territories/create',
    name: 'territory.create',
    component: page('territory/create'),
  },
  {
    path: '/territories/:id/edit',
    name: 'territory.edit',
    component: page('territory/edit')
  },

  // Companies
  {
    path: '/companies',
    name: 'company.index',
    component: page('company/index'),
  },
  {
    path: '/companies/create',
    name: 'company.create',
    component: page('company/create'),
  },
  {
    path: '/companies/:id/edit',
    name: 'company.edit',
    component: page('company/edit')
  },

  // Employees
  {
    path: '/employees',
    name: 'employee.index',
    component: page('employee/index'),
  },
  {
    path: '/employees/create',
    name: 'employee.create',
    component: page('employee/create'),
  },
  {
    path: '/employees/:id/edit',
    name: 'employee.edit',
    component: page('employee/edit')
  },

  // Country
  {
    path: '/countries',
    name: 'country.index',
    component: page('country/index'),
  },
  {
    path: '/countries/create',
    name: 'country.create',
    component: page('country/create'),
  },
  {
    path: '/countries/:id/edit',
    name: 'country.edit',
    component: page('country/edit')
  },

  // Region
  {
    path: '/regions',
    name: 'region.index',
    component: page('region/index'),
  },
  {
    path: '/regions/create',
    name: 'region.create',
    component: page('region/create'),
  },
  {
    path: '/regions/:id/edit',
    name: 'region.edit',
    component: page('region/edit')
  },

  // Area
  {
    path: '/areas',
    name: 'area.index',
    component: page('area/index'),
  },
  {
    path: '/areas/create',
    name: 'area.create',
    component: page('area/create'),
  },
  {
    path: '/areas/:id/edit',
    name: 'area.edit',
    component: page('area/edit')
  },

  // Doctor
  {
    path: '/doctors',
    name: 'doctor.index',
    component: page('doctor/index'),
  },
  {
    path: '/doctors/create',
    name: 'doctor.create',
    component: page('doctor/create'),
  },
  {
    path: '/doctors/:id/edit',
    name: 'doctor.edit',
    component: page('doctor/edit')
  },
  {
    path: '/doctors/classifications',
    name: 'doctor.classification.index',
    component: page('doctor/classification/index'),
  },
  {
    path: '/doctors/classifications/create',
    name: 'doctor.classification.create',
    component: page('doctor/classification/create'),
  },
  {
    path: '/doctors/classifications/:id/edit',
    name: 'doctor.classification.edit',
    component: page('doctor/classification/edit')
  },
  {
    path: '/doctors/specialties',
    name: 'doctor.specialty.index',
    component: page('doctor/specialty/index'),
  },
  {
    path: '/doctors/specialties/create',
    name: 'doctor.specialty.create',
    component: page('doctor/specialty/create'),
  },
  {
    path: '/doctors/specialties/:id/edit',
    name: 'doctor.specialty.edit',
    component: page('doctor/specialty/edit')
  },

  // Teams
  {
    path: '/teams',
    name: 'team.index',
    component: page('team/index'),
  },
  {
    path: '/teams/create',
    name: 'team.create',
    component: page('team/create'),
  },
  {
    path: '/teams/:id/edit',
    name: 'team.edit',
    component: page('team/edit')
  }

];

export function createRouter() {
  return new Router({
    routes,
    base: process.env.baseRoute || "/",
    mode: 'history',
  })
}
