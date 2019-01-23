<template>
    <router-link
        v-if="field.value && showAsLink"
        :to="{
            name: 'detail',
            params: {
                resourceName: resourceName,
                resourceId: field.value
            }
        }"
        class="no-underline dim text-primary font-bold"
    >
        {{ parentFieldLabel }}
    </router-link>

    <span v-else-if="field.value && !showAsLink" class="text-left" v-html="nl2br(htmlEncode(parentFieldLabel))"></span>

    <span v-else class="whitespace-no-wrap text-left">&mdash;</span>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],
        computed: {
            parentFieldLabel() {
                if (this.field.config.multiple) {
                    let labels = []

                    this.field.options.forEach((option) => {
                        if (this.field.value.indexOf(option.id) !== -1) {
                            labels.push(option.text)
                        }
                    })
                    return labels.join(',\n')

                } else {
                    let label = ''

                    this.field.options.forEach((option) => {
                        if (option.id === this.field.value) {
                          label = option.text
                        }
                    })

                    return label
                }
            },
            showAsLink() {
                return this.field.showAsLink && !this.field.config.multiple
            }
        },

        methods: {
            htmlEncode (html) {
                let txt = document.createElement("textarea")
                txt.innerHTML = html
                return txt.value
            },

            nl2br (text) {
                return text.replace(/(?:\r\n|\r|\n)/g, '<br>')
            }
        }
    }
</script>
