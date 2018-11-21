<template>
    <v-layout class="m-t-20" justify-center row >
        <v-flex xs11 >
            <v-card>
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>Student Course Graph</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn to="/points/search-name" icon exact>
                        <v-icon>home</v-icon>
                    </v-btn>
                </v-toolbar>
                <div class="p-15">
                    {{StudentName}} <span class="m-l-20">{{CourseName}}</span>
                </div>

                <v-layout class="m-t-10" row>
                    <v-flex class="m-5" xs12>
                        <ve-line :title="title" :extend="chartExtend" :data="chartData" :colors="lineColors" :settings="chartSettings" :loading="loading" >

                        </ve-line>
                    </v-flex>
                </v-layout>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script src="./_index.js"></script>