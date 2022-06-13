<template>
    <div v-if="hasErrors" class="bg-red text-white p-4">
        <ul class="font-bold list-disc list-inside">
            <li v-for="(error, key) in validationErrors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        errors: {
            type: Object,
            required: false,
            default: null,
        },
    },
    computed: {
        validationErrors() {
            if (this.errors !== null) return this.errors;
            else return this.$page.props.errors;
        },
        hasErrors() {
            if (!this.validationErrors) return false;
            else return Object.keys(this.validationErrors).length > 0;
        },
    }
})
</script>
