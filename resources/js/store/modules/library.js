import axios from "axios";

export default {
    state: {
        libraries: [],
    },
    actions: {
        async getLibrariesWithBooks({commit}, params) {

            try {
                let {data} = await axios.get(`/api/libraries/books`, params)
                commit('SET_LIBRARIES', data.data)
                return data
            } catch (e) {
                return false
            }

        },

        async getLibraries({commit}, params) {

            try {
                let {data} = await axios.get(`/api/libraries`, params)
                commit('SET_LIBRARIES', data.data)
                return data
            } catch (e) {
                return false
            }

        },

    },
    mutations: {
        SET_LIBRARIES(state, data) {
            state.libraries = data
        },
    },

    getters: {
        GET_LIBRARIES(state) {
            return state.libraries
        },
    }
}
