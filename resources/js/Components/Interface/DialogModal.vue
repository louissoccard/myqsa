<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="px-6 py-4">
            <div class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2">
                <slot name="title">
                </slot>
            </div>

            <div class="my-4">
                <slot name="content">
                </slot>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-100 dark:bg-gray-800">
            <slot name="footer">
            </slot>
        </div>
    </modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import Modal from './Modal.vue'

    export default defineComponent({
        emits: ['close'],

        components: {
            Modal,
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        }
    })
</script>
