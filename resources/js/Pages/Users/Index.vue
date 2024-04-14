<template>
    <AppLayout title="User Accounts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Accounts
            </h2>
        </template>

        <div class="flex justify-center">
            <table>
                <tr><th>User</th></tr>
                <tr v-for="(user, id) in props.users" :v-bind:key="user.id">
                    <td>{{ user.username }}</td>
                </tr>
            </table>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['users']);

</script>