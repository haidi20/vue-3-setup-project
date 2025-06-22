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

  onMounted(() => {
    fetchSelectBusinessFields();
  });

  return { columns, filters };
}