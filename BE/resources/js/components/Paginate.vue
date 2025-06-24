<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-4">
      <!-- Previous Button -->
      <li class="page-item" :class="{ disabled: !pagination.links[0].url }">
        <Link class="page-link" :href="pagination.links[0].url || '#'" preserve-scroll>
          <span v-html="pagination.links[0].label"></span>
        </Link>
      </li>

      <!-- Page Numbers -->
      <li
        class="page-item"
        :class="{ active: link.active, disabled: !link.url }"
        v-for="(link, index) in pagination.links.slice(1, -1)"
        :key="index"
      >
        <Link class="page-link" :href="link.url || '#'" preserve-scroll>
          <span v-html="link.label"></span>
        </Link>
      </li>

      <!-- Next Button -->
      <li
        class="page-item"
        :class="{ disabled: !pagination.links[pagination.links.length - 1].url }"
      >
        <Link
          class="page-link"
          :href="pagination.links[pagination.links.length - 1].url || '#'"
          preserve-scroll
        >
          <span v-html="pagination.links[pagination.links.length - 1].label"></span>
        </Link>
      </li>
    </ul>
  </nav>
</template>
