<template>
  <div>
    <!-- 🔍 Search Box -->
    <div class="row align-items-end">
      <div :class="colSearchClass">
        <input v-model="search" type="text" class="form-control" placeholder="Cari..." />
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
          <tr v-else-if="data.length === 0">
            <td :colspan="countColumn" class="text-center">Tidak ada data</td>
          </tr>
          <slot v-else name="tbody" :data="data" />
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
            v-for="(page, index) in visiblePages"
            :key="index"
            class="page-item"
            :class="{
              active: current_page === page,
              disabled: page === '...',
            }"
          >
            <a
              class="page-link"
              href="#"
              @click.prevent="page !== '...' ? changePage(page) : null"
              :style="{ cursor: page === '...' ? 'default' : 'pointer' }"
            >{{ page }}</a>
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
import debounce from "lodash/debounce";

// === Props ===
const props = defineProps({
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
  nameData: {
    type: String,
    required: true,
  },
  nameLoading: {
    type: String,
    required: true,
  },
  nameAction: {
    type: String,
    required: true,
  },
  searchTime: {
    type: Number,
    default: 1000,
  },
});

// === Store ===
const store = useStore();

// === Computed Properties ===

const colSearchClass = computed(() => {
  return `col-md-${props.colSearch}`;
});

const loadingTable = computed(() => {
  return store.state[props.nameStore]?.loading?.[props.nameLoading] || false;
});

const data = computed(() => {
  return store.state[props.nameStore]?.data?.[props.nameData] || [];
});

const totalItems = computed(() => {
  return store.state[props.nameStore]?.total_data[props.nameData] || 0;
});

const totalPages = computed(() => {
  return Math.ceil(totalItems.value / perPage.value);
});

const countColumn = computed(() => {
  return props.columns.filter((col) => col.field !== null).length;
});

const filters = computed(() => {
  return (
    store.state[props.nameStore]?.table_options[props.nameData]?.filters || {}
  );
});

const search = computed({
  get: () =>
    store.state[props.nameStore]?.table_options[props.nameData]?.filters
      ?.search || "",
  set: (val) =>
    store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
      filter: {
        search: val,
        page: 1,
        offset: 0,
      },
    }),
});

const current_page = computed({
  get: () =>
    store.state[props.nameStore]?.table_options[props.nameData]?.filters
      ?.page || 1,
  set: (val) =>
    store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
      filter: { page: val },
    }),
});

const perPage = computed({
  get: () =>
    store.state[props.nameStore]?.table_options[props.nameData]?.filters
      ?.limit || props.perPage,
  set: (val) =>
    store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
      filter: { limit: val },
    }),
});

const pages = computed(() => {
  const result = [];
  for (let i = 1; i <= totalPages.value; i++) {
    result.push(i);
  }
  return result;
});

const visiblePages = computed(() => {
  const maxVisiblePages = 5; // Jumlah maksimal nomor halaman yang ditampilkan
  const currentPage = current_page.value;
  const totalPagesVal = totalPages.value;

  if (totalPagesVal <= maxVisiblePages) {
    // Jika total halaman kurang dari atau sama dengan maxVisiblePages, tampilkan semua
    return Array.from({ length: totalPagesVal }, (_, i) => i + 1);
  }

  const half = Math.floor(maxVisiblePages / 2);

  let start = currentPage - half;
  let end = currentPage + half;

  if (start <= 1) {
    start = 1;
    end = maxVisiblePages;
  }

  if (end > totalPagesVal) {
    end = totalPagesVal;
    start = totalPagesVal - maxVisiblePages + 1;
  }

  const pagesArray = [];

  for (let i = start; i <= end; i++) {
    pagesArray.push(i);
  }

  // Tambahkan ellipsis jika diperlukan
  if (start > 1) {
    pagesArray.unshift("...");
  }

  if (end < totalPagesVal) {
    pagesArray.push("...");
  }

  // Selalu tambahkan halaman pertama dan terakhir jika tidak termasuk dalam array
  if (!pagesArray.includes(1)) {
    pagesArray.unshift(1);
  }

  if (!pagesArray.includes(totalPagesVal)) {
    pagesArray.push(totalPagesVal);
  }

  return pagesArray;
});

// === Debounced Fetch Function ===
const fetchDataDebounced = debounce(() => {
  fetchData();
}, props.searchTime);

const fetchData = () => {
  store.dispatch(`${props.nameStore}/${props.nameAction}`, {
    ...filters.value,
  });
};

// === Watchers ===
watch(
  () => [filters.value.search, filters.value.page, filters.value.limit],
  () => {
    if (filters.value.search) {
      fetchDataDebounced();
    } else {
      fetchData();
    }
  }
);

// === Methods ===
const changePage = (page) => {
  // console.info("changePage", {
  //   page,
  //   totalPages: totalPages.value,
  //   current_page: current_page.value,
  //   filters: filters.value,
  // });

  if (page < 1 || page > totalPages.value) return;

  const newOffset = (page - 1) * perPage.value;

  store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
    filter: {
      page,
      offset: newOffset,
    },
  });
};

// === Lifecycle Hook ===
onMounted(() => {
  // Set default jika belum ada
  if (!filters.value.limit) {
    perPage.value = props.perPage;
  }

  if (!filters.value.order_by) {
    store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
      filter: {
        order_by: "created_at",
        sort_by: "desc",
      },
    });
  }

  fetchData();
});
</script>

<style scoped>
.pagination {
  margin: 0;
}
.page-link {
  cursor: pointer;
}
</style>