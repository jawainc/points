<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout class="m-t-20" justify-center row>
        <v-flex xs11>
            <v-card>
                <v-toolbar color="blue-grey" dark>
                    <v-toolbar-title>Student Points</v-toolbar-title>
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

                <v-flex xs12 class="m-t-10" row v-for="course in items" :key="course.course_id" >
                    <v-flex xs12>
                        <div class="p-t-20 p-b-20 p-l-5 title grey lighten-4">Course: {{course.course_name}}</div>
                    </v-flex>

                    <v-container grid-list fluid>
                        <v-layout row wrap justify-center>
                            <v-flex class="m-5" xs12 sm12 md6 lg3 v-for="student in course.students" :key="student.student_id">
                                <v-card>
                                    <v-card-title>{{student.student_name}}</v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <template v-for="(point, index) in student.points">
                                            <v-list-tile
                                                    :key="point.point_id"
                                                    two-line
                                            >
                                                <v-list-tile-content>
                                                    <v-list-tile-sub-title><span class="font-weight-bold m-r-15">{{point.date | makeDate}}</span></v-list-tile-sub-title>
                                                    <v-list-tile-sub-title><span class="font-weight-regular">Points:</span> <span class="font-weight-light m-r-10">{{point.points}}</span> <span class="font-weight-regular">Hrs:</span> <span class="font-weight-light m-r-10">{{point.hours}}</span></v-list-tile-sub-title>
                                                </v-list-tile-content>
                                                <v-list-tile-action>
                                                    <v-icon
                                                            color="grey lighten-1"
                                                            @click="edit(point)"
                                                    >edit</v-icon>
                                                </v-list-tile-action>
                                            </v-list-tile>
                                            <v-divider
                                                    v-if="index + 1 < student.points.length"
                                                    :key="index"
                                            ></v-divider>
                                            <v-dialog v-model="point.edit" persistent max-width="600px">
                                                <v-form >
                                                    <v-card>
                                                        <v-card-title>
                                                            <span class="headline">{{student.student_name}} {{point.date | makeDate}}</span>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-layout wrap>
                                                                    <v-flex xs12>
                                                                        <v-text-field label="Points*" type="number" v-model="editPoint" :error-messages="pointRules" required></v-text-field>
                                                                    </v-flex>
                                                                    <v-flex xs12>
                                                                        <v-textarea label="Add Notes" v-model="notes" rows="1" ></v-textarea>
                                                                    </v-flex>


                                                                </v-layout>
                                                            </v-container>
                                                        </v-card-text>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="blue darken-1" flat @click="close(point)">Close</v-btn>
                                                            <v-btn color="blue darken-1" outline @click="savePoint(student, point)" :loading="isSaving">Save</v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-form>
                                            </v-dialog>
                                        </template>
                                    </v-card-text>
                                    <v-divider></v-divider>
                                    <v-card-title>Total Points: {{student.total_points}}</v-card-title>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>

                </v-flex>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import moment from 'moment';
    import _ from 'lodash';

    export default {
        name: 'PointStudent',
        data () {
            return {
                itemsLoading: false,
                items: [],
                editPoint: null,
                pointRules: null,
                notes: null,
                isSaving: false,
                rowsPerPageItems: [4, 8, 12],
                pagination: {
                    rowsPerPage: 4
                }
            }
        },
        filters: {
            makeDate: (value) => {
                if (!value) return '';
                return moment(value).format("dddd MM/DD/YY");
            },
            parseHours: (value) => {
                if (!value) return '';
                let arr = value.split('.');
                return `Hours: ${arr[0]} Minutes: ${(arr[1]) ? arr[1] : 0}`;
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
                axios.get('/api/points/points/coursePoints')
                    .then((response) => {
                        let data = _.filter(response.data.data, (item) => {
                            item.students = _.pickBy(item.students, (student) => {
                                return student.points.length;
                            });
                            return true;
                        });

                        _.forEach(data, (course) => {
                            _.forEach(course.students, (student) => {
                                let total = 0;
                                _.forEach(student.points, (point) =>  {
                                    total += parseInt(point.points);
                                    student['total_points'] = total;
                                })
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

            savePoint(student, point) {
                this.pointRules = null;
                if (this.verify()) {
                    this.isSaving = true;
                    axios.post('/api/points/points/coursePoints', {
                        id: point.point_id,
                        points: this.editPoint,
                        notes: this.notes
                    })
                        .then((result) => {
                            point.points = this.editPoint;
                            point.notes = this.notes;
                            let total = 0;
                            _.forEach(student.points, (point) =>  {
                                total += parseInt(point.points);
                                student['total_points'] = total;
                            });
                        })
                        .finally(() => {
                            this.close(point);
                        })
                }


            },
            edit (point) {
                let time = point.hours.split('.');
                this.editPoint = _.clone(point.points);
                this.notes = _.clone(point.notes);
                Vue.set(point, 'edit', true);
            },

            close (point) {
                Vue.set(point, 'edit', false);
                this.editPoint = null;
                this.isSaving = false;
                this.pointRules = null;
                this.notes = null;
            },

            verify () {
                if (!this.editPoint || !Number.isInteger(parseInt(this.editPoint)) || parseInt(this.editPoint) <= 0) {
                    this.pointRules = 'Points should be greater than zero';
                    return false;
                }

                this.pointRules = null;

                return true;
            },

            pointTotal (student) {
                let total = 0;
                for (point in student.points) {
                    total += parseInt(point.points);
                }
                Vue.set(student, 'total_points', total);
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
