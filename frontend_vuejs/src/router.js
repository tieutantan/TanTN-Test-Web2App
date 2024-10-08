import {createRouter, createWebHistory} from 'vue-router';
import LoginForm from './components/LoginForm.vue';
import RegistrationForm from './components/RegistrationForm.vue';
import HomePage from './components/HomePage.vue';
import DashboardPage from './components/DashboardPage.vue';

const routes = [
    {path: '/', component: HomePage},
    {path: '/login', component: LoginForm},
    {path: '/registration', component: RegistrationForm},
    {path: '/dashboard', component: DashboardPage}
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;