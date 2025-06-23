<template>
  <div>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container-fluid">
        <button class="btn btn-outline-secondary d-lg-none me-2" @click="toggleSidebar">☰</button>
        <span class="navbar-brand">Aplikasi Akunting</span>
      </div>
    </nav>

    <!-- Sidebar -->
    <div :class="['sidebar', { show: isSidebarOpen }]">
      <ul class="nav flex-column">
        <li v-for="item in sidebarMenu" :key="item.title" class="nav-item">
          <!-- Menu dengan anak -->
          <template v-if="item.children && item.children.length">
            <a
              class="nav-link"
              data-bs-toggle="collapse"
              :href="`#collapse${item.title}`"
              role="button"
              aria-expanded="false"
              :aria-controls="'collapse' + item.title"
            >
              {{ item.title }}
              <span class="float-end">&#9660;</span>
            </a>
            <ul class="collapse list-unstyled ps-3" :id="`collapse${item.title}`">
              <li v-for="child in item.children" :key="child.title" class="nav-item">
                <router-link
                  :to="{ name: child.url.name }"
                  class="nav-link"
                  @click="closeSidebarOnMobile"
                >{{ child.title }}</router-link>
              </li>
            </ul>
          </template>

          <!-- Menu tanpa anak -->
          <template v-else>
            <router-link
              :to="{ name: item.url.name }"
              class="nav-link"
              @click="closeSidebarOnMobile"
            >{{ item.title }}</router-link>
          </template>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="content container mt-4 ms-lg-10 ps-lg-5 pt-4">
      <router-view />
    </div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import Footer from "@/layouts/Footer.vue";
import { ref } from "vue";

const isSidebarOpen = ref(false);
const sidebarMenu = [
  {
    title: "Dashboard",
    url: { name: "Dashboard" },
  },
  // {
  //   title: "Products",
  //   children: [
  //     { title: "List", url: { name: "ProductsList" } },
  //     { title: "Add New", url: { name: "ProductsAdd" } },
  //   ],
  // },
  {
    title: "Jenis Usaha",
    url: { name: "BusinessField" },
  },
];

function toggleSidebar() {
  isSidebarOpen.value = !isSidebarOpen.value;
}

function closeSidebarOnMobile() {
  if (window.innerWidth < 992) {
    isSidebarOpen.value = false;
  }
}
</script>

<style scoped>
.sidebar {
  position: fixed;
  top: 56px;
  left: 0;
  width: 220px;
  height: 100%;
  background: #f8f9fa;
  border-right: 1px solid #dee2e6;
  padding-top: 1rem;
  transition: transform 0.3s ease;
  transform: translateX(-100%);
  z-index: 1040;
}
.sidebar.show {
  transform: translateX(0);
}
@media (min-width: 992px) {
  .sidebar {
    transform: translateX(0);
    left: 0;
  }
  .content {
    margin-left: 220px;
  }
}
</style>