<template>
    <Head>
        <title>Nights Away</title>
    </Head>
    <RequirementPage title="Nights Away" accent="teal" :progress-percentage="progressPercentage"
                     :progress-message="progressMessage"
                     :completion-message="completionMessage">
        <template #description>
            <p>
                You must:<br>
                Complete 18 nights away as an Explorer Scout or Scout Network member, of which at least 12 must be camping.
            </p>
        </template>

        <p class="mb-2">Use the table below to manage the nights away you have completed for your QSA.</p>
        <Table :columns="columns" :table-data="nights_away" :clickable="true" @click="eventClicked" empty-message="No nights away to show" />
        <div class="bg-teal hover:bg-teal-darkened cursor-pointer text-white font-bold text-center px-4 py-2" @click="showCreateModal = true">Add Entry</div>
    </RequirementPage>

    <!-- Create Event Modal -->
    <DialogModal :show="showCreateModal" max-width="lg" :closeable="true" @close="closeCreateModal">
        <template #title>Add Nights Away Event</template>
        <template #content>
            <form @submit.prevent="submitCreation">
                <Input id="event-name" class="w-full mb-4" label="Event Name" type="text" v-model="createForm.name" required/>
                <Input id="start-date" class="w-full mb-4" label="Start Date" type="text" v-model="createForm.start_date" placeholder="dd/mm/yyyy" required/>
                <Select id="type" class="w-full mb-4" label="Event Type" v-model="createForm.type" required>
                    <option value="" selected>Select...</option>
                    <option value="Indoors">Indoors</option>
                    <option value="Camping">Camping</option>
                </Select>
                <Select id="type" class="w-full" label="Number of Nights" v-model="createForm.number_of_nights" required>
                    <option value="" selected>Select...</option>
                    <option :value="number + 1" v-for="number of Array(18).keys()" :key="number + 1">{{ number + 1 }} Night{{ number === 0 ? '' : 's' }}</option>
                </Select>
                <ValidationErrors :errors="createForm.errors" class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitCreation"></button>
            </form>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeCreateModal">Cancel
            </Button>
            <Button class="inline bg-teal hover:bg-teal-darkened disabled:bg-navy-darkened" :loading="this.createForm.loading"
                    type="submit" @click="submitCreation">
                <span>Add</span>
                <Feather class="ml-0.5" icon="plus" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Edit Event Modal -->
    <DialogModal :show="showEditModal" max-width="lg" :closeable="true" @close="closeEditModal">
        <template #title>Edit Nights Away Event</template>
        <template #content>
            <form @submit.prevent="submitEdit">
                <Input id="event-name" class="w-full mb-4" label="Event Name" type="text" v-model="editForm.name" required/>
                <Input id="start-date" class="w-full mb-4" label="Start Date" type="text" v-model="editForm.start_date" placeholder="dd/mm/yyyy" required/>
                <Select id="type" class="w-full mb-4" label="Event Type" v-model="editForm.type" required>
                    <option value="" selected>Select...</option>
                    <option value="Indoors">Indoors</option>
                    <option value="Camping">Camping</option>
                </Select>
                <Select id="type" class="w-full" label="Number of Nights" v-model="editForm.number_of_nights" required>
                    <option value="" selected>Select...</option>
                    <option :value="number + 1" v-for="number of Array(18).keys()" :key="number + 1">{{ number + 1 }} Night{{ number === 0 ? '' : 's' }}</option>
                </Select>
                <ValidationErrors :errors="editForm.errors" class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitEdit"></button>
                <p class="sm:hidden mt-4 text-red font-bold hover:underline cursor-pointer text-center" @click="showDeleteModal = true">Delete Event</p>
            </form>
        </template>
        <template #footer>
            <Button class="hidden sm:inline-flex bg-red hover:bg-red-darkened disabled:bg-red-darkened mr-auto"
                    type="submit" @click="showDeleteModal = true">
                <span>Delete</span>
                <Feather class="ml-2" icon="trash-2" :size="18"/>
            </Button>
            <Button class="bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeEditModal">Cancel
            </Button>
            <Button class="bg-teal hover:bg-teal-darkened disabled:bg-navy-darkened" :loading="this.editForm.loading"
                    type="submit" @click="submitEdit">
                <span>Save</span>
                <Feather class="ml-2" icon="save" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Delete Event Modal -->
    <DialogModal :show="showDeleteModal" max-width="xl">
        <template #title>Delete Nights Away Event</template>
        <template #content>
            <p>Are you sure you want to delete the {{ editForm.name }} event?</p>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="showDeleteModal = false">Cancel
            </Button>
            <Button class="inline bg-red hover:bg-red-darkened disabled:bg-red-darkened"
                    type="submit" @click="submitDeletion">
                <span>Delete</span>
                <Feather class="ml-2" icon="trash-2" :size="18"/>
            </Button>
        </template>
    </DialogModal>
</template>

<script>
import {defineComponent} from "vue";
import RequirementPage from "@/Components/Award/RequirementPage";
import {Head} from "@inertiajs/inertia-vue3";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import ValidationErrors from "@/Components/Forms/ValidationErrors";
import Button from "@/Components/Buttons/Button";
import Table from "@/Components/Interface/Table";
import DialogModal from "@/Components/Interface/DialogModal";
import Feather from "@/Components/Feather";

export default defineComponent({
    components: {Table, ValidationErrors, Input, Select, RequirementPage, Head, Button, DialogModal, Feather},
    props: {
        id: Number,
        nights_away: Array,
    },

    data() {
        return {
            columns: [{name: 'Event', key: 'name'}, {name: 'Date', key: 'start_date', formatter: this.formatDate}, {name: 'Type', class: 'hidden sm:table-cell'}, {name: 'Nights', key: 'number_of_nights', class: 'hidden sm:table-cell'}],

            showCreateModal: false,
            createForm: this.$inertia.form({
                name: '',
                start_date: null,
                type: '',
                number_of_nights: '',
            }),

            showEditModal: false,
            editForm: null,
            manageId: null,

            showDeleteModal: false,
        }
    },

    methods: {
        eventClicked(id) {
            let event = this.nights_away.find(x => x.id === id);
            this.editForm = this.$inertia.form({
                'name': event.name,
                'start_date': this.formatDate(event.start_date),
                'type': event.type,
                'number_of_nights': String(event.number_of_nights),
            });
            this.manageId = id;
            this.showEditModal = true;
        },
        formatDate(date) {
            if (date === null || date === undefined || date === '') return null;
            let parts = String(date).split('-');
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        },
        date(string) {
            if (string === null) return string;
            let date = string.split('/');
            if (isNaN(Date.parse(`${date[1]}/${date[0]}/${date[2]}`))) return string;
            return `${date[2]}-${date[1]}-${date[0]}`;
        },
        submitCreation() {
            let date = this.createForm.start_date;
            this.createForm.start_date = this.date(date);
            this.createForm.post(this.route('award.nights-away.store', this.id), {
                wantsJson: true,
                onSuccess: () => {this.closeCreateModal()},
            });
            this.createForm.start_date = date;
        },
        submitEdit() {
            let date = this.editForm.start_date;
            this.editForm.start_date = this.date(date);
            this.editForm.patch(this.route('award.nights-away.patch', this.manageId), {
                wantsJson: true,
                onSuccess: () => {this.closeEditModal()},
            });
            this.editForm.start_date = date;
        },
        submitDeletion() {
            this.$inertia.form().delete(this.route('award.nights-away.delete', this.manageId), {
                onSuccess: () => {
                    this.showDeleteModal = false;
                    this.closeEditModal();
                    this.manageId = null;
                }
            });
        },
        closeCreateModal() {
            this.showCreateModal = false;
            this.createForm.reset();
        },
        closeEditModal() {
            this.showEditModal = false;
            this.editForm.clearErrors();
            this.editForm = null;
        }
    },

    computed: {
        numberOfCamping() {
            return this.nights_away.reduce((acc, x) => acc + (x.type === 'Camping' ? x.number_of_nights : 0), 0);
        },
        numberOfIndoors() {
            return this.nights_away.reduce((acc, x) => acc + (x.type === 'Indoors' ? x.number_of_nights : 0), 0);
        },
        progressPercentage() {
            return Math.ceil(((this.numberOfCamping + Math.min(6, this.numberOfIndoors)) / 18) * 100);
        },
        progressMessage() {
            if (this.numberOfCamping === 0 && this.numberOfIndoors === 0) return 'You have completed 0 nights away';
            else if (this.numberOfCamping === 0) return `You have completed ${this.numberOfIndoors} night${this.numberOfIndoors === 1 ? '' : 's'} away indoors.`;
            else if (this.numberOfIndoors === 0) return `You have completed ${this.numberOfCamping} night${this.numberOfCamping === 1 ? '' : 's'} away camping.`;
            else return `You have completed ${this.numberOfCamping} night${this.numberOfCamping === 1 ? '' : 's'} away camping and ${this.numberOfIndoors} night${this.numberOfIndoors === 1 ? '' : 's'} away indoors.`;
        },
        completionMessage() {
            let remaining = 18 - (this.numberOfCamping + Math.min(6, this.numberOfIndoors));
            let campingRemaining = Math.max(0, 12 - this.numberOfCamping);

            if (campingRemaining === 0) return `You must complete ${remaining} more night${remaining === 1 ? '' : 's'} away.`;
            else if (campingRemaining === remaining) return `You must complete ${remaining} more night${remaining === 1 ? '' : 's'} away, of which all must be camping.`;
            else return `You must complete ${remaining} more night${remaining === 1 ? '' : 's'} away, of which ${campingRemaining} must be camping.`;

        }
    }
})
</script>
