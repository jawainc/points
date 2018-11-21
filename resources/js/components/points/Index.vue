<template>

    <div>

        <v-layout align-center justify-center row fill-height class="m-t-10">
            <v-flex xs11>
                <v-stepper alt-labels v-model="e1">
                    <v-stepper-header>
                        <v-stepper-step color="pink accent-3" :complete="e1 > 1" step="1">Search Your Name
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step color="pink accent-3" :complete="e1 > 2" step="2">Find Course</v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step color="pink accent-3" step="3">Enter Points</v-stepper-step>
                    </v-stepper-header>
                    <v-stepper-items>
                        <v-stepper-content step="1">

                            <v-card flat>
                                <v-layout align-center justify-center row class="layout-card">
                                    <v-flex xs12>
                                        <v-autocomplete
                                                ref="studentAutoFocus"
                                                v-model="model.student"
                                                :items="items.students"
                                                :loading="isStudentLoading"
                                                :search-input.sync="studentSearch"
                                                color="blue-grey darken-2"
                                                hide-selected
                                                hide-no-data
                                                clearable
                                                label="Student Name"
                                                placeholder="Start typing to Search"
                                                :error-messages="errorMessages.searchStudentErrorMessage"
                                        ></v-autocomplete>
                                    </v-flex>
                                </v-layout>
                                <v-card-actions>
                                    <v-btn large color="pink" @click="verifyStudentName()" dark>
                                        Continue
                                    </v-btn>
                                </v-card-actions>
                            </v-card>

                        </v-stepper-content>
                        <v-stepper-content step="2">

                            <v-card flat>
                                <v-layout align-space-around justify-center column class="layout-card">
                                    <v-flex xs12>
                                        <v-icon>mdi-school</v-icon>
                                        <span class="m-l-15 student-name">{{model.student.name}}</span>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-autocomplete
                                                :autofocus="courseAutoFocus"
                                                v-model="model.courseName"
                                                :items="model.student.courses"
                                                item-text="name"
                                                item-value="id"
                                                :loading="isCourseLoading"
                                                color="blue-grey darken-2"
                                                hide-selected
                                                hide-no-data
                                                clearable
                                                label="Course"
                                                placeholder="Start typing to Search"
                                                :error-messages="errorMessages.searchCourseErrorMessage"
                                        ></v-autocomplete>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-autocomplete
                                                v-model="model.courseSession"
                                                :items="items.sessions"
                                                :loading="isSessionLoading"
                                                color="blue-grey darken-2"
                                                hide-selected
                                                hide-no-data
                                                clearable
                                                label="Course Session"
                                                placeholder="Start typing to Search"
                                                :error-messages="errorMessages.searchSessionErrorMessage"
                                                :disabled="isCourseSelected"
                                        ></v-autocomplete>
                                    </v-flex>
                                </v-layout>
                                <v-card-actions>
                                    <v-btn large color="pink" @click="verifyCourse()" dark>Continue</v-btn>
                                    <v-btn large flat @click="e1 = 1">Back</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn large outline color="blue-grey darken-1" @click="cancel()">Cancel</v-btn>
                                </v-card-actions>
                            </v-card>

                        </v-stepper-content>
                        <v-stepper-content step="3">

                            <v-card flat>
                                <v-layout align-space-around justify-center column class="layout-card">
                                    <v-layout row wrap>
                                        <v-flex xs12 class="p-10">
                                            <v-text-field
                                                    ref="pointsAutoFocusInput"
                                                    :autofocus="pointsAutoFocus"
                                                    v-model="model.studentPoints"
                                                    label="Enter Points"
                                                    color="blue-grey darken-2"
                                                    type="text"
                                                    @focus="focused('points')"
                                                    :readonly="true"
                                                    :error-messages="errorMessages.studentPointsErrorMessage"
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex class="p-10" xs6>
                                            <v-text-field
                                                    v-model="model.studentHours"
                                                    label="Enter Hours"
                                                    color="blue-grey darken-2"
                                                    type="text"
                                                    @focus="focused('hours')"
                                                    :readonly="true"
                                                    :error-messages="errorMessages.studentHoursErrorMessage"
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex class="p-10" xs6>
                                            <v-text-field
                                                    v-model="model.studentMinutes"
                                                    label="Enter Minutes"
                                                    color="blue-grey darken-2"
                                                    type="text"
                                                    @focus="focused('minutes')"
                                                    :readonly="true"
                                            ></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row>
                                        <v-flex class="p-10" xs12>
                                            <v-btn @click="keyBoardInput('1')" dark color="pink">
                                                <v-icon dark>mdi-numeric-1</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('2')" dark color="pink">
                                                <v-icon dark>mdi-numeric-2</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('3')" dark color="pink">
                                                <v-icon dark>mdi-numeric-3</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('4')" dark color="pink">
                                                <v-icon dark>mdi-numeric-4</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('5')" dark color="pink">
                                                <v-icon dark>mdi-numeric-5</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('6')" dark color="pink">
                                                <v-icon dark>mdi-numeric-6</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('7')" dark color="pink">
                                                <v-icon dark>mdi-numeric-7</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('8')" dark color="pink">
                                                <v-icon dark>mdi-numeric-8</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('9')" dark color="pink">
                                                <v-icon dark>mdi-numeric-9</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('0')" dark color="pink">
                                                <v-icon dark>mdi-numeric-0</v-icon>
                                            </v-btn>
                                            <v-btn @click="keyBoardInput('del')" dark color="pink">
                                                <v-icon dark>mdi-backspace</v-icon>
                                            </v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-layout>
                                <v-card-actions>
                                    <v-btn large color="pink" @click="proceedFinish()" :loading="isFinishing" dark>Finish</v-btn>
                                    <v-btn large color="light-green " :loading="isSaving" @click="proceedGraph()" dark>
                                        View Graph
                                    </v-btn>
                                    <v-btn large flat @click="e1 = 2">Back</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn outline color="blue-grey darken-1" @click="cancel()">Cancel</v-btn>
                                </v-card-actions>
                            </v-card>

                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
            </v-flex>
        </v-layout>


            <v-dialog
                    v-model="passwordDialog"
                    width="500"
            >


                <v-card>
                    <v-card-title
                            class="headline blue-grey text-white"
                            primary-title
                    >
                        Enter Your Password
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field label="Passord"
                                                  type="password"
                                                  v-model="model.studentPassword"
                                                  color="blue-grey darken-2"
                                                  :error-messages="errorMessages.studentPasswordErrorMessage"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="pink"
                                flat
                                large
                                @click="confirmPassword()"
                                :loading="isVerifyingPassword"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

    </div>

</template>

<script src="./_index.js"></script>
