<template>
    <v-layout class="m-t-20" justify-center row>
        <v-flex xs11>
            <v-card>
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>{{mainTitle}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn to="/points/graph/selection" icon exact>
                        <v-icon>home</v-icon>
                    </v-btn>
                    <v-btn @click="logout()" icon exact>
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                </v-toolbar>

                <v-subheader>Graph Options</v-subheader>
                <v-layout class="m-t-10" justify-center row>
                    <v-flex class="p-5" xs3>
                        <v-autocomplete
                                v-model="model.student"
                                :items="items.students"
                                :loading="itemsLoading"
                                color="blue-grey darken-2"
                                hide-selected
                                hide-no-data
                                clearable
                                label="Students"
                        ></v-autocomplete>
                    </v-flex>
                    <v-flex class="p-5" xs3>
                        <v-menu
                                :close-on-content-click="false"
                                v-model="fromDateMenu"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="model.fromDate"
                                    label="Date From"
                                    prepend-icon="event"
                                    clearable
                                    readonly
                            ></v-text-field>
                            <v-date-picker v-model="model.fromDate" @input="fromDateMenu = false"></v-date-picker>
                        </v-menu>
                    </v-flex>

                    <v-flex class="p-5" xs3>
                        <v-menu
                                :close-on-content-click="false"
                                v-model="toDateMenu"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="model.toDate"
                                    label="Date To"
                                    prepend-icon="event"
                                    clearable
                                    readonly
                            ></v-text-field>
                            <v-date-picker v-model="model.toDate" @input="toDateMenu = false" ></v-date-picker>
                        </v-menu>
                    </v-flex>


                </v-layout>
                <v-layout class="m-t-10" row>
                    <v-flex class="p-5" xs12>
                        <v-btn large dark color="pink" :loading="loadingGraph" @click="loadGraph()">View Graph</v-btn>
                    </v-flex>
                </v-layout>

                <v-layout class="m-t-10" row>
                    <v-flex class="m-5" xs12>
                        <ve-line :extend="chartExtend" :data="chartData" :colors="lineColors" :settings="chartSettings" :loading="loading" >
                            <div v-if="empty" class="data-empty">No Data</div>
                        </ve-line>
                    </v-flex>
                </v-layout>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script src="./_group.js"></script>
<style>
    .data-empty {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(255, 255, 255, .7);
        color: #888;
        font-size: 20px;
    }
</style>
