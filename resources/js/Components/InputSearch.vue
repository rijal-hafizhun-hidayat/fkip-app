<script setup>
defineProps({
    modelValue: {
        type: String,
    },
});

defineEmits(['update:modelValue']);
</script>
<template>
    <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="px-2 py-2 border-solid border-2 border-slate-300 rounded"
        placeholder="Cari ..."
    />
</template>