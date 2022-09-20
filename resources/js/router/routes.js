import auth from './middleware/auth';
import unauthorized from "./middleware/unauthorized"

const routes = [
    {
        path: '/login',
        name: 'Login',
        meta: {
            middleware: unauthorized
        },
        component: () => import('../pages/login')
    },
    {
        path: '/',
        name: 'Home',
        meta: {
            middleware: auth
        },
        component: () => import('../pages/index')
    },
    {
        path: '/search',
        name: 'Search',
        meta: {
            middleware: auth
        },
        component: () => import('../pages/search')
    },
    {
        path: '/books/create',
        name: 'CreateBook',
        meta: {
            middleware: auth
        },
        component: () => import('../pages/createBook')
    },
]

export default routes
