<template>
    <section>
        <form @submi.prevent="submit">
            <v-text-field
                v-model="title"
                label="Title"
                required
            ></v-text-field>
            <v-text-field
                v-model="description"
                label="Description"
                required
            ></v-text-field>
            <v-text-field
                v-model="author"
                label="Author"
                required
            ></v-text-field>
            <v-row>
                    <v-col cols="6">
                        <v-select
                            v-model="select.library"
                            :items="items"
                            item-text="name"
                            item-value="id"
                            label="Libraries"
                            return-object
                        ></v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            v-model="select.count"
                            label="Existing count"
                            min="1"
                            type="number"
                        ></v-text-field>
                    </v-col>
                <v-col cols="2">
                    <v-btn
                        class="ma-2"
                        text
                        icon
                        color="lighten-2"
                        @click="addSelectedLibrary()"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
            <div v-for="(selectedLibrary, arrayKey) in selectedLibraries">
                <v-btn
                    close
                    class="ma-2 blue lighten-4"
                >
                    {{selectedLibrary.library.name}} : {{selectedLibrary.count}}
                    <v-btn
                        text
                        icon
                        color="lighten-2"
                        @click="removeSelectedLibrary(arrayKey)"                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-btn>
            </div>
            <p v-if="selectError" class="red--text text--darken-4">Please select library where this book exists</p>

            <p v-if="showError" class="red--text text--darken-4">All fields are required</p>

            <v-btn
                class="mr-4 mt-5"
                @click="submit"
            >
                submit
            </v-btn>
            <v-btn @click="clear" class="mt-5">
                clear
            </v-btn>
        </form>

    </section>
</template>

<script>
export default {
    name: "createBook",
    data() {
        return {
            title : '',
            description: '',
            author: '',
            select: {
                library: '',
                count: ''
            },
            items: [],
            selectedLibraries: [],
            selectError: false,
            showError: false,
        }
    },
    watch: {
        title() {
            if (this.title === "") {
                this.titleError = true
            }
            this.titleError = false
        }
    },
    methods: {
        clear () {
            this.title = ""
            this.description = ""
            this.author = ""
            for (let key=this.selectedLibraries.length; key>0; key-- ) {
                this.removeSelectedLibrary(key-1)
            }
            this.showError = false
            this.selectError = false
        },
        async submit () {
            this.showError = false
            if (!!this.title && !!this.description && !!this.author && this.selectedLibraries.length) {
                let response = await this.$store.dispatch('addBook', {
                    title: this.title,
                    description: this.description,
                    author: this.author,
                    libraries: this.selectedLibraries
                })
                if (response.status === 201) {
                    this.clear()
                }
            } else {
                this.showError = true
            }
        },
        async getLibraries () {
            let response = await this.$store.dispatch("getLibraries")
            this.items = response.data
        },
        addSelectedLibrary() {
            if (this.select.library === "" || this.select.count === "") {
                this.selectError = true
            } else {
                this.selectError = false
                this.selectedLibraries.push(structuredClone(this.select))
                this.items.forEach((item, index) => {
                    if (item.id === this.select.library.id) {
                        this.items.splice(index,1)
                    }
                })
                this.select.library=""
                this.select.count=""
            }
        },
        removeSelectedLibrary(key) {
            this.items.push(structuredClone(this.selectedLibraries[key].library))
            this.selectedLibraries.splice(key,1)
        }
    },
    created () {
        this.getLibraries()
    }
}
</script>

<style lang="scss">
.input-error {
    border: 1px solid darkred;
}
.success-alert {
    position: fixed !important;
    bottom: 0;
    left: 0;
}
</style>
