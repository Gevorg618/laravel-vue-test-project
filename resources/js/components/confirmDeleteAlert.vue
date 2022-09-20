<template>
    <v-row class="deleteAlert" justify="center">

        <v-dialog
            v-model="dialogValue"
            max-width="290"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Press Yes if you want to delete
                </v-card-title>

                <v-card-text>
                    Are you sure you want to delete this book?
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="returnAnswer(false)"
                    >
                        No
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="returnAnswer(true)"
                    >
                        Yes
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    name: "confirmDeleteAlert",
    data() {
        return {
            dialogValue: this.dialog
        }
    },
    props: {
        dialog: {
            required: false,
            type: Boolean,
            default: false
        }
    },
    watch: {
        dialog(newValue) {
            this.dialogValue = newValue
        }
    },
    methods: {
        returnAnswer(answer) {
            this.$emit('deleteAnswer',{answer: answer})
        }
    },
    updated() {
        this.dialogValue = this.dialog
    }
}
</script>

<style scoped>
.deleteAlert {
    position: absolute;
    top: 50px;
    z-index: 9999;
}
</style>
