<template>





    <div class=" container mx-auto">
            <div  v-for="publication in publications" class="  flex items-center justify-center py-2">
                <a href="#" class="block w-5/12 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{publication.id }}.{{ publication.title }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ publication.photos }}<br>${{ publication.price }}</p>
                </a>
            </div>

        <div class="flex justify-center mt-4 space-x-2">
            <button
                @click="fetchPage(page - 1)"
                :disabled="page === 1"
                class="px-4 py-2 bg-gray-800 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Previous
            </button>
            <button
                v-for="pageNumber in totalPages"
                :key="pageNumber"
                @click="fetchPage(pageNumber)"
                :class="{'bg-gray-800 text-white': page === pageNumber, 'bg-gray-200 text-gray-800': page !== pageNumber}"
                class="px-4 py-2 rounded"
            >
                {{ pageNumber }}
            </button>
            <button
                @click="fetchPage(page + 1)"
                :disabled="page === totalPages"
                class="px-4 py-2 bg-gray-800 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const publications = ref([]);
const page = ref(1);
const totalPages = ref(1);

const fetchPage = async (pageNumber) => {
    try {
        const response = await axios.get(`/index.php/api?page=${pageNumber}`);
        publications.value = response.data.data;
        page.value = response.data.meta.current_page;
        totalPages.value = response.data.meta.last_page;
    } catch (error) {
        console.error('Error fetching publications', error);
    }
};

onMounted(() => {
    fetchPage(page.value);
});
</script>

<style scoped>
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>



