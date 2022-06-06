<template>
    <Head title="Manage Users - Admin Centre"/>

    <h2 class="font-bold text-2xl">Manage Users</h2>
    <p class="mb-4">Use this page to create and manage all users.</p>
    <Table
        :columns="[{name: 'Name', sortable: true, searchable: true}, {name: 'District', sortable: true, searchable: true}]"
        :table-data="usersTable" :numbered="true" :clickable="true" @click="rowClicked">
        <template #header>
            <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                    type="button" @click="openCreateModal">
                <span>Create</span>
                <Feather class="ml-2" icon="user-plus" :size="18"/>
            </Button>
        </template>
    </Table>

    <!-- Create User Modal -->
    <DialogModal :show="showCreateModal" max-width="lg" :closeable="false">
        <template #title>Create User</template>
        <template #content>
            <form @submit.prevent="submitCreation">
                <div class="w-full mb-6">
                    <Input id="first-name" class="inline-block w-1/2 pr-2" label="First Name" type="text"
                           v-model="createForm.first_name" required autocomplete="given-name" ref="create"/>
                    <Input id="last-name" class="inline-block w-1/2 pl-2" label="Last Name" type="text"
                           v-model="createForm.last_name" required autocomplete="family-name"/>
                </div>
                <Input id="email-address" class="w-full mb-6" label="Email Address" type="email" v-model="createForm.email"
                       required/>
                <Input id="password" class="w-full mb-6" label="Password" type="password" v-model="createForm.password"
                       required autocomplete="new-password"/>
                <Select id="district" class="w-full" label="District" v-model="createForm.district" required>
                    <option value="null" selected>Select...</option>
                    <option v-for="district of districts" :key="district.id" :value="district.id">
                        {{ district.name }}
                    </option>
                </Select>
                <Message class="mt-4"
                         v-show="Object.values(this.districts).filter(district => district.name === 'Hampshire' && district.id === parseInt(createForm.district)).length === 1">
                    If they already have a Hampshire Scouts Microsoft account they should just use that to sign in.
                    Their account will automatically be created.
                </Message>
                <ValidationErrors class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitCreation"></button>
            </form>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeCreateModal">Cancel
            </Button>
            <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened" :loading="this.createForm.loading"
                    type="submit" @click="submitCreation">
                <span>Create</span>
                <Feather class="ml-2" icon="user-plus" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Manage User Modal -->
    <DialogModal :show="showManageModal" max-width="4xl" :closeable="!(showEditModal || showResetPasswordModal || showDeleteModal)" @close="closeManageModal">
        <template #title>
            <h2 class="font-bold text-2xl">{{ manageUser.first_name + ' ' + manageUser.last_name }}</h2>
            <h4 class="font-normal">{{ districts[manageUser.district_id].name }}</h4>
        </template>
        <template #content>
            <div class="flex gap-2">
                <div class="w-1/2">
                    <p class="mb-2"><strong>myQSA ID:</strong> {{ String(manageUser.id).padStart(5, '0') }}</p>
                    <p><strong>Email:</strong> {{ manageUser.email }}</p>
                    <p class="mb-2"><strong>Email verified at:</strong> {{ formatDate(manageUser.email_verified_at) }}</p>
                    <p><strong>Account created at:</strong> {{ formatDate(manageUser.created_at) }}</p>
                    <p class="mb-2"><strong>Last sign in at:</strong> {{ formatDate(manageUser.last_signed_in_at) }}</p>
                    <p><strong>Two-factor authentication enabled:</strong> No</p>
                </div>
                <div class="flex flex-col w-1/2">
                    <p class="font-bold text-lg">Manage User</p>
                    <div class="w-full" v-if="manageUser.id !== user.id">
                        <MenuItem icon="clipboard" @click="openEditModal">Edit Details</MenuItem>
                        <MenuItem icon="unlock" @click="showResetPasswordModal = true">Reset Password</MenuItem>
                        <MenuItem icon="award" :href="route('award', {id: manageUser.id})">View Award</MenuItem>
                        <MenuItem icon="trash-2" class="bg-red hover:bg-red-darkened text-white font-bold"
                                  @click="showDeleteModal = true">Delete Account
                        </MenuItem>
                    </div>
                    <div class="flex flex-1 items-center justify-center" v-else>
                        <p>You cannot manage your own account. Please go to the
                            <AppLink :href="route('manage-account')">Manage Account</AppLink>
                            page.</p>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700 disabled:bg-navy-darkened"
                    type="button" @click="closeManageModal">Close
            </Button>
        </template>
    </DialogModal>

    <!-- Edit User Modal -->
    <DialogModal :show="showEditModal" max-width="lg" :closeable="false">
        <template #title>Edit {{ manageUser !== null ? manageUser.first_name + ' ' + manageUser.last_name : 'User' }}</template>
        <template #content>
            <form @submit.prevent="submitEdit" v-if="editForm !== null">
                <div class="w-full mb-6">
                    <Input id="first-name" class="inline-block w-1/2 pr-2" label="First Name" type="text"
                           v-model="editForm.first_name" required autocomplete="given-name" ref="edit"/>
                    <Input id="last-name" class="inline-block w-1/2 pl-2" label="Last Name" type="text"
                           v-model="editForm.last_name" required autocomplete="family-name"/>
                </div>
                <Input id="email-address" class="w-full mb-6" label="Email Address" type="email" v-model="editForm.email"
                       required/>
                <Select id="district" class="w-full" label="District" v-model="editForm.district" required>
                    <option value="null" selected>Select...</option>
                    <option v-for="district of districts" :key="district.id" :value="district.id">
                        {{ district.name }}
                    </option>
                </Select>
                <Message class="mt-4"
                         v-show="Object.values(this.districts).filter(district => district.name === 'Hampshire' && district.id === parseInt(editForm.district)).length === 1">
                    If they have a Hampshire Scouts Microsoft account they should use that to sign in.
                </Message>
                <ValidationErrors class="mt-4"></ValidationErrors>
                <button class="hidden" type="submit" @submit.prevent="submitEdit"></button>
            </form>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeEditModal">Cancel
            </Button>
            <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened" :loading="editForm.loading" v-if="editForm !== null"
                    type="submit" @click="submitEdit">
                <span>Edit</span>
                <Feather class="ml-2" icon="edit-2" :size="16"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Delete User Modal -->
    <DialogModal :show="showDeleteModal" max-width="lg">
        <template #title>Delete User</template>
        <template #content>
            <p>Are you sure you want to delete {{ manageUser.first_name + ' ' + plural(manageUser.last_name) }} account?
                This action cannot be undone.</p>
            <div class="flex items-center gap-4 bg-red text-white font-bold p-4 mt-4" v-if="deletionError">
                <Feather icon="alert-octagon" :size="20"/>
                <p>An error occurred. Please try again later.</p>
            </div>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700"
                    type="button" @click="closeDeleteModal">Cancel
            </Button>
            <Button class="inline bg-red hover:bg-red-darkened disabled:bg-red-darkened"
                    type="submit" @click="submitDeletion">
                <span>Delete</span>
                <Feather class="ml-2" icon="trash-2" :size="18"/>
            </Button>
        </template>
    </DialogModal>

    <!-- Reset Password Modal -->
    <DialogModal :show="showResetPasswordModal" max-width="lg">
        <template #title>Reset {{ manageUser.first_name + ' ' + plural(manageUser.last_name) }} Password</template>
        <template #content>
            <p v-if="!newPassword">Are you sure you want to reset {{ plural(manageUser.first_name) }} password?
                They will be signed out of all devices and forced to enter their new password to regain account access.</p>
            <div v-else>
                <p class="mb-4">{{ plural(manageUser.first_name) }} password has been reset. Their new password is shown below:</p>
                <div class="block mb-6 text-center">
                    <p class="inline-block bg-gray-800 dark:bg-gray-400 text-gray-200 dark:text-gray-800 text-mono text-lg p-4">
                    {{ newPassword }}</p>
                </div>
                <p class="italic">Once you close this window their password will no longer be visible.</p>
            </div>
            <div class="flex items-center gap-4 bg-red text-white font-bold p-4 mt-4" v-if="resetPasswordError">
                <Feather icon="alert-octagon" :size="20"/>
                <p>An error occurred. Please try again later.</p>
            </div>
        </template>
        <template #footer>
            <Button class="inline bg-gray-500 hover:bg-gray-700" v-show="!newPassword"
                    type="button" @click="closeResetPasswordModal">Cancel
            </Button>
            <Button class="inline bg-red hover:bg-red-darkened disabled:bg-red-darkened"
                    type="submit" @click="submitPasswordReset" v-show="!newPassword">
                <span>Reset Password</span>
                <Feather class="ml-2" icon="unlock" :size="18"/>
            </Button>
            <Button class="inline bg-navy hover:bg-navy-darkened disabled:bg-navy-darkened"
                    type="submit" @click="closeResetPasswordModal" v-show="newPassword">
                <span>Close</span>
            </Button>

        </template>
    </DialogModal>
</template>

<script>
import {defineComponent} from "vue";
import {Head} from "@inertiajs/inertia-vue3";
import OptionCard from "@/Components/Interface/OptionCard";
import Table from "@/Components/Interface/Table";
import Button from "@/Components/Buttons/Button";
import Feather from "@/Components/Feather";
import DialogModal from "@/Components/Interface/DialogModal";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import Message from "@/Components/Interface/Message";
import ValidationErrors from "@/Components/Forms/ValidationErrors";
import MenuItem from "@/Components/Interface/MenuItem";
import AppLink from "@/Components/Interface/AppLink";

export default defineComponent({
    components: {
        DialogModal,
        Button,
        Table,
        OptionCard,
        Head,
        Feather,
        Input,
        Select,
        Message,
        ValidationErrors,
        MenuItem,
        AppLink,
    },
    props: {user: Object, users: Object, districts: Object},

    data() {
        return {
            showCreateModal: false,
            showManageModal: false,
            showDeleteModal: false,
            deletionError: false,

            showEditModal: false,

            showResetPasswordModal: false,
            newPassword: null,
            resetPasswordError: false,

            manageUser: null,
            createForm: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                district: 'null',
            }),
            editForm: null,
        }
    },

    methods: {
        submitCreation() {
            this.createForm.post(this.route('admin-centre.users.create'), {
                wantsJson: true,
                onSuccess: () => this.closeCreateModal()
            });
        },
        submitEdit() {
            this.editForm.patch(this.route('admin-centre.users.patch', this.manageUser.id), {
                wantsJson: true,
                onSuccess: () => this.closeEditModal()
            });
        },
        submitDeletion() {
            axios.delete(this.route('admin-centre.users.delete', this.manageUser.id))
                .then(() => {
                    delete this.users[this.manageUser.id];
                    this.showDeleteModal = false;
                    this.showManageModal = false;
                    this.manageUser = null;
                    this.deletionError = false;
                })
                .catch(() => {
                    this.deletionError = true;
                });
        },
        submitPasswordReset() {
            let password = Math.random().toString(36).slice(-8);
            axios.patch(this.route('admin-centre.users.reset-password', this.manageUser.id), {password: password})
                .then(() => {
                    this.newPassword = password;
                }).catch(() => {
                    this.resetPasswordError = true;
            });
        },
        openCreateModal() {
            this.showCreateModal = true;
            this.$nextTick(() => this.$refs.create.focus());
        },
        closeCreateModal() {
            this.showCreateModal = false;
            this.createForm.reset();
        },
        openEditModal() {
            this.editForm = this.$inertia.form({
                first_name: this.manageUser.first_name,
                last_name: this.manageUser.last_name,
                email: this.manageUser.email,
                district: String(this.manageUser.district_id),
            });
            this.showEditModal = true;
            this.$nextTick(() => this.$refs.edit.focus());
        },
        closeEditModal() {
            this.manageUser = this.users[this.manageUser.id];
            this.showEditModal = false;
            this.editForm = null;
        },
        closeManageModal() {
            this.showManageModal = false;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.deletionError = false;
        },
        closeResetPasswordModal() {
            this.newPassword = null;
            this.showResetPasswordModal = false;
        },
        rowClicked(rowId) {
            this.manageUser = this.users[rowId];
            this.showManageModal = true;
        },
        formatDate(date) {
            if (date === null) return 'Never';

            let dateObj = new Date(date);
            let day = String(dateObj.getDate()).padStart(2, '0');
            let month = String(dateObj.getMonth() + 1).padStart(2, '0');
            let year = String(dateObj.getFullYear()).slice(2);
            let hour = String(dateObj.getHours()).padStart(2, '0');
            let minute = String(dateObj.getMinutes()).padStart(2, '0');
            return `${day}/${month}/${year} ${hour}:${minute}`;
        },
        plural(string) {
            return string + (string.slice(-1).toLowerCase() === 's' ? "'" : "'s");
        }
    },

    computed: {
        usersTable() {
            let users = [];

            for (let user of Object.values(this.users)) {
                users.push({
                    id: user.id,
                    name: `${user.first_name} ${user.last_name}`,
                    district: this.districts[user.district_id].name
                });
            }

            return users;
        }
    }
})
</script>
