<template>
  <div>
    <p class="fs-5 mb-3">
      Jumlah Barang :
      <span class="badge bg-primary">{{ count_items }}</span>
    </p>
    <p class="fs-5 mb-4">
      Total Stok :
      <span class="badge bg-success">{{ totalStock }}</span>
    </p>
    <p class="fs-5 mb-3">
      Total Data :
      <span class="badge bg-info">{{ total_data }}</span>
    </p>
    <p class="fs-5 mb-3">
      Jumlah Dashboard :
      <span class="badge bg-warning">{{ dashboards.length }}</span>
    </p>

    <div class="d-flex justify-content-center gap-3">
      <button @click="addCount" class="btn btn-success btn-md">
        <i class="bi bi-plus-circle"></i> Tambah Barang
      </button>
      <button @click="removeCount" class="btn btn-danger btn-md">
        <i class="bi bi-dash-circle"></i> Kurangi Barang
      </button>
    </div>
  </div>
</template>

<script setup>
import useDashboard from "@/features/dashboard/scripts/Dashboard.script.js";

const {
  count_items,
  totalStock,
  dashboards,
  total_data,

  addCount,
  removeCount,
} = useDashboard();
</script>

<style scoped>
.card-title {
  color: #2c3e50;
}
</style>