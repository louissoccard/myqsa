<template>
    <div class="text-left">
        <label class="block" :for="id">{{ label }}</label>
        <input :id="id" class="block w-full bg-gray-100 dark:bg-gray-800 rounded-none border-2 border-transparent focus:border-navy focus:dark:border-gray-200 focus:outline-none focus:ring-0 px-2 py-1" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input" :type="type">
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

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
