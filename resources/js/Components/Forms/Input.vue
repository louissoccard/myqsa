<template>
    <div class="text-left">
        <div class="relative flex justify-between">
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
            <div v-if="!!this.$slots.tooltip">
                <span class="text-blue dark:text-white font-bold text-sm hover:underline cursor-pointer" ref="tooltipLabel"
                      @click.prevent="tooltipLabelClick"><slot name="tooltip-label"></slot></span>
                <Transition enter-active-class="ease-out duration-300"
                            enter-from-class="opacity-0"
                            enter-to-class="opacity-100"
                            leave-active-class="ease-in duration-200"
                            leave-from-class="opacity-100"
                            leave-to-class="opacity-0">
                    <div class="absolute left-2 right-2 top-8 bg-white dark:bg-black shadow-md p-4 z-50 max-w-md"
                         v-show="tooltipVisible" ref="tooltip">
                        <slot name="tooltip"></slot>
                    </div>
                </Transition>
            </div>
        </div>
        <input :id="id"
               class="block w-full rounded-none border-2 border-transparent focus:border-navy focus:dark:border-gray-500 focus:outline-none focus:ring-0 px-2 py-1 appearance-none"
               :class="[inputClass, bg]" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
               ref="input" :type="type" :placeholder="placeholder" :disabled="disabled">
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
        },
        disabled: {
            type: String,
            required: false,
        }
    },

    emits: ['update:modelValue'],

    data() {
        return {
            tooltipVisible: false,
        }
    },

    mounted() {
        document.addEventListener('click', this.closeOnEscape);
        document.addEventListener('keydown', this.closeOnEscape);
    },

    unmounted() {
        document.removeEventListener('keydown', this.closeOnEscape);
    },

    methods: {
        focus() {
            this.$refs.input.focus()
        },
        tooltipLabelClick() {
            this.tooltipVisible = !this.tooltipVisible;

            if (this.tooltipVisible === true) {
                this.$refs.tooltip.focus();
            }
        },
        closeOnEscape(event) {
            if (((event.type === "keydown" && event.key === 'Escape') || (event.type === "click" && event.target !== this.$refs.tooltipLabel)) && this.tooltipVisible) {
                this.tooltipVisible = false;
            }
        }
    }
})
</script>
