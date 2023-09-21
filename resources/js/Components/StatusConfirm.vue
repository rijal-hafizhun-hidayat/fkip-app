<script setup>
import { ref } from 'vue'

const classConfirm = ref('')
const confirm = ref('')
const props = defineProps({
    isConfirm: Number
})

const setIsConfirm = () => {
    if(props.isConfirm == 0){
        confirm.value = 'Menunggu proses Dpl'
        classConfirm.value = 'bg-black'
    }
    else if(props.isConfirm == 1){
        confirm.value = 'Direvisi'
        classConfirm.value = 'bg-amber-500'
    }
    else if(props.isConfirm == 2){
        confirm.value = 'Disetujui'
        classConfirm.value = 'bg-green-500'
    }
    else if(props.isConfirm == 3){
        confirm.value = 'Ditolak'
        classConfirm.value = 'bg-rose-500'
    }
    return confirm.value
}
</script>
<template>
    <div :class="[classConfirm]" class="rounded p-1.5 whitespace-nowrap">
        <p class="text-center text-white">{{ setIsConfirm() }}</p>
    </div>
</template>