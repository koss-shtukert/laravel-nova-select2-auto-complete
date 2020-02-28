<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <select
                    ref="select2"
                    :id="field.attribute"
                    :class="classList"
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
    import isEmpty from '../helpers'

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
        computed: {
            classList() {
                return [this.errorClass].push('select2-hidden-accessible')
            }
        },
        mounted() {
            this.makeSelect2()
        },
        beforeDestroy() {
            this.destroySelect2()
        },
        watch: {
            errorClasses(value) {
                const select2 = $(this.$refs.select2)

                select2.parent().find('.select2-container--default .select2-selection').css('border-color', '#bacad6')

                if (value.includes('border-danger')) {
                    select2.parent().find('.select2-container--default .select2-selection').css('border-color', '#e74444')
                }
            }
        },
        methods: {
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.getValue()
                this.options = this.field.config
                this.options.data = this.field.options.map(option => {
                    if (this.options.optgroup) {
                        option.children.map(children => {
                            children.selected = this.options.multiple ? this.value.indexOf(children.id) !== -1 : this.value === children.id

                            return children
                        })
                    }

                    option.selected = this.options.multiple ? this.value.indexOf(option.id) !== -1 : this.value === option.id

                    return option
                })
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
                if (this.options.multiple) {
                    value = isNaN(value) ? value : value * 1 // If number passed as string, convert to number
                    const index = this.value.indexOf(value)

                    if (index === -1) {
                        this.value.push(value)
                    } else {
                        this.value.splice(index, 1)
                    }
                } else {
                    this.value = value
                }
            },

            makeSelect2() {
                const select2 = $(this.$refs.select2)

                select2
                    .select2(this.options)
                    .on('select2:select', e => this.handleChange(e.params.data.id))
                    .on('select2:unselect', e => {
                        if (this.options.multiple) {
                            this.handleChange(e.params.data.id)
                        } else {
                            this.handleChange(0)
                        }
                    })

                // This is necessary to get a multiselect to show its selected values on initialization
                if (this.options.multiple) {
                    select2.val(this.value).trigger('change')
                }
            },

            destroySelect2() {
                const select2 = $(this.$refs.select2)

                select2.select2('destroy')
            },

            /**
             * @returns {*}
             */
            getValue() {
                let value = this.__composeValue(this.field.value)
                let defaultValue = this.field.config.defaultValue ? (this.field.config.multiple ? this.field.config.defaultValue : this.field.config.defaultValue[0]) : (this.field.config.multiple ? [] : null)

                return value.length ? this.field.value : defaultValue
            },

            /**
             * @param value
             * @returns {[]}
             * @private
             */
            __composeValue(value) {
                let composedValue = []

                if (Array.isArray(value)) {
                    composedValue = value
                } else {
                    if (!isEmpty(value)) {
                        composedValue = [value]
                    }
                }

                return composedValue
            }
        },
    }
</script>
