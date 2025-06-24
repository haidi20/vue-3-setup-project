<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});

function onChangePage(page) {
  window.scrollTo({ top: 0, behavior: "smooth" });
}
</script>

<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-4">
      <!-- Tombol First -->
      <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
        <Link
          class="page-link"
          @click="onChangePage(1)"
          :href="`${pagination.path}?page=1`"
          preserve-scroll
        >&laquo; First</Link>
      </li>

      <!-- Tombol Previous -->
      <li class="page-item" :class="{ disabled: !pagination.links[0].url }">
        <Link
          class="page-link"
          @click="onChangePage(pagination.current_page - 1)"
          :href="pagination.links[0].url || '#'"
          preserve-scroll
        >
          <span>Previous</span>
        </Link>
      </li>

      <!-- Nomor Halaman -->
      <li
        class="page-item"
        @click="onChangePage(pagination.current_page)"
        :class="{ active: link.active, disabled: !link.url }"
        v-for="(link, index) in pagination.links.slice(1, -1)"
        :key="index"
      >
        <Link class="page-link" :href="link.url || '#'" preserve-scroll>
          <span>{{ link.label }}</span>
        </Link>
      </li>

      <!-- Tombol Next -->
      <li class="page-item" :class="{ disabled: !pagination.links.at(-1).url }">
        <Link
          class="page-link"
          @click="onChangePage(pagination.current_page + 1)"
          :href="pagination.links.at(-1).url || '#'"
          preserve-scroll
        >
          <span>Next</span>
        </Link>
      </li>

      <!-- Tombol Last -->
      <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
        <Link
          class="page-link"
          :href="`${pagination.path}?page=${pagination.last_page}`"
          @click="onChangePage(pagination.last_page)"
          preserve-scroll
        >Last &raquo;</Link>
      </li>
    </ul>
  </nav>
</template>
