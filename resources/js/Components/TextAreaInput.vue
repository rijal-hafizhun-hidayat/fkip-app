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
    <textarea
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
</template>