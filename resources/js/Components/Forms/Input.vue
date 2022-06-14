<template>
    <div class="text-left">
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
        <input :id="id"
               class="block w-full rounded-none border-2 border-transparent focus:border-navy focus:dark:border-gray-500 focus:outline-none focus:ring-0 px-2 py-1 appearance-none"
               :class="[inputClass, bg]" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
               ref="input" :type="type" :placeholder="placeholder">
        <slot></slot>
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
        inputClass: {
            type: String,
            required: false,
            default: '',
        },
        bg: {
          type: String,
          required: false,
          default: 'bg-gray-100 dark:bg-gray-800',
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
