<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <select
                ref="select2"
                :id="field.attribute"
                :class="errorClasses"
                class="w-full form-control form-input form-input-bordered"
                v-model="value">
                <slot></slot>
            </select>
        </template>
    </default-field>
</template>

<script>
    import 'select2/dist/js/select2.full.min'
    import {FormField, HandlesValidationErrors} from 'laravel-nova'

    export default {
        mixins: [FormField, HandlesValidationErrors],

        props: ['resourceName', 'resourceId', 'field'],

        data() {
            return {
                options: {
                    data: null
                }
            }
        },

        mounted() {
            this.makeSelect2()
        },

        methods: {
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || null
                this.options = this.field.config
                this.options.data = this.field.options
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                formData.append(this.field.attribute, this.value || '')
            },

            /**
             * Update the field's internal value.
             */
            handleChange(value) {
                this.value = value
            },

            makeSelect2() {
                const select2 = $(this.$refs.select2)

                select2
                    .select2(this.options)
                .on('select2:select', e => this.handleChange(e.params.data.id))
                .on('select2:unselect', e => this.handleChange(0))

                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.attributeName === 'class') {
                            let classValue = $(mutation.target).prop(mutation.attributeName)

                            if (classValue.split(' ').includes('border-danger')) {
                                select2.addClass('select2-hidden-accessible')
                                $('.select2-container--default .select2-selection').css('border-color', '#e74444')
                            }
                        }
                    });
                });

                observer.observe(select2[0], {
                    attributes: true
                });
            }
        },
    }
</script>
