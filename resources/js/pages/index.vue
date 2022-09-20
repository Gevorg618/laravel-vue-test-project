<template>
    <main>
        <confirm-delete-alert :dialog="showDeleteAlert" @deleteAnswer="deleteBook" ></confirm-delete-alert>
        <section v-for="(library, libraryKey) in libraries">
            <h2>{{library.name}}</h2>
            <v-row>
                <v-col  v-for="(book, bookKey) in library.books" cols="12" :key="book.id" md="6" lg="4">
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

                                <v-row
                                    align="center"
                                    justify="end"
                                >
                                    <v-btn
                                        class="ma-2"
                                        text
                                        icon
                                        color="lighten-2"
                                        @click="showConfirmAlert(libraryKey, bookKey)"
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
                                        @click="likeBook($event, libraryKey, bookKey)"
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
    </main>
</template>

<script>
import confirmDeleteAlert from "../components/confirmDeleteAlert";
export default {
    name: "index",
    components: {
        confirmDeleteAlert
    },

    data() {
        return {
            libraries: {},
            showDeleteAlert: false,
            book: null,
            library: null
        }
    },
    methods: {
        async getLibraries() {
            let response = await this.$store.dispatch('getLibrariesWithBooks')
            this.libraries = response.data
        },

        async likeBook(e, libraryKey, bookKey) {
            let book = this.libraries[libraryKey].books[bookKey]
            let response = await this.$store.dispatch('likeBook', book.id)

            if (response.data.success) {
                book.liked = !book.liked
                this.libraries[libraryKey].books.splice(bookKey,1,book)
            }
        },

        async deleteBook(data) {
            this.showDeleteAlert = false
            if (data.answer) {
                let book = this.libraries[this.library].books[this.book]
                let response = await this.$store.dispatch('deleteBook', book.id)

                if (response.data.success) {
                    await this.getLibraries()
                }
            }
            this.library = null
            this.book = null
        },

        showConfirmAlert(libraryKey, bookKey) {
            this.showDeleteAlert = true
            this.book = bookKey
            this.library = libraryKey
        }
    },

    computed: {
        authId() {
            return this.$store.getters.GET_AUTH_ID
        }
    },

    mounted() {
        this.getLibraries()
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
