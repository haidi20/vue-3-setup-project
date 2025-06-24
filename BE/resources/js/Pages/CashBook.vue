<script setup>
import Pagination from "@/components/Paginate.vue";
import { defineProps } from "vue";

defineProps({
  cash_books: Object,
});
</script>

<template>
  <div>
    <header class="header">
      <h5 class="mb-0">Cash Book</h5>
    </header>
    <main class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!cash_books.data.length">
                    <td colspan="6" class="text-center">No data available.</td>
                  </tr>
                  <tr v-for="item in cash_books.data" :key="item.id">
                    <td>{{ item.transaction_date_readable }}</td>
                    <td>
                      <strong>{{ item.description }}</strong>
                      <br />
                      <small>
                        No Dokumen: {{ item.document_number ?? '-' }}
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
                        Dibuat: {{ item.created_at ?? '-' }}
                        <br />
                      </small>
                    </td>
                    <td>{{ item.debit_readable }}</td>
                    <td>{{ item.credit_readable }}</td>
                    <td>{{ item.balance_readable }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <Pagination :pagination="cash_books.meta" />
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
