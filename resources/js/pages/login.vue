<template>
    <v-container>
        <h1 class="mb-5 text-center">Login</h1>

        <form class="login-form">
            <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                label="E-mail"
                required
            ></v-text-field>
            <v-text-field
                v-model="password"
                :error-messages="passwordErrors"
                label="Password"
                required
                type="password"
            ></v-text-field>

            <v-btn
                class="mr-4"
                @click="submit"
            >
                submit
            </v-btn>
        </form>
        <transition name="fade" mode="out-in">
            <v-alert v-if="showError" class="errorAlert" show variant="danger">{{error}}
                <button @click.prevent="showError = false" class="alertButton">
                    <v-icon icon="x-lg"></v-icon>
                </button>
            </v-alert>
        </transition>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    name: "login",
    data() {
        return {
            showError: false,
            password: '',
            email: '',
            passwordErrors: '',
            emailErrors: ''
        }
    },
    methods: {
        async submit()
        {

            this.emailErrors=''
            this.passwordErrors = ''
            if (this.email === '')
            {
                this.emailErrors = 'The email field is required.'
                return
            }

            if (this.password === '')
            {
                this.passwordErrors = 'The password field is required.'
                return
            }

            let {data} = await this.$store.dispatch('login', {
                email: this.email,
                password: this.password
            })
            console.log(data)
            if (data) this.$router.push({name: 'Home'})
        }
    }
}
</script>

<style lang="scss">
.login-form {
    margin-left: auto;
    margin-right: auto;
    max-width: 550px;
}
</style>
