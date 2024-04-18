<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Icon } from '@iconify/vue';
import { ref, reactive, nextTick, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { VueTelInput } from 'vue3-tel-input';
import 'vue-tel-input/vue-tel-input.css';
import { initFlowbite } from 'flowbite';

const props = defineProps(['userProfile']);
const showModal = ref(false);
const showAssignRoleModal = ref(false);

const form = useForm({
    profile_name:'',
    description:'',
    status:'',
    processing: false,
})

function showEditModal(userprofile) {

    form.profile_name = userprofile.profile_name;
    form.description = userprofile.description;
    form.status = userprofile.status;
    showModal.value = true;

}

function showCreateUserProfileForm() {
    showModal.value = true;
}

function closeModal() {
    form.clearErrors();
    form.reset();
    showModal.value = false;
    showAssignRoleModal.value = false;
}

function confirmCreateOrUpdate() {
    if (form.id == '') {
        form.post(route('userProfile.store'), {
            onSuccess: () => {
                closeModal();
            }
        })

    } else {
        form.put(route('userProfile.update', form.id), {
            onSuccess: () => {
                closeModal();
            },
            onError: (e) => {
                alert(e);
            }
        })
    }
}
function createProfile(userId) {
    router.put(route('userprofile.createProfile', userId),
        {
            onFinish: () => {
                closeModal();
            }
        })
}

function deleteProfile(userId) {
    router.put(route('userprofile.deleteProfile', userId),
        {
            onFinish: () => {
                closeModal();
            }
        })
}
/*
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
*/

onMounted(() => initFlowbite())

</script>

<template>
    <AppLayout title="User Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Profiles
            </h2>


        </template>
        <div class="p-7 h-screen">
            <div class="flex justify-around">
                <table class="w-2/3 z-10">
                    <thead class="border-b-2 border-gray-200">
                        <tr>
                            <td colspan="7" class="text-right pb-6">
                                <PrimaryButton @click="showCreateUserProfileForm">
                                    Create
                                </PrimaryButton>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Role</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Description</th>
                            <th class="bg-gray-50 p-3 text-lg font-semibold tracking-wide text-left">Status</th>
                            <th colspan=2
                                class="bg-gray-50 py-3 px-1 pr-2 text-lg font-semibold tracking-wide text-left">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(userProfile, id) in props.users" :v-bind:key="userProfile.id" class="bg-white hover:bg-gray-100">
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.profile_name }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.description }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.status }}</td>

                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="carbon:edit" class="hover:text-indigo-500 hover:cursor-pointer"
                                    @click="showEditModal(user)" />
                            </td>
                            <td class="py-3 px-1 text-lg text-gray-700 text-left">

                                <!-- https://flowbite.com/docs/components/speed-dial/#dropdown-menu -->
<!-- This part probably dont need -->
                                <div data-dial-init class="relative group">
                                    <div :id="'user' + id"
                                        class="z-50 ml-10 absolute flex flex-col justify-end hidden py-1 mb-4 space-y-2 bg-white border border-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                        <ul class="text-sm text-gray-500 dark:text-gray-300">
                                            <li>
                                                <span
                                                    class="flex items-center px-5 py-2 border-b border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white dark:border-gray-600">

                                                    <span class="text-sm font-medium hover:cursor-pointer"
                                                        @click="showAssignRoleForm(user)">Assign
                                                        Role</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span
                                                    class="flex items-center px-5 py-2 border-b border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white dark:border-gray-600">
                                                    <template v-if="user.status == 'active'">
                                                        <span class="text-sm font-medium hover:cursor-pointer"
                                                            @click="suspendAccount(user)">Suspend
                                                            User</span>
                                                    </template>
                                                    <template v-else>
                                                        <span class="text-sm font-medium hover:cursor-pointer"
                                                            @click="activateAccount(user)">Activate
                                                            User</span>

                                                    </template>
                                                </span>
                                            </li>
                                            <li>
<!-- Till here -->                                                
                                                <span
                                                    class="flex items-center px-5 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white">

                                                    <span class="text-sm font-medium text-red-500 hover:cursor-pointer"
                                                        @click="deleteUser(userProfile.id)">Delete User Profile</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" :data-dial-toggle="'user' + id"
                                        :aria-controls="'user' + id" aria-expanded="false"
                                        class=" right-24 flex items-center justify-center ml-auto hover:text-indigo-500 pr-2">
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
            {{ form.id == '' ? 'Create User Profile' : 'Update User Profile' }}
        </template>
        <template #content>

            <div class="flex items-center space-x-2 my-3">
                <div>
                    <InputLabel for="profile_name" value="profile_name" />
                    <TextInput id="profile_name" v-model="form.profile_name" type="text" class="mt-1 block w-full" required
                        autofocus />
                    <InputError class="mt-2" :message="form.errors.profile_name" />

                </div>
                <div>
                    <InputLabel for="description" value="description" />
                    <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <InputLabel for="status" value="status" />
<!-- This need change to check box? -->                    <TextInput id="status" v-model="form.status" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
            </div>
<!--
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
-->           <!-- <div class="mb-2">
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
                </div> -
            </template>
            
        -->
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

<!---
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
-->
</template>