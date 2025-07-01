<template>
  <div class="d-flex flex-column min-vh-100">
    <!-- Navbar (Topbar) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Inventory</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#sidebarMenu"
          aria-controls="sidebarMenu"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-text d-none d-lg-block ms-auto">Aplikasi Akunting</span>
      </div>
    </nav>

    <div class="container-fluid flex-grow-1">
      <div class="row flex-nowrap">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-12 col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <li v-for="item in sidebarMenu" :key="item.title" class="nav-item">
                <router-link
                  :to="{ name: item.url.name }"
                  class="nav-link d-flex align-items-center text-white"
                  :class="{ active: isActive(item.url.name) }"
                  @click="closeSidebarOnMobile"
                >
                  <i v-if="item.icon" :class="item.icon"></i>
                  <span class="ms-2">{{ item.title }}</span>
                </router-link>
              </li>
            </ul>
          </div>
        </nav>

        <!-- Main Content -->
        <main class="col px-0 flex-grow-1">
          <div class="pt-3 px-3">
            <router-view />
          </div>
          <Footer />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import Footer from "@/layouts/Footer.vue";
import { useRoute } from "vue-router";

const route = useRoute();

const sidebarMenu = [
  {
    title: "Dashboard",
    url: { name: "Dashboard" },
    icon: "bi bi-speedometer2",
  },
  {
    title: "Jenis Usaha",
    url: { name: "BusinessField" },
    icon: "bi bi-briefcase",
  },
  {
    title: "Pengguna",
    url: { name: "User" },
    icon: "bi bi-person",
  },
];

function isActive(name) {
  return route.name === name;
}

function closeSidebarOnMobile() {
  // Optionally close sidebar on mobile after click
  const sidebar = document.getElementById("sidebarMenu");
  if (
    window.innerWidth < 992 &&
    sidebar &&
    sidebar.classList.contains("show")
  ) {
    // Bootstrap collapse
    const collapse = bootstrap.Collapse.getInstance(sidebar);
    if (collapse) collapse.hide();
  }
}
</script>

<style scoped>
.sidebar {
  min-height: 100vh;
}
.nav-link.active,
.nav-link:hover {
  background: #495057;
  color: #fff !important;
}
</style>
