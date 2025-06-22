<template>
  <div>
    <!-- 🔍 Search Box -->
    <div class="row align-items-end">
      <div :class="colSearchClass">
        <input
          v-model="search"
          type="text"
          class="form-control"
          placeholder="Cari..."
          @input="onSearch"
        />
      </div>

      <!-- 🧩 Slot untuk filter tambahan -->
      <div v-if="filter" class="col-md-auto">
        <slot name="filter"></slot>
      </div>

      <div v-else class="col"></div>
    </div>

    <!-- 📋 Tabel -->
    <div class="table-responsive mt-4">
      <table class="table table-hover table-bordered" :id="id" style="width: 100%">
        <!-- 📌 Header -->
        <thead class="table-light">
          <tr>
            <th
              v-for="(item, index) in columns.filter(col => col.field !== null)"
              :key="index"
              :style="{ width: item.width }"
              :colspan="item.colspan"
              :rowspan="item.rowspan"
              class="align-middle"
              :class="item.class"
            >
              <slot v-if="item.label_custom" :name="item.label_custom"></slot>
              <span v-else>{{ item.label }}</span>
            </th>
            <slot name="thead"></slot>
          </tr>
          <tr>
            <slot name="theadSecond"></slot>
          </tr>
          <tr>
            <slot name="theadThird"></slot>
          </tr>
        </thead>

        <!-- 📊 Body -->
        <tbody>
          <tr v-if="loadingTable">
            <td :colspan="countColumn" class="text-center">Memuat data...</td>
          </tr>
          <tr v-else-if="filteredData.length === 0">
            <td :colspan="countColumn" class="text-center">Tidak ada data</td>
          </tr>
          <slot v-else name="tbody" :filteredData="filteredData" :current_page="current_page" />
        </tbody>

        <!-- 📇 Footer -->
        <tfoot v-if="footer">
          <slot name="tfoot"></slot>
        </tfoot>
      </table>
    </div>

    <!-- 📄 Pagination -->
    <div class="row mt-3">
      <div class="col d-flex justify-content-end">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: current_page === 1 }">
            <a class="page-link" href="#" @click.prevent="changePage(1)">First</a>
          </li>
          <li class="page-item" :class="{ disabled: current_page === 1 }">
            <a class="page-link" href="#" @click.prevent="changePage(current_page - 1)">Previous</a>
          </li>

          <li
            v-for="page in pages"
            :key="page"
            class="page-item"
            :class="{ active: current_page === page }"
          >
            <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
          </li>

          <li class="page-item" :class="{ disabled: current_page === totalPages }">
            <a class="page-link" href="#" @click.prevent="changePage(current_page + 1)">Next</a>
          </li>
          <li class="page-item" :class="{ disabled: current_page === totalPages }">
            <a class="page-link" href="#" @click.prevent="changePage(totalPages)">Last</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useStore } from "vuex";

// === Props ===
const props = defineProps({
  nameData: {
    type: String,
    required: true,
  },
  id: {
    type: String,
    default: "",
  },
  columns: {
    type: Array,
    required: true,
  },
  filter: {
    type: Boolean,
    default: false,
  },
  footer: {
    type: Boolean,
    default: false,
  },
  perPage: {
    type: Number,
    default: 10,
  },
  colSearch: {
    type: Number,
    default: 2,
  },
  bordered: {
    type: Boolean,
    default: true,
  },
  nameStore: {
    type: String,
    required: true,
  },
  nameLoading: {
    type: String,
    required: true,
  },
});

// === State ===
const search = ref("");
const current_page = ref(1);
const count_data = ref(0);
const totalPages = ref(0);
const timeout = ref(null);
const countColumn = ref(0);

// === Store ===
const store = useStore();

// === Computed Properties ===
const colSearchClass = computed(() => {
  return `col-md-${props.colSearch}`;
});

const loadingTable = computed(() => {
  return store.state[props.nameStore]?.loading?.[props.nameLoading] || false;
});

const filteredData = computed(() => {
  const data = store.state[props.nameStore]?.selected[props.nameData] || [];

  let filtered = [...data];

  // Filter berdasarkan pencarian
  if (search.value) {
    const query = search.value.toLowerCase();
    filtered = data.filter((item) => {
      return Object.values(item).some((val) =>
        typeof val === "string" || typeof val === "number"
          ? val.toString().toLowerCase().includes(query)
          : false
      );
    });
  }

  count_data.value = filtered.length;
  totalPages.value = Math.ceil(count_data.value / props.perPage);

  // Paginasi
  const start = (current_page.value - 1) * props.perPage;
  const end = start + props.perPage;

  return filtered.slice(start, end);
});

const pages = computed(() => {
  const result = [];
  for (let i = 1; i <= totalPages.value; i++) {
    result.push(i);
  }
  return result;
});

// === Watchers ===
watch(
  () => props.data,
  (newVal) => {
    countColumn.value = props.columns.filter(
      (col) => col.field !== null
    ).length;
  },
  { immediate: true }
);

watch(
  () => search.value,
  () => {
    current_page.value = 1;
  }
);

onMounted(() => {
  countColumn.value = props.columns.filter((col) => col.field !== null).length;
});

// === Methods ===
function onSearch() {
  clearTimeout(timeout.value);
  timeout.value = setTimeout(() => {
    // Bisa emit atau panggil fungsi lain
  }, 500);
}

function changePage(page) {
  if (page < 1 || page > totalPages.value) return;
  current_page.value = page;
}
</script>

<style scoped>
.pagination {
  margin: 0;
}
.page-link {
  cursor: pointer;
}
</style>