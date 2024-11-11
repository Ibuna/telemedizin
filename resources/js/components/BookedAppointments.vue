<template>
    <div class="flex justify-center items-center w-full my-6">
        <div class="prose w-full max-w-4xl">
            <h1 class="text-center mb-4">Gebuchte Termine</h1>
            <div v-if="bookedAppointments.length > 0">
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <!-- head -->
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 px-4 py-2 w-1/4">Datum</th>
                            <th class="border border-gray-200 px-4 py-2 w-1/4">Name</th>
                            <th class="border border-gray-200 px-4 py-2 w-1/4">Fachgebiet</th>
                            <th class="border border-gray-200 px-4 py-2 w-1/4">Stornieren</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="bookedAppointment in bookedAppointments" :key="bookedAppointment.id" class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 w-1/2">
                                {{ formatDate(bookedAppointment.date_time) }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2 w-1/2">{{ bookedAppointment.name }}</td>
                            <td class="border border-gray-200 px-4 py-2 w-1/2">{{ bookedAppointment.specialization }}</td>
                            <td class="border border-gray-200 px-4 py-2 w-1/2">
                                <button @click="cancelAppointment(bookedAppointment.id)" class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                    Stornieren
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="text-center">
                <p>Keine gebuchten Termine vorhanden</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useRoute } from 'vue-router';
import { useMainStore } from '@/stores/mainStore';

export default defineComponent({
    name: 'BookedAppointments',
    data() {
        return {
            mainStore: useMainStore(),
        };
    },
    computed: {
        bookedAppointments() {
            return this.mainStore.bookedAppointments;
        },
    },
    methods: {
        async cancelAppointment(id: number) {
            await this.mainStore.cancelAppointment(id);
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
    created() {
        
    },
});
</script>