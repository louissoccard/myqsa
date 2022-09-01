<template>
    <Component :is="href ? (normal_link ? 'a' : 'Link') : 'button'" :type="href ? '' : type" class="inline-flex items-center justify-center px-4 py-2 font-bold text-white rounded-none appearance-none focus:outline-none transition" :href="href" :target="target" :data="data">
        <slot></slot>
    </Component>
</template>

<script>
    import { defineComponent } from 'vue'
    import Feather from "@/Components/Feather";
    import {Link} from "@inertiajs/inertia-vue3";

    export default defineComponent({
        components: {Feather, Link},
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            href: {
                type: String,
                required: false,
            },
            normal_link: {
                type: Boolean,
                required: false,
                default: false
            },
            target: {
                type: String,
                required: false,
            },
            data: {
                type: Object,
                required: false,
            }
        }
    })
</script>
