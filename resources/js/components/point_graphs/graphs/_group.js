import VeLine from 'v-charts/lib/line';
import 'v-charts/lib/style.min.css';
import 'echarts/lib/component/title';
import moment from 'moment';
export default {
    name: 'GraphSelectionGroup',
    components: {
        /**
         * load graph component for Line type
         */
        've-line': VeLine
    },
    props: ['id'],
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
            mainTitle: '',
            // line colors
            lineColors: ['#00BCD4','#000000', '#8BC34A'],
            // initial chart data
            chartData: {
                columns: ['date', 'Points', 'Hours', 'Points/Hour'],
                rows: []
            },
            loading: false,
            dataEmpty: 'No Data',
            empty: true,
            itemsLoading: false,
            loadingGraph: false,
            // toggle calender menu on date inputs
            fromDateMenu: false,
            toDateMenu: false,
            // input models
            model: {
                student: null,
                fromDate: null,
                toDate: null
            },
            // fetched data holder
            items: {
                students: []
            }

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
            axios.get('/api/graphs/group/loadItems/'+this.id)
                .then((response) => {
                    this.items.students = response.data.students;
                    this.mainTitle = response.data.name;
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
                student_id: this.model.student,
                from_date: this.model.fromDate,
                to_date: this.model.toDate,
                group_id: this.id
            };
            axios.post('/api/graphs/group/loadGraphData', postData)
                .then((response) => {
                    let tmp = [];
                    let dt = response.data;

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