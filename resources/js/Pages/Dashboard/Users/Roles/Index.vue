<script setup>
import DashboardLayout from "../../../../Layouts/DashboardLayout.vue";
import TableCell from "../../../../Components/Table/TableCell.vue";
import Table from "../../../../Components/Table/Table.vue";
import {Link} from "@inertiajs/vue3";
import TableHead from "../../../../Components/Table/TableHead.vue";
import PrimaryButton from "../../../../Components/PrimaryButton.vue";
import SecondaryButton from "../../../../Components/SecondaryButton.vue";
import EditRoleModel from "../../../../Components/Dashboard/Users/EditRoleModel.vue";
const props = defineProps({
    roles: Object,
    permissions: Object
});

</script>

<template>
    <DashboardLayout>
        <Table>
            <template #title>
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Users</h1>
            </template>
            <template #actions>
                <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">New Role</a>
            </template>

            <template #headers>
                <TableHead>
                    <span class="font-weight-bolder">ID</span>
                </TableHead>
                <TableHead>Role</TableHead>
                <TableHead>Guard Name</TableHead>
<!--                <TableHead>Permissions</TableHead>-->
                <TableHead>Created at</TableHead>
                <TableHead>Updated at</TableHead>
                <TableHead>
                    <span class="sr-only">Edit</span>
                </TableHead>
            </template>

            <template #rows>
                <tr v-for="(role, index) in roles" :key="role.id">
                    <TableCell :isFirst="true" :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        <span class="font-weight-bolder">{{ role.id }}</span>
                    </TableCell>
                    <TableCell :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">{{ role.name }}</a>
                    </TableCell>
                    <TableCell :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        {{ role.guard_name }}
                    </TableCell>
<!--                    <TableCell :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">-->
<!--                        <span v-for="(permission, index) in role.permissions">-->
<!--                            <template v-if="index <= 2">-->
<!--                                {{ permission.name + ' ' }}-->
<!--                            </template>-->
<!--                        </span>-->
<!--                    </TableCell>-->
                    <TableCell :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        <time :datetime="role.created_at.dateTime" :title="role.created_at.dateTime">{{ role.created_at.human }}</time>
                    </TableCell>
                    <TableCell :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        <time :datetime="role.updated_at.dateTime" :title="role.updated_at.dateTime">{{ role.updated_at.human }}</time>
                    </TableCell>
                    <TableCell :isLast="true" :class="[index !== role.length - 1 ? 'border-b border-gray-200' : '']">
                        <Link :href="route('roles.edit', role)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                    </TableCell>
                </tr>
            </template>
        </Table>
    </DashboardLayout>
</template>
