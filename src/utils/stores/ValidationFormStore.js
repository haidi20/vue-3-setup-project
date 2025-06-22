import Vue from "vue";
import messageValidation from "@/utils/constants/MessageValidation.js";
import VueCookies from "vue-cookies";

const ValidationFormStore = {
    namespaced: true,
    state: {
        errors: {}, // ✅ Simpan semua error di sini
        is_active_validation: true,
        // is_active_validation: false,
    },

    mutations: {
        INSERT_ERROR(state, { field, message }) {
            if (message) {
                // console.info("insert error", field, message);
                Vue.set(state.errors, field, message);
            } else {
                // console.info("remove error", field);
                Vue.delete(state.errors, field);
            }
        },
        REMOVE_ERROR(state, field) {
            console.info("remove error", field);
            // console.info("remove error", field);
            if (state.errors[field]) {
                Vue.delete(state.errors, field);
            }
        },
        UPDATE_ISACTIVE_VALIDATION(state, payload) {
            state.is_active_validation = payload.value;
        },
        CLEAR_ERROR(state, commit) {
            // Hapus semua field satu per satu
            Object.keys(state.errors).forEach(key => {
                console.info("key clear error", key);
                Vue.delete(state.errors, key);
            });

            console.info("clear error", state.errors);
        },
    },

    actions: {
        validateField({ commit, state }, { fieldName, value, rules }) {
            let errors = [];

            // 🔥 Fungsi untuk mengambil pesan error dari file eksternal
            const getMessage = (rule, replacements = {}) => {
                let message = messageValidation[rule] || "Invalid input";

                return Object.keys(replacements).reduce((msg, key) => {
                    let value = replacements[key].replace(/_/g, " "); // 🔥 Ganti underscore dengan spasi
                    return msg.replace(`{${key}}`, value);
                }, message);
            };

            // ✅ Ambil data dari localStorage jika ada
            // const storedValue = VueCookies.get(fieldName);
            // if (storedValue !== null && value === "") {
            //     value = storedValue; // ✅ Gunakan data dari localStorage jika value kosong
            // }

            // 🔥 Validasi required (termasuk select option)
            if (rules.includes("required")) {
                if (value === "" || value === null || value === undefined) {
                    errors.push(getMessage("required", { field: fieldName }));
                }
            }

            if (rules.includes("email") && value && !/^\S+@\S+\.\S+$/.test(value)) {
                errors.push(getMessage("email", { field: fieldName }));
            }

            rules.forEach((rule) => {
                let [ruleName, param] = rule.split(":");

                // Cek apakah validasi harus dijalankan
                let shouldValidate = value || rules.includes("required");

                if (!shouldValidate) return;

                if (ruleName === "min" && param !== undefined && value.length < parseInt(param)) {
                    // console.info("param", param);
                    // console.info("value.length", value.length, "param", param);
                    errors.push(getMessage("min", { field: fieldName, length: param }));
                }

                if (ruleName === "max" && param !== undefined && value.length > parseInt(param)) {
                    errors.push(getMessage("max", { field: fieldName, length: param }));
                }

                if (ruleName === "numeric") {
                    if (isNaN(value)) {
                        // Jika bukan angka sama sekali
                        errors.push(getMessage("numeric", { field: fieldName }));
                    } else if (parseFloat(value) === 0) {
                        // Jika nilainya 0
                        errors.push(getMessage("numeric_zero", { field: fieldName }));
                    }
                }

                if (ruleName === "between") {
                    let [min, max] = param.split(",");
                    if (value.length < parseInt(min) || value.length > parseInt(max)) {
                        errors.push(getMessage("between", { field: fieldName, min, max }));
                    }
                }

                if (ruleName === "confirmed") {
                    let confirmField = document.querySelector(`[name="${param}"]`);
                    if (confirmField && value !== confirmField.value) {
                        // console.info("insert error");
                        errors.push(getMessage("confirmed", { field: fieldName, other: param }));
                    }
                }

                // ✅ Tambahkan validasi digits
                if (ruleName === "digits" && value.length !== parseInt(param)) {
                    errors.push(getMessage("digits", { field: fieldName, length: param }));
                }
            });

            // console.info("errors", errors);

            // ✅ Simpan error ke Vuex
            commit("INSERT_ERROR", { field: fieldName, message: errors[0] || "" });
        },
        onCheckValidationForm: async (context, payload) => {
            // context.commit("UPDATE_ISACTIVE_VALIDATION", { value: true });

            // console.info(context.state.errors);

            // 🔥 Perbaikan: Cek apakah errors memiliki isi hanya jika validasi aktif
            return !context.state.is_active_validation || Object.keys(context.state.errors).length === 0;


        },
    },
    getters: {
        getErrors(state) {
            console.info("getErrors", state.errors);
            return state.is_active_validation ? state.errors : {};
        },
        getIsActiveValidation(state) {
            return state.is_active_validation;
        },
    },
}

export default ValidationFormStore;
