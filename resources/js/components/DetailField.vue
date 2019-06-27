<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80">
                    {{ field.name }}
                </h4>
            </slot>
        </div>
        <div class="w-3/4 py-4">
            <slot name="value">
                <div v-if="field.value">
                    <div v-for="option in field.options">
                        <template v-if="field.showAsLink">
                            <router-link
                                v-if="valueExist(field.value, option.id)"
                                :to="{
                                        name: 'detail',
                                        params: {
                                            resourceName: field.linkToResource || resourceName,
                                            resourceId: option.id
                                        }
                                    }"
                                class="no-underline dim text-primary font-bold"
                            >
                                {{ labelFor(option.text) }}
                            </router-link>
                        </template>
                        <template v-else>
                            <p v-if="valueExist(field.value, option.id)" class="text-left" v-html="labelFor(option.text)"></p>
                        </template>
                    </div>
                </div>
                <p v-else>&mdash;</p>
            </slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
        mounted() {
            this.$ga.page('/detail')
        },
        methods: {
            labelFor(text) {
                return text.replace(/(?:\r\n|\r|\n)/g, ' ')
            },
            valueExist(fieldValue, optionValue) {
                fieldValue = Array.isArray(fieldValue) ? fieldValue : [fieldValue]

                return fieldValue.indexOf(optionValue) !== -1
            }
        }
    }
</script>
