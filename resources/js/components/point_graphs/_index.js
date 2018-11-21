export default {
    name: "GraphLogin",
    data () {
        return {
            formSubmitting: false,
            model: {
                password: null
            },
            errorMessages: {
                passwordErrorMessage: null,
                loginError: '',
            },
            isLoginError: false
        }
    },
    methods: {
        /**
         * verify input password
         */
        submitLogin () {
            if (this.verifyLogin()) {
                this.formSubmitting = true;


                axios.post('/api/login', {
                    password: this.model.password
                })
                    .then((response) => {
                        console.log(response);
                        if (response.data.success) {
                            this.$router.push('/points/graph/selection');
                        } else {
                            this.errorMessages.loginError = 'Invalid Password';
                            this.isLoginError = true;
                        }
                    })
                    .catch((e) => {
                        this.errorMessages.loginError = e.response.data.message;
                        this.isLoginError = true;
                    })
                    .finally(() => {
                        this.formSubmitting = false;
                    })

            }
        },
        /**
         * verify password field is not empty
         * @returns {boolean}
         */
        verifyLogin () {
            if (!_.isNil(this.model.password) && !_.isEmpty(this.model.password)) {
                this.errorMessages.passwordErrorMessage = null;
                return true;
            } else {
                this.errorMessages.passwordErrorMessage = 'Password is required';
                return false;
            }
        }
    }
}