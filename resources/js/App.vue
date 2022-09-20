<template>
    <v-app>
        <navbar v-if="auth"></navbar>
        <v-sheet
            id="scrolling-techniques-2"
            class="overflow-y-auto"
        >
            <v-container class="page-content">
                <v-main>
                    <router-view></router-view>
                </v-main>
            </v-container>
        </v-sheet>


    </v-app>
</template>

<script>
import navbar from "./components/navbar";
export default {
    name: "App",
    components: {
        navbar
    },
    computed: {
        auth() {
            return this.$store.getters.GET_AUTH
        }
    }
}

</script>

<style lang="scss">
.page-content {
    margin-top: 150px;
}
#scrolling-techniques-2 {
    min-height: 90%;
}
</style>
