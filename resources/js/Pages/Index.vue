<template>
    <MainLayout>
        <div class="flex flex-col justify-center">
            <button class="border-2 rounded px-5 py-2 bg-gray-500" @click="startGame">
                <span class="text-white font-bold text-lg">Start Game</span>
            </button>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from 'axios';
import { router } from "@inertiajs/vue3";

const startGame = (async () => {
    await axios.post('/start').then(response => {
        router.reload({ only: ["game"] });
    }).catch((error) => {
        console.log(error)
    });
})

</script>