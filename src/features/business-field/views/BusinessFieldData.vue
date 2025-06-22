<template>
  <DataTableServer
    :columns="columns"
    :name-store="'businessField'"
    :name-data="'business_fields'"
    name-loading="data_business_fields"
    :name-action="'fetchBusinessFields'"
    :per-page="filters.limit"
    :col-search="3"
    id="business-field-table"
    :filter="false"
  >
    <template #tbody="{ data }">
      <tr v-for="field in data" :key="field.id">
        <td>{{ field.code }}</td>
        <td>{{ field.name }}</td>
      </tr>
    </template>

    <template #filter>
      <!--  -->
    </template>
  </DataTableServer>
</template>

<script setup>
// D:\learns\inventory-app\src\components\DatatableServerSide.vue
import DataTableServer from "@/components/DatatableServerSide.vue";
import useBusinessField from "../scripts/BusinessField.script.js";

const { columns, filters } = useBusinessField();
</script>