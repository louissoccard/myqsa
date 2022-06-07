<template>
    <Component :is="href ? 'Link' : 'div'" class="relative" :href="href">
        <div v-if="!icon" class="inline-block" style="width: calc(0.75rem + 18px)">&nbsp;</div>

        <div class="flex items-center w-full px-3 select-none cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700" :class="[this.class, paddingY]">
            <Feather v-if="icon" class="inline mr-3" :size="18" :icon="icon"></Feather>
            <slot></slot>
        </div>
    </Component>
</template>

<script>
import {defineComponent} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
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

    components: {Link, Feather},
})
</script>
