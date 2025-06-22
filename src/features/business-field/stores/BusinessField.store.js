import axiosCustom from "@/utils/helpers/axios_custom";
import { StatusResponseEnum } from "@/utils/constants/enums";

const defaultTableOptions = {
  filters: {
    search: "",
    offset: 0,
    limit: 5,
    order_by: "created_at",
    sort_by: "desc",

    user_id: null,
    job_type_id: "",
    province_code: "",
  },
  columns: [
    {
      label: "Kode",
      field: "code",
      class: "",
      width: "120px",
    },
    {
      label: "Nama",
      field: "name",
      class: "",
      width: "200px",
    },
  ],
  page: 1,
  per_page: 5,
  per_page_options: [],
};


const defaultForm = {
  id: null,
  name: null,
}

// business field = bidang usaha | kategori bisnis, dll.

const BusinessFieldStore = {
  namespaced: true,
  state: {
    base_url: null,
    data: {
      business_fields: [
        // ...BusinessFields,
      ],
    },
    select: {
      business_fields: [],
    },
    total_data: {
      business_fields: 0,
    },
    table_options: {
      business_fields: {
        ...defaultTableOptions,
        filters: Object.assign({}, defaultTableOptions.filters),
      },
    },
    form: { ...defaultForm },
    loading: {
      data_business_fields: false,
      select_business_fields: false,
    },
  },
  mutations: {
    INSERT_DATA(state, payload) {
      Object.assign(state.data, payload);
    },
    UPDATE_TOTAL_DATA(state, payload) {
      // console.info("payload total_data:", payload);
      Object.assign(state.total_data, payload);
    },
    UPDATE_FILTERS(state, { filter }) {
      // console.info("payload filter:", filter);
      state.table_options.business_fields.filters = {
        ...state.table_options.business_fields.filters,
        ...filter,
      };
    },
    UPDATE_SELECT(state, payload) {
      // console.info("payload business_fields:", payload);
      Object.assign(state.select, payload);
    },
    CLEAR_FORM(state, payload) {
      state.form = { ...defaultForm };
    },
    UPDATE_LOADING(state, payload) {
      Object.assign(state.loading, payload);
    },
  },
  actions: {
    fetchBusinessFields: async (context, payload) => {

      try {
        context.commit("UPDATE_LOADING", { data_business_fields: true });
        const search = payload?.search;
        const filters = context.state.table_options.business_fields.filters;

        // console.info("fetchBusinessFields", search, filters);
        const response = await axiosCustom.get("/business-fields", {
          params: filters,
        });

        const body = response.data;
        const data = body.data || {};

        if (body.status !== StatusResponseEnum.SUCCESS) {

          return {
            status: StatusResponseEnum.ERROR,
            message: body.message,
            data: null, // Ganti dengan data yang sesuai jika ada
          };
        }

        context.commit("INSERT_DATA", {
          business_fields: data.business_fields || [],
        });
        context.commit("UPDATE_TOTAL_DATA", {
          business_fields: data.total || 0,
        });

        return body;
      } catch (error) {
        console.info(error);
      } finally {
        context.commit("UPDATE_LOADING", { data_business_fields: false });
      }
    },
    fetchSelectBusinessFields: async (context, payload) => {
      // console.info("fetchSelectBusinessFields", payload);
      context.commit("UPDATE_LOADING", { select_business_fields: true });

      const search = payload?.search;

      return await axiosCustom
        .get(
          `/master/business-fields`, {
          params: { search, },
        })
        .then((responses) => {
          // console.info(responses);
          if (responses.status == 200) {
            const body = responses.data;
            if (body.status == "success") {
              const business_fields = body.data.business_fields;

              // console.info(business_fields);
              context.commit("UPDATE_SELECT", {
                business_fields,
              });

              return business_fields;
            }
          }

          return [];

        })
        .catch((err) => {
          console.info(err);
        })
        .finally(() => {
          context.commit("UPDATE_LOADING", { select_business_fields: true });
        });
    },
  },
  getters: {
    //
  },
}

export default BusinessFieldStore;
