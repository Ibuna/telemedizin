<template>
    <div class="flex justify-center items-center w-full my-6">
        <div class="prose w-full max-w-4xl">
            <h1 class="text-center mb-4">Ärzteübersicht</h1>
            <table class="table-auto w-full border-collapse border border-gray-200">
                <!-- head -->
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-200 px-4 py-2">Name</th>
                        <th class="border border-gray-200 px-4 py-2">Fachgebiet</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="doctor in doctors" :key="doctor.id" class="hover:bg-gray-50">
                        <td class="border border-gray-200 px-4 py-2 w-full">
                            <router-link :to="{ name: 'DoctorDetail', params: { id: doctor.id } }"
                                class="block w-full h-full no-underline text-slate-600 hover:text-slate-900">
                                {{ doctor.name }}
                            </router-link>
                        </td>
                        <td class="border border-gray-200 px-4 py-2">{{ doctor.specialization.name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script lang="ts">
import { defineComponent } from 'vue';
import { useMainStore } from '@/stores/mainStore';

export default defineComponent({
    name: 'Overview',
    data() {
        return {
            mainStore: useMainStore(),
        };
    },
    computed: {
        doctors() {
            return this.mainStore.doctors;
        },
    },
    methods: {
        async fetchDoctors() {
            await this.mainStore.fetchDoctors();
        },
    },
    created() {
        this.fetchDoctors();
    },
});
</script>