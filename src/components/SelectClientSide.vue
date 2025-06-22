<template>
  <el-select
    v-model="internalValue"
    :placeholder="placeholder"
    filterable
    :class="addClass"
    @change="handleChange"
    style="width: 100%"
  >
    <el-option
      v-for="option in localOptions"
      :key="option[value]"
      :label="getOption(option)"
      :value="option[value]"
    />

    <!-- 💡 Custom Empty State -->
    <template #empty>{{ textEmpty }}</template>
  </el-select>
</template>

<script setup>
import { ref, computed, watch } from "vue";

// === Props ===
const props = defineProps({
  options: {
    type: Array,
    required: true,
    default: () => [],
  },
  value: {
    type: String,
    default: "id",
  },
  label: {
    type: String,
    default: "name",
  },
  textEmpty: {
    type: String,
    default: "Data tidak tersedia",
  },
  placeholder: {
    type: String,
    default: "Pilih",
  },
  onChange: {
    type: Function,
    default: null,
  },
  addClass: {
    type: [String, Array, Object],
    default: "",
  },
  valueSelected: {
    type: [String, Number, null],
    default: null,
  },
  limitLabel: {
    type: Number,
    default: 0,
  },
});

// === Emits ===
const emit = defineEmits(["update:valueSelected"]);

// === Internal Value ===
const internalValue = ref(props.valueSelected);

// === Watch: valueSelected dari luar → internalValue ===
watch(
  () => props.valueSelected,
  (newVal) => {
    internalValue.value = newVal;
  }
);

// === Watch: internalValue berubah → kirim ke luar via emit ===
watch(
  () => internalValue.value,
  (newVal) => {
    emit("update:valueSelected", newVal);
  }
);

// === Computed: localOptions ===
const localOptions = computed(() => {
  return props.options || [];
});

// === Method: handleChange ===
function handleChange(value) {
  if (typeof props.onChange === "function") {
    props.onChange(value);
  }
}

// === Method: getOption (untuk truncate label) ===
function getOption(option) {
  const label = option[props.label] || "";
  if (props.limitLabel !== 0 && label.length > props.limitLabel) {
    return label.slice(0, props.limitLabel) + "...";
  }
  return label;
}
</script>
