<template>
    <section>
        <confirm-delete-alert :dialog="showDeleteAlert" @deleteAnswer="deleteBook" ></confirm-delete-alert>
        <v-form @submit.prevent="search">
            <v-row class="justify-center align-center">
                <v-col
                    cols="7"
                    md="4"
                >
                    <v-text-field
                        v-model="searchData"
                        label="Search"
                        required
                    ></v-text-field>
                </v-col>
                <v-col
                    cols="1"
                    md="2"
                >
                    <v-btn type="submit">
                        <v-icon
                            large
                            color="blue darken-2"
                        >
                            mdi-magnify
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-form>

        <v-row>
            <v-col  v-for="(book, bookKey) in books" cols="12" :key="book.id" md="6" lg="4">
                <v-card
                    class="mx-auto"
                    color="#26c6da"
                    dark
                    max-width="400"
                >
                    <v-card-title>
                        <span class="text-h6 font-weight-light">{{book.title}}</span>
                    </v-card-title>

                    <v-card-text class="text-h5 font-weight-bold book-description">
                        {{book.description}}
                    </v-card-text>

                    <v-card-actions>
                        <v-list-item class="grow flex-wrap">

                            <v-list-item-content class="col-12">
                                <v-list-item-title class="book-author">author: {{book.author}}</v-list-item-title>
                            </v-list-item-content>
                            <v-list-item-content class="col-12" v-for="library in book.libraries" :key="library.id">
                                <v-list-item-title class="">Library: {{library.name}}</v-list-item-title>
                                <v-list-item-subtitle class="">Existing count: {{library.existing_count}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-row
                                align="center"
                                justify="end"
                            >
                                <v-btn
                                    class="ma-2"
                                    text
                                    icon
                                    color="lighten-2"
                                    @click="showConfirmAlert(bookKey)"
                                    v-if="book.user_id == authId"
                                >
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>

                                <v-btn
                                    class="ma-2"
                                    text
                                    icon
                                    color="lighten-2"
                                    :color="book.liked ? 'yellow' : 'white'"
                                    @click="likeBook($event, bookKey)"
                                >
                                    <v-icon>mdi-heart</v-icon>
                                </v-btn>

                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </section>
</template>

<script>

import confirmDeleteAlert from "../components/confirmDeleteAlert";

export default {
    name: "search",
    components: {
        confirmDeleteAlert
    },
    data() {
        return {
            searchData: '',
            books:{},
            showDeleteAlert: false,
            book: null
        }
    },
    computed: {
        authId() {
            return this.$store.getters.GET_AUTH_ID
        }
    },
    methods: {
        async search() {
            if (!!this.searchData) {
                let response = await this.$store.dispatch('searchBooks', {
                    searchData : this.searchData
                })

                this.books = response.data
            }
        },

        async likeBook(e, bookKey) {
            let book = this.books[bookKey]
            let response = await this.$store.dispatch('likeBook', book.id)

            if (response.data.success) {
                book.liked = !book.liked
                this.books.splice(bookKey,1,book)
            }
        },

        async deleteBook(data) {
            this.showDeleteAlert = false
            if (data.answer) {
                let book = this.books[this.book]
                let response = await this.$store.dispatch('deleteBook', book.id)

                if (response.data.success) {
                    await this.search();
                }
            }

            this.book = null
        },

        showConfirmAlert(bookKey) {
            this.showDeleteAlert = true
            this.book = bookKey
        }
    }
}
</script>

<style lang="scss">
.book-description {
    display: -webkit-box;
    height: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: pre-line;
    -webkit-line-clamp: 8;
    -webkit-box-orient: vertical;
}
.book-author {
    width: 100%;
    overflow: unset;
    text-overflow: initial;
}
</style>
