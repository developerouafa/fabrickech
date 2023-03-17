<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
    categories: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Log in" />
        <!-- form wrapper -->
            <div class="container py-16">
                <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                    <h2 class="text-2xl uppercase font-medium mb-1">
                        {{__('LOGIN')}}
                    </h2>
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <p class="text-gray-600 mb-6 text-sm">
                        {{ __('loginifyouare') }}
                    </p>
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div>
                                <InputLabel for="email" class="text-gray-600 mb-2 block">
                                    {{__('EmailAddress')}} <span class="text-primary">*</span>
                                </InputLabel>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="input-box"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="example@mail.com"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            <div>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="input-box"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="type password"
                                />

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-3 text-gray-600">{{__('rememberme')}}</span>
                                </label>
                            </div>
                            <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-primary text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{__('forgotyourpassword')}}
                        </Link>
                        </div>
                        <div class="mt-4">
                            <Button class="block w-full py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{__('login')}}
                            </Button>
                        </div>
                    </form>
                    <p class="mt-4 text-gray-600 text-center">
                        {{__('donthaveaccount')}}
                        <Link
                            :href="route('register')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                        {{__('RegisterNow')}}
                        </Link>
                    </p>
                </div>
            </div>
        <!-- form wrapper end -->
    <!-- </GuestLayout> -->
</template>
