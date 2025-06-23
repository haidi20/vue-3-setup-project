import { useStore } from 'vuex'
import { ref, computed, watch, onMounted, onUpdated, onUnmounted } from 'vue'
import { useState, useActions, useMutations, useGetters } from '@/utils/helpers/store_helper'

export default function useBusinessField() {
  const { columns, filters } = useState('businessField', {
    filters: 'table_options.business_fields.filters',
    columns: 'table_options.business_fields.columns',
  });

  const { fetchSelectBusinessFields } = useActions('businessField', {
    fetchSelectBusinessFields: 'fetchSelectBusinessFields',
  });

  // Generate columns for each day of the current month
  const getColumns = () => {
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth(); // 0-indexed
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const dayColumns = [];
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    for (let day = 1; day <= daysInMonth; day++) {
      const date = new Date(year, month, day);
      const dayName = dayNames[date.getDay()];
      dayColumns.push({
        label: dayName,
        field: `day_${day}`,
      });
    }
    // Gabungkan columns dari state dengan dayColumns
    return [...columns.value, ...dayColumns];
  };


  // Kolom yang akan difiksasi (index)
  const columnFixed = [0, 1];

  return {
    columns,
    getColumns,
    filters,
    fetchSelectBusinessFields,
    columnFixed,
  };
}