<template>
    <a class="flex flex-row justify-between items-center hover:bg-gray-200 dark:hover:bg-gray-900 cursor-pointer px-4 py-2">
        <div class="inline-block">
            <div>
                <h4 class="text-lg"><slot></slot></h4>
            </div>
            <p class="font-light text-sm">{{ daysPastString }}</p>
        </div>
        <span class="w-2 h-2" :class="colour"></span>
    </a>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        daysPast: {
            type: Number,
            required: true,
        },
        colour: {
            type: String,
            required: false,
            default: "bg-navy",
        }
    },

    computed: {
        daysPastString() {
           if (this.daysPast === 0) {
               return "Today";
           } else {
               return this.daysPast + " days ago";
           }
        }
    }
})
</script>
