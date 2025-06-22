<script setup>
import { ref, computed, watch } from "vue";
import { useStore } from "vuex";
import debounce from "lodash/debounce";

// === Props ===
const props = defineProps({
  id: {
    type: String,
    default: "",
  },
  name: {
    type: String,
    default: "",
  },
  limitLabel: {
    type: Number,
    default: 0,
  },
  label: {
    type: String,
    default: "name",
  },
  value: {
    type: String,
    default: "id",
  },
  options: {
    type: String,
    required: true,
  },
  textEmpty: {
    type: String,
    required: true,
  },
  namespaceForm: {
    type: String,
    required: true,
  },
  namespaceSelect: {
    type: String,
    required: true,
  },
  nameModel: {
    type: String,
    required: true,
  },
  nameAction: {
    type: String,
    required: true,
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
  isUseValidation: {
    type: Boolean,
    default: false,
  },
  dataRules: {
    type: String,
    default: "",
  },
  valueSelected: {
    type: [String, Number, null],
    default: null,
  },
});

const emit = defineEmits(["update:valueSelected"]);

// === Store & State ===
const store = useStore();
const isLoading = ref(false);
const internalValue = ref(props.valueSelected);

// === Computed: Form & Select State ===
const form = computed(() => {
  return store.state[props.namespaceForm]?.form || {};
});

const select = computed(() => {
  const result = store.state[props.namespaceSelect]?.select || {};

  // console.info("select state:", result);

  return result;
});

const localOptions = computed(() => {
  const result =
    store.state[props.namespaceSelect]?.select[props.options] || [];

  // console.info("localOptions:", result);

  return result;
});

// === Watch untuk v-model ===
watch(
  () => props.valueSelected,
  (newVal) => {
    internalValue.value = newVal;
  }
);

watch(
  () => internalValue.value,
  (newVal) => {
    emit("update:valueSelected", newVal);
  }
);

// === Fetch Data via Action ===
function fetchData(search = "") {
  return store.dispatch(`${props.namespaceSelect}/${props.nameAction}`, {
    search,
  });
}

// === Handle Remote Search ===
const handleRemote = debounce((query) => {
  if (query.length >= 2 || query === "") {
    isLoading.value = true;
    fetchData(query)
      .catch((err) => console.error("Error saat fetch data:", err))
      .finally(() => {
        isLoading.value = false;
      });
  }
}, 300);

// === Get Option Label ===
function getOption(option) {
  const label = option[props.label] || "";
  if (props.limitLabel && label.length > props.limitLabel) {
    return label.slice(0, props.limitLabel) + "...";
  }
  return label;
}

// === Handle Change ===
function handleChange(value) {
  if (typeof props.onChange === "function") {
    props.onChange(value);
  }

  if (props.isUseValidation && props.dataRules) {
    const fieldName = props.name;
    const rules = props.dataRules.split("|");
    store.dispatch("validationForm/validateField", {
      fieldName,
      value,
      rules,
    });
  }
}
</script>

<template>
  <el-select
    v-model="internalValue"
    :placeholder="placeholder"
    filterable
    remote
    :remote-method="handleRemote"
    :class="addClass"
    style="width: 100%"
    @change="handleChange"
    :loading="isLoading"
  >
    <el-option
      v-for="option in localOptions"
      :key="option[value]"
      :label="getOption(option)"
      :value="option[value]"
    />

    <!-- 💡 Custom Empty State -->
    <template #empty>{{ textEmpty }}</template>

    <!-- 💬 Loading state -->
    <template #loading>
      <div class="el-select-dropdown__item">
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        Memuat...
      </div>
    </template>
  </el-select>
</template>