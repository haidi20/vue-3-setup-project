import { ref, computed, watch, onMounted, onUpdated, onUnmounted } from 'vue'

export default function useDashboard() {
  // ========== DATA ==========
  const count_items = ref(0)

  // ========== COMPUTED ==========
  const totalStock = computed(() => {
    return count_items.value * 10;
  })

  // ========== METHODS ==========
  const addCount = () => {
    count_items.value++
  }

  const removeCount = () => {
    if (count_items.value > 0) count_items.value--
  }

  // ========== WATCH ==========
  watch(
    () => count_items.value,
    (newVal) => {
      if (newVal >= 5) {
        alert('Kamu sudah menekan tombol lebih dari 5 kali!')
      }
    }
  )

  // ========== LIFECYCLE HOOKS ==========
  onMounted(() => {
    // console.log('Dashboard mounted')
  });

  onUpdated(() => {
    // console.log('Dashboard updated')
  });

  onUnmounted(() => {
    // console.log('Dashboard unmounted')
  });

  // ========== RETURN ==========
  return {
    // Data
    count_items,
    totalStock,
    addCount,
    removeCount,
  }
}