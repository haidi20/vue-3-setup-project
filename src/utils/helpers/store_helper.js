import { computed } from 'vue'
import { useStore } from 'vuex'

// === useState ===
export function useState(moduleNamespace, mapping) {
  const store = useStore()
  const baseState = moduleNamespace ? store.state[moduleNamespace] : store.state

  const result = {}

  Object.keys(mapping).forEach(key => {
    const path = mapping[key]
    result[key] = computed(() => {
      return path.split('.').reduce((acc, key) => acc?.[key], baseState)
    })
  })

  return result
}

// === useMutations ===
export function useMutations(moduleNamespace, mapping) {
  const store = useStore()

  const result = {}

  Object.keys(mapping).forEach(key => {
    const mutationPath = mapping[key]
    const commitType = moduleNamespace ? `${moduleNamespace}/${mutationPath}` : mutationPath

    result[key] = (payload) => store.commit(commitType, payload)
  })

  return result
}

// === useActions ===
export function useActions(moduleNamespace, mapping) {
  const store = useStore()

  const result = {}

  Object.keys(mapping).forEach(key => {
    const actionPath = mapping[key]
    const dispatchType = moduleNamespace ? `${moduleNamespace}/${actionPath}` : actionPath

    result[key] = (payload) => store.dispatch(dispatchType, payload)
  })

  return result
}

// === useGetters ===
export function useGetters(moduleNamespace, mapping) {
  const store = useStore()

  const result = {}

  Object.keys(mapping).forEach(key => {
    const getterPath = mapping[key]
    const getterType = moduleNamespace ? `${moduleNamespace}/${getterPath}` : getterPath

    result[key] = computed(() => store.getters[getterType])
  })

  return result
}