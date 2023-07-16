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
        <li class="float-left list-none">Tidak Kompeten</li>
        <li class="float-left list-none"><input required type="radio" :name="name" :value="1" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue == 1"/></li>
        <li class="float-left list-none"><input required type="radio" :name="name" :value="2" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue == 2"/></li>
        <li class="float-left list-none"><input required type="radio" :name="name" :value="3" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue == 3"/></li>
        <li class="float-left list-none"><input required type="radio" :name="name" :value="4" @input="$emit('update:modelValue', $event.target.value)" :checked="modelValue == 4"/></li>
        <li class="float-left list-none">Sangat Kompoten</li>
    </ul>
</template>
<style scoped>
    /* .likert li {
        float: left;
        list-style-type: none;
    } */
</style>