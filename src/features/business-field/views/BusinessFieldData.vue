<template>
  <DataTableServer
    :columns="getColumns()"
    :name-store="'businessField'"
    :name-data="'business_fields'"
    name-loading="data_business_fields"
    :name-action="'fetchBusinessFields'"
    :per-page="filters.limit"
    :col-search="3"
    :column-fixed="columnFixed"
    id="business-field-table"
    :filter="false"
  >
    <template #tbody="{ data }">
      <tr v-for="field in data" :key="field.id">
        <td
          v-for="(col, index) in getColumns()"
          :key="col.field"
          :class="{ 'fixed-col': columnFixed.includes(index) }"
        >{{ field[col.field] || "-" }}</td>
      </tr>
    </template>

    <template #filter>
      <!--  -->
    </template>
  </DataTableServer>
</template>

<script setup>
import DataTableServer from "@/components/DatatableServerSide.vue";
import useBusinessField from "../scripts/BusinessField.script.js";

const { columns, getColumns, filters, columnFixed } = useBusinessField();
</script>

<style scoped>
.table {
  border-collapse: collapse;
}

.fixed-col {
  position: sticky;
  background-color: white !important;
  z-index: 2;
  box-shadow: 2px 0 2px -2px rgba(0, 0, 0, 0.1);
  border: 1px solid red; /* Tambahkan border untuk kolom tetap */
}
</style>