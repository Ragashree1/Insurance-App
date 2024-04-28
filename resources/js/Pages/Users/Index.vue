<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Icon } from '@iconify/vue';
import { ref, reactive, nextTick, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
// import StatusMessage from '@/Components/StatusMessage.vue'
import TextInput from '@/Components/TextInput.vue';
import { VueTelInput } from 'vue3-tel-input';
import 'vue-tel-input/vue-tel-input.css';
import { initFlowbite } from 'flowbite';
import { debounce } from 'lodash';
import StatusMessage from '../../Components/StatusMessage.vue';

const props = defineProps(['users', 'search']);
const showModal = ref(false);
const showAssignRoleModal = ref(false);
const search = ref(props.search);
const show = ref(true);

const searchUser = debounce(() => {
    router.get(route('search-users', search.value));
}, 500)

const form = useForm({
    id: '',
    username: '',
    first_name: '',
    last_name: '',
    email: '',
    contact: '',
    password: '',
    password_confirmation: '',
    user_profile_id: '',
    nationality: '',
    residence_country: '',
    status: '',
    dob: '',
    photo: null,
    processing: false,
})

const hideMessage = () => {
    show.value = false;
}

function showEditUserForm(user) {
    form.id = user.id;
    form.username = user.username;
    form.first_name = user.first_name;
    form.last_name = user.last_name;
    form.email = user.email;
    form.contact = user.contact;
    form.password = user.password;
    form.user_profile_id = user.user_profile_id;
    form.nationality = user.nationality;
    form.residence_country = user.residence_country;
    form.status = user.status;
    form.dob = user.dob;
    showModal.value = true;
    // form.photo = user.photo;
}

function showCreateUserForm() {
    showModal.value = true;
}

function closeModal() {
    form.clearErrors();
    form.reset();
    showModal.value = false;
    showAssignRoleModal.value = false;
}

function updateNo(phone, phoneObject, input) {
    if (phoneObject?.formatted) {
        form.contact = phoneObject.formatted
    }
}

function confirmCreateUser() {
    console.log('hello');
    form.post(route('users.store'), {
        onSuccess: () => {
            closeModal();
        }
    })
}

function confirmUpdateUser() {
    form.put(route('users.update', form.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (e) => {
            alert(e);
        }
    })
}

function activateAccount(id) {
    router.put(route('users.activate-account', id),
        {
            onFinish: () => {
                closeModal();
            }
        })
}

function suspendAccount(id) {
    router.put(route('users.suspend-account', id),
        {
            onFinish: () => {
                closeModal();
            }
        })
}

function showAssignRoleForm(user) {
    form.id = user.id;
    form.user_profile_id = user.user_profile_id;
    showAssignRoleModal.value = true;
}

function assignRole() {
    form.put(route('users.assign-role', form.id), {
        onSuccess: () => {
            closeModal();
        }
    })
}

function deleteUser($user) {
    router.delete(route('users.destroy', $user));
}

onMounted(() => {
    initFlowbite();
})

</script>

<template>
    <AppLayout title="User Accounts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Accounts
            </h2>

        </template>
        <StatusMessage :show="show" @click="hideMessage"></StatusMessage>
        <div class=" p-7 h-screen w-screen">
            <div class="flex justify-around">
                <table class="z-10 ">
                    <thead class="border-b-2 border-gray-200">
                        <tr>
                            <td colspan="2" class="text-left pb-6">
                                <!-- https://flowbite.com/docs/forms/search-input/#search-bar-example -->

                                <form class="max-w-md mx-auto">
                                    <label for="default-search"
                                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" v-model="search" @input="searchUser"
                                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Search" />
                                    </div>
                                </form>
                            </td>
                            <td colspan="5" class="text-right pb-6">
                                <PrimaryButton @click="showCreateUserForm">
                                    Create
                                </PrimaryButton>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Username</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Email</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Contact</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Profile</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Status</th>
                            <th colspan=2
                                class="bg-gray-50 py-3 px-1 pr-2 text-lg font-semibold tracking-wide text-left">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, id) in props.users" :v-bind:key="user.id" class="bg-white hover:bg-gray-100">
                            <td class="p-3 text-lg text-gray-700">{{ user.username }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ user.email }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ user.contact }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ user.user_profile?.name }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ user.status }}</td>

                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="carbon:edit" class="hover:text-indigo-500 hover:cursor-pointer"
                                    @click="showEditUserForm(user)" />
                            </td>
                            <td class="py-3 px-1 text-lg text-gray-700 text-left">

                                <!-- https://flowbite.com/docs/components/speed-dial/#dropdown-menu -->

                                <div data-dial-init class="relative group">
                                    <div :id="'user' + id"
                                        class="z-50 ml-10 absolute flex flex-col justify-end hidden py-1 mb-4 space-y-2 bg-white border border-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                        <ul class="text-sm text-gray-500 dark:text-gray-300">
                                            <li>
                                                <span
                                                    class="flex items-center px-5 py-2 border-b border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white dark:border-gray-600">
                                                    <template v-if="user.status == 'active'">
                                                        <span class="text-sm font-medium hover:cursor-pointer"
                                                            @click="suspendAccount(user.id)">Suspend
                                                            User</span>
                                                    </template>
                                                    <template v-else>
                                                        <span class="text-sm font-medium hover:cursor-pointer"
                                                            @click="activateAccount(user.id)">Activate
                                                            User</span>

                                                    </template>
                                                </span>
                                            </li>
                                            <li>
                                                <span
                                                    class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">

                                                    <span class="text-sm font-medium text-red-500 hover:cursor-pointer"
                                                        @click="deleteUser(user.id)">Delete
                                                        User</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" :data-dial-toggle="'user' + id" data-dial-trigger="click"
                                        :aria-controls="'user' + id" aria-expanded="false"
                                        class=" right-20 flex items-center justify-center ml-auto hover:text-indigo-500 pr-2">
                                        <Icon icon="carbon:overflow-menu-horizontal" />
                                        <span class="sr-only">Open actions menu</span>
                                    </button>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>


    <DialogModal :show="showModal" @close="closeModal">
        <template #title>
            {{ form.id == '' ? 'Create User' : 'Update User' }}
        </template>
        <template #content>

            <div class="flex items-center space-x-2 my-3">
                <div>
                    <InputLabel for="username" value="username" />
                    <TextInput id="username" v-model="form.username" type="text" class="mt-1 block w-full" required
                        autofocus />
                    <InputError class="mt-2" :message="form.errors.username" />

                </div>
                <div>
                    <InputLabel for="first_name" value="first name" />
                    <TextInput id="first_name" v-model="form.first_name" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>
                <div>
                    <InputLabel for="last_name" value="last name" />
                    <TextInput id="last_name" v-model="form.last_name" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>

            <div class="flex justify-around space-x-2 my-3">
                <div class="w-full">
                    <InputLabel for="dob" value="dob" />
                    <TextInput id="dob" v-model="form.dob" type="date" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.dob" />
                </div>
                <div class="w-full">
                    <InputLabel for="nationality" value="nationality" />
                    <TextInput id="nationality" v-model="form.nationality" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.nationality" />
                </div>
                <div class="w-full">
                    <InputLabel for="residence_country" value="residence country" />
                    <TextInput id="residence_country" v-model="form.residence_country" type="text"
                        class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.residence_country" />
                </div>
            </div>

            <div class="flex justify-around space-x-2 my-3">
                <div class="w-full">
                    <InputLabel for="email" value="email" />
                    <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                        autofocus />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="w-full">
                    <InputLabel for="contact" value="contact" class="pb-1" />
                    <VueTelInput
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        :autoDefaultCountry="false" :value="form.contact" @input="updateNo"></VueTelInput>
                    <InputError class="mt-2" :message="form.errors.contact" />
                </div>
            </div>

            <div class="flex justify-around space-x-2 my-3">
                <div class="w-full">
                    <InputLabel for="password" value="new password" />
                    <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="w-full">
                    <InputLabel for="password" value="confirm password" />
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>
            <div class="mb-2">
                <InputLabel for="user_profile_id" value="user profile" />
                <select
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.user_profile_id">
                    <option value="1">System Admin</option>
                    <option value="2">Real Estate Agent</option>
                    <option value="3">Seller</option>
                    <option value="4">Buyer</option>
                </select>

                <InputError class="mt-2" :message="form.errors.user_profile_id" />
            </div>

            <template v-if="form.id != ''">
                <div class="mb-2">
                    <InputLabel for="status" value="status" />
                    <select
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.status">
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
            </template>

        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>
            <template v-if="form.id == ''">
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="confirmCreateUser">
                    Submit
                </PrimaryButton>
            </template>
            <template v-else>
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="confirmUpdateUser">
                    Submit
                </PrimaryButton>
            </template>

        </template>

    </DialogModal>


    <DialogModal :show="showAssignRoleModal" @close="closeModal">
        <template #title>
            {{ 'Assign Role' }}
        </template>
        <template #content>
            <div class="mb-2">
                <InputLabel for="user_profile_id" value="user profile" />
                <select
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.user_profile_id">
                    <option value="1">System Admin</option>
                    <option value="2">Real Estate Agent</option>
                    <option value="3">Seller</option>
                    <option value="4">Buyer</option>
                </select>

                <InputError class="mt-2" :message="form.errors.user_profile_id" />
            </div>


        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="assignRole">
                Submit
            </PrimaryButton>
        </template>

    </DialogModal>
</template>