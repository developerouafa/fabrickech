<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: String,
    categories: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Email Verification" />

                <div class="container py-16">
                    <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
                        <h2 class="text-sm text-gray-600 uppercase font-medium mb-1">
                            {{ __('verifymailthanksyou') }}
                        </h2>
                        <p class="text-gray-600 mb-6 text-sm" v-if="verificationLinkSent">
                            {{__('anewverificationlink')}}
                        </p>
                        <form @submit.prevent="submit">
                            <div class="mt-4 flex items-center justify-between">
                                <Button class="px-2 py-2 text-center text-white bg-primary border rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    {{__('RESENDVERIFICATIONEMAIL')}}
                                </Button>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >{{ __('Logout') }}</Link
                                >
                            </div>
                        </form>
                    </div>
                </div>
    <!-- </GuestLayout> -->
</template>
