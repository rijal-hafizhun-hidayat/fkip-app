<script setup>
defineProps({
    level: String
})
</script>
<template>
    <div class="bg-red-500 mt-10 px-4 py-6 rounded shadow-md">
        <p v-if="level == 'dpl'" class="text-white">Dpl Belum Terhubung</p>
        <p v-else-if="level == 'guru-pamong'" class="text-white">Guru Pamong Belum Terhubung</p>
    </div>
</template>