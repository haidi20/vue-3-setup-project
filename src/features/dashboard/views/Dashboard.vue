<script setup>
import { useDashboard } from "@/features/dashboard/scripts/Dashboard.script.js";

const { count_items, addCount } = useDashboard();
</script>


<template>
  <div>
    <h1>Dasboard</h1>

    <p>
      Jumlah Barang : {{ count_items }}
      <br />
    </p>

    <button @click="addCount">Tambah Barang</button>
  </div>
</template>

<style scoped>
h1 {
  color: #2c3e50;
  margin-bottom: 16px;
}

p {
  font-size: 18px;
  color: #34495e;
}
</style>