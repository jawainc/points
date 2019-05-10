<template>
    <v-layout align-center justify-center row fill-height>
        <v-flex xs8>
            <v-card class="p-l-30 p-r-30 p-t-40 p-b-40">
                <v-flex xs12>
                    <h1 class="text-primary">Enter password to login</h1>
                    <v-alert class="m-t-5 m-b-5"
                             type="error"
                             v-model="isLoginError"
                             dismissible
                             transition="scale-transition"
                    >
                        {{errorMessages.loginError}}
                    </v-alert>
                    <v-text-field
                            label="Enter Password"
                            type="password"
                            color="blue-grey darken-2"
                            v-model="model.password"
                            :error-messages="errorMessages.passwordErrorMessage"
                    ></v-text-field>
                    <v-card-actions>
                        <v-btn large color="pink" dark @click="submitLogin()" :loading="formSubmitting">Log In</v-btn>
                    </v-card-actions>
                </v-flex>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
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
                                this.$router.push('/points/selection');
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
</script>
