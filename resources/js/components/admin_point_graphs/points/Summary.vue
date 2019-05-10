<template>
    <v-layout class="m-t-20" justify-center row>
        <v-flex xs12>
            <v-card>
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>Student Points Summary</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn to="/points/selection" icon exact>
                        <v-icon>home</v-icon>
                    </v-btn>
                    <v-btn @click="logout()" icon exact>
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                </v-toolbar>

                <v-layout class="p-20" justify-center row v-if="itemsLoading" >
                    <v-progress-circular
                            indeterminate
                            color="primary"
                    ></v-progress-circular>
                </v-layout>

                <v-layout class="p-20" justify-center row v-if="!itemsLoading && !items.length" >
                    No Data
                </v-layout>


                <v-container grid-list v-if="!itemsLoading && items.length" fluid>
                    <v-layout row wrap justify-center>
                        <v-flex class="m-5" xs12 sm12 md6 lg3 v-for="course in items" :key="course.course_id">
                                <v-card>
                                    <v-card-title class="font-weight-bold grey lighten-3">{{course.course_name}}</v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <template v-for="(point, index) in course.points" >
                                            <v-list-tile
                                                    :key="index"
                                            >
                                                <v-list-tile-content>
                                                    <v-list-tile-sub-title>
                                                        <span class="font-weight-bold m-r-15">{{point.date | makeDate}}</span>
                                                        <span class="font-weight-regular">Points:</span> <span class="font-weight-light m-r-10">{{point.sum_points}}</span>
                                                    </v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                            <v-divider
                                                    v-if="index + 1 < course.points.length"

                                            ></v-divider>
                                        </template>
                                    </v-card-text>
                                    <v-divider></v-divider>
                                    <v-card-title>Total Points: {{course.total_points}}</v-card-title>
                                    <v-divider></v-divider>
                                    <v-layout row justify-space-between class="pa-3">
                                        <span >Quota: {{course.quota}}</span>
                                        <v-icon
                                                color="blue-grey lighten-1"
                                                @click="edit(course)"
                                        >edit</v-icon>
                                    </v-layout>

                                    <v-dialog v-model="course.edit" persistent max-width="600px">
                                        <v-form >
                                            <v-card>
                                                <v-card-title>
                                                    <span class="headline">{{course.course_name}}</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field label="Quota*" type="number" v-model="editQuota" :error-messages="quotaRules" required></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" flat @click="close(course)">Close</v-btn>
                                                    <v-btn color="blue darken-1" outline @click="saveQuota(course)" :loading="isSaving">Save</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-form>
                                    </v-dialog>
                                </v-card>
                            </v-flex>
                    </v-layout>
                </v-container>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "Summary",
        data () {
            return {
                itemsLoading: false,
                items: [],
                editQuota: null,
                quotaRules: null,
                isSaving: false
            }
        },
        filters: {
            makeDate: (value) => {
                if (!value) return '';
                return moment(value).format("dddd MM/DD/YY");
            }
        },
        mounted () {
            /**
             * on mounting component fetch data from server
             */
            this.loadItems();
        },
        methods: {
            /**
             * fetch data from server
             */
            loadItems () {
                this.itemsLoading = true;
                axios.get('/api/points/points/courseSummary')
                    .then((response) => {
                        let data = response.data.data;
                        _.forEach(data, (course) => {
                            let total = 0;
                            _.forEach(course.points, (point) =>  {
                                total += parseInt(point.sum_points);
                                course['total_points'] = total;
                            })
                        });
                        this.items = data;
                    })
                    .catch((e) => {
                        console.log(e);
                    })
                    .finally(() => {
                        this.itemsLoading = false;
                    })
            },

            saveQuota(course) {
                this.quotaRules = null;
                if (this.verify()) {
                    this.isSaving = true;
                    axios.post('/api/points/points/courseSummary', {
                        id: course.course_id,
                        quota: this.editQuota
                    })
                        .then((result) => {
                            course.quota = this.editQuota;
                        })
                        .finally(() => {
                            this.close(course);
                        })
                }

            },
            edit (course) {
                this.editQuota = _.clone(course.quota);
                Vue.set(course, 'edit', true);
            },

            close (course) {
                Vue.set(course, 'edit', false);
                this.editQuota = null;
                this.isSaving = false;
                this.quotaRules = null;
            },

            verify () {
                if (!this.editQuota || !Number.isInteger(parseInt(this.editQuota)) || parseInt(this.editQuota) < 0) {
                    this.quotaRules = 'Quota should be positive number';
                    return false;
                }

                this.quotaRules = null;

                return true;
            },

            /**
             * logout session
             */
            logout () {
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