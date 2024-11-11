<template>
    <div class="flex justify-center items-center w-full my-6">
        <div class="prose w-full max-w-4xl">
            <h1 class="text-center mb-4">Arzt Details</h1>
            <div v-if="doctor">
                <p><strong>Name:</strong> {{ doctor.name }}</p>
                <p><strong>Fachgebiet:</strong> {{ doctor.specialization.name }}</p>
                <h3 class="text-center mb-4">Telemedizinsprechstunden</h3>
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <!-- head -->
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 px-4 py-2 w-1/2">Start</th>
                            <th class="border border-gray-200 px-4 py-2 w-1/2">Ende</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="timeslot in timeslots" :key="timeslot.id" class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 w-1/2">
                                {{ formatDate(timeslot.start_time) }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 w-1/2">{{ formatDate(timeslot.end_time) }}</td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="text-center mb-4">Termine</h3>
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <!-- head -->
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 px-4 py-2 w-full">Termin</th>
                            <th class="border border-gray-200 px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="appointment in appointments" :key="appointment.id">
                            <tr :class="{ 'bg-gray-200': appointment.status === 'booked' }" class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-2 w-full">
                                    {{ formatDate(appointment.date_time) }}
                                </td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <button v-if="appointment.status === 'available'"
                                        @click="toggleForm(appointment.id)"
                                        class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                        Buchen
                                    </button>
                                    <button v-else class="ml-4 bg-gray-500 text-white font-bold py-1 px-2 rounded" disabled>
                                        {{ appointment.status }}
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="isFormVisible(appointment.id)">
                                <td colspan="2" class="border border-gray-200 px-4 py-2 bg-blue-100">
                                    <form @submit.prevent="submitForm(appointment.id)">
                                        <div class="mb-4">
                                            <label for="patient_name"
                                                class="block text-gray-700 text-sm font-bold mb-2">Patientenname:</label>
                                            <input type="text" v-model="form.patient_name" id="patient_name"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="patient_email"
                                                class="block text-gray-700 text-sm font-bold mb-2">E-Mail-Adresse:</label>
                                            <input type="email" v-model="form.patient_email" id="patient_email"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                required>
                                        </div>
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Absenden
                                        </button>
                                        <p v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</p>
                                    </form>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <p>Loading...</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useRoute } from 'vue-router';
import { useMainStore } from '@/stores/mainStore';

export default defineComponent({
    name: 'DoctorDetail',
    data() {
        return {
            mainStore: useMainStore(),
            form: {
                patient_name: '',
                patient_email: '',
            },
            visibleFormId: null as number | null,
            errorMessage: '' as string | null,
            intervalId: null as number | null,
        };
    },
    computed: {
        doctor() {
            return this.mainStore.doctor;
        },
        timeslots() {
            return this.mainStore.timeslots;
        },
        appointments() {
            return this.mainStore.appointments;
        },
    },
    methods: {
        formatDate(dateString: string) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}.${month}.${year} ${hours}:${minutes} Uhr`;
        },
        async fetchDoctor(id: number) {
            await this.mainStore.fetchDoctor(id);
        },
        async bookAppointment(id: number) {
            try {
                await this.mainStore.bookAppointment(id, this.form.patient_name, this.form.patient_email);
                this.visibleFormId = null;
                this.errorMessage = null;
            } catch (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    this.errorMessage = error.response.data.message;
                } else {
                    this.errorMessage = 'Fehler beim Buchen des Termins. Bitte versuchen Sie es erneut.';
                }
            }
        },
        async checkAvailability(doctorId: number) {
            await this.mainStore.checkAppointmentAvailability(doctorId);
        },
        toggleForm(id: number) {
            // Reset form data
            this.form.patient_name = '';
            this.form.patient_email = '';
            this.errorMessage = null;
            this.visibleFormId = this.visibleFormId === id ? null : id;
        },
        isFormVisible(id: number) {
            return this.visibleFormId === id;
        },
        async submitForm(id: number) {
            await this.bookAppointment(id);
        },
        clearData() {
            this.mainStore.clearTimeslots();
            this.mainStore.clearAppointments();
            this.mainStore.clearDoctor();
        },
    },
    created() {
        const route = useRoute();
        const doctorId = parseInt(route.params.id as string, 10);
        this.fetchDoctor(doctorId);
        // Check availability every 10 seconds
        this.intervalId = window.setInterval(() => {
            this.checkAvailability(doctorId);
        }, 10000);
    },
    beforeUnmount() {
        this.clearData();
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    },
});
</script>