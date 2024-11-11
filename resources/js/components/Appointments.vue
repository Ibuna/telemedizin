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
            </div>
            <div v-else>
                <p>Loading...</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

export default defineComponent({
    name: 'DoctorAppointments',
    data() {
        return {
            doctor: null as any,
            appointments: [] as Array<{ id: number, start_time: date, end_time: date }>,
        };
    },
    methods: {
        async fetchAppointments(id: string) {
            try {
                const response = await axios.get(`/api/doctors/${id}`);
                this.doctor = response.data;
                this.timeslots = response.data.timeslots;
            } catch (error) {
                console.error('Error fetching doctor:', error);
            }
        },
        formatDate(dateString: string) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}.${month}.${year} ${hours}:${minutes} Uhr`;
        },
    },
    mounted() {
        const route = useRoute();
        const doctorId = route.params.id as string;
        this.fetchDoctor(doctorId);
    },
});
</script>