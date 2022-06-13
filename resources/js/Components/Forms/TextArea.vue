<template>
    <div class="text-left" :class="containerClass">
        <label v-if="label" class="block" :for="id">{{ label }}</label>
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
        placeholder: {
            type: String,
            required: false,
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
