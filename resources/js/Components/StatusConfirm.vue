<script setup>
import { ref } from 'vue'

const classNoConfirm = ref('bg-red-500')
const classConfirm = ref('bg-green-500')
const confirm = ref('')
const props = defineProps({
    isConfirm: Number
})

console.log(props.isCon)

const setIsConfirm = () => {
    if(props.isConfirm == 1){
        confirm.value = 'ACC'
    }
    else{
        confirm.value = 'Belum ACC'
    }
    return confirm.value
}
</script>
<template>
    <p :class="[isConfirm == 1 ? classConfirm : classNoConfirm]" class="text-center rounded text-white">{{ setIsConfirm() }}</p>
</template>