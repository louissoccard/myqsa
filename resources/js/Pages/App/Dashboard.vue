<template>
    <Head title="Dashboard" />

    <h2 class="font-bold text-2xl mb-4">Good {{ timeOfDay }}, {{ user.first_name }}</h2>
    <Card title="Queen's Scout Award" :href="route('award')" class="mb-4" v-if="user.permissions.includes('qsa.has')">
        <div class="flex flex-row flex-wrap lg:flex-nowrap lg:justify-center items-start mt-8 lg:space-x-6">
            <ProgressBar section="Membership" colour="#003982" class="mb-6 lg:mb-0 sm:pr-3 lg:pr-0"
                                      :percentage="25">
                Membership
            </ProgressBar>
            <ProgressBar section="Nights Away" colour="#00a794" class="mb-6 lg:mb-0 sm:pl-3 lg:pr-0"
                                      :percentage="100">
                Nights Away
            </ProgressBar>
            <ProgressBar section="ICV List" colour="#ffb4e5" class="mb-6 lg:mb-0 sm:pr-3 lg:pr-0"
                                      :percentage="50">
                ICV
                List
            </ProgressBar>
            <ProgressBar section="DofE" colour="#ffe627" class="mb-6 lg:mb-0 sm:pl-3 lg:pr-0"
                                      :percentage="75">
                DofE
            </ProgressBar>
            <ProgressBar section="Presentation" colour="#7413dc" class="sm:pr-3 lg:pr-0"
                                      :percentage="0">
                Presentation
            </ProgressBar>
        </div>
    </Card>

    <div class="flex flex-col lg:flex-row lg:space-x-4 items-stretch">
        <Card title="My Notes" class="lg:w-1/2 mb-4 lg:mb-0">
            <form class="flex flex-col items-end flex-1 py-4" @submit.prevent="submit">
                <TextArea id="notes" container-class="flex w-full flex-1" class="flex-1 resize-none overflow-y-auto min-h-28 dark:bg-gray-700" v-model="form.notes"></TextArea>
                <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened text-sm w-24 mt-2"
                        :disabled="form.processing" :loading="form.processing">Save
                </Button>
            </form>
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
import TextArea from "@/Components/Forms/TextArea";
import Button from "@/Components/Buttons/Button";
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {Head, Button, TextArea, Notification, ProgressBar, Card, Feather},
    props: {
        user: Object,
        notes: String,
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
            form: this.$inertia.form({
                notes: this.notes,
            }),

            announcements: [
                {"title": "Upcoming Maintenance", "daysPast": 0, "colour": "bg-red"},
                {"title": "ICV List Zoom Session", "daysPast": 3, "colour": "bg-green"},
                {"title": "County Kudu 2021", "daysPast": 15, "colour": "bg-green"},
                ],
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('dashboard.save-notes'));
        }
    }
})
</script>
