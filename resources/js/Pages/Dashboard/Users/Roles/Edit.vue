<script setup>
import EditRoleModel from "../../../../Components/Dashboard/Users/EditRoleModel.vue";
import { defineProps } from 'vue';
import DashboardLayout from "../../../../Layouts/DashboardLayout.vue";

const props = defineProps({
    role: Object,
    permissions: Object
});
</script>
<template>
    <DashboardLayout>
        <EditRoleModel :permissions="permissions" :role="role" :show="true"/>
    </DashboardLayout>
</template>
