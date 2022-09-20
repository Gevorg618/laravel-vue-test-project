import Vue from 'vue'
import Vuex from 'vuex'
import items from "./modules/user"
import book from "./modules/book"
import library from "./modules/library";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        items,
        book,
        library
    }
})
