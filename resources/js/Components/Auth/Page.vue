<template>
    <div class="flex items-center justify-center w-screen h-full bg-gray-100 dark:bg-black p-4">
        <div class="flex flex-col items-center w-full max-w-md bg-white dark:bg-gray-800 shadow-md px-8 sm:px-16 py-8">
            <Logo width="w-40" class="mb-8 max-h-20" />
            <slot></slot>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Logo from "@/Components/Logo";

export default defineComponent({
    components: {Logo},
})
</script>
