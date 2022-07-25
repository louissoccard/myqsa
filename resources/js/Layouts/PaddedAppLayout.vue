<template>
    <AppLayout :title="title" :user="user">
        <div class="w-full container mx-auto p-6 md:py-10 md:px-10">
            <slot></slot>
        </div>
    </AppLayout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from "@/Layouts/AppLayout";

export default defineComponent({
    components: {AppLayout},
    props: {
        title: String,
        user: Object,
    },
})
</script>
