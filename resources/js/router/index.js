// Home
import Home from '../components/home/Index';

// Graphs & Points
import PointGraphs from '../components/admin_point_graphs/Index';
import PointSelection from '../components/admin_point_graphs/Selection';
import PointGraphSelection from '../components/admin_point_graphs/GraphSelection';
import PointGraphSelectionStudents from '../components/admin_point_graphs/graphs/Students';
import PointGraphSelectionGroup from '../components/admin_point_graphs/graphs/Group';
import PointPointSelection from '../components/admin_point_graphs/points/Index';
import PointPointStudent from '../components/admin_point_graphs/points/Student';
import PointPointSummary from '../components/admin_point_graphs/points/Summary';

// Points
import Points from '../components/points/Index';

// Student Points Graph
import Graphs from '../components/graphs/Index';



export default [
    /******************
     * Home
     ******************/
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    /******************
     * Points
     ******************/
    {
        path: '/points/search-name',
        name: 'Points',
        component: Points
    },
    /******************
     * Graphs
     ******************/
    {
        path: '/points/graph',
        name: 'PointGraph',
        component: PointGraphs
    },
    {
        path: '/points/selection',
        name: 'PointSelection',
        component: PointSelection
    },
    /******************
     * Admin Graphs
     ******************/
    {
        path: '/points/graph/selection',
        name: 'PointGraphSelection',
        component: PointGraphSelection
    },
    {
        path: '/points/graph/selection/students',
        name: 'PointGraphSelectionStudents',
        component: PointGraphSelectionStudents
    },
    {
        path: '/points/graph/selection/group/:id',
        name: 'PointGraphSelectionCategory',
        component: PointGraphSelectionGroup,
        props: true
    },
    /******************
     * Admin Points
     ******************/
    {
        path: '/points/points',
        name: 'PointPointSelection',
        component: PointPointSelection
    },
    {
        path: '/points/points/student',
        name: 'PointPointStudent',
        component: PointPointStudent
    },
    {
        path: '/points/points/summary',
        name: 'PointPointSummary',
        component: PointPointSummary
    },

    /******************
     * Student Graph
     ******************/
    {
        path: '/graph/:enrollment_id/:course_id',
        name: 'Graph',
        component: Graphs
    }

]
