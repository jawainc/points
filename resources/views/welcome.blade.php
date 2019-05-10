<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Students Point System') }}</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700|Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet" >
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <v-app>
                <v-toolbar color="pink" dark height=58 app>
                    <v-toolbar-title class="white--text font-weight-light">Student Points System</v-toolbar-title>
                </v-toolbar>
                <v-content>
                    <v-container fluid>
                        <router-view></router-view>
                    </v-container>
                </v-content>
            </v-app>
        </div>


    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

