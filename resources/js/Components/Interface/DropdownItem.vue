<template>
    <Link :class="[defaultClasses, linkClasses, this.class]" :href="href" v-if="href">
        <Feather v-if="icon" class="inline mr-3" :size="18" :icon="icon"></Feather>
        <slot></slot>
    </Link>
    <div :class="[defaultClasses, this.class]" v-else>
        <Feather v-if="icon" class="inline mr-3" :size="18" :icon="icon"></Feather>
        <slot></slot>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
import Feather from "@/Components/Feather";

export default defineComponent({
    props: {
        href: {
            type: String,
            default: null,
        },
        class: String,
        icon: {
            type: String,
            required: false
        },

    },

    components: { Link, Feather },

    data() {
        return {
            defaultClasses: "px-4 py-2",
            linkClasses: "cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700",
        }
    }
})
</script>
