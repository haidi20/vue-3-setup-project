import { ref, computed, watch, onMounted, onUpdated } from "vue";
import { useStore } from "vuex";
import debounce from "lodash/debounce";

export const useDatatableServerSide = (props) => {
  // === Store ===
  const store = useStore();

  // --- Refs ---
  const tableRef = ref(null);
  const thRefs = ref([]);

  // --- Functions ---

  function setThRef(el, index) {
    if (el) thRefs.value[index] = el;
  }

  function applyDynamicStickyLeft() {
    const headers = tableRef.value?.querySelectorAll("thead th");
    const rows = tableRef.value?.querySelectorAll("tbody tr");

    // console.info("applyDynamicStickyLeft", headers, rows);

    if (!headers || !thRefs.value.length) return;

    let cumulativeWidth = 0;

    props.columns.forEach((col, index) => {
      if (props.columnFixed.includes(index)) {
        const th = thRefs.value[index];
        if (th) {
          th.style.left = `${cumulativeWidth}px`;
          cumulativeWidth += th.offsetWidth;
        }
      }
    });

    // Set left for tbody td
    if (rows) {
      rows.forEach((row) => {
        let tdCumulativeWidth = 0;
        props.columns.forEach((col, index) => {
          if (props.columnFixed.includes(index)) {
            const td = row.children[index];
            if (td) {
              td.style.left = `${tdCumulativeWidth}px`;
              tdCumulativeWidth += td.offsetWidth;
            }
          }
        });
      });
    }
  }

  // === Computed Properties ===
  const colSearchClass = computed(() => `col-md-${props.colSearch}`);

  const loadingTable = computed(() =>
    store.state[props.nameStore]?.loading?.[props.nameLoading] || false
  );

  const data = computed(() =>
    store.state[props.nameStore]?.data?.[props.nameData] || []
  );

  const totalItems = computed(() =>
    store.state[props.nameStore]?.total_data?.[props.nameData] || 0
  );

  const perPage = computed({
    get: () =>
      store.state[props.nameStore]?.table_options?.[props.nameData]?.filters?.limit ||
      props.perPage,
    set: (val) =>
      store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
        filter: { limit: val },
      }),
  });

  const totalPages = computed(() => Math.ceil(totalItems.value / perPage.value));

  const countColumn = computed(() =>
    props.columns.filter((col) => col.field !== null).length
  );

  const filters = computed(() =>
    store.state[props.nameStore]?.table_options?.[props.nameData]?.filters || {}
  );

  const search = computed({
    get: () =>
      store.state[props.nameStore]?.table_options?.[props.nameData]?.filters?.search ||
      "",
    set: (val) =>
      store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
        filter: { search: val, page: 1, offset: 0 },
      }),
  });

  const current_page = computed({
    get: () =>
      store.state[props.nameStore]?.table_options?.[props.nameData]?.filters?.page || 1,
    set: (val) =>
      store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
        filter: { page: val },
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
    const maxVisible = 5;
    const currentPage = current_page.value;
    const total = totalPages.value;

    if (total <= maxVisible) return Array.from({ length: total }, (_, i) => i + 1);

    const half = Math.floor(maxVisible / 2);
    let start = Math.max(1, currentPage - half);
    let end = Math.min(total, start + maxVisible - 1);
    if (end - start + 1 < maxVisible) start = Math.max(1, end - maxVisible + 1);

    const result = [];

    for (let i = start; i <= end; i++) result.push(i);

    if (start > 1) result.unshift("...");
    if (end < total) result.push("...");

    if (!result.includes(1)) result.unshift(1);
    if (!result.includes(total)) result.push(total);

    return result;
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
    if (page < 1 || page > totalPages.value) return;

    const newOffset = (page - 1) * perPage.value;
    store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
      filter: { page, offset: newOffset },
    });
  };

  // === Lifecycle Hook ===
  onMounted(() => {
    if (!filters.value.limit) {
      perPage.value = props.perPage;
    }
    if (!filters.value.order_by) {
      store.commit(`${props.nameStore}/UPDATE_FILTERS`, {
        filter: { order_by: "created_at", sort_by: "desc" },
      });
    }
    fetchData();

    applyDynamicStickyLeft();
    window.addEventListener("resize", applyDynamicStickyLeft);
  });

  onUpdated(() => {
    applyDynamicStickyLeft();
  });

  return {
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
  };
};
