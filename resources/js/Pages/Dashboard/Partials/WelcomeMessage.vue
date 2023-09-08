<script setup>
defineProps({
    nama: String
})
</script>
<template>
    <div class="bg-white mt-10 px-4 py-6 rounded shadow-md">
        <p>Selamat Datang {{ nama }}</p>
    </div>
</template>