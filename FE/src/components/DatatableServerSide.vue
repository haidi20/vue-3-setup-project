<template>
  <div>
    <!-- Search Box -->
    <div class="row align-items-end">
      <div :class="colSearchClass">
        <input v-model="search" type="text" class="form-control" placeholder="Cari..." />
      </div>

      <div v-if="filter" class="col-md-auto">
        <slot name="filter"></slot>
      </div>
      <div v-else class="col"></div>
    </div>

    <!-- Table -->
    <div class="table-responsive mt-4">
      <table ref="tableRef" class="table table-hover table-bordered">
        <!-- Header -->
        <thead class="table-light">
          <tr>
            <th
              v-for="(item, index) in columns"
              :key="index"
              :ref="(el) => setThRef(el, index)"
              :style="{ width: item.width }"
              :colspan="item.colspan"
              :rowspan="item.rowspan"
              class="align-middle"
              :class="[item.class, { 'fixed-col': columnFixed.includes(index) }]"
            >
              <template v-if="item.label_custom">
                <slot :name="item.label_custom"></slot>
              </template>
              <template v-else>{{ item.label }}</template>
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

        <!-- Body -->
        <tbody>
          <tr v-if="loadingTable">
            <td :colspan="countColumn" class="text-center">Memuat data...</td>
          </tr>
          <tr v-else-if="data.length === 0">
            <td :colspan="countColumn" class="text-center">Tidak ada data</td>
          </tr>
          <slot v-else name="tbody" :data="data" />
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
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
import { useDatatableServerSide } from "./DatatableServerSide.script";

// === Props ===
const props = defineProps({
  columns: {
    type: Array,
    required: true,
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
  perPage: {
    type: Number,
    default: 10,
  },
  colSearch: {
    type: Number,
    default: 2,
  },
  footer: {
    type: Boolean,
    default: false,
  },
  filter: {
    type: Boolean,
    default: false,
  },
  searchTime: {
    type: Number,
    default: 500,
  },
  columnFixed: {
    type: Array,
    default: () => [0],
  },
});

// === Composable Function ===
const {
  tableRef,
  thRefs,
  setThRef,

  colSearchClass,
  loadingTable,
  data,
  totalItems,
  totalPages,
  countColumn,
  filters,
  search,
  current_page,
  perPage,
  pages,
  visiblePages,
  changePage,
} = useDatatableServerSide({
  ...props,
});
</script>

<style scoped>
.table-responsive {
  overflow-x: auto;
}

.table {
  border-collapse: collapse; /* Hindari jarak antar kolom */
}

.table th {
  padding-left: 10px;
}

/* Kolom tetap */
.fixed-col {
  position: sticky;
  background-color: white !important;
  z-index: 2;
  min-width: 150px; /* Atur lebar minimal */
  padding: 0; /* Hilangkan padding */
  margin: 0; /* Hilangkan margin */
  border: 1px solid red; /* Tetap kasih border */
}

/* Scrollable Columns */
.scrollable-columns {
  overflow-x: auto;
  width: calc(100% - 300px); /* Sesuaikan dengan total lebar kolom tetap */
}
</style>