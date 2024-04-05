<template>
   
    <table>
        <tr><th>User</th></tr>
        <tr v-for="(user, id) in props.users" :v-bind:key="user.id">
            <td>{{ user.name }}</td>
        </tr>
    </table>
</template>

<script setup>

const props = defineProps(['users']);

</script>