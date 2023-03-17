<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    categories: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->

        <Head title="Register" />
        <!-- form wrapper -->
            <div class="container py-16">
                <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                    <h2 class="text-2xl uppercase font-medium mb-1">
                        {{__('createaccount')}}
                    </h2>
                    <p class="text-gray-600 mb-6 text-sm">
                        {{__('registerhere')}}
                    </p>
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div>
                                <InputLabel for="email" class="text-gray-600 mb-2 block">{{__('EmailAddress')}} <span class="text-primary">*</span></InputLabel>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                                    v-model="form.email"
                                    required
                                    autocomplete="username"
                                    placeholder="example@mail.com"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            <div>
                                <InputLabel for="password" class="text-gray-600 mb-2 block">{{__('password')}} <span class="text-primary">*</span></InputLabel>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="type password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                            <div>
                                <InputLabel for="password_confirmation" class="text-gray-600 mb-2 block">{{__('confirmpassword')}} <span class="text-primary">*</span></InputLabel>
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="confirm your password"
                                />

                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <Button class="block w-full py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{__('createaccount')}}
                            </Button>
                        </div>
                    </form>
                    <p class="mt-4 text-gray-600 text-center">
                        <Link
                            :href="route('login')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                        {{__('Alreadyregistered')}}
                        </Link>
                    </p>
                </div>
            </div>
        <!-- form wrapper end -->
    <!-- </GuestLayout> -->
</template>
