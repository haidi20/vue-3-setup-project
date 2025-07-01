// import axiosCustom from "@/utils/helpers/axios_custom";
// import { swalToast } from "@/utils/helpers/helper";
// import { StatusResponseEnum } from "@/utils/constants/enums";

const defaultTableOptions = {
  filters: {
    search: "",
    offset: 0,
    limit: 5,
    order_by: "created_at",
    sort_by: "desc",

    search: "",
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
};

const UserStore = {
  namespaced: true,
  state: {
    data: {
      users: [],
    },
    total_data: {
      users: 0,
    },
    table_options: {
      users: {
        ...defaultTableOptions,
      },
    },
    form: { ...defaultForm },
    loading: {
      data_users: false,
    },
  },
  mutations: {
    INSERT_DATA(state, payload) {
      Object.assign(state.data, payload);
    },
    UPDATE_LOADING(state, payload) {
      Object.assign(state.loading, payload);
    },
    UPDATE_FILTERS(state, { filter, status_data }) {
      state.table_options.users.filters = {
        ...state.table_options.users.filters,
        ...filter,
      };
    },
    CLEAR_FORM(state) {
      state.form = { ...defaultForm };
    },
  },
  actions: {
    fetchUsers: async (context, payload) => {
      try {
        const filter = context.state.table_option.filter;

        context.commit("UPDATE_LOADING", { data_users: true });

        const response = await axiosCustom.get(`/users`, {
          params: {
            ...filter,
          },
        });

        const body = response.data;
        const data = body.data;

        console.info("fetch data body job seekers:", body);

        if (body.status !== StatusResponseEnum.SUCCESS) {
          console.error("Error fetching job vacancies:", response);
          return {
            status: StatusResponseEnum.FAIL,
            message: body.message,
            data: data,
          }
        }

        const job_seekers = data.seekers;
        const total_data = data.total_data;

        context.commit("INSERT_DATA", { job_seekers });
        context.commit("UPDATE_TOTAL_DATA", { job_seekers: total_data });

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
    //
  },
};

export default UserStore;
