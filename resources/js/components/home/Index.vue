<template>
    <v-layout align-center justify-center row fill-height >
        <v-flex xs8 >
            <v-card  class="p-l-30 p-r-30 p-t-40 p-b-40" >
                <v-btn block large dark color="pink m-t-20" to="/points/search-name">Enter Points</v-btn>
                <v-btn block large dark color="pink m-t-20 m-b-20" to="/points/graph" >View Graphs</v-btn>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "Index"
    }
</script>
