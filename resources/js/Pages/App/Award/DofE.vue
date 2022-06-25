<template>
    <Head>
        <title>DofE</title>
    </Head>
    <RequirementPage title="Duke of Edinburgh's Award" alt-title="DofE" accent="yellow"
                     :progress-percentage="progressPercentage"
                     :progress-message="progressMessage"
                     :completion-message="completionMessage">
        <template #description>
            <p>
                You must:<br>
                Hold the Gold Duke of Edinburgh's Award.
            </p>
        </template>

        <p class="mb-4">Enter the dates below so that myQSA can calculate your membership length. Leave the field blank
            if it does not apply to you. The system will only calculate your progress once you enter your date of
            birth.</p>
        <div class="flex flex-col space-y-4 max-w-md">
            <Select id="dofe-organisation" label="Who did you complete your DofE with?" class="w-full"
                    v-model="completedWith.value" :saved="completedWith.saved" @change="selectOrgChanged">
                <option value="null">Select...</option>
                <option>Hampshire Scouts</option>
                <option value="">Other</option>
            </Select>
            <div class="w-full space-y-3" v-if="completedWith.value === ''">
                <Input id="organisation" label="Licenced Organisation" placeholder="Your School, Centre, etc."
                       :saved="organisation.saved" v-model="organisation.value" @focusout="submit(organisation)"/>
                <Input id="number" label="eDofE Number" placeholder="123456"
                       :saved="number.saved" v-model="number.value" @input="submit(number)"/>
                <Input id="completion-date" label="Completion Date" placeholder="dd/mm/yyyy"
                       :saved="completionDate.saved" v-model="completionDate.value"
                       @input="submit(completionDate)"/>
            </div>
        </div>
        <div class="border-t border-gray-300 dark:border-gray-700 mt-4 pt-4 grid sm:grid-cols-2 gap-x-4 gap-y-3 sm:gap-y-2">
            <Select id="dofe-volunteering" label="Volunteering" class="w-full"
                    v-model="volunteering.value" :saved="volunteering.saved" @change="submit(volunteering)">
                <option>Not Started</option>
                <option>In Progress</option>
                <option>Complete</option>
            </Select>
            <Select id="dofe-physical" label="Physical" class="w-full"
                    v-model="physical.value" :saved="physical.saved" @change="submit(physical)">
                <option>Not Started</option>
                <option>In Progress</option>
                <option>Complete</option>
            </Select>
            <Select id="dofe-skills" label="Skills" class="w-full"
                    v-model="skills.value" :saved="skills.saved" @change="submit(skills)">
                <option>Not Started</option>
                <option>In Progress</option>
                <option>Complete</option>
            </Select>
            <Select id="dofe-expedition" label="Expedition" class="w-full"
                    v-model="expedition.value" :saved="expedition.saved" @change="submit(expedition)">
                <option>Not Started</option>
                <option>In Progress</option>
                <option>Complete</option>
            </Select>
            <Select id="dofe-residential" label="Residential" class="w-full"
                    v-model="residential.value" :saved="residential.saved" @change="submit(residential)">
                <option>Not Started</option>
                <option>In Progress</option>
                <option>Complete</option>
            </Select>
        </div>
    </RequirementPage>
</template>

<script>
import {defineComponent} from "vue";
import RequirementPage from "@/Components/Award/RequirementPage";
import {Head} from "@inertiajs/inertia-vue3";
import Input from "@/Components/Forms/Input";
import ValidationErrors from "@/Components/Forms/ValidationErrors";
import Button from "@/Components/Buttons/Button";
import Select from "@/Components/Forms/Select";

export default defineComponent({
    components: {Select, ValidationErrors, Input, RequirementPage, Head, Button},
    props: {
        dofe_organisation: String,
        dofe_number: String,
        dofe_completion: String,
        dofe_award: Object,
        user: Object,
    },

    data() {
        return {
            completedWith: {
                name: 'dofe_organisation',
                value: this.dofe_organisation !== 'Hampshire Scouts' && this.dofe_organisation !== null ? '' : String(this.dofe_organisation),
                saved: null,
            },

            organisation: {name: 'dofe_organisation', value: this.dofe_organisation, saved: null},
            number: {name: 'dofe_number', value: this.dofe_number, saved: null},
            completionDate: {name: 'dofe_completion', value: this.formatDate(this.dofe_completion), saved: null},

            volunteering: {name: 'dofe_volunteering', value: this.dofe_award.volunteering, saved: null},
            physical: {name: 'dofe_physical', value: this.dofe_award.physical, saved: null},
            skills: {name: 'dofe_skills', value: this.dofe_award.skills, saved: null},
            expedition: {name: 'dofe_expedition', value: this.dofe_award.expedition, saved: null},
            residential: {name: 'dofe_residential', value: this.dofe_award.residential, saved: null},
        }
    },

    mounted() {
        window.onbeforeunload = () => {
            if (this.completedWith.value === '') this.submit(this.organisation);
        }
    },

    methods: {
        formatDate(date) {
            if (date === null || date === undefined || date === '') return null;
            let parts = String(date).split('-');
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        },
        date(string) {
            if (string === null) return null;
            let date = string.split('/');
            if (isNaN(Date.parse(`${date[1]}/${date[0]}/${date[2]}`))) return null;
            return new Date(date[2], date[1] - 1, date[0]);
        },
        submit(value) {
            if (value.value === '' && value.name !== 'dofe_organisation') value.value = null;
            if (value.value !== null && value === this.number && (value.value.length < 6 || value.value.length > 8)) return;
            if (value.value !== null && value === this.completionDate && !value.value.match("^..\/..\/....$")) return;

            let data = {};

            if (value === this.completionDate && value.value !== null) {
                let dateObj = this.date(value.value);
                if (dateObj === null) return;
                data[value.name] = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}-${String(dateObj.getDate()).padStart(2, '0')}`;
            } else {
                data[value.name] = value.value;
                if (data[value.name] === 'null') data[value.name] = null;
            }

            console.log(data);

            axios.post(this.route('award.dofe.store', this.user.id), data)
                .then(() => {
                    value.saved = true;
                    setTimeout(() => value.saved = null, 2500);
                })
                .catch(() => {
                    value.saved = false;
                    setTimeout(() => value.saved = null, 2500);
                });
        },
        selectOrgChanged() {
            if (this.completedWith.value === 'Hampshire Scouts') this.organisation.value = 'Hampshire Scouts';
            else if (this.completedWith.value === '') this.organisation.value = '';
            this.submit(this.completedWith);
        }
    },

    computed: {
        progressPercentage() {
            if (this.completionDate.value !== null && this.completionDate.value.match("^..\/..\/....$") && this.date(this.completionDate.value) !== null) return 100;

            let total = 0;

            for (let item of [this.volunteering.value, this.physical.value, this.skills.value, this.expedition.value, this.residential.value]) {
                if (item === 'In Progress') total += 5;
                if (item === 'Complete') total += 15;
            }

            return total;
        },
        progressMessage() {
            let sections = [this.volunteering.value, this.physical.value, this.skills.value, this.expedition.value, this.residential.value];

            let notStarted = sections.filter(x => x === 'Not Started').length;
            let inProgress = sections.filter(x => x === 'In Progress').length;
            let complete = sections.filter(x => x === 'Complete').length;

            let parts = [];

            if (notStarted > 0) parts.push(`not started ${notStarted} section${notStarted === 1 ? '' : 's'}`);
            if (inProgress > 0) parts.push(`${notStarted} section${notStarted === 1 ? '' : 's'} being completed`);
            if (complete > 0) parts.push(`${notStarted} section${notStarted === 1 ? '' : 's'} complete`);

            return 'You have ' + this.sentenceBuilder(parts);
        },
        completionMessage() {
            let sections = [this.volunteering, this.physical, this.skills, this.expedition, this.residential];

            let sectionsToStart = sections.filter(x => x.value === 'Not Started').map(x => x.name.substring(5));
            let sectionsInProgress = sections.filter(x => x.value === 'In Progress').map(x => x.name.substring(5));


            let toStart = `You must start the ${this.sentenceBuilder(sectionsToStart)} section${sectionsToStart.length === 1 ? '' : 's'}`;
            let toFinish = `You must finish the ${this.sentenceBuilder(sectionsInProgress)} section${sectionsInProgress.length === 1 ? '' : 's'}`;

            if (sectionsToStart.length > 0 && sectionsInProgress.length > 0) return `${toStart}. ${toFinish}`;
            else if (sectionsToStart.length > 0) return toStart;
            else if (sectionsInProgress.length > 0) return toFinish;
            else return '';
        },
    }
})
</script>
