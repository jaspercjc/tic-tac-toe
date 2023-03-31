<template>
    <MainLayout>
        <div class="flex flex-col justify-center">
            <div class="font-bold">Player Turn: <span class="capitalize">{{ game.player }}</span></div>
            <div class="grid grid-cols-4">
                <div v-for="(col, colIndex) in game.board">
                    <div v-for="(row, rowIndex) in col">
                        <div class="text-2xl border-2 py-4 px-8 capitalize border-black cursor-pointer">{{ row }}</div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import MainLayout from '@/Layouts/MainLayout.vue';

const game = computed(() => {
    return usePage().props.game;
});

</script>