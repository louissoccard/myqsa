<template>
    <Head>
        <title>Membership</title>
    </Head>
    <RequirementPage title="Membership" accent="navy" :progress-percentage="progressPercentage"
                     :progress-message="progressMessage"
                     :completion-message="completionMessage">
        <template #description>
            <p>You must:</p>
            <ul class="list-square list-outside pl-3.5">
                <li>Be aged 16 or older to start the award and complete the award before your 25th birthday</li>
                <li>Be a member of either Explorer Scouts or Scout Network (or a combination of both) for at least
                    18 months
                    to complete the award
                </li>
            </ul>
        </template>

        <p class="mb-4">Enter the dates below so that myQSA can calculate your membership length. Leave the field blank
            if it does not apply to you. The system will only calculate your progress once you enter your date of birth.</p>
        <div class="grid sm:grid-cols-2 gap-4">
            <Input id="date-of-birth" label="Date of Birth" placeholder="dd/mm/yyyy" class="w-full"
                   :saved="date_of_birth.saved" v-model="date_of_birth.value" @input="submit(date_of_birth)"/>
            <span class="hidden sm:inline"></span>
            <Input id="explorers-start" label="Explorers Start Date" placeholder="dd/mm/yyyy"
                   :saved="explorers_start.saved" v-model="explorers_start.value" @input="submit(explorers_start)"/>
            <Input id="explorers-end" label="Explorers End Date" placeholder="dd/mm/yyyy"
                   :saved="explorers_end.saved" v-model="explorers_end.value" @input="submit(explorers_end)"/>
            <Input id="network-start" label="Network Start Date" placeholder="dd/mm/yyyy"
                   :saved="network_start.saved" v-model="network_start.value" @input="submit(network_start)"/>
            <Input id="network-end" label="Network End Date" placeholder="dd/mm/yyyy"
                   :saved="network_end.saved" v-model="network_end.value" @input="submit(network_end)"/>
            <ValidationErrors></ValidationErrors>
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

export default defineComponent({
    components: {ValidationErrors, Input, RequirementPage, Head, Button},
    props: {
        id: Number,
        membership_record: Object,
    },
    data() {
        return {
            progressPercentage: 0,
            progressMessage: 'You have completed 0 months',
            completionMessage: 'Remain in Scouting for another 18 months',

            date_of_birth: {name: 'date_of_birth', value: this.formatDate(this.membership_record.date_of_birth), saved: null},
            explorers_start: {name: 'explorers_start', value: this.formatDate(this.membership_record.explorers_start), saved: null},
            explorers_end: {name: 'explorers_end', value: this.formatDate(this.membership_record.explorers_end), saved: null},
            network_start: {name: 'network_start', value: this.formatDate(this.membership_record.network_start), saved: null},
            network_end: {name: 'network_end', value: this.formatDate(this.membership_record.network_end), saved: null},
        }
    },

    mounted() {
      this.updateCompletion();
    },

    methods: {
        formatDate(date) {
            if (date === null || date === undefined || date === '') return null;
            let parts = String(date).split('-');
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        },

        submit(date) {
            if (date.value === '') date.value = null;
            if (date.value !== null && !date.value.match("^..\/..\/....$")) return;

            let data = {};

            if (date.value !== null) {
                let dateObj = this.date(date.value);
                if (dateObj === null) return;
                data[date.name] = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}-${String(dateObj.getDate()).padStart(2, '0')}`;
            } else {
                data[date.name] = null;
            }

            axios.post(this.route('award.membership.store', this.id), data)
                .then(() => {
                    date.saved = true;
                    setTimeout(() => date.saved = null, 2500);
                    this.updateCompletion();
                })
                .catch(() => {
                    date.saved = false;
                    setTimeout(() => date.saved = null, 2500);
                });
        },

        calculateMonths(date1, date2) {
            let months = 0;
            while (date1 < date2) {
                months += 1;
                if (date2.getMonth() === 0) {
                    date2.setMonth(11);
                    date2.setFullYear(date2.getFullYear() - 1);
                } else {
                    date2.setMonth(date2.getMonth() - 1);
                }
            }

            return Math.max(0, months - 1);
        },

        dateMin(date1, date2) {
            return (date1.valueOf() < date2.valueOf() ? date1 : date2);
        },
        dateMax(date1, date2) {
            return (date1.valueOf() > date2.valueOf() ? date1 : date2);
        },

        date(string) {
            if (string === null) return;
            let date = string.split('/');
            if (isNaN(Date.parse(`${date[1]}/${date[0]}/${date[2]}`))) return null;
            return new Date(date[2], date[1] - 1, date[0]);
        },

        updateCompletion() {
            if (this.date_of_birth.value === null) {
                this.progressPercentage = 0;
                this.progressMessage = 'You have completed 0 months';
                this.completionMessage = 'Remain in Scouting for another 18 months';

                return;
            }

            let sixteenthBirthday = this.date(this.date_of_birth.value);
            sixteenthBirthday.setFullYear(sixteenthBirthday.getFullYear() + 16);
            let eighteenthBirthday = this.date(this.date_of_birth.value);
            eighteenthBirthday.setFullYear(eighteenthBirthday.getFullYear() + 18);
            let twentyFifthBirthday = this.date(this.date_of_birth.value);
            twentyFifthBirthday.setFullYear(twentyFifthBirthday.getFullYear() + 25);

            let explorerMonthsCompleted = 0;
            let explorerMonthsRemaining = 0;

            let networkMonthsCompleted = 0;
            let networkMonthsRemaining = 0;

            if (this.explorers_start.value !== null) {
                let startDate = this.dateMax(sixteenthBirthday, this.date(this.explorers_start.value));
                let endDate = this.explorers_end.value !== null ? this.date(this.explorers_end.value) : new Date();
                endDate = this.dateMin(eighteenthBirthday, endDate);

                explorerMonthsCompleted = this.calculateMonths(startDate, endDate);
            }

            explorerMonthsRemaining = Math.min(18 - explorerMonthsCompleted, this.calculateMonths(new Date(), eighteenthBirthday));

            if (this.network_start.value !== null) {
                let startDate = this.dateMax(eighteenthBirthday, this.date(this.network_start.value));
                let endDate = this.network_end.value !== null ? this.date(this.network_end.value) : new Date();
                endDate = this.dateMin(twentyFifthBirthday, endDate);

                networkMonthsCompleted = this.calculateMonths(startDate, endDate);
            }

            networkMonthsRemaining = Math.min(18 - networkMonthsCompleted - (explorerMonthsCompleted + explorerMonthsRemaining), this.calculateMonths(new Date(), twentyFifthBirthday));

            let monthsCompleted = explorerMonthsCompleted + networkMonthsCompleted;
            this.progressPercentage = Math.floor(Math.min(100, (monthsCompleted / 18) * 100));
            this.progressMessage = 'You have completed ' + monthsCompleted + ' ' + (monthsCompleted === 1 ? 'month' : 'months');

            if (monthsCompleted === 0) {
                if (explorerMonthsRemaining > 0 && networkMonthsRemaining > 0) {
                    this.completionMessage = 'Join Explorer Scouts for ' + explorerMonthsRemaining + ' ' + (explorerMonthsRemaining === 1 ? 'month' : 'months') + ' and then join Scout Network for ' + networkMonthsRemaining + ' ' + (networkMonthsRemaining === 1 ? 'month' : 'months');
                } else if (explorerMonthsRemaining > 0) {
                    this.completionMessage = 'Join Explorer Scouts for ' + explorerMonthsRemaining + ' ' + (explorerMonthsRemaining === 1 ? 'month' : 'months');
                } else if (networkMonthsRemaining > 0) {
                    this.completionMessage = 'Join Scout Network for ' + networkMonthsRemaining + ' ' + (networkMonthsRemaining === 1 ? 'month' : 'months');
                }
            } else {
                if (explorerMonthsRemaining > 0 && networkMonthsRemaining > 0) {
                    this.completionMessage = 'Remain in Explorer Scouts for ' + explorerMonthsRemaining + ' ' + (explorerMonthsRemaining === 1 ? 'month' : 'months') + ' and then join Scout Network for ' + networkMonthsRemaining + ' ' + (networkMonthsRemaining === 1 ? 'month' : 'months');
                } else if (explorerMonthsRemaining > 0) {
                    this.completionMessage = 'Remain in Explorer Scouts for ' + explorerMonthsRemaining + ' ' + (explorerMonthsRemaining === 1 ? 'month' : 'months');
                } else if (networkMonthsRemaining > 0) {
                    if (this.network_start.value === null) {
                    this.completionMessage = 'Join Scout Network for ' + networkMonthsRemaining + ' ' + (networkMonthsRemaining === 1 ? 'month' : 'months');

                    } else {
                    this.completionMessage = 'Remain in Scout Network for ' + networkMonthsRemaining + ' ' + (networkMonthsRemaining === 1 ? 'month' : 'months');
                    }
                }

            }
        }
    }
})
</script>
