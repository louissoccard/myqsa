<template>
    <button :type="type" class="inline-flex items-center justify-center px-4 py-2 font-bold text-white focus:outline-none transition">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'
    import Feather from "@/Components/Feather";

    export default defineComponent({
        components: {Feather},
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
