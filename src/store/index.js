import { createStore } from 'vuex'
import DashboardStore from '@/features/dashboard/stores/Dashboard.store'

export default createStore({
  modules: {
    dashboard: DashboardStore
  }
});