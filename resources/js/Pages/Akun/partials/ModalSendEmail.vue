<script setup>
import { ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EmailButton from '@/Components/EmailButton.vue';
defineProps({
    button_text: String
})

const isHidden = ref(true)
const showModal = () => {
    isHidden.value = !isHidden.value
}
</script>
<template>
    <EmailButton @click="showModal">{{ button_text }}</EmailButton>

    <div :class="{ 'hidden': isHidden }" class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg sm:w-1/3">
            <!--- modal title -->
            <div class="flex justify-end px-6 ">
                <div class="mt-2">
                    <PrimaryButton @click="showModal"><i class="fa-solid fa-xmark text-white"></i></PrimaryButton>
                </div>
            </div>
            <!-- modal body -->
            <div class="p-3">
                <form class="px-3 space-y-6">

                    <div>
                        <p>ini modal send email</p>
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton class="mt-5">Submit</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>