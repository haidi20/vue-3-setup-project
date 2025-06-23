import { createStore } from 'vuex'
import DashboardStore from '@/features/dashboard/stores/Dashboard.store'
import BusinessFieldStore from '@/features/business-field/stores/BusinessField.store'
import ValidationFormStore from "@/utils/stores/ValidationFormStore";

export default createStore({
  modules: {
    dashboard: DashboardStore,
    businessField: BusinessFieldStore,
    validationForm: ValidationFormStore
  }
});