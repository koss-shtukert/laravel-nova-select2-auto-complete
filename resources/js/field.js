Nova.booting((Vue, router) => {
    Vue.component('index-select2', require('./components/IndexField'));
    Vue.component('detail-select2', require('./components/DetailField'));
    Vue.component('form-select2', require('./components/FormField'));
})
