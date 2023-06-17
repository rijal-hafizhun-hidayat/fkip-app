<template>
    <footer>© {{ date }}. Fakultas Kependidikan Ilmu Pendidikan. All Rights Reserved</footer>
</template>
<script>
import { ref } from 'vue';
export default{
    setup(){
        const date = ref('')
        date.value = new Date().getFullYear()

        return {
            date
        }
    }
}
</script>