<script setup>
import useDashboard from "@/features/dashboard/scripts/Dashboard.script.js";

const {
  count_items,
  totalStock,
  addCount,
  removeCount,

  // dashboard
  dashboards,
  total_data,
  fetchDashboards,
  getDashboards,
  loading,
} = useDashboard();
</script>

<template>
  <div class="container mt-5">
    <div class="card shadow-sm p-4 mb-5 bg-body rounded">
      <h1 class="card-title text-center mb-4">Dasboard Inventaris</h1>

      <div class="card-body text-center">
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

        <div
          v-if="loading.data_dashboards"
          class="alert alert-secondary d-flex align-items-center justify-content-center mb-4"
          role="alert"
        >
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Memuat data...
        </div>

        <div class="mb-4">
          <h5>Ringkasan Dashboard:</h5>
          <ul class="list-group">
            <li
              v-if="getDashboards.length === 0"
              class="list-group-item text-center text-muted"
            >Tidak ada data</li>
            <li
              v-else
              v-for="(item, index) in getDashboards"
              :key="index"
              class="list-group-item d-flex justify-content-between align-items-center"
            >
              {{ item.label }}
              <span class="badge bg-secondary">{{ item.value }}</span>
            </li>
          </ul>
        </div>

        <div class="d-flex justify-content-center gap-3">
          <button @click="addCount" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Tambah Barang
          </button>
          <button @click="removeCount" class="btn btn-danger btn-lg">
            <i class="bi bi-dash-circle"></i> Kurangi Barang
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Optional: tambahan gaya khusus jika dibutuhkan */
.card-title {
  color: #2c3e50;
}
</style>