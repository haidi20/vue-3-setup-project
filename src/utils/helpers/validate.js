import store from "@/store"; // Sesuaikan jumlah `../` sesuai struktur folder

const validateField = (el) => {
    const rules = el.getAttribute("data-rules") ? el.getAttribute("data-rules").split("|") : [];
    const fieldName = el.getAttribute("name") || "Field";
    const value = el.value.trim();

    // store.commit("validationForm/UPDATE_ISACTIVE_VALIDATION", { value: true });
    store.dispatch("validationForm/validateField", { fieldName, value, rules });
};

export default {
    bind(el) {
        if (!el.getAttribute("data-rules")) return; // Pastikan ada aturan validasi

        el.isDirty = false; // Tambahkan properti untuk menandai apakah input sudah tersentuh

        const validate = () => {
            el.isDirty = true; // Tandai input sebagai sudah digunakan

            setTimeout(() => {
                validateField(el); // Jalankan validasi setelah Vue memperbarui state
            }, 0); // Eksekusi setelah event loop berikutnya
        };

        el.addEventListener("input", validate);
        el.addEventListener("blur", validate);
        el.addEventListener("change", validate);
        el.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === "Tab") {
                validate(e);
            }
        });
    },

    update(el) {
        if (el.isDirty) {
            validateField(el); // Jalankan validasi hanya jika sudah tersentuh
        }
    }
};

// 🔥 Helper untuk mendapatkan error dari Vuex
export const getErrors = () => {
    const errors = store.state.validationForm.is_active_validation ? store.state.validationForm.errors : {};
    console.log("Validation Errors:", errors); // Debugging
    return errors;
};

// 🔥 Memaksa validasi semua field dengan pendekatan `bind()`
export const onCheckValidationForm = async (form) => {
    if (!form) {
        console.log("⚠️ Form tidak ada atau undefined!");
        return false;
    }

    // 🔥 Ambil semua input, select, dan textarea yang memiliki dataset validationRules
    const inputs = form.querySelectorAll("[data-rules]");

    // 🔥 Jalankan validasi seperti yang dilakukan `bind()`
    inputs.forEach((el) => {
        const rules = el.getAttribute("data-rules") || ""; // Ambil aturan validasi
        validateField(el, rules); // Gunakan function yang sama seperti di directive
    });

    return await store.dispatch("validationForm/onCheckValidationForm");
};
