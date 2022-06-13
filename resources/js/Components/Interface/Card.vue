<template>
    <Component :is="href ? 'Link' : 'div'" :href="href" class="flex flex-1 flex-col w-full p-4 bg-gray-100 dark:bg-gray-900" :class="[{ 'border-2 border-transparent hover:border-blue transition-border-color duration-300 select-none cursor-pointer': href }, this.class]">
        <div class="flex items-center justify-between mb-0.5 pb-2 border-b border-grey-20 dark:border-grey-60">
            <h3 class="text-xl font-bold">{{ title }}</h3>
            <Feather v-if="href" class="ml-1" icon="external-link" />
            <slot name="header-content" v-else></slot>
        </div>
        <p v-if="description" class="mt-2 mb-4">{{ description }}</p>
        <slot></slot>
    </Component>
</template>

<script>
import {defineComponent} from "vue";
import {Link} from '@inertiajs/inertia-vue3';
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {Link, Feather},
    props: {
        href: {
            type: String,
            required: false,
        },
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: false,
        },
        class: {
            type: String,
            required: false,
        }
    },
})
</script>
