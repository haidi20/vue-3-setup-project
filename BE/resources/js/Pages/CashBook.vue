<template>
  <div>
    <header class="header">
      <h5 class="ms-4">Pembukuan Kas</h5>
    </header>
    <main class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in paginatedData" :key="item.id || index">
                    <td>{{ item.transaction_date_readable }}</td>
                    <td>
                      <strong>{{ item.description }}</strong>
                      <br />
                      <small>
                        No Dokumen: {{ item.document_number || '-' }}
                        <br />
                        Akun: {{ item.account_estimate_name }}
                        <br />
                        Sumber: {{ item.funding_source_name }}
                        <br />
                        Jenis: {{ item.payment_type_name }}
                        <br />
                        Unit: {{ item.organizational_unit_name }}
                        <br />
                        <template v-if="item.reference">
                          Referensi: {{ item.reference }}
                          <br />
                        </template>
                        Dibuat: {{ item.created_at || '-' }}
                        <br />
                      </small>
                    </td>
                    <td>{{ item.debit_readable }}</td>
                    <td>{{ item.credit_readable }}</td>
                    <td>{{ item.balance_readable }}</td>
                  </tr>
                  <tr v-if="paginatedData.length === 0">
                    <td colspan="6" class="text-center">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
              <nav>
                <ul class="pagination">
                  <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button
                      class="page-link"
                      @click="changePage(currentPage - 1)"
                      :disabled="currentPage === 1"
                    >Previous</button>
                  </li>
                  <li
                    class="page-item"
                    v-for="page in totalPages"
                    :key="page"
                    :class="{ active: currentPage === page }"
                  >
                    <button class="page-link" @click="changePage(page)">{{ page }}</button>
                  </li>
                  <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <button
                      class="page-link"
                      @click="changePage(currentPage + 1)"
                      :disabled="currentPage === totalPages"
                    >Next</button>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

  <script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

// Ambil data dari props yang dikirim oleh Laravel
const props = usePage().props;
const rawData = ref(props.data.data);

const pageSize = 10;
const currentPage = ref(1);

// Hitung debit, kredit, dan saldo
const processedData = computed(() => {
  let balance = 0;
  return rawData.value.map((item) => {
    let debit = 0;
    let credit = 0;
    if (item.type === "in") {
      debit = item.amount;
      credit = 0;
      balance += item.amount;
    } else {
      debit = 0;
      credit = item.amount;
      balance -= item.amount;
    }
    return {
      ...item,
      debit,
      credit,
      balance,
      transaction_date_readable: item.transaction_date_readable,
      account_estimate_name: item.account_estimate?.name || "-",
      funding_source_name: item.funding_source?.name || "-",
      payment_type_name: item.payment_type?.name || "-",
      organizational_unit_name: item.organizational_unit?.name || "-",
    };
  });
});

// Hitung jumlah halaman
const totalPages = computed(() =>
  Math.ceil(processedData.value.length / pageSize)
);

// Data untuk halaman saat ini
const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * pageSize;
  return processedData.value.slice(start, start + pageSize);
});

function changePage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}
</script>

  <style scoped>
.header {
  padding: 1rem 0;
  border-bottom: 1px solid #eee;
}
.table-responsive {
  margin-top: 1rem;
}
</style>
