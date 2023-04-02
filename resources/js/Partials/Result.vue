<template>
    <div class="absolute w-screen h-screen inset-0 flex justify-center items-center bg-gray-700 bg-opacity-80">
        <div class="bg-white p-10 flex flex-col items-center roundex-lg w-full">
            <div class="text-3xl font-bold" :class="player == 'X' ? 'text-red-500' : 'text-green-500'">{{ result }}
            </div>
            <button class="font-bold bg-black text-white px-2 py-1 rounded hover:bg-gray-700 mt-5"
                @click="restart">Restart</button>

        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axios from 'axios';

const result = computed(() => {
    return usePage().props.game.result;
});

const player = computed(() => {
    return usePage().props.game.player;
});

const restart = (async () => {
    await axios.post('/start').then(response => {
        router.reload({ only: ["game"] });
    }).catch((error) => {
        console.log(error)
    });
})

</script>