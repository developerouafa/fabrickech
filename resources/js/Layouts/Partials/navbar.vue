<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, useForm } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const searchcategory = ref("1")

const search = _.throttle(function(){
        const formtwo = useForm({
            searchcategory: searchcategory.value,
        });
        formtwo.get(route('shop'),{
            replace: true,
            preserveState: true,
        });
    }, 500)
</script>
<template>
    <nav class="bg-gray-800 hidden lg:block">
        <div class="container">
            <div class="flex">
                <!-- all category -->
                <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                    <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                        <option
                        class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                        v-for="category in $page.props.categories"
                        :value="category.id"
                        :key="category.id"
                        ><span class="ml-6 text-gray-600 text-sm"> {{category.title.en}} </span></option>
                    </select>
                </div>
                <div v-if="$page.props.locale.locale == 'ar'">
                    <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                        <option
                        class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                        v-for="category in $page.props.categories"
                        :value="category.id"
                        :key="category.id"
                        ><span class="ml-6 text-gray-600 text-sm"> {{category.title.ar}} </span></option>
                    </select>
                </div>
                <div v-if="$page.props.locale.locale == 'en'">
                    <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                        <option
                        class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                        v-for="category in $page.props.categories"
                        :value="category.id"
                        :key="category.id"
                        ><span class="ml-6 text-gray-600 text-sm"> {{category.title.en}} </span></option>
                    </select>
                </div>
                <!-- all category end -->

                <!-- nav menu -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center justify-between flex-grow pl-12 pr-12">
                        <div class="flex items-center space-x-6 text-base capitalize">
                            <Link :href="route('welcome')" :active="route().current('welcome')" class="text-gray-200 hover:text-white transition pl-4">
                                {{__('home')}}
                            </Link>
                            <Link :href="route('shop')" :active="route().current('shop')" class="text-gray-200 hover:text-white transition">
                                {{__('shop')}}
                            </Link>
                            <Link :href="route('posts')" class="text-gray-200 hover:text-white transition"> {{__('aboutus')}} </Link>
                            <Link :href="route('contactus')" class="text-gray-200 hover:text-white transition"> {{__('contactus')}} </Link>
                        </div>
                        <div>
                            <div class="ml-3 relative" v-if="$page.props.auth.user">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 hover:text-white focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <div class="text-2xl"><i class="far fa-user"></i></div>
                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.manageaccount')"> {{__('MyProfile')}} </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            {{__('Logout')}}
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>

                            <template v-else>
                                <Link :href="route('login')" class="ml-auto justify-self-end text-gray-200 hover:text-white transition">{{__('login')}} / </Link>
                                <Link
                                    :href="route('register')"
                                    class="ml-auto justify-self-end text-gray-200 hover:text-white transition"
                                    >{{__('register')}}</Link
                                >
                            </template>
                        </div>
                    </div>
                <!-- nav menu end -->
            </div>
        </div>
    </nav>

    <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:hidden">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- all category -->
                    <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                        <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                            <option
                            class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                            v-for="category in $page.props.categories"
                            :value="category.id"
                            :key="category.id"
                            ><span class="ml-6 text-gray-600 text-sm"> {{category.title.en}} </span></option>
                        </select>
                    </div>
                    <div v-if="$page.props.locale.locale == 'ar'">
                        <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                            <option
                            class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                            v-for="category in $page.props.categories"
                            :value="category.id"
                            :key="category.id"
                            ><span class="ml-6 text-gray-600 text-sm"> {{category.title.ar}} </span></option>
                        </select>
                    </div>
                    <div v-if="$page.props.locale.locale == 'en'">
                        <select class="px-8 py-4 bg-primary flex items-center cursor-pointer group relative" v-model="searchcategory" @change="search">
                            <option
                            class="px-6 py-3 flex items-center border-gray-300 bg-gray-100 hover:bg-gray-100 transition"
                            v-for="category in $page.props.categories"
                            :value="category.id"
                            :key="category.id"
                            ><span class="ml-6 text-gray-600 text-sm"> {{category.title.en}} </span></option>
                        </select>
                    </div>
                    <!-- all category end -->
                </div>

                <!-- Hamburger -->
                <div class="flex items-center">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    <!-- Responsive Navigation Menu -->
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="lg:hidden"
        >
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('welcome')" :active="route().current('welcome')">
                        {{__('home')}}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('shop')" :active="route().current('shop')">
                        {{__('shop')}}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('posts')">{{__('aboutus')}}</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('contactus')">{{ __('contactus') }}</ResponsiveNavLink>
                    <div v-if="$page.props.auth.user">
                        <ResponsiveNavLink :href="route('profile.edit')"> {{__('MyProfile')}} </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" as="button">
                            {{__('Logout')}}
                        </ResponsiveNavLink>
                    </div>
                    <template v-else>
                        <ResponsiveNavLink :href="route('login')">{{__('login')}} </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')" >{{__('register')}}</ResponsiveNavLink>
                    </template>
                </div>
            </div>
        </div>
</template>
