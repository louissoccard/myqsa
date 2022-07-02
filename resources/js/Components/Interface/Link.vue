<template>
    <a :href="href" class="inline font-bold text-blue dark:text-white hover:underline"><slot></slot></a>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        href: null,
    }
})
</script>
