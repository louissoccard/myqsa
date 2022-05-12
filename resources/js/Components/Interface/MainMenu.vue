<template>
    <div>
        <MainMenuItem :active="route().current('dashboard')" :href="route('dashboard')" icon="layout">Dashboard
        </MainMenuItem>
        <MainMenuItem :active="route().current('award')" :href="route('award')" icon="award">My Award</MainMenuItem>
        <MainMenuItem :active="false" :href="route('dashboard')" icon="users">My Participants</MainMenuItem>
        <MainMenuItem :active="false" :href="route('dashboard')" icon="grid">Admin Centre</MainMenuItem>

        <div class="w-full my-3 px-3">
            <div class="w-full h-0.5 border-b border-gray-200 dark:border-gray-700"></div>
        </div>

        <MainMenuItem :active="false" :href="route('dashboard')" icon="help-circle" padding-y="py-2"
                      class="font-bold">Help
        </MainMenuItem>
        <MainMenuItem :active="false" :href="route('dashboard')" icon="inbox" padding-y="py-2" class="font-bold">
            Feedback
        </MainMenuItem>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import MainMenuItem from "@/Components/Interface/MainMenuItem";

export default defineComponent({
    components: {MainMenuItem}
})
</script>
