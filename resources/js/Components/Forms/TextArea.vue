<template>
    <div class="text-left" :class="containerClass">
        <div class="flex justify-between relative">
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
        <textarea :id="id"
                  class="block w-full border-2 border-transparent rounded-none focus:border-navy focus:dark:border-gray-500 focus:outline-none focus:ring-0 px-2 py-1"
                  :class="[this.class, bg]" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                  :rows="rows" :placeholder="placeholder" :maxlength="characterLimit" ref="textarea"></textarea>
        <p class="text-sm text-right w-full py-1 px-2 bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700" v-if="characterLimit">{{ modelValue.length }}/{{ characterLimit }}</p>
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
        bg: {
          type: String,
          required: false,
          default: 'bg-gray-100 dark:bg-gray-800',
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
        },
        characterLimit: {
            type: Number,
            required: false,
            default: null,
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
    },
})
</script>
