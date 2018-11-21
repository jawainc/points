import VeLine from 'v-charts/lib/line';
import 'v-charts/lib/style.min.css';
import 'echarts/lib/component/title';
import moment from 'moment';

export default {
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
            isLoading: false,
            StudentName: '',
            CourseName: '',
            // line colors
            lineColors: ['#00BCD4','#000000', '#8BC34A'],
            // initial chart data
            chartData: {
                columns: ['date', 'Points', 'Hours', 'Points/Hour'],
                rows: []
            },
            title: {
                text: 'Student Graph'
            },
            loading: true,
            dataEmpty: 'No Data',
            empty: true,
        }
    },
    mounted () {
        /**
         * on mount fetch chart data
         */
        axios.post('/api/points/graph', {
            'course_id': this.$route.params.course_id,
            'enrollment_id': this.$route.params.enrollment_id,
        })
            .then((response) => {
                this.StudentName = 'Student: '+response.data.student_name;
                this.CourseName = 'Course: '+response.data.course_name;
                let tmp = [];
                let dt = response.data.graph_data;

                _.forEach(dt, (obj) => {
                    tmp.push({
                        'Points': obj.points,
                        'Hours': obj.hours,
                        'date': obj.date,
                        'Points/Hour': obj.points_hours
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
    }

}