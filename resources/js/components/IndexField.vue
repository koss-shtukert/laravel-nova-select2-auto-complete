<template>
    <div v-if="!isEmpty(field.value)">
        <div v-for="option in field.options">
            <template v-if="field.config.optgroup">
                <div v-for="children in option.children">
                    <template v-if="field.showAsLink">
                        <router-link
                                v-if="valueExist(field.value, children.id)"
                                :to="{
                            name: 'detail',
                            params: {
                                resourceName: field.linkToResource || resourceName,
                                resourceId: children.id
                            }
                        }"
                                class="no-underline dim text-primary font-bold"
                        >
                            {{ labelFor(children.text) }}
                        </router-link>
                    </template>
                    <template v-else>
                        <span v-if="valueExist(field.value, children.id)" class="text-left" v-html="labelFor(children.text)"></span>
                    </template>
                </div>
            </template>
            <template v-else>
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
                    <span v-if="valueExist(field.value, option.id)" class="text-left" v-html="labelFor(option.text)"></span>
                </template>
            </template>
        </div>
    </div>

    <span v-else class="whitespace-no-wrap text-left">&mdash;</span>
</template>

<script>
    import isEmpty from '../helpers'

    export default {
        props: ['resourceName', 'field'],
        methods: {
            labelFor(text) {
                return text.replace(/(?:\r\n|\r|\n)/g, ' ')
            },
            valueExist(fieldValue, optionValue) {
                fieldValue = Array.isArray(fieldValue) ? fieldValue : [fieldValue]

                return fieldValue.indexOf(optionValue) !== -1
            },
            isEmpty(value) {
                return isEmpty(value)
            }
        }
    }
</script>
