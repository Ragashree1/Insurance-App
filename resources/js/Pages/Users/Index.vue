<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Icon } from '@iconify/vue';
import { ref, reactive, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

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

            <div class="flex justify-center">
                <table>
                    <thead class="border-b-2 border-gray-200">
                        <tr>
                            <td colspan="5" class="text-right pb-6">
                                <PrimaryButton @click="showCreateUserForm">
                                    Create
                                </PrimaryButton>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-gray-50 p-3 text-sm font-semibold tracking-wide text-left">Username</th>
                            <th class="bg-gray-50 p-3 text-sm font-semibold tracking-wide text-left">Email</th>
                            <th class="bg-gray-50 p-3 text-sm font-semibold tracking-wide text-left">Contact</th>
                            <th class="bg-gray-50 p-3 text-sm font-semibold tracking-wide text-left">Profile</th>
                            <th class="bg-gray-50 p-3 text-sm font-semibold tracking-wide text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, id) in props.users" :v-bind:key="user.id" class="bg-white hover:bg-gray-100">
                            <td class="p-3 test-sm text-gray-700">{{ user.username }}</td>
                            <td class="p-3 test-sm text-gray-700">{{ user.email }}</td>
                            <td class="p-3 test-sm text-gray-700">{{ user.contact }}</td>
                            <td class="p-3 test-sm text-gray-700">{{ user.user_profile?.name }}</td>
                            <td class="p-3 test-sm text-gray-700">
                                <span>
                                    <Icon icon="carbon:edit" class="hover:text-indigo-500 hover:cursor-pointer"
                                        @click="showEditModal(user)" />
                                </span>
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
            <InputLabel for="email" value="Email" />
            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus />
            <InputError class="mt-2" :message="form.errors.email" />

            <InputLabel for="username" value="username" />
            <TextInput id="username" v-model="form.username" type="text" class="mt-1 block w-full" required autofocus />
            <InputError class="mt-2" :message="form.errors.username" />
            <InputLabel for="first_name" value="first name" />
            <TextInput id="first_name" v-model="form.first_name" type="text" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.first_name" />
            <InputLabel for="last_name" value="last name" />
            <TextInput id="last_name" v-model="form.last_name" type="text" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.last_name" />

            <InputLabel for="contact" value="contact" />
            <TextInput id="contact" v-model="form.contact" type="text" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.contact" />
            <InputLabel for="password" value="password" />
            <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.password" />
            <InputLabel for="user_profile_id" value="user profile" />
            <select class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                v-model="form.user_profile_id">
                <option value="1">System Admin</option>
                <option value="2">Real Estate Agent</option>
                <option value="3">Seller</option>
                <option value="4">Buyer</option>

            </select>

            <InputError class="mt-2" :message="form.errors.user_profile_id" />
            <InputLabel for="nationality" value="nationality" />
            <TextInput id="nationality" v-model="form.nationality" type="text" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.nationality" />
            <InputLabel for="residence_country" value="residence_country" />
            <TextInput id="residence_country" v-model="form.residence_country" type="text" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.residence_country" />
            <InputLabel for="status" value="status" />
            <select class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                v-model="form.user_profile_id">
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>
            <InputError class="mt-2" :message="form.errors.status" />
            <InputLabel for="dob" value="dob" />
            <TextInput id="dob" v-model="form.dob" type="date" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.dob" />
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