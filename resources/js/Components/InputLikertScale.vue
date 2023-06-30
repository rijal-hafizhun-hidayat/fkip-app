<script setup>
    defineProps({
        modelValue: {
            type: String,
            required: true,
        },
        name: {
            type: String
        }
    });

    defineEmits(['update:modelValue']);
</script>
<template>
    <ul class="likert space-x-4">
        <li>Tidak Bagus</li>
        <li><input type="radio" :name="name" value="25" @input="$emit('update:modelValue', $event.target.value)" /></li>
        <li><input type="radio" :name="name" value="50" @input="$emit('update:modelValue', $event.target.value)" /></li>
        <li><input type="radio" :name="name" value="75" @input="$emit('update:modelValue', $event.target.value)" /></li>
        <li><input type="radio" :name="name" value="100" @input="$emit('update:modelValue', $event.target.value)" /></li>
        <li>Sangat Bagus</li>
    </ul>
</template>
<style scoped>
    .likert li {
        float: left;
        list-style-type: none;
    }
</style>