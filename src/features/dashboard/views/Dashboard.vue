<script setup>
import useDashboard from "@/features/dashboard/scripts/Dashboard.script.js";

const { count_items, totalStock, addCount, removeCount } = useDashboard();
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