<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
    categories: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Forgot Password" />
                <div class="container py-16">
                    <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                        <h2 class="text-sm text-gray-600 mb-4">
                            {{__('forgotpassword')}}
                        </h2>

                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit">
                            <div>
                                <label>{{__('EmailAddress')}}</label>

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Button class="px-2 py-2 text-center text-white bg-primary border rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{__('EmailPasswordResetLink')}}
                                </Button>
                            </div>
                        </form>
                </div>
            </div>
    <!-- </GuestLayout> -->
</template>
