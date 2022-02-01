<template>
    <h2 class="font-bold text-xl">Good {{ timeOfDay }}, {{ user.first_name }}</h2>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        user: Object
    },

    computed: {
        timeOfDay() {
            let currentHour = new Date().getHours();

            if (12 <= currentHour && 17 > currentHour) {
                return 'afternoon';
            } else if (17 <= currentHour) {
                return 'evening';
            } else {
                return 'morning';
            }

        }
    }
})
</script>
