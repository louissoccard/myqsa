<template>
    <div class="flex flex-row lg:flex-col lg:justify-center items-center w-full sm:w-1/2 lg:w-auto" :class="this.class">
        <CircularProgressBar :id="sectionId" :colour="colour" :percentage="percentage" class="w-20 lg:w-auto" />
        <h5 class="ml-4 lg:ml-0 lg:mt-4">{{ section }}</h5>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import CircularProgressBar from "@/Components/Interface/CircularProgressBar";

export default defineComponent({
    components: {CircularProgressBar},

    props: {
        section: {
            type: String,
            required: true,
        },
        percentage: {
            type: Number,
            required: true,
        },
        colour: {
            type: String,
            required: false,
            default: "#003982",
        },
        class: {
            type: String,
            required: false,
            default: "",
        }
    },

    computed: {
        sectionId() {
            return this.section.toLowerCase().replace(' ', '-');
        }
    }
})
</script>
