<template>
    <v-layout class="m-t-20" justify-center row >
        <v-flex xs11 >
            <v-card>
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>Choose to view graph</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn @click="logout()" icon exact>
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                </v-toolbar>

                <v-layout v-if="dataLoading" class="m-100 p-b-100" align-center justify-center row fill-height >
                    <v-progress-circular
                            v-if="dataLoading"
                            :width="3"
                            color="pink"
                            indeterminate
                    ></v-progress-circular>
                </v-layout>


                <v-list v-if="itemsLoaded" >

                        <v-list-tile @click="viewGraphSection('student')">
                            <v-list-tile-content>
                                <v-list-tile-title>Student</v-list-tile-title>
                            </v-list-tile-content>

                            <v-list-tile-action>
                                <v-icon>
                                    chevron_right
                                </v-icon>
                            </v-list-tile-action>

                        </v-list-tile>
                        <v-divider></v-divider>


                        <template v-for="(category, index) in items">
                            <v-list-tile
                                    :key="index"
                                    @click="viewGraphSection('category', category.id)"
                            >
                                <v-list-tile-content>
                                    <v-list-tile-title>{{category.name}}</v-list-tile-title>
                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-icon>
                                        chevron_right
                                    </v-icon>
                                </v-list-tile-action>

                            </v-list-tile>

                            <v-divider v-if="index < items.length - 1"></v-divider>
                        </template>



                </v-list>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script src="./_graph_selection.js"></script>
