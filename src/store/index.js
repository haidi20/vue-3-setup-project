import { createStore } from 'vuex'
import authStore from '@/features/auth/stores/Auth.store'
import UserStore from '@/features/user/stores/User.store'
import DashboardStore from '@/features/dashboard/stores/Dashboard.store'
import BusinessFieldStore from '@/features/business-field/stores/BusinessField.store'
import ValidationFormStore from "@/utils/stores/ValidationFormStore";

export default createStore({
  modules: {
    auth: authStore,
    user: UserStore,
    dashboard: DashboardStore,
    businessField: BusinessFieldStore,
    validationForm: ValidationFormStore
  }
});