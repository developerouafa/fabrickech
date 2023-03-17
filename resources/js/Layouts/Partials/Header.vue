<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import headerlanguageselector from './headerlanguageselector.vue';

const searchproduct = ref("")

const search = _.throttle(function(){
        const formtwo = useForm({
            searchproduct: searchproduct.value,
        });
        formtwo.get(route('shop'),{
            replace: true,
            preserveState: true,
        });
    }, 500)
</script>

<template>
    <header class="py-4 shadow-sm bg-gray-800 lg:bg-white">
        <div class="container flex items-center justify-between">
            <!-- logo -->
                <Link :href="route('welcome')" :active="route().current('welcome')" class="block w-32">
                    <img class="w-14" src="/assets/img/brand/favicon.png" alt="Logo">
                </Link>
                <!-- logo end -->
                <headerlanguageselector/>

            <!-- searchbar -->
                <div class="w-full flex xl:max-w-xl lg:max-w-lg lg:flex relative">
                    <span class="absolute left-4 top-3 text-lg text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input @keyup="search" type="text" v-model="searchproduct" class="pl-8 w-full border border-primary py-3 px-0 rounded-md focus:ring-primary focus:border-primary"
                    placeholder = " Search "/>
                </div>
            <!-- searchbar end -->

            <!-- navicons -->
            <div v-if="$page.props.auth.user">
                <div class="space-x-4 flex items-center px-4">
                    <Link :href="route('wishlist')" :active="route().current('wishlist')" class="m-3 block text-center text-white lg:text-gray-700 hover:text-primary transition relative">
                        <span
                            class="absolute -right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                            {{ $page.props.wishlists.wishlists }}
                        </span>
                        <div class="text-2xl">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="text-xs leading-3">{{ __('wishlist') }}</div>
                    </Link>
                    <Link :href="route('cart')" :active="route().current('cart')" class="m-3 block text-center text-white lg:text-gray-700 hover:text-primary transition relative">
                        <span
                            class="absolute -right-3 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                            {{ $page.props.carts.countincart }}
                        </span>
                        <div class="text-2xl">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="text-xs leading-3">{{ __('cart') }}</div>
                    </Link>
                </div>
            </div>
            <div v-else>
                <div class="space-x-4 flex items-center px-4">
                    <Link :href="route('wishlist')" :active="route().current('wishlist')" class="m-1 block text-center text-white lg:text-gray-700 hover:text-primary transition relative">
                        <div class="text-2xl">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="text-xs leading-3">{{ __('wishlist') }}</div>
                    </Link>
                    <Link :href="route('cart')" :active="route().current('cart')"
                        class="m-1 block text-center text-white lg:text-gray-700 hover:text-primary transition relative">
                        <div class="text-2xl">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="text-xs leading-3">{{ __('cart') }}</div>
                    </Link>
                </div>
            </div>
            <!-- navicons end -->
        </div>
    </header>
</template>
