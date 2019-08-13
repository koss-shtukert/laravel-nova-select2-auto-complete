Nova.booting((Vue, router, store) => {
    Vue.component('index-laravel-nova-select2', require('./components/IndexField'))
    Vue.component('detail-laravel-nova-select2', require('./components/DetailField'))
    Vue.component('form-laravel-nova-select2', require('./components/FormField'))
})
