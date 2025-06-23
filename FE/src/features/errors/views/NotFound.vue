<template>
  <div class="not-found container text-center mt-5">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="96"
      height="96"
      fill="currentColor"
      class="bi bi-exclamation-triangle text-danger mb-4"
      viewBox="0 0 16 16"
    >
      <path
        d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.856c.06.104.009.228-.112.228H1.192a.13.13 0 0 1-.112-.228L7.938 2.016zm.823-1.447a1.13 1.13 0 0 0-1.922 0L.082 12.425C-.418 13.233.145 14.25 1.192 14.25h13.616c1.047 0 1.61-1.017 1.11-1.825L8.76.569z"
      />
      <path
        d="M7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm.93-6.481a.5.5 0 0 0-.858 0l-2.857 5.5A.5.5 0 0 0 5.5 11h5a.5.5 0 0 0 .429-.981l-2.857-5.5z"
      />
    </svg>
    <h1 class="display-4">404 - Halaman Tidak Ditemukan</h1>
    <p class="lead">Halaman yang Anda cari tidak tersedia.</p>
    <router-link to="/" class="btn btn-primary mt-3">Kembali ke Beranda</router-link>
  </div>
</template>

<script setup>
// Tidak ada script yang diperlukan
</script>

<style scoped>
/* Tidak perlu styling tambahan, gunakan Bootstrap 5 */
</style>
