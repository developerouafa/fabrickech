<script setup>
import { Head, useForm } from '@inertiajs/vue3';
const props = defineProps({
            categories: {
                type: Object,
                default: () => ({}),
            },
        });
</script>

<template>
    <Head title="Home" />

        <!-- breadcrum -->
        <div class="container py-4 flex justify-between">
            <div class="flex gap-3 items-center">
                <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
                    <i class="fas fa-home"></i>
                </Link>
                <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
                <p class="text-gray-600 font-medium uppercase">{{__('Shopping Cart')}}</p>
            </div>
        </div>
        <!-- breadcrum end -->

        <!-- order complete wrapper -->
        <div class="max-w-3xl mx-auto px-4 pt-16 pb-24 text-center">
        <div class="mb-8">
            <img src="images/complete.png" class="w-16 inline-block">
        </div>
        <h2 class="text-gray-800 font-medium text-3xl mb-3">
            {{__('YOUR ORDER IS COMPLETED!')}}
        </h2>
        <p class="text-gray-600 ">
            {{__('thankyoufororder')}}
        </p>
        <div class="mt-10">
            <Link :href="route('shop')" :active="route().current('shop')" class="bg-primary border border-primary text-white px-6 py-3 font-medium rounded-md uppercase hover:bg-transparent
         hover:text-primary transition text-center">
         {{__('Continue shopping')}}
                </Link>
        </div>
    </div>
    <!-- order complete wrapper end -->
</template>
