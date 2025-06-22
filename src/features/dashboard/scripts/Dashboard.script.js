import { ref } from 'vue'

export function useDashboard() {
  const count_items = ref(0);

  const addCount = () => {
    count_items.value++;
  };

  return {
    count_items,
    addCount
  };
}