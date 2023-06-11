<script setup>
    defineProps({
        modelValue: {
            type: String,
            required: true,
        },
    });

    defineEmits(['update:modelValue']);
</script>
<template>
    <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="" id="">
        <option selected disabled value="">--pilih prodi--</option>
        <option>PVTO</option>
        <option>Bahasa indonesia</option>
        <option>PGSD</option>
    </select>
</template>