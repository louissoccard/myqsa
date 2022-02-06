<template>
    <div class="bg-gray-200 dark:bg-gray-700 p-4 flex items-center">
        <Feather :size="20" :icon="icon" class="mr-4" />
        <p> <slot></slot> </p>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {
        Feather,
    },

    props: {
        icon: {
            type: String,
            required: false,
            default: 'alert-triangle',
        }
    }
})
</script>
