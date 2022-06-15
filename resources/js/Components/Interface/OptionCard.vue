<template>
    <Component :is="href ? 'Link' : 'div'" :href="href" class="p-4 bg-gray-100 dark:bg-gray-800 flex items-center justify-between font-bold" :class="{ 'border-2 border-transparent hover:border-blue dark:hover:border-white transition-border-color duration-300 select-none cursor-pointer': href }">
        <slot></slot>
        <Feather icon="users" :size="20" class="ml-2.5" />
    </Component>
</template>

<script>
import {defineComponent} from "vue";
import Feather from "@/Components/Feather";
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    props: {
        href: {
            type: String,
            required: false,
        },
        icon: {
          type: String,
          required: false,
        },
    },

    components: {Link, Feather},

})
</script>
