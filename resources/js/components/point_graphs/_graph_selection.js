export default {
    name: "GraphSelection",
    data () {
        return {
            dataLoading: false,
            itemsLoaded: false,
            items: []
        }
    },
    mounted: function () {
        /**
         * on component mounted load student
         * categories from server
         */
        this.loadStudentCategories();
    },
    methods: {
        /**
         * fetch student categories from server
         */
        loadStudentCategories () {
            this.dataLoading = true;
            axios.get('/api/graphs/groups')
                .then((response) => {
                    this.items = response.data;
                })
                .catch((e) => {
                    console.log(e);
                })
                .finally(() => {
                    this.dataLoading = false;
                    this.itemsLoaded = true;
                })
        },
        /**
         * move graphs screen for students or category
         * @param item
         * @param id
         */
        viewGraphSection (item, id) {
            if (item === 'student') {
                this.$router.push('/points/graph/selection/students');
            } else {
                this.$router.push('/points/graph/selection/group/' + id);
            }
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