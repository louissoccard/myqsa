<template>
    <div class="text-left">
        <label class="block" :for="id">{{ label }}</label>
        <div class="flex flex-row">
            <select :id="id"
                    class="appearance-none cursor-pointer block w-full bg-gray-100 dark:bg-gray-800 border-2 border-transparent rounded-none focus:border-navy focus:dark:border-gray-200 focus:outline-none focus:ring-0 px-2 py-1"
                    :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
                <slot></slot>
            </select>
            <svg class="fill-current h-5 w-5 -ml-8 mt-2 pointer-events-none cursor-pointer"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
            </svg>
        </div>
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
        type: String,
        label: {
            type: String,
            required: true,
        },
    },

    emits: ['update:modelValue'],

    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
})
</script>
