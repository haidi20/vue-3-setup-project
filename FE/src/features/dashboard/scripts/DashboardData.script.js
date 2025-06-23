import { useStore } from 'vuex'
import { ref, computed, watch, onMounted, onUpdated, onUnmounted } from 'vue'
import { useState, useActions, useMutations, useGetters } from '@/utils/helpers/store_helper'

export function useDashboardData() {
  const { columns } = useState('dashboard', {
    columns: 'table_option.dashboards.columns',
  });

  // Edit data by id
  const onEdit = (index, item) => {
    console.log('Real Item:', item)
  }

  // Delete data by index
  const onDelete = (index) => {
    console.log("Deleting data with index:", index);
  }

  return { columns, onEdit, onDelete };
}