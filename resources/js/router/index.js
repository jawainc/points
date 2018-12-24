// Home
import Home from '../components/home/Index';

// Graphs
import PointGraphs from '../components/point_graphs/Index';
import PointGraphSelection from '../components/point_graphs/GraphSelection';
import PointGraphSelectionStudents from '../components/point_graphs/graphs/Students';
import PointGraphSelectionGroup from '../components/point_graphs/graphs/Group';

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
     * Student Graph
     ******************/
    {
        path: '/graph/:enrollment_id/:course_id',
        name: 'Graph',
        component: Graphs
    }

]
