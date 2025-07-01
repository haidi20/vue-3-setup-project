<template>
  <div class="container mt-5">
    <div class="card shadow-sm p-4 mb-5 bg-body rounded">
      <h1 class="card-title text-center mb-4">Pengguna</h1>

      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Peran (Role)</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.email || '-' }}</td>
              <td>
                <span>
                  {{
                  user.groups?.length
                  }}
                </span>
                <ul>
                  <li v-for="group in user.groups" :key="group">{{ group.id }} - {{ group.name }}</li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>

        <p v-if="error" style="color: red">{{ error }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import useUser from "@/features/user/scripts/User.script.js";

const { users, error } = useUser();
</script>