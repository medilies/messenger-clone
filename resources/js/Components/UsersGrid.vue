<template>
    <ag-grid-vue
        class="ag-theme-alpine-dark h-full"
        :columnDefs="columnDefs.value"
        :rowData="usersStore.users"
        :defaultColDef="defaultColDef"
        rowSelection="multiple"
        animateRows="true"
    >
    </ag-grid-vue>
</template>

<script setup>
import { reactive } from "vue";

import { useUsersStore } from "@/Stores/UsersStore";

import { AgGridVue } from "ag-grid-vue3";

import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

const usersStore = useUsersStore();

const columnDefs = reactive({
    value: [
        { headerName: "ID", field: "id" },
        { headerName: "Name", field: "name" },
        { headerName: "Email", field: "email", sortable: false },
    ],
});

const defaultColDef = { sortable: true, filter: true, flex: 1 };
</script>
