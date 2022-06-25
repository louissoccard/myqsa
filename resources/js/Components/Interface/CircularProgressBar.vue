<template>
    <div class="flex flex-col justify-center items-center" :class="containerClass">
        <div :id="this.id" class="relative max-w-xxs" :class="this.class"></div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import ProgressBar from "progressbar.js";

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

    data() {
        return {
            bar: null
        }
    },

    mounted() {
        this.bar = new ProgressBar.Circle('#' + this.id, {
            color: this.colour,
            strokeWidth: 6,
            easing: 'easeInOut',
            trailColor: 'currentColor',
            trailWidth: 2,
            text: {
                value: 0,
                style: {
                    // Text color.
                    // Default: same as stroke color (options.color)
                    color: 'unset',
                    'font-weight': '700',
                    position: 'absolute',
                    left: '50%',
                    top: '50%',
                    padding: 0,
                    margin: 0,
                    // You can specify styles which will be browser prefixed
                    transform: {
                        prefix: true,
                        value: 'translate(-50%, -50%)'
                    }
                },
            },

            duration: 1200,
            step: function (state, circle) {
                if (circle.text !== null) {
                    circle.text.innerHTML = Math.floor(circle.value() * 100) + '%';
                }
            }
        });

        const text = document.querySelector('#' + this.id + ' .progressbar-text');
        text.classList.add('text-grey-80');
        text.classList.add('dark:text-grey-5');
        text.classList.add('md:text-lg');

        const svg = document.querySelector('#' + this.id + ' svg');
        svg.classList.add('text-grey-20');
        svg.classList.add('dark:text-grey-60');

        if (this.percentage === null || this.percentage === undefined) this.bar.animate(0.009);
        else this.setPercentage(this.percentage);
    },

    methods: {
        setPercentage(percentage) {
            if (this.bar !== null) {
                this.bar.animate(Math.min(1, (percentage / 100) + 0.009));
            }
        }
    },

    watch: {
        percentage(newPercentage) {
            this.setPercentage(newPercentage);
        }
    },
})
</script>
