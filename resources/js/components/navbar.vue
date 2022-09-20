<template>
    <v-card class="overflow-hidden">
        <v-app-bar
            fixed
            color="#fcb69f"
            dark
            shrink-on-scroll
            src="https://picsum.photos/1920/1080?random"
            scroll-target="#scrolling-techniques-2"
        >
            <template v-slot:img="{ props }">
                <v-img
                    v-bind="props"
                    gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
                ></v-img>
            </template>

            <router-link :to="{name: 'Home'}" class="nav-items">
                <v-app-bar-title href="/" class="page-links">Home</v-app-bar-title>
            </router-link>

            <router-link :to="{name: 'Search'}" class="nav-items">
                <v-app-bar-title href="/search" class="page-links">Search</v-app-bar-title>
            </router-link>

            <router-link :to="{name: 'CreateBook'}" class="nav-items">
                <v-app-bar-title href="/books/create" class="page-links">Create</v-app-bar-title>
            </router-link>

            <v-btn
                class="ma-2 ms-auto page-links"
                outlined
                color="white"
                @click="logout"
            >
                Logout
            </v-btn>

        </v-app-bar>

    </v-card>
</template>

<script>

export default {
    name: "navbar",
    data () {
        return {
        }
    },

    methods: {
        async logout() {
            let response = await this.$store.dispatch('logout')
            if (response.success) this.$router.push({'name': 'Login'})
        }
    }
}
</script>

<style lang="scss">

.nav-items {
    color: #fff !important;
    margin-left: 10px;
    .page-links > div {
        width: fit-content !important;
        border: 1px solid #fff !important;
        border-radius: 10px;
        padding: 5px;
    }
}

</style>
