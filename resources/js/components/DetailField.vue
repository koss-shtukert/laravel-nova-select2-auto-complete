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
                    v-if="field.value"
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
                let label = ''

                this.field.options.forEach((option) => {
                    if (option.id === this.field.value) {
                        label = option.text
                    }
                })

                return label
            },
        }
    }
</script>
