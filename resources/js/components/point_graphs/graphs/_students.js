import VeLine from 'v-charts/lib/line';
import 'v-charts/lib/style.min.css';
import 'echarts/lib/component/title';
import moment from 'moment';

export default {
    name: 'GraphSelectionStudent',
    components: {
        /**
         * load graph component for Line type
         */
        've-line': VeLine
    },
    data () {
        /**
         * chart settings
         * @type {{metrics: string[], axisSite: {right: string[]}, yAxisName: string[], dimension: string[]}}
         */
        this.chartSettings = {
            metrics: ['Points', 'Hours', 'Points/Hour'],
            axisSite: {right: ['Points/Hour']},
            yAxisName: ['', 'Points/Hrs'],
            dimension: ['date'],
        };
        /**
         * extending charts to show line type, solid or dashed
         * @type {{series(*): *}}
         */
        this.chartExtend = {
            series(v) {
                v.forEach(i => {
                    if(i.name === 'Hours') {
                        i.lineStyle = {
                            type: 'dashed'
                        }
                    } else {
                        i.lineStyle = {
                            type: 'solid'
                        }
                    }
                });
                return v
            }
        };
        return {
            // line colors
            lineColors: ['#00BCD4','#000000', '#8BC34A'],
            // initial chart data
            chartData: {
                columns: ['date', 'Points', 'Hours', 'Points/Hour'],
                rows: []
            },
            // title
            title: {
                text: 'Student Graph'
            },
            loading: false,
            itemsLoading: false,
            loadingGraph: false,
            dataEmpty: 'No Data',
            empty: true,
            // toggle calender menu on date inputs
            fromDateMenu: false,
            toDateMenu: false,
            // input models
            model: {
                student: null,
                course: null,
                fromDate: null,
                toDate: null
            },
            // fetched data holders
            items: {
                students: [],
                courses: []
            },
            loadedCourses: []

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
            axios.get('/api/graphs/students/loadItems')
                .then((response) => {
                    this.items.students = response.data.students;
                    this.items.courses = response.data.courses;
                    this.loadedCourses = response.data.courses;
                })
                .catch((e) => {
                    console.log(e);
                })
                .finally(() => {
                    this.itemsLoading = false;
                })
        },

        /**
         * fetch data for graph
         */
        loadGraph () {
            this.loadingGraph = true;
            let postData = {
                student_id: !_.isNil(this.model.student) ? this.model.student.id : null,
                course_id: this.model.course,
                from_date: this.model.fromDate,
                to_date: this.model.toDate
            };
            axios.post('/api/graphs/students/loadGraphData', postData)
                .then((response) => {
                    let tmp = [];
                    let dt = response.data;
                    console.log(dt);
                    _.forEach(dt, (obj) => {
                        let cPoints = parseInt(obj.total_points);
                        let cHours = this.timeConvert(obj.t_hours, obj.total_minutes);
                        tmp.push({
                            'Points': obj.total_points,
                            'Hours': cHours,
                            'date': moment(obj.date).format('MM/DD/YYYY'),
                            'Points/Hour': (cPoints/cHours).toFixed(2)
                        });

                    });
                    if (tmp.length > 0) {
                        this.chartData.rows = tmp;
                        this.loading = false;
                        this.empty = false;
                    } else {
                        this.chartData.rows = [];
                        this.loading = false;
                        this.empty = true;
                    }
                })
                .catch((e) => {
                    console.log(e);
                })
                .finally(() => {
                    this.loadingGraph = false;
                })
        },

        /**
         * on changing student, load student's course only
         */
        onStudentChange () {
            if (_.isNil(this.model.student) || _.isEmpty(this.model.student)) {
                this.items.courses = this.loadedCourses;
            } else {
                let tempCourse = [];
                _.forEach(this.model.student.courses, function (obj) {
                    tempCourse.push({
                       text: obj.name,
                       value: obj.id
                    });
                });
                this.items.courses = tempCourse;
            }
            this.model.course = null;
        },

        /**
         * convert hrs amd minutes to total hours
         * @param hrs
         * @param mins
         * @returns {number}
         */
        timeConvert (hrs, mins){
            let minutes = parseInt(mins) % 60;
            let hours = (parseInt(mins) - minutes) / 60;
            let totalHours = parseInt(hrs) + hours;
            return parseFloat(totalHours +"."+ minutes);
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