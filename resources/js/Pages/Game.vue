<template>
    <MainLayout>
        <div class="flex flex-col justify-center">
            <div class="flex">
                <div class="font-bold flex-grow">Player Turn: <span class="capitalize">{{ game.player }}</span></div>
                <button class="font-bold bg-black text-white px-2 py-1 rounded hover:bg-gray-700"
                    @click="surrender">Surrender</button>
            </div>
            <div class="grid grid-cols-4 mt-2">
                <div v-for="(col, colIndex) in game.board">
                    <div v-for="(row, rowIndex) in col">
                        <div class="text-2xl border-2 py-4 px-8 capitalize border-black cursor-pointer"
                            @click="move(colIndex, rowIndex)">
                            {{ row }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="game.error" class="mt-2 text-red-500">{{ game.error }}</div>
        <GameResult v-if="game.result" />
    </MainLayout>
</template>

<script setup>
import { computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axios from 'axios';
import MainLayout from '@/Layouts/MainLayout.vue';
import GameResult from '@/Partials/Result.vue';

const game = computed(() => {
    return usePage().props.game;
});

const move = (async (row, col) => {
    await axios.post('/move', { row, col }).then(response => {
        router.reload({ only: ["game"] });
    }).catch((error) => {
        console.log(error)
    });
})

const surrender = (async () => {
    await axios.post('/surrender').then(response => {
        router.reload({ only: ["game"] });
    }).catch((error) => {
        console.log(error)
    });
})
</script>