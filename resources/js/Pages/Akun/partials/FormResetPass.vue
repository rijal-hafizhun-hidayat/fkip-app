<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import axios from 'axios';
import nprogress from 'nprogress';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const password = ref('')
const validation = ref([])
const isSeePass = ref(false)

const props = defineProps({
    id: Number
})

const submit = () => {
    nprogress.start()
    axios.put(`/resetPass/${props.id}`, {
        password: password.value
    })
    .then((res) => {
        Swal.fire({
            icon: 'success',
            title: res.data.title,
            text: res.data.text
        })
        router.get('/akun')
    })
    .catch((err) => {
        validation.value = err.response.data.errors
    })
    .finally(() => {
        nprogress.done()
    })
}
</script>

<template>
    <section>
        <form @submit.prevent="submit" class="space-y-6">
            <InputLabel for="password" value="Masukkan Password Baru" />
            <div class="flex flex-row">
                <div class="basis-full">
                    <TextInput
                        id="password"
                        :type="isSeePass == false ? 'password' : 'text'"
                        class="mt-1 block w-full"
                        :class="{ 'border-rose-600': validation.password }"
                        v-model="password"
                    />

                    <InputError v-if="validation.password" :message="validation.password[0]" class="mt-2" />
                </div>
                <div class="ml-3">
                    <PrimaryButton v-if="isSeePass == true" class="mt-1 py-3.5" @click="isSeePass = !isSeePass"><i class="fa-solid fa-eye-slash"></i></PrimaryButton>
                    <PrimaryButton v-if="isSeePass == false" class="mt-1 py-3.5" @click="isSeePass = !isSeePass"><i class="fa-solid fa-eye"></i></PrimaryButton>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <PrimaryButton>Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
