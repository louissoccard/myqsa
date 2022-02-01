<template>
    <div v-if="hasErrors" class="bg-red text-white p-4">
        <ul class="font-bold list-disc list-inside">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    computed: {
        errors() {
            return this.$page.props.errors
        },

        hasErrors() {
            return Object.keys(this.errors).length > 0;
        },
    }
})
</script>
