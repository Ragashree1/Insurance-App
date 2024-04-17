<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Icon } from '@iconify/vue';
import { ref, reactive, nextTick, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { VueTelInput } from 'vue3-tel-input';
import 'vue-tel-input/vue-tel-input.css';

const props = defineProps(['users']);
const showModal = ref(false);

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

function showEditModal(user) {
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
}

function updateNo(phone, phoneObject, input) {
    if (phoneObject?.formatted) {
        form.contact = phoneObject.formatted
    }
}

function confirmCreateOrUpdate() {
    if (form.id == '') {
        form.post(route('users.store'), {
            onSuccess: () => {
                closeModal();
            }
        })

    } else {
        form.put(route('users.update', form.id), {
            onSuccess: () => {
                closeModal();
            },
            onError: (e) => {
                alert(e);
            }
        })
    }
}

</script>

<template>
    <AppLayout title="User Accounts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Accounts
            </h2>
        </template>
        <div class="p-7 h-screen">

            <div class="flex justify-around">
                <table class="w-2/3">
                    <thead class="border-b-2 border-gray-200">
                        <tr>
                            <td colspan="6" class="text-right pb-6">
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
                            <th colspan=2 class="bg-gray-50 py-3 px-1 text-lg font-semibold tracking-wide text-left">
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
                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="carbon:edit" class="hover:text-indigo-500 hover:cursor-pointer"
                                    @click="showEditModal(user)" />
                            </td>
                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="carbon:overflow-menu-horizontal"
                                    class="hover:text-indigo-500 hover:cursor-pointer" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>

    <DialogModal :show="showModal">
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

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="confirmCreateOrUpdate">
                Submit
            </PrimaryButton>
        </template>

    </DialogModal>
</template>