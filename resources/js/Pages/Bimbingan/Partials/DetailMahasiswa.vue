<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    mahasiswa: Array
})
console.log(props.mahasiswa['nim'])
</script>
<template>
    <div class="bg-white rounded-md shadow overflow-x-auto py-8 px-10 mt-10">
        <div class="flex">
            <InputLabel for="nama" class="basis-1/4 mt-3" value="Namaaaaaaa" />
            <TextInput
                disabled
                id="nama"
                type="text"
                class="mt-1 block w-full bg-slate-200"
            />
        </div>

        <div class="flex">
            <InputLabel for="nim" class="basis-1/4 mt-5" value="Nim" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-3 block w-full bg-slate-200"
            />
        </div>   
    </div>
</template>