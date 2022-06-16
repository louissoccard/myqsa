<template>
    <a class="flex flex-row justify-between items-center hover:bg-gray-200 dark:hover:bg-gray-800 cursor-pointer px-4 py-2">
        <div class="inline-block">
            <div>
                <h4 class="text-lg">{{ title }}</h4>
            </div>
            <p class="font-light text-sm">{{ description }}</p>
        </div>
        <Feather icon="chevron-right" :size="18" />
    </a>
</template>

<script>
import {defineComponent} from "vue";
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {Feather},
    props: {
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: true,
        },
    },
})
</script>
