import axiosCustom from "@/utils/helpers/axios_custom";

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
    table_options: {
      business_fields: {
        filters: {
          //
        },
        columns: [
          // {
          //     label: "",
          //     class: "",
          //     width: "200px",
          // },
        ],
        total: 0,
        limit: 5,
        offset: 0,
        // perPageValues: [5, 10, 25, 50, 100],
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
      context.commit("UPDATE_LOADING", { data_business_fields: true });
      const search = payload?.search;

      return await axiosCustom
        .get(
          `/master/business-fields`, {
          params: { search, },
        })
        .then((responses) => {
          // console.info(responses);
          if (responses.status == 200 && responses.data.status === "success") {
            const body = responses.data;
            const business_fields = body.data.business_fields;

            // console.info("business_fields:", business_fields);

            // console.info(business_fields);
            context.commit("INSERT_DATA", {
              business_fields,
            });

            return business_fields;
          }

          return [];

        })
        .catch((err) => {
          console.info(err);
        })
        .finally(() => {
          context.commit("UPDATE_LOADING", { data_business_fields: false });
        });
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
