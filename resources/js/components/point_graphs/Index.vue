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

<script src="./_index.js"></script>
