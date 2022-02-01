<template>
    <span v-html="svg_template" class="inline-flex justify-center items-center" :class="this.class" :style="'width: ' + size + 'px; height: ' + size + 'px;'"></span>
</template>

<script>
import {defineComponent} from "vue";
const feather = require('feather-icons');

export default defineComponent({
    mounted() {
        this.svg_template = feather.icons[this.icon].toSvg({ 'class': this.svgClass, 'width': this.size, 'height': this.size });
    },

    data() {
        return {
            svg_template: ""
        }
    },

    props: {
        class: {
            type: String,
            default: "",
            required: false,
        },
        svgClass: {
            type: String,
            default: "",
            required: false,
        },
        icon: {
            type: String,
            required: true,
        },
        size: {
            type: Number,
            required: false,
            default: 24
        }
    },
})
</script>
