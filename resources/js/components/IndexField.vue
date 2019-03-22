<template>
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
                <span v-if="valueExist(field.value, option.id)" class="text-left" v-html="labelFor(option)"></span>
            </template>
        </div>
    </div>

    <span v-else class="whitespace-no-wrap text-left">&mdash;</span>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],
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
