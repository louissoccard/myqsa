<template>
    <div class="relative px-3 text-gray-500 dark:text-gray-400">
        <span v-if="active" class="absolute inset-y-0 left-0 w-1 bg-navy dark:bg-white" aria-hidden="true"></span>
        <div v-if="!icon" class="inline-block" style="width: calc(0.75rem + 18px)">&nbsp;</div>

        <a :href="href" class="flex items-center w-full px-3 select-none font-bold" :class="[link_classes, this.class, paddingY]">
            <Feather v-if="icon" class="inline mr-3" :size="18" :icon="icon"></Feather>
            <slot></slot>
        </a>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Feather from "@/Components/Feather";

export default defineComponent({
    props: {
        active: Boolean,
        href: String,
        icon: String,
        class: String,
        paddingY: {
            type: String,
            required: false,
            default: 'py-3'
        }
    },

    components: {Feather},

    computed: {
        link_classes() {
            if (this.active) return 'text-grey-80 dark:text-grey-5';
            else if (this.href) return 'cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-900';
            else return 'cursor-default';
        }
    }
})
</script>
