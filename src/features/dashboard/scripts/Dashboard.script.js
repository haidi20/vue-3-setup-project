import { ref, computed, watch, onMounted, onUpdated, onUnmounted } from 'vue'
import { useStore } from 'vuex'
import { useState, useActions, useMutations, useGetters } from '@/utils/helpers/store_helper'


export default function useDashboard() {
  const store = useStore();

  // ========== DATA ==========
  const count_items = ref(0);

  // ========== COMPUTED ==========
  const totalStock = computed(() => count_items.value * 10);
  const { dashboards, total_data } = useState('dashboard', {
    dashboards: 'data.dashboards',
    total_data: 'total_data.dashboards'
  })

  // ========== METHODS ==========
  const { loading } = useMutations('dashboard', {
    loading: 'loading'
  })
  const { fetchDashboards } = useActions('dashboard', {
    fetchDashboards: 'fetchData',
  })
  const { getDashboards } = useGetters('dashboard', {
    getDashboards: 'getDataPaginated'
  })

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
    // dashboard
    dashboards,
    total_data,
    fetchDashboards,
    getDashboards,
    loading,

    addCount,
    removeCount,
  }
}