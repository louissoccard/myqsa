<template>
    <Link :href="href" class="inline font-bold text-blue hover:underline"><slot></slot></Link>
</template>

<script>
import {defineComponent} from "vue";
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {Link},
    props: {
        href: null,
    }
})
</script>
