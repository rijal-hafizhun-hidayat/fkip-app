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
    <ul class="space-x-4">
        <li class="float-left list-none">Tidak Bagus</li>
        <li class="float-left list-none"><input type="radio" :name="name" :value="'25'" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue === 25"/></li>
        <li class="float-left list-none"><input type="radio" :name="name" :value="'50'" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue === 50"/></li>
        <li class="float-left list-none"><input type="radio" :name="name" :value="'75'" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue === 75"/></li>
        <li class="float-left list-none"><input type="radio" :name="name" :value="'100'" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue === 100"/></li>
        <li class="float-left list-none">Sangat Bagus</li>
    </ul>
</template>
<style scoped>
    /* .likert li {
        float: left;
        list-style-type: none;
    } */
</style>