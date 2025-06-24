<template>
  <div>
    <header class="header">
      <h5 class="mb-0">Dashboard</h5>
    </header>
    <main class="content">
      <div class="container mt-5">
        <div class="row">
          <div v-for="(item, index) in dataCounts" :key="item.label" class="col-md-4 mb-3">
            <div class="card" :class="cardBgClass(index)">
              <div class="card-body">
                <h5 class="card-title">{{ item.label }}</h5>
                <p class="card-text">{{ item.value }} data</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
defineProps({
  dataCounts: {
    type: Array,
    required: true,
  },
});

function cardBgClass(index) {
  if (index % 3 === 0) return "text-bg-primary";
  if (index % 3 === 1) return "text-bg-success";
  return "text-bg-warning";
}
</script>
