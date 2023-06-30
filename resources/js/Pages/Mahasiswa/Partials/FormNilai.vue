<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="flex">
            <InputLabel for="nama" class="basis-1/4 mt-3" value="Nama" />
            <TextInput
                disabled
                id="nama"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nama"
            />
        </div>
        <div class="flex">
            <InputLabel for="nim" class="basis-1/4 mt-3" value="Nim" />
            <TextInput
                disabled
                id="nim"
                type="text"
                class="mt-1 block w-full bg-slate-200"
                v-model="form.nim"
            />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_satu" class="basis-1/5 mt-3" value="Nilai Komponen 1" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="n_komponen_satu"
                v-model="form.n_komponen_satu"
            />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_dua" class="basis-1/5 mt-3" value="Nilai Komponen 2" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="n_komponen_dua"
                v-model="form.n_komponen_dua"
            />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_tiga" class="basis-1/5 mt-3" value="Nilai Komponen 3" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="n_komponen_tiga"
                v-model="form.n_komponen_tiga"
            />
        </div>
        <div class="flex">
            <InputLabel for="n_komponen_empat" class="basis-1/5 mt-3" value="Nilai Komponen 4" />
            <InputLikertScale
                class="mt-2.5 block"
                :name="n_komponen_empat"
                v-model="form.n_komponen_empat"
            />
        </div>
        <PrimaryButton>Submit</PrimaryButton>
    </form>
</template>
<script>
import { reactive, onMounted } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLikertScale from '@/Components/InputLikertScale.vue'
import axios from 'axios';
export default {
    components: {
        TextInput,
        InputLabel,
        InputError,
        PrimaryButton,
        InputLikertScale
    },
    props: {
        id: Number
    },
    setup(props){
        const form = reactive({
            nama: '',
            nim: '',
            n_komponen_satu: '',
            n_komponen_dua: '',
            n_komponen_tiga: '',
            n_komponen_empat: ''

        })

        onMounted(() => {
            axios.get(`/getMahasiswaGuruPamongById/${props.id}`)
            .then((res) => {
                form.nama = res.data.data.nama
                form.nim = res.data.data.nim
            })
            .catch((err) => {
                console.log(err)
            })
        })

        const submit = () => {
            console.log(form)
        }

        return {
            form,
            submit
        }
    }
}
</script>