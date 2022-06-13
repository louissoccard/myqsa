<template>
    <MainMenuItem :active="active" :href="href" :icon="icon">My Award</MainMenuItem>
    <div v-show="active">
        <slot></slot>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import MainMenuItem from "@/Components/Interface/MainMenuItem";

export default defineComponent({
    components: {MainMenuItem},
    props: {
        active: {
            type: Boolean,
            required: true,
        },
        href: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            required: true,
        }
    }
})
</script>
