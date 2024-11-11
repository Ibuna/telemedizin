import { defineStore } from 'pinia';
import axios from 'axios';

export const useMainStore = defineStore('main', {
    state: () => ({
        doctors: [] as Array<{ id: number, name: string, specialization: { name: string }, timeslots: Array<{ id: number, date: string }> }>,
        timeslots: [] as Array<{ id: number, start_time: string, end_time: string }>,
        appointments: [] as Array<{ id: number, date_time: string, status: string }>,
        bookedAppointments: [] as Array<{ id: number, date_time: string, name: string, specialization: string }>,
        doctor: null as any,
    }),
    actions: {
        async fetchDoctors() {
            try {
                const response = await axios.get('/api/doctors');
                this.doctors = response.data;
            } catch (error) {
                console.error('Error fetching doctors:', error);
            }
        },
        async fetchDoctor(id: number) {
            try {
                const response = await axios.get(`/api/doctors/${id}`);
                console.log(response.data);
                this.doctor = response.data;
                this.timeslots = response.data.timeslots;
                this.appointments = response.data.appointments;
            } catch (error) {
                console.error('Error fetching doctor:', error);
            }
        },
        async bookAppointment(id: number, patientName: string, patientEmail: string) {
            try {
                const response = await axios.put(`/api/appointments/${id}`, { status: 'booked', patient_name: patientName, patient_email: patientEmail });
                const index = this.appointments.findIndex(appointment => appointment.id === id);
                if (index !== -1) {
                    this.appointments[index].status = 'booked';
                }
                this.bookedAppointments.push({
                    id: this.appointments[index].id,
                    date_time: this.appointments[index].date_time,
                    name: this.doctor.name,
                    specialization: this.doctor.specialization.name,
                });
            } catch (error) {
                throw error;
            }
        },
        async cancelAppointment(id: number) {
            try {
                const response = await axios.put(`/api/appointments/${id}`, { status: 'available' });
                this.bookedAppointments = this.bookedAppointments.filter(appointment => appointment.id !== id);
            } catch (error) {
                console.error('Error canceling appointment:', error);
            }
        },
        clearTimeslots() {
            if (this.doctor) {
                this.doctor.timeslots = [];
            }
        },
        clearAppointments() {
            if (this.doctor) {
                this.doctor.appointments = [];
            }
        },
        clearDoctor() {
            this.doctor = null;
        },
    },
});