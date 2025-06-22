<template>
  <DatatableClientSide
    nameData="dashboards"
    :columns="columns"
    name-store="dashboard"
    name-loading="data_dashbaords"
    :filter="true"
    :footer="false"
    :per-page="5"
    :col-search="2"
    bordered
  >
    <template #tbody="{ filteredData }">
      <tr v-for="(item, index) in filteredData" :key="index">
        <td v-for="column in columns" :key="column.label">
          <template v-if="column.field === 'actions'">
            <button class="btn btn-sm btn-info me-1" @click="onEdit(index, item)">Ubah</button>
            <button class="btn btn-sm btn-danger" @click="onDelete(index)">Hapus</button>
          </template>
          <template v-else>{{ item[column.field] }}</template>
        </td>
      </tr>
    </template>

    <template #filter>
      <!--  -->
    </template>
  </DatatableClientSide>
</template>

<script setup>
import DatatableClientSide from "@/components/DatatableClientSide.vue";
import { useDashboardData } from "@/features/dashboard/scripts/DashboardData.script";

const { columns, onEdit, onDelete } = useDashboardData();
</script>