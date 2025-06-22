import axiosCustom from "@/utils/helpers/axios_custom";
import { swalToast } from "@/utils/helpers/helper";
import { StatusResponseEnum } from "@/utils/constants/enums";
import dashboardJson from "../data/datatable.json";

const defaultTableOptions = {
  filters: {
    search: "",
    offset: 0,
    limit: 5,
    order_by: "created_at",
    sort_by: "desc",
  },
  columns: [
    //  
  ],
  page: 1,
  per_page: 5,
  per_page_options: [],
};

const defaultForm = {
  id: null,
  business_field_id: "",
  business_field_name: null,
};

const DashboardStore = {
  namespaced: true,
  state: {
    data: {
      dashboards: [
        ...dashboardJson,
      ],
    },
    selected: {
      dashboards: [
        ...dashboardJson,
      ],
    },
    total_data: {
      dashboards: 2,
    },
    table_option: {
      dashboards: {
        ...defaultTableOptions,
      },
    },
    form: { ...defaultForm },
    loading: {
      data_dashbaords: false,
    },
  },
  mutations: {
    INSERT_DATA(state, payload) {
      Object.assign(state.data, payload);
    },
    UPDATE_TOTAL_DATA(state, payload) {
      Object.assign(state.total_data, payload);
    },
    UPDATE_LOADING(state, payload) {
      Object.assign(state.loading, payload);
    },
    UPDATE_FILTERS(state, { filter }) {
      state.table_option.dashboards.filters = {
        ...state.table_option.dashboards.filters,
        ...filter,
      };
    },
    CLEAR_FORM(state) {
      state.form = { ...defaultForm };
    },
  },
  actions: {
    fetchData: async (context, payload) => {
      try {
        const filter = context.state.table_option.dashboards.filters;

        context.commit("UPDATE_LOADING", { data_dashbaords: true });

        console.info("fetch dashboards", filter);

        return;

        const response = await axiosCustom.get(`/dashboards`, {
          params: {
            ...filter,
          },
        });

        const body = response.data;
        const data = body.data;

        if (body.status !== StatusResponseEnum.SUCCESS) {
          return {
            status: StatusResponseEnum.FAIL,
            message: body.message,
            data: data,
          }
        }

        const dashboards = data.dashboards || [];
        const total_data = data.total_data || 0;

        context.commit("INSERT_DATA", { dashboards });
        context.commit("UPDATE_TOTAL_DATA", { dashboards: total_data });

        return body;
      } catch (error) {
        console.error("Fetch Data users Error:", error);
        return {
          status: StatusResponseEnum.FAIL,
          message: "Error fetching users data",
          data: {
            error: error.message,
            payload,
          }
        };
      } finally {
        context.commit("UPDATE_LOADING", { data_users: false });
      }
    },
  },
  getters: {
    getDataPaginated: (state) => {
      const { filters, page, per_page } = state.table_option.dashboards;
      const { search } = filters;

      // console.info("filters", filters);

      let dashboards = state.data.dashboards;

      return dashboards;
    }
  },
};

export default DashboardStore;
