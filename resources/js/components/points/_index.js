export default {
    name: "SearchName",
    data () {
        return {
            // first screen to start
            e1: 0,
            // user input model
            model: {
                student: {
                    id: null,
                    name: null,
                    courses: []
                },
                studentPassword: null,
                courseName: null,
                courseSession: null,
                studentPoints: null,
                studentHours: null,
                studentMinutes: null
            },
            // holds data loaded from server
            items: {
                students: [],
                courses: [],
                sessions: []
            },
            // error messages
            errorMessages: {
                searchStudentErrorMessage: null,
                searchCourseErrorMessage: null,
                searchSessionErrorMessage: null,
                studentPointsErrorMessage: null,
                studentHoursErrorMessage: null,
                studentPasswordErrorMessage: null
            },
            // toggles
            courseAutoFocus: false,
            pointsAutoFocus: false,
            isStudentError: false,
            isCourseError: false,
            isSessionError: false,
            isStudentLoded: false,
            focusedInput: null,
            isPasswordRequired: false,
            passwordDialog: false,
            // loading indicators
            isStudentLoading: false,
            isCourseLoading: false,
            isSessionLoading: false,
            isSaving: false,
            isFinishing: false,
            isVerifyingPassword: false,
            // search syncs
            studentSearch: null,
            courseSearch: null,
            sessionSearch: null,

        }
    },
    computed: {
        /**
         * check if course selected
         * @returns {boolean}
         */
      isCourseSelected: function () {
          if (!_.isNil(this.model.courseName)) {
              this.loadSessions();
              return false;
          } else {
              return true;
          }
      }
    },
    watch: {
        /**
         * watcher for course change
         * @param oldVal
         * @param newVal
         */
        courseName (oldVal, newVal) {
            if ((oldVal !== newVal) && newVal > 0 && !this.isSessionLoading) {
                this.loadSessions();
            }
        },
        /**
         * watcher for student search
         * @param val
         */
        studentSearch (val) {
            if (!_.isNil(val) && !_.isEmpty(val) && !this.isStudentLoading) {
                this.isStudentError = false;
                this.errorMessages.searchStudentErrorMessage = null;
                if (val.length < 2) {
                    this.items.students = [];
                    this.isStudentLoded = false;
                } else if (!this.isStudentLoded){
                    this.loadStudents(val);
                }
            } else {

            }
        },
        /**
         * watcher for course search
         * @param val
         */
        courseSearch (val) {
            if (!_.isNil(val) && !_.isEmpty(val)) {
                this.isCourseError = false;
                this.errorMessages.searchCourseErrorMessage = '';
                if (this.items.courses.length > 0) return;
                this.items.courses = this.entries.courses;
            } else {
                this.items.courses = [];
            }
        },
        /**
         * watcher for session search
         * @param val
         */
        sessionSearch (val) {
            if (!_.isNil(val) && !_.isEmpty(val)) {
                this.isSessionError = false;
                this.errorMessages.searchSessionErrorMessage = '';
                if (this.items.sessions.length > 0) return;
                this.items.sessions = this.entries.sessions;
            } else {
                this.items.sessions = [];
            }
        }
    },
    mounted () {
        // on component mounted set focus on student name
        this.$nextTick(this.$refs.studentAutoFocus.focus);
    },
    methods: {
        /**
         * search for students for given input
         * @param val
         */
        loadStudents (val) {
            this.isStudentLoading = true;
            axios.post('/api/points/find/students', {'name': val})
                .then((response) => {
                    this.items.students = response.data.students;
                    this.isPasswordRequired = response.data.student_password_enable;
                    this.isStudentLoded = true;
                })
                .catch((e) => {
                    console.log(e);
                })
                .finally(() => {
                    this.isStudentLoading = false;
                })
        },
        /**
         * load session for student course
         */
        loadSessions () {
            this.isSessionLoading = true;
            axios.post('/api/points/find/sessions', {
                'student_id': this.model.student.id,
                'course_id': this.model.courseName
            })
                .then((response) => {
                    this.items.sessions = response.data;
                })
                .catch((e) => {
                    console.log(e);
                })
                .finally(() => {
                    this.isSessionLoading = false;
                })
        },
        /**
         * verify student field is not empty
         */
        verifyStudentName () {
            if (!_.isNil(this.model.student.name) && !_.isEmpty(this.model.student.name)) {
                this.e1 = 2;
                this.courseAutoFocus = true;
            } else {
                this.isStudentError = true;
                this.errorMessages.searchStudentErrorMessage = 'Name is required!'
            }
        },
        /**
         * verify course empty
         */
        verifyCourse () {
            if (this.verifyCourseName() && this.verifySessions()) {
                if (this.isPasswordRequired) {
                    this.model.studentPassword = null;
                    this.errorMessages.studentPasswordErrorMessage = null;
                    this.passwordDialog = true;
                } else {
                    this.enterPoints();
                }
            }
        },
        /**
         * verify student entered password
         */
        confirmPassword () {
            if (!_.isNil(this.model.studentPassword) && !_.isEmpty(this.model.studentPassword)) {
                this.errorMessages.studentPasswordErrorMessage = null;
                this.isVerifyingPassword = true;
                axios.post('/api/points/student/password', {
                    password: this.model.studentPassword,
                    student_id: this.model.student.id
                })
                    .then((response) => {
                        if (response.data.verified) {
                            this.enterPoints();
                            this.passwordDialog = false;
                        } else {
                            this.errorMessages.studentPasswordErrorMessage = response.data.errorMessage;
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                    })
                    .finally(() => {
                        this.isVerifyingPassword = false;
                    });

            } else {
                this.errorMessages.studentPasswordErrorMessage = 'Password is required';
            }
        },
        /**
         * verify course name is not empty
         * @returns {boolean}
         */
        verifyCourseName () {
            if (
                !_.isNil(this.model.courseName) &&
                (this.model.courseName > 0)
            ) {
                return true;
            } else {
                this.isCourseError = true;
                this.errorMessages.searchCourseErrorMessage = 'Course is required!';
                return false;
            }
        },
        /**
         * verify course session is not empty
         * @returns {boolean}
         */
        verifySessions () {
            if (
                !_.isNil(this.model.courseSession) &&
                !_.isEmpty(this.model.courseSession)
            ) {
                return true;
            } else {
                this.isSessionError = true;
                this.errorMessages.searchSessionErrorMessage = 'Session is required!';
                return false;
            }
        },
        /**
         * verify points field is not empty
         * @returns {boolean}
         */
        verifyPoints () {
            if (
                !_.isNil(this.model.studentPoints) &&
                !_.isEmpty(this.model.studentPoints)
            ) {
                return true;
            } else {
                this.errorMessages.studentPointsErrorMessage = 'Points are required';
                return false;
            }
        },
        /**
         * verify hours is not empty
         * @returns {boolean}
         */
        verifyHours () {
            if (
                !_.isNil(this.model.studentHours) &&
                !_.isEmpty(this.model.studentHours)
            ) {
                return true;
            } else {
                this.errorMessages.studentHoursErrorMessage = 'Hours are required';
                return false;
            }
        },
        /**
         * display points screen
         */
        enterPoints () {
            this.courseAutoFocus = false;
            this.focusedInput = 'points';
            this.e1 = 3;
        },
        /**
         * set auto focus on points input
         */
        setPointAutoFocus () {
            this.$refs.pointsAutoFocusInput.focus();
            this.pointsAutoFocus = true;
        },
        /**
         * on cancel move to 1st screen
         */
        cancel () {
            this.reset();
            this.e1 = 1;
            this.$nextTick(this.$refs.studentAutoFocus.focus);
        },
        /**
         * reset all fields
         */
        reset () {
            this.isStudentError = false;
            this.isCourseError = false;
            this.isSessionError = false;
            this.focusedInput = null;
            this.model = {
                student: {
                    id: null,
                    name: null,
                    courses: []
                },
                courseName: null,
                courseSession: null,
                studentPoints: null,
                studentHours: null
            };
            this.items = {
                students: [],
                courses: [],
                sessions: []
            };
            this.errorMessages = {
                searchStudentErrorMessage: null,
                searchCourseErrorMessage: null,
                searchSessionErrorMessage: null
            }
        },
        /**
         * set input focus on points screen
         * @param input
         */
        focused (input) {
            this.focusedInput = input;
        },
        /**
         * get on screen keys
         * set focused input value
         * @param key
         */
        keyBoardInput (key) {
            if (this.focusedInput === 'points') {
                if (key === 'del') {
                    if (!_.isNil(this.model.studentPoints)) {
                        this.model.studentPoints = this.model.studentPoints.slice(0, -1)
                    }
                } else {
                    if (_.isNil(this.model.studentPoints)) {
                        this.model.studentPoints = key;
                    } else {
                        this.model.studentPoints = this.model.studentPoints + key;
                    }
                }
            } else if (this.focusedInput === 'hours') {
                if (key === 'del') {
                    if (!_.isNil(this.model.studentHours)) {
                        this.model.studentHours = this.model.studentHours.slice(0, -1)
                    }
                } else {
                    if (_.isNil(this.model.studentHours)) {
                        this.model.studentHours = key;
                    } else {
                        this.model.studentHours = this.model.studentHours + key;
                    }
                }
            } else if (this.focusedInput === 'minutes') {
                if (key === 'del') {
                    if (!_.isNil(this.model.studentMinutes)) {
                        this.model.studentMinutes = this.model.studentMinutes.slice(0, -1)
                    }
                } else {
                    if (_.isNil(this.model.studentMinutes)) {
                        this.model.studentMinutes = key;
                    } else {
                        this.model.studentMinutes = this.model.studentMinutes + key;
                    }
                }
            }
        },
        /**
         * on finish, save values
         * and move to 1st screen
         */
        proceedFinish () {
            if (this.verifyPoints() && this.verifyHours()) {
                this.isFinishing = true;
                axios.post('/api/points/save', {
                    'student_id': this.model.student.id,
                    'course_id': this.model.courseName,
                    'enrollment_id': this.model.courseSession.enrollment_id,
                    'section_id': this.model.courseSession.section_id,
                    'points': this.model.studentPoints,
                    'hours': this.model.studentHours,
                    'minutes': (_.isNil(this.model.studentMinutes))? 0 : this.model.studentMinutes
                })
                    .then((response) => {
                        this.cancel();
                    })
                    .catch((e) => {
                        console.log(e);
                    })
                    .finally(() => {
                        this.isFinishing = false;
                    })
            }
        },
        /**
         * on finish, save values
         * and move to graph
         */
        proceedGraph () {
            if (this.verifyPoints() && this.verifyHours()) {
                this.isSaving = true;
                axios.post('/api/points/save', {
                    'student_id': this.model.student.id,
                    'course_id': this.model.courseName,
                    'enrollment_id': this.model.courseSession.enrollment_id,
                    'section_id': this.model.courseSession.section_id,
                    'points': this.model.studentPoints,
                    'hours': this.model.studentHours,
                    'minutes': (_.isNil(this.model.studentMinutes))? 0 : this.model.studentMinutes
                })
                    .then((response) => {
                        this.$router.push('/graph/' + this.model.courseSession.enrollment_id + '/' + this.model.courseName);
                    })
                    .catch((e) => {
                        console.log(e);
                    })
                    .finally(() => {
                        this.isSaving = false;
                    })

            }
        }
    }
}