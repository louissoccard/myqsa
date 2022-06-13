<template>
    <div class="text-left" :class="containerClass">
        <div class="flex justify-between">
            <label class="block" :class="{'hidden': hideLabel}" :for="id">{{ label }}</label>
            <Transition enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                <p v-if="saved === true" class="ml-2 text-green">Saved</p>
                <p v-else-if="saved === false" class="ml-2 text-red">Saving Failed</p>
            </Transition>
        </div>
        <textarea :id="id"
                  class="block w-full bg-white dark:bg-gray-800 border-2 border-transparent rounded-none focus:border-navy focus:dark:border-gray-500 focus:outline-none focus:ring-0 px-2 py-1"
                  :class="this.class" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                  :rows="rows" :placeholder="placeholder" ref="textarea"></textarea>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    props: {
        modelValue: String,
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: false,
        },
        class: {
            type: String,
            required: false,
        },
        containerClass: {
            type: String,
            required: false,
        },
        hideLabel: {
            type: Boolean,
            required: false,
            default: false,
        },
        placeholder: {
            type: String,
            required: false,
        },
        saved: {
            type: Boolean,
            required: false,
            default: null,
        },
        rows: {
            type: String,
            required: false,
        }
    },

    emits: ['update:modelValue'],

    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
})
</script>
