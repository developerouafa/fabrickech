<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Confirm Password" />
                <div class="container py-16">
                    <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                        <h2 class="text-sm text-gray-600 mb-4">
                            This is a secure area of the application. Please confirm your password before continuing.
                        </h2>
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <Button class="px-2 py-2 text-center text-white bg-primary border rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Confirm
                                </Button>
                            </div>

                            <!-- <div class="flex justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Confirm
                                </PrimaryButton>
                            </div> -->
                        </form>
                    </div>
                </div>
    <!-- </GuestLayout> -->
</template>
