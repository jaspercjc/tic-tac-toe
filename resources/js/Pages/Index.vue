<template>
    <MainLayout>
        <div class="flex flex-col justify-center">
            <p class="text-center text-3xl font-bold">Tic Tac Toe</p>

            <button class="border-2 rounded px-5 py-2 bg-gray-500 mt-4" @click="startGame">
                <span class="text-white font-bold text-lg">Start Game</span>
            </button>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import axios from 'axios';
const startGame = (() => {

})
</script>