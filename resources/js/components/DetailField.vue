<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80">
                    {{ fieldLabel }}
                </h4>
            </slot>
        </div>
        <div class="w-3/4 py-4">
            <slot name="value">
                <router-link
                    v-if="field.value && showAsLink"
                    :to="{
                        name: 'detail',
                        params: {
                            resourceName: field.linkToResource || resourceName,
                            resourceId: field.value
                        }
                    }"
                    class="no-underline dim text-primary font-bold"
                >
                    {{ parentFieldLabel }}
                </router-link>

                <p v-else-if="field.value && !showAsLink" v-html="nl2br(htmlEncode(parentFieldLabel))"></p>

                <p v-else>&mdash;</p>
            </slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
        computed: {
            fieldLabel() {
                return this.fieldName || this.field.name
            },
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
