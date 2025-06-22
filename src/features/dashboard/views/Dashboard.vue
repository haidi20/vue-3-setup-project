<template>
  <div class="container mt-5">
    <div class="card shadow-sm p-4 mb-5 bg-body rounded">
      <h1 class="card-title text-center mb-4">Dasboard Inventaris</h1>

      <div class="card-body text-center">
        <DashboardCount />
        <br />

        <div class="row">
          <div class="col-md-4 offset-md-4 mb-3">
            <SelectClientSide :options="options" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4 mb-3">
            <DashboardBusinessField />
          </div>
        </div>

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
          <DashboardData />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SelectClientSide from "@/components/SelectClientSide.vue";
import DashboardCount from "./DashboardCount.vue";
import DashboardBusinessField from "./DashboardBusinessField.vue";
import DashboardData from "./DashboardData.vue";
import useDashboard from "@/features/dashboard/scripts/Dashboard.script.js";

const {
  // dashboard
  dashboards,
  total_data,
  fetchDashboards,
  getDashboards,
  options,
  loading,
} = useDashboard();
</script>


<style scoped>
/* Optional: tambahan gaya khusus jika dibutuhkan */
.card-title {
  color: #2c3e50;
}
</style>