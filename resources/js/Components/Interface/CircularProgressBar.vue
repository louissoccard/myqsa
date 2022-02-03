<template>
    <div class="flex flex-col justify-center items-center" :class="containerClass">
        <div :id="this.id" class="relative max-w-xxs" :class="this.class" :data-percentage="percentage"></div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        id: {
            type: String,
            required: true
        },
        percentage: {
          type: Number,
          required: true,
        },
        colour: {
            type: String,
            default: '#003982',
            required: false,
        },
        containerClass: {
            type: String,
            required: false,
        },
        class: {
            type: String,
            required: false,
        }
    },

    mounted() {
        progressBars['{{ $barId }}'] = window.progressBars.createProgressCircle('#' + this.id, this.colour);
    }
})
</script>
