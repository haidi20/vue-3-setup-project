<template>
  <SelectServerSide
    value="id"
    label="name"
    id="lapangan_usaha"
    name="lapangan_usaha"
    options="business_fields"
    nameModel="business_field_name"
    namespaceForm="dashboard"
    namespaceSelect="businessField"
    nameAction="fetchSelectBusinessFields"
    placeholder="PILIH LAPANGAN USAHA"
    textEmpty="Maaf, tidak ada lapangan usaha"
    :onChange="onChangeBusinessField"
  />
</template>

<script setup>
import SelectServerSide from "@/components/SelectServerSide.vue";

const onChangeBusinessField = (value) => {
  console.info("value business field:", value);
};
</script>