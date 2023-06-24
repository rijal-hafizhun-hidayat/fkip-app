<template>
    <form @submit.prevent="submit" class="mt-6 space-y-6">
        <div>
            <InputLabel for="nipy" value="Nip / Niy" />
            <TextInput
                id="nipy"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nipy"
                :class="{ 'border-rose-600': validation.nipy }"
                v-on:keypress="numOnly()"
            />
            <InputError v-if="validation.nipy" :message="validation.nipy[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="nama" value="Nama" />
            <TextInput
                id="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                :class="{ 'border-rose-600': validation.nama }"
            />
            <InputError v-if="validation.nama" :message="validation.nama[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="prodi" value="Prodi"/>
            <SelectInput class="mt-1 blobk w-full" v-model="form.prodi" :class="{ 'border-rose-600': validation.prodi }">
                <option selected disabled value="">-- Pilih --</option>
                <option v-for="prodi in prodis">{{ prodi.nama }}</option>
            </SelectInput>
            <InputError v-if="validation.prodi" :message="validation.prodi[0]" class="mt-2" />
        </div>

        <div>
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                :class="{ 'border-rose-600': validation.email }"
            />
            <InputError v-if="validation.email" :message="validation.email[0]" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton>Save</PrimaryButton>
        </div>
    </form>
</template>
<script>
import { ref, reactive } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import axios from 'axios';
import NProgress from 'nprogress';
import Swal from 'sweetalert2'
export default {
    components: {
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
        SelectInput,
        Footer
    },
    props: {
        prodis: Object
    },
    setup(){
        const form = reactive({
            nipy: '',
            nama: '',   
            prodi: '',
            email: ''
        })

        const validation = ref([])

        const submit = () => {
            NProgress.start()
            axios.post('/dpl', {
                nipy: form.nipy,
                nama: form.nama,
                prodi: form.prodi,
                email: form.email,
                asal: form.asal
            })
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: res.data.title,
                    text: res.data.text
                })
                router.get('/dpl')
            })
            .catch((err) => {
                if(err.response.data.errors){
                    validation.value = err.response.data.errors
                }
                else{
                    //console.log(err.response.data)
                    Swal.fire({
                        icon: 'error',
                        title: err.response.data.title,
                        text: err.response.data.text
                    })
                }
            })
            .finally(() => {
                NProgress.done()
            })
        }

        const numOnly = (evt) => {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        }

        return {
            form,
            validation,
            submit,
            numOnly
        }
    }
}
</script>