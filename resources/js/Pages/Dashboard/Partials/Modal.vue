<template>
    <PrimaryButton>Tambah Kelas</PrimaryButton>

    <div class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg w-1/3">
            <!--- modal title -->
            <div class="px-6 py-2">
                <p>buat kelas</p>
            </div>
            <!-- modal body -->
            <div class="p-3">
                <form @submit.prevent="submit" class="px-3">
                    <div class="mb-5">
                        <InputLabel for="nama" value="Nama Kelas (wajib)" />
                        <TextInput
                            id="nama"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.nama"
                        />
                        <InputError class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <InputLabel for="prodi" value="prodi" />
                        <Select
                            v-model="form.prodi"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" />
                    </div>
                    <div>
                        <InputLabel for="matakuliah" value="Matakuliah" />
                        <TextInput
                            id="matakuliah"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.matakuliah" 
                        />
                        <InputError class="mt-2" />
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Buat</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue'
export default{
    components: { InputError, InputLabel, PrimaryButton, TextInput, Select, PrimaryButton },
    setup(){
        const form = reactive({
            nama: '',
            prodi: '',
            matakuliah: ''
        })

        const submit = () => {
            console.log(form)
        }

        return {
            submit,
            form
        }
    }
}
</script>