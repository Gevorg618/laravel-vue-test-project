import axios from "axios";

export default {
    state: {
        books: [],
        product: null
    },
    actions: {
        async searchBooks({commit}, params) {
            try {
                let {data} = await axios.post(`/api/books/search`, params)
                commit('SET_BOOKS', data.data)
                return data
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async likeBook({commit}, id) {
            try {
                let {data} = await axios.get(`/api/books/${id}/like`)

                return data
            } catch (e) {
                return false
            }
        },

        async addBook({commit}, params) {
            try {
                return await axios.post(`/api/books`, params)
            } catch (e) {
                return false
            }
        },

        async deleteBook ({commit}, id) {
            try {
                let {data} = await axios.delete(`/api/books/${id}`)
                return data
            } catch (e) {
                return false
            }
        }
    },
    mutations: {
        SET_BOOKS(state, data) {
            state.books = data
        },

        SET_SINGLE_BOOK(state, data) {
            state.book = data
        },
    },

    getters: {
        GET_BOOKS(state) {
            return state.books
        },

        GET_BOOK(state) {
            return state.book
        },
    }
}
