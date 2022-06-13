<template>
    <Link :href="href" class="w-full xl:w-1/2">
        <div class="flex flex-col h-full bg-grey-5 dark:bg-gray-900 p-4 border-2 border-transparent hover:border-blue
            transition-border-color duration-300 select-none cursor-pointer">
            <div class="flex justify-between pb-2 mb-4 border-b border-grey-20 dark:border-grey-60">
                <h3 class="text-xl font-bold">{{ title }}</h3>
                <Feather icon="external-link"></Feather>
            </div>

            <div class="flex flex-col sm:flex-row items-center flex-initial gap-4" v-if="progressBarId !== null">
                <div class="w-1/3 flex-shrink-0">
                    <CircularProgressBar :id="progressBarId" :percentage="percentage" :colour="colour"></CircularProgressBar>
                </div>

                <div class="flex-initial">
                    <slot></slot>
                </div>
            </div>
            <div class="w-full" v-else>
                <slot></slot>
            </div>
        </div>
    </Link>
</template>

<script>
import {defineComponent} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
import Feather from "@/Components/Feather";
import CircularProgressBar from "@/Components/Interface/CircularProgressBar";

export default defineComponent({
    components: {Link, Feather, CircularProgressBar},
    props: {
        href: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        progressBarId: {
            type: String,
            required: false,
            default: null,
        },
        percentage: {
            type: Number,
            required: false,
        },
        colour: {
            type: String,
            required: false,
        }
    }
})
</script>
