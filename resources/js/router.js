import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import ContactList from './components/ContactList.vue'
import ContactDetails from './components/ContactDetails.vue'
import ContactForm from './components/ContactForm.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        redirect: '/contacts',
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { requiresAuth: false }
    },
    {
        path: '/contacts',
        name: "contact-list",
        component: ContactList,
        meta: { requiresAuth: true }
    },
    {
        path: '/contacts/:id',
        name: 'contact-details',
        component: ContactDetails,
        meta: { requiresAuth: true }
    },
    {
        path: '/contacts/create',
        name: 'contact-create',
        component: ContactForm,
        meta: { requiresAuth: true }
    },
    {
        path: '/contacts/:id/edit',
        name: 'contact-edit',
        component: ContactForm,
        meta: { requiresAuth: true }
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach(async (to, from, next) => {
    // Giriş yapma ve kayıt sayfalarına gidiliyorsa, doğrudan izin ver
    if (to.name === 'login' || to.name === 'register') {
        return next()
    }

    if (to.meta.requiresAuth) {
        try {
            // Kullanıcının oturumunun geçerli olup olmadığını kontrol et
            await axios.get('/user') // `/user` endpointine istek atılır
            next() // Oturum geçerli, devam et
        } catch (error) {
            next({ name: 'login' }) // Oturum geçerli değil, login sayfasına yönlendir
        }
    } else {
        next()
    }
})

export default router