<template>
    <div class="relative px-3 text-gray-500 dark:text-gray-400">
        <span v-if="active" class="absolute inset-y-0 left-0 w-1 dark:bg-white" :class="activeColourClass" aria-hidden="true"></span>
        <Link :href="href" class="flex items-center w-full px-3 select-none" :class="[link_classes, this.class, paddingY]">
            <slot></slot>
        </Link>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Feather from "@/Components/Feather";
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    props: {
        active: Boolean,
        activeColourClass: {
            type: String,
            required: false,
            default: 'bg-navy',
        },
        href: String,
        class: String,
        paddingY: {
            type: String,
            required: false,
            default: 'py-1'
        }
    },

    components: {Feather, Link},

    computed: {
        link_classes() {
            if (this.active) return 'text-grey-80 dark:text-grey-5 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800';
            else if (this.href) return 'cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800';
            else return 'cursor-default';
        }
    }
})
</script>
