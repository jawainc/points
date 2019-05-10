<template>
    <v-layout class="m-t-20" justify-center row>
        <v-flex xs11>
            <v-card elevation="0">
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>View Points</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn to="/points/selection" icon exact>
                        <v-icon>home</v-icon>
                    </v-btn>
                    <v-btn @click="logout()" icon exact>
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                </v-toolbar>


                <v-layout align-center justify-center row fill-height >
                    <v-flex xs12 >
                        <v-card  class="p-l-30 p-r-30 p-t-40 p-b-40" >
                            <v-btn block large dark color="pink m-t-20" to="/points/points/student">Students</v-btn>
                            <v-btn block large dark color="pink m-t-20 m-b-20" to="/points/points/summary" >View Points Summary</v-btn>
                        </v-card>
                    </v-flex>
                </v-layout>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "Index",
        /**
         * logout session
         */
        methods: {
            logout() {
                axios.get('/api/logout')
                    .then((response) => {

                    })
                    .catch((e) => {
                        console.log(e);
                    })
                    .finally(() => {
                        this.$router.push('/');
                    })
            }
        }
    }
</script>

<style scoped>

</style>