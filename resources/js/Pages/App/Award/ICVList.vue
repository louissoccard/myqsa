<template>
    <Head>
        <title>ICV List</title>
    </Head>

    <RequirementPage title="ICV List" alt-title="ICV list" accent="pink" :progress-percentage="progressPercentage"
                     :progress-message="progressMessage"
                     :completion-message="completionMessage">
        <template #description>
            <p>
                You must:<br>
                Complete six activities in total, two from each topic area of the ICV activities list. A minimum of two
                must be from the QSA ICV list and the others from any of the QSA, or
                Chief Scout Platinum or Diamond ICV lists.
            </p>
        </template>

        <p class="mb-2">Use the table below to manage the icv activities you have completed for your QSA.</p>
        <Table :columns="columns" :table-data="icv_activities" :clickable="true" @click="eventClicked"
               empty-message="No activities to show"/>
        <div class="bg-pink hover:bg-pink-darkened cursor-pointer text-black hover:text-white font-bold text-center px-4 py-2"
             @click="showCreateModal = true">Add Entry
        </div>
    </RequirementPage>

    <!-- Create Activity Modal -->
    <DialogModal :show="showCreateModal" max-width="lg" :closeable="true" @close="closeCreateModal">
        <template #title>Add ICV Activity</template>
        <template #content>
            <form @submit.prevent="submitCreation">
                <Select id="category" class="w-full mb-4" label="Category" v-model="createForm.category" required>
                    <option value="" selected>Select...</option>
                    <option>International</option>
                    <option>Community</option>
                    <option>Values</option>
                </Select>
                <Input id="start-date" class="w-full mb-4" label="Start Date" type="text"
                       v-model="createForm.start_date" placeholder="dd/mm/yyyy" required/>
                <Input id="end-date" class="w-full mb-4" label="End Date" type="text" v-model="createForm.end_date"
                       placeholder="dd/mm/yyyy" required/>
                <TextArea id="description" class="w-full" container-class="mb-4" label="Description" type="text" rows="4"
                          v-model="createForm.description" :character-limit="255" required/>
                <Select id="type" class="w-full mb-4" label="Completed as part of CSA Platinum or Diamond"
                        v-model="createForm.part_of_csa" required>
                    <option value="" selected>Select...</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
                <ValidationErrors :errors="createForm.errors" class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitCreation"></button>
            </form>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeCreateModal">Cancel
            </Button>
            <Button
                class="inline bg-pink hover:bg-pink-darkened text-black hover:text-white disabled:text-white disabled:bg-pink-darkened"
                :loading="this.createForm.loading"
                type="submit" @click="submitCreation">
                <span>Add</span>
                <Feather class="ml-0.5" icon="plus" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Edit Activity Modal -->
    <DialogModal :show="showEditModal" max-width="lg" :closeable="true" @close="closeEditModal">
        <template #title>Edit ICV Activity</template>
        <template #content>
            <form @submit.prevent="submitEdit">
                <Select id="category" class="w-full mb-4" label="Category" v-model="editForm.category" required>
                    <option value="" selected>Select...</option>
                    <option>International</option>
                    <option>Community</option>
                    <option>Values</option>
                </Select>
                <Input id="start-date" class="w-full mb-4" label="Start Date" type="text" v-model="editForm.start_date"
                       placeholder="dd/mm/yyyy" required/>
                <Input id="end-date" class="w-full mb-4" label="End Date" type="text" v-model="editForm.end_date"
                       placeholder="dd/mm/yyyy" required/>
                <TextArea id="description" class="w-full" container-class="mb-4" label="Description" type="text" rows="4"
                          v-model="editForm.description" :character-limit="255" required/>
                <Select id="type" class="w-full mb-4" label="Completed as part of CSA Platinum or Diamond"
                        v-model="editForm.part_of_csa" required>
                    <option value="" selected>Select...</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </Select>
                <ValidationErrors :errors="editForm.errors" class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitEdit"></button>
                <p class="sm:hidden mt-4 text-red font-bold hover:underline cursor-pointer text-center"
                   @click="showDeleteModal = true">Delete Activity</p>
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
            <Button
                class="bg-pink hover:bg-pink-darkened text-black hover:text-white disabled:text-white disabled:bg-pink-darkened"
                :loading="this.editForm.loading"
                type="submit" @click="submitEdit">
                <span>Save</span>
                <Feather class="ml-2" icon="save" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Delete Activity Modal -->
    <DialogModal :show="showDeleteModal" max-width="xl">
        <template #title>Delete ICV Activity</template>
        <template #content>
            <p>Are you sure you want to delete this {{ editForm.category.toLowerCase() }} activity?</p>
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
import TextArea from "@/Components/Forms/TextArea";

export default defineComponent({
    components: {TextArea, Table, ValidationErrors, Input, Select, RequirementPage, Head, Button, DialogModal, Feather},
    props: {
        id: Number,
        icv_activities: Array,
    },

    data() {
        return {
            columns: [{name: 'Category'}, {
                name: 'Date',
                key: 'start_date',
                formatter: this.formatDate
            }, {
                name: 'Description',
                class: 'hidden sm:table-cell',
                formatter: this.formatDescription
            }, {name: 'Part of CSA', class: 'hidden sm:table-cell', formatter: x => x === 1 ? 'Yes' : 'No'}],

            showCreateModal: false,
            createForm: this.$inertia.form({
                category: '',
                start_date: null,
                end_date: null,
                description: '',
                part_of_csa: '',
            }),

            showEditModal: false,
            editForm: null,
            manageId: null,

            showDeleteModal: false,
        }
    },

    methods: {
        eventClicked(id) {
            let activity = this.icv_activities.find(x => x.id === id);
            this.editForm = this.$inertia.form({
                category: String(activity.category),
                start_date: this.formatDate(activity.start_date),
                end_date: this.formatDate(activity.end_date),
                description: activity.description,
                part_of_csa: String(activity.part_of_csa),
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
            let start_date = this.createForm.start_date;
            let end_date = this.createForm.end_date;
            this.createForm.start_date = this.date(start_date);
            this.createForm.end_date = this.date(end_date);
            this.createForm.post(this.route('award.icv-list.store', this.id), {
                wantsJson: true,
                onSuccess: () => {
                    this.closeCreateModal()
                },
            });
            this.createForm.start_date = start_date;
            this.createForm.end_date = end_date;
        },
        submitEdit() {
            let start_date = this.editForm.start_date;
            let end_date = this.editForm.end_date;
            this.editForm.start_date = this.date(start_date);
            this.editForm.end_date = this.date(end_date);
            this.editForm.patch(this.route('award.icv-list.patch', this.manageId), {
                wantsJson: true,
                onSuccess: () => {
                    this.closeEditModal()
                },
            });
            this.editForm.start_date = start_date;
            this.editForm.end_date = end_date;
        },
        submitDeletion() {
            this.$inertia.form().delete(this.route('award.icv-list.delete', this.manageId), {
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
        },
        formatDescription(description) {
            if (description.length < 25) return description;
            else return description.substring(0, 25) + '...';
        },
    },

    computed: {
        numberOfInternational() {
            return this.icv_activities.filter(x => x.category === 'International').length;
        },
        numberOfCommunity() {
            return this.icv_activities.filter(x => x.category === 'Community').length;
        },
        numberOfValues() {
            return this.icv_activities.filter(x => x.category === 'Values').length;
        },
        numberOfQsaList() {
          return this.icv_activities.filter(x => x.part_of_csa === 0).length;
        },
        progressPercentage() {
            let total = Math.min(2, this.numberOfInternational) + Math.min(2, this.numberOfCommunity) + Math.min(2, this.numberOfValues);
            total = Math.min(total, 4 + Math.min(2, this.numberOfQsaList));

            return Math.floor((total / 6) * 100);
        },
        progressMessage() {
            let message = [];

            if (this.numberOfInternational > 0) message.push(`${this.numberOfInternational} international activit${this.numberOfInternational === 1 ? 'y' : 'ies'}`);
            if (this.numberOfCommunity > 0) message.push(`${this.numberOfCommunity} community activit${this.numberOfCommunity === 1 ? 'y' : 'ies'}`);
            if (this.numberOfValues > 0) message.push(`${this.numberOfValues} values activit${this.numberOfValues === 1 ? 'y' : 'ies'}`);

            if (message.length === 0) return 'You have not completed any ICV activities';
            else return 'You have completed ' + this.sentenceBuilder(message);
        },
        completionMessage() {
            let message = [];
            let listMessage = '';

            if (this.numberOfInternational < 2) message.push(`${2 - this.numberOfInternational} more international activit${(2 - this.numberOfInternational) === 1 ? 'y' : 'ies'}`);
            if (this.numberOfCommunity < 2) message.push(`${2 - this.numberOfCommunity} more community activit${(2 - this.numberOfCommunity) === 1 ? 'y' : 'ies'}`);
            if (this.numberOfValues < 2) message.push(`${2 - this.numberOfValues} more values activit${(2 - this.numberOfValues) === 1 ? 'y' : 'ies'}`);
            if (this.numberOfQsaList === 0) listMessage = 'Two of your activities must be from the QSA ICV list';
            if (this.numberOfQsaList === 1) listMessage = 'One of your activities must be from the QSA ICV list';

            return (message.length > 0 ? 'You must complete ' : '') + this.sentenceBuilder(message) + (listMessage !== '' && message.length > 0 ? '. ' : '') + listMessage;
        }
    }
})
</script>
