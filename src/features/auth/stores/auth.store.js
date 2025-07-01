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
};

const AuthStore = {
  namespaced: true,
  state: {
    data: {
      auth: [],
      groups: [],
    },
    total_data: {
      auth: 0,
    },
    table_options: {
      auth: {
        ...defaultTableOptions,
      },
    },
    form: { ...defaultForm },
    loading: {
      data_auth: false,
      data_groups: false,
    },
    user_login: {
      db: 'odoo',
      username: 'nhaidii@yahoo.com',
      password: 'samarinda',
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
      state.table_options.auth.filters = {
        ...state.table_options.auth.filters,
        ...filter,
      };
    },
    CLEAR_FORM(state) {
      state.form = { ...defaultForm };
    },
  },
  actions: {
    onLogin: async (context, payload) => {
      try {
        const filter = context.state.table_options.auth.filters;

        context.commit("UPDATE_LOADING", { data_auth: true });

        const { db, username, password } = context.state.user_login;

        const response = await fetch('/web/session/authenticate', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            jsonrpc: '2.0',
            method: 'call',
            params: {
              db,
              login: username,
              password,
            },
          }),
        });

        const odooLoginData = await response.json();

        // Jika login berhasil, lanjutkan ke endpoint lain jika perlu
        console.log('Login berhasil auth store:', odooLoginData.result);

        context.commit("INSERT_DATA", {
          auth: odooLoginData.result,
        });

        // Placeholder return
        return {
          status: "SUCCESS",
          message: "Login dan fetch auth berhasil",
          data: {
            odoo_session: odooLoginData.result,
            // auth: authData, // jika ada data tambahan dari auth sistem kamu
          }
        };

      } catch (error) {
        return {
          status: "FAIL",
          message: "Error fetching auth data",
          data: {
            error: error.message,
            payload,
          }
        };
      } finally {
        context.commit("UPDATE_LOADING", { data_auth: false });
      }
    },
    fetchGroupNames: async (context, groupIds) => {
      try {
        context.commit("UPDATE_LOADING", { data_groups: true });

        const response = await fetch('/web/dataset/call_kw', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            jsonrpc: '2.0',
            method: 'call',
            params: {
              model: 'res.groups',
              method: 'search_read',
              args: [],
              kwargs: {
                domain: [['id', 'in', groupIds]],
                fields: ['id', 'name'],
              }
            }
          })
        });

        const result = await response.json();

        console.log('fetchGroupNames result:', result);

        // Optionally commit to store if needed
        context.commit("INSERT_DATA", { groups: result.result });

        return {
          status: "SUCCESS",
          message: "Fetch group names berhasil",
          data: result.result || [],
        };
      } catch (error) {
        return {
          status: "FAIL",
          message: "Error fetching group names",
          data: {
            error: error.message,
            groupIds,
          }
        };
      } finally {
        context.commit("UPDATE_LOADING", { data_groups: false });
      }
    },
  },
  getters: {
    //
  },
};

export default AuthStore;
