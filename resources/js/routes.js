const Welcome = () => import('./components/Welcome.vue')
const PropertyList = () => import('./components/property/AllProperty.vue') 
const PropertyCreate = () => import('./components/property/AddProperty.vue') 
const PropertyEdit = () => import('./components/property/EditProperty.vue') 

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Welcome
    },
    {
        name: 'propertyList',
        path: '/property',
        component: PropertyList
    },
    {
        name: 'propertyEdit',
        path: '/property/:id/edit',
        component: PropertyEdit
    },
    {
        name: 'propertyAdd',
        path: '/property/add',
        component: PropertyCreate
    }
]