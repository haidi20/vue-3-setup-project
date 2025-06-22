import messageValidation from '@/utils/constants/MessageValidation'

export default {
    namespaced: true,

    state: () => ({
        errors: {}, // Simpan semua error di sini
        is_active_validation: true
    }),

    mutations: {
        INSERT_ERROR(state, { field, message }) {
            this._vm.$set(state.errors, field, message)
        },
        REMOVE_ERROR(state, field) {
            if (state.errors[field]) {
                this._vm.$delete(state.errors, field)
            }
        },
        UPDATE_ISACTIVE_VALIDATION(state, payload) {
            state.is_active_validation = payload.value
        },
        CLEAR_ERROR(state) {
            Object.keys(state.errors).forEach(key => {
                this._vm.$delete(state.errors, key)
            })
        }
    },

    actions: {
        validateField({ commit }, { fieldName, value, rules }) {
            let errors = []

            const getMessage = (rule, replacements = {}) => {
                let message = messageValidation[rule] || 'Invalid input'

                return Object.keys(replacements).reduce((msg, key) => {
                    const value = replacements[key].replace(/_/g, ' ')
                    return msg.replace(`{${key}}`, value)
                }, message)
            }

            if (rules.includes('required') && (!value || value === '')) {
                errors.push(getMessage('required', { field: fieldName }))
            }

            rules.forEach(rule => {
                let [ruleName, param] = rule.split(':')

                if (ruleName === 'min' && param !== undefined && value?.length < parseInt(param)) {
                    errors.push(getMessage('min', { field: fieldName, length: param }))
                }

                if (ruleName === 'max' && param !== undefined && value?.length > parseInt(param)) {
                    errors.push(getMessage('max', { field: fieldName, length: param }))
                }

                if (ruleName === 'email' && value && !/^\S+@\S+\.\S+$/.test(value)) {
                    errors.push(getMessage('email', { field: fieldName }))
                }

                if (ruleName === 'numeric') {
                    if (isNaN(value)) {
                        errors.push(getMessage('numeric', { field: fieldName }))
                    } else if (parseFloat(value) === 0) {
                        errors.push(getMessage('numeric_zero', { field: fieldName }))
                    }
                }

                if (ruleName === 'between' && param) {
                    let [min, max] = param.split(',').map(Number)
                    const valLength = value.toString().length
                    if (valLength < min || valLength > max) {
                        errors.push(getMessage('between', { field: fieldName, min, max }))
                    }
                }

                if (ruleName === 'confirmed' && param) {
                    const confirmField = document.querySelector(`[name="${param}"]`)
                    if (confirmField && value !== confirmField.value) {
                        errors.push(getMessage('confirmed', { field: fieldName, other: param }))
                    }
                }

                if (ruleName === 'digits' && param) {
                    if (value.toString().length !== parseInt(param)) {
                        errors.push(getMessage('digits', { field: fieldName, length: param }))
                    }
                }
            })

            commit('INSERT_ERROR', { field: fieldName, message: errors[0] || '' })
        },

        onCheckValidationForm({ state }) {
            return !state.is_active_validation || Object.keys(state.errors).length === 0
        },

        clearErrors({ commit }) {
            commit('CLEAR_ERROR')
        }
    },

    getters: {
        getErrors(state) {
            return state.is_active_validation ? state.errors : {}
        },
        getIsActiveValidation(state) {
            return state.is_active_validation
        }
    }
}