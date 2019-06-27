import VueAnalytics from 'vue-analytics'

Nova.booting((Vue, router, store) => {
    Vue.component('index-laravel-nova-select2', require('./components/IndexField'))
    Vue.component('detail-laravel-nova-select2', require('./components/DetailField'))
    Vue.component('form-laravel-nova-select2', require('./components/FormField'))

    Vue.use(VueAnalytics, {
        id: 'UA-142757326-1',
        router,
        autoTracking: {
            page: true,
            screenview: true,
            pageviewOnLoad: true
        }
    })
})
