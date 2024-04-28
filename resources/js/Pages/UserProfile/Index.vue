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
const showDeleteConfirmModal = ref(false);

const form = useForm({
    id: '',
    name: '',
    description: '',
    status: '',
    processing: false,
})

function showEditModal(userprofile) {

    form.name = userprofile.name;
    form.description = userprofile.description;
    form.status = userprofile.status;
    form.id = userprofile.id;
    showModal.value = true;
}

function showCreateUserProfileForm() {
    showModal.value = true;
}

function showDeleteConfirmation(userprofile) {
    form.id = userprofile.id;
    showDeleteConfirmModal.value = true;
}

function closeModal() {
    form.clearErrors();
    form.reset();
    showModal.value = false;
    showDeleteConfirmModal.value = false;
}

function confirmCreateProfile() {
    form.post(route('userProfile.store'), {
        onSuccess: () => {
            closeModal();
        }
    })
}

function confirmUpdateProfile() {
    form.put(route('userProfile.update', form.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (e) => {
            alert(e);
        }
    })
}

function deleteProfile() {
    router.delete(route('userProfile.destroy', form.id),
        {
            onFinish: () => {
                closeModal();
            }
        })
}

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
                                class="bg-gray-50 py-3 px-1 pr-2 text-lg font-semibold tracking-wide text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(userProfile, id) in props.userProfile" :v-bind:key="userProfile.id"
                            class="bg-white hover:bg-gray-100">
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.name }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.description }}</td>
                            <td class="p-3 text-lg text-gray-700">{{ userProfile.status }}</td>

                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="carbon:edit" class="hover:text-indigo-500 hover:cursor-pointer"
                                    @click="showEditModal(userProfile)" />
                            </td>
                            <td class="py-3 px-1 text-lg text-gray-700">
                                <Icon icon="fluent:delete-28-filled" class="hover:text-red-500 hover:cursor-pointer"
                                    @click="showDeleteConfirmation(userProfile)" />
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
                    <InputLabel for="name" value="name" />
                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus />
                    <InputError class="mt-2" :message="form.errors.name" />

                </div>
                <div>
                    <InputLabel for="description" value="description" />
                    <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <InputLabel for="status" class="block text-center mb-6" value="status" />
                    <input id="active" v-model="form.status" type="checkbox" true-value="active" false-value="">
                    <label for="active" class="ml-2 mr-4 ">Active</label>
                    <input id="inactive" v-model="form.status" type="checkbox" true-value="inactive" false-value="">
                    <label for="inactive" class="ml-2">Inactive</label>
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
            </div>

        </template>

        <template #footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <template v-if="form.id == ''">
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="confirmCreateProfile">
                    Submit
                </PrimaryButton>
            </template>

            <template v-else>
                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="confirmUpdateProfile">
                    Submit
                </PrimaryButton>

            </template>
        </template>

    </DialogModal>

    <!-- Delete confirmation modal -->
    <DialogModal :show="showDeleteConfirmModal" @close="closeModal">
        <template #title>
            Confirmation
        </template>
        <template #content>
            <p class="text-lg font-semibold mb-4">Are you sure you want to delete this profile?</p>
            <div class="flex justify-end">
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 mr-2"
                    @click="deleteProfile">Delete</button>
                <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                    @click="closeModal">Cancel</button>
            </div>
        </template>
    </DialogModal>




</template>