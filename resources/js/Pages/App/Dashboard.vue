<template>
    <Head title="Dashboard" />

    <h2 class="font-bold text-2xl mb-4">Good {{ timeOfDay }}, {{ user.first_name }}</h2>
    <Card title="Queen's Scout Award" :href="route('award.index')" class="mb-4" v-if="user.permissions.includes('qsa.has')">
        <div class="flex flex-row flex-wrap lg:flex-nowrap lg:justify-center items-start mt-8 lg:space-x-6">
            <ProgressBar section="Membership" colour="#003982" class="mb-6 lg:mb-0 sm:pr-3 lg:pr-0"
                                      :percentage="percentages.membership">
                Membership
            </ProgressBar>
            <ProgressBar section="Nights Away" colour="#00a794" class="mb-6 lg:mb-0 sm:pl-3 lg:pr-0"
                                      :percentage="percentages.nights_away">
                Nights Away
            </ProgressBar>
            <ProgressBar section="ICV List" colour="#ffb4e5" class="mb-6 lg:mb-0 sm:pr-3 lg:pr-0"
                                      :percentage="percentages.icv_list">
                ICV
                List
            </ProgressBar>
            <ProgressBar section="DofE" colour="#ffe627" class="mb-6 lg:mb-0 sm:pl-3 lg:pr-0"
                                      :percentage="percentages.dofe">
                DofE
            </ProgressBar>
            <ProgressBar section="Presentation" colour="#7413dc" class="sm:pr-3 lg:pr-0"
                                      :percentage="percentages.presentation">
                Presentation
            </ProgressBar>
        </div>
    </Card>

    <div class="flex flex-col lg:flex-row lg:space-x-4 items-stretch">
        <Card title="To Fill" class="lg:w-1/2 mb-4 lg:mb-0">
        </Card>

        <Card title="Updates & Announcements" class="lg:w-1/2">
            <div class="w-full max-h-60 overflow-auto">
                <Notification :days-past="announcement.daysPast" :colour="announcement.colour" v-for="announcement of announcements">{{ announcement.title }}</Notification>
            </div>
            <div class="w-full text-center" v-if="announcements.length >= 4">
                <Feather :size="18" icon="chevron-down" />
            </div>
        </Card>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import Card from "@/Components/Interface/Card";
import ProgressBar from "@/Components/Dashboard/ProgressBar";
import Notification from "@/Components/Interface/Notification";
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {Head, Notification, ProgressBar, Card, Feather},
    props: {
        user: Object,
        percentages: Object,
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
    },

    data() {
        return {
            announcements: [
                {"title": "Upcoming Maintenance", "daysPast": 0, "colour": "bg-red"},
                {"title": "ICV List Zoom Session", "daysPast": 3, "colour": "bg-green"},
                {"title": "County Kudu 2021", "daysPast": 15, "colour": "bg-green"},
            ],
        }
    },
})
</script>
