import {createWebHistory, createRouter} from "vue-router";

import Home from '../components/Home';
import Company from '../components/Company';
import EditCompany from '../components/EditCompany';
import AddCompany from '../components/AddCompany';
import Employee from '../components/Employee';
import EditEmployee from '../components/EditEmployee';
import AddEmployee from '../components/AddEmployee';
import Login from '../components/Login';
import pagination from 'laravel-vue-pagination';

export const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/home',
    name: 'Home',
    component: Home
  },
  {
    path: '/company',
    name: 'Company',
    component: Company
  },
  {
    path: '/company/add',
    name: 'addcompany',
    component: AddCompany
  },
  {
    path: '/company/:id/edit',
    name: 'editcompany',
    component: EditCompany
  },
  {
    path: '/employees',
    name: 'Employees',
    component: Employee
  },
  {
    path: '/employee/add',
    name: 'addemployee',
    component: AddEmployee
  },
  {
    path: '/employee/:id/edit',
    name: 'editemployee',
    component: EditEmployee
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
