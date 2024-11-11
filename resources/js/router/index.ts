import { createRouter, createWebHistory } from 'vue-router';
import Overview from '@/components/Overview.vue';
import DoctorDetail from '@/components/DoctorDetail.vue';
import BookedAppointments from '../components/BookedAppointments.vue';

const routes = [
  {
    path: '/',
    name: 'Overview',
    component: Overview,
  },
  {
    path:  '/doctors/:id',
    name: 'DoctorDetail',
    component: DoctorDetail, 
    props: true,
  },
  {
    path:  '/booked-appointments',
    name: 'BookedAppointments',
    component: BookedAppointments, 
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;