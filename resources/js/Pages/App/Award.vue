<template>
    <Head title="Award" />

    <h2 class="font-bold text-2xl mb-4">Your Queen's Scout Award</h2>

    <div class="flex flex-row flex-wrap items-stretch">
        <Card title="Membership" :href="route('award')" progressBarId="membership-progress"
                      :percentage="25"
                      colour="#003982"
                      class="xl:pr-2 mb-4">
            <div>
                You must:
                <ul class="list-square list-outside pl-3.5">
                    <li>Be aged 16 or older to start the award and complete the award before your 25th birthday</li>
                    <li>Be a member of either Explorer Scouts or Scout Network (or a combination of both) for at least
                        18 months
                        to complete the award
                    </li>
                </ul>
            </div>
        </Card>
        <Card title="Nights Away" :href="route('award')" progressBarId="nights-away-progress"
                      :percentage="100"
                      colour="#00a794" class="xl:pl-2 mb-4">
            You must:<br>
            Complete 18 nights away as an Explorer Scout or Scout Network member, of which at least 12 must be camping.
        </Card>
        <Card title="ICV List" :href="route('award')" progressBarId="icv-progress"
                      :percentage="50"
                      colour="#ffb4e5" class="xl:pr-2 mb-4">
            You must:<br>
            Complete six activities in total, two from each topic area of the ICV activities list. A minimum of two must be from the QSA ICV list and the others from any of the QSA, or
            Chief
            Scout Platinum or Diamond ICV lists.
        </Card>
        <Card title="DofE" :href="route('award')" progressBarId="dofe-progress"
                      :percentage="75"
                      colour="#ffe627" class="xl:pl-2 mb-4">
            You must:<br>
            Hold the Gold Duke of Edinburgh's Award.
        </Card>
        <Card title="Presentation" :href="route('award')" progressBarId="presentation-progress"
                      :percentage="0"
                      colour="#7413dc" class="xl:pr-2 mb-4 xl:mb-0">
            You must:<br>
            Make a presentation covering all elements of your award to a suitable audience, with the aim of inspiring
            and motivating others to achieve the award. The presentation should be the final activity you complete.
        </Card>
        <Card title="Sign Off" href="{{ route('award') }}" class="xl:pl-2"></Card>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import Card from "@/Components/Award/Card";

export default defineComponent({
    components: {Head, Card},
})
</script>
