<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Pagination from './Pagination.vue';
import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';

const showingNavigationDropdown = ref(false);

const props = defineProps({
        products: {
            type: Object,
            default: () => ({}),
        },
        filtres: Object,
        categories: {
            type: Object,
            default: () => ({}),
        },
        idbycategory: {
            type: Number,
            default: () => ({}),
        }
    });
    const per_page = ref(props.filtres.per_page ?? 5)
    const defaultshorting = ref(props.filtres.defaultshorting ?? 3)
    const searchcategory = ref(props.filtres.searchcategory ?? "")
    const searchpriceone = ref(props.filtres.searchpriceone ?? "")
    const searchpricetwo = ref(props.filtres.searchpricetwo ?? "")
    // const searchsizeheight = ref(props.filtres.searchsizeheight ?? "")
    // const searchsizewidth = ref(props.filtres.searchsizewidth ?? "")

    const search = _.throttle(function(){
        console.log("per_page : ", per_page.value)
        console.log("defaultshorting : ", defaultshorting.value)
        console.log("searchcategory : ", searchcategory.value)
        console.log("searchpriceone : ", searchpriceone.value)
        console.log("searchpricetwo : ", searchpricetwo.value)
        console.log("idbycategory : ", props.idbycategory)

        const formtwo = useForm({
            per_page: per_page.value,
            defaultshorting: defaultshorting.value,
            searchcategory: searchcategory.value,
            searchpriceone: searchpriceone.value,
            searchpricetwo: searchpricetwo.value,
            // searchsizeheight: searchsizeheight.value,
            // searchsizewidth: searchsizewidth.value,
            idbycategory: props.idbycategory,
        });
        formtwo.get(route('shopbycategoryindex'),{
            replace: true,
            preserveState: true,
        });
    }, 500)

    // View
        const formview = useForm({
            id: props.products.id
        });
        function view(id) {
                formview.get(route('view.product', id));
        }

    // Wishlist
        const formWishlist = useForm({
            id: props.products.id
        });
        function addwishlist(id) {
            formWishlist.get(route('addwishlist', id),
                {
                    onSuccess: (page) => {
                        useSwallSuccess("Add To Wish List Success")
                    },
                    onerror: (errors) => {
                        useSwallErreur("Erreur")
                    }
                });
        }

    // Add To Cart
        const formaddtocart = useForm({
            id: props.products.id
        });
        function addtocart(id) {
            formaddtocart.post(route('addtocart', id),
                {
                    onSuccess: (page) => {
                        useSwallSuccess("Add To Cart Success")
                    },
                    onerror: (errors) => {
                        useSwallErreur("Erreur")
                    }
                });
        }
</script>

<template>
    <Head title="Shop" />

    <!-- breadcrum -->
    <div class="container py-4 flex justify-between">
        <div class="flex gap-3 items-center">
            <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
                <i class="fas fa-home"></i>
            </Link>
            <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
            <p class="text-gray-600 font-medium">{{__('shop')}}</p>
        </div>
    </div>
    <!-- breadcrum end -->

    <!-- shop wrapper -->
    <div class="container grid lg:grid-cols-4 gap-6 pt-4 pb-16 items-start relative">
        <!-- sidebar -->
        <div class="col-span-1 bg-white px-4 pt-4 pb-6 shadow rounded overflow-hidden absolute lg:static left-4 top-16 z-10 w-72 lg:w-full lg:block">
            <div class="divide-gray-200 divide-y space-y-5 relative">
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }">
                    <!-- category filter -->
                    <div class="pt-4">
                            <select class="w-56 text-sm text-gray-600 px-4 py-3 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary" v-model="defaultshorting" @change="search">
                                <option :value="1">{{__('pricehigh')}}</option>
                                <option :value="2">{{__('pricelow')}}</option>
                                <option :value="3">{{__('latestpr')}}</option>
                                <option :value="4">{{__('olderproduct')}}</option>
                            </select>
                            <select class="mt-2 w-56 text-sm text-gray-600 px-4 py-3 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary"
                                @change="search"
                                v-model="per_page">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                    </div>
                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">{{__('childrencategory')}}</h3>
                        <!-- <div class="space-y-2"> -->
                            <!-- single category -->
                            <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                <select class="mt-2 w-56 text-sm text-gray-600 px-4 py-3 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary"
                                    v-model="searchcategory" @change="search">
                                    <option
                                    v-for="category in props.categories"
                                    :value="category.id"
                                    :key="category.id"
                                    >{{category.title.en}}</option>
                                </select>
                            </div>
                            <div v-if="$page.props.locale.locale == 'ar'">
                                <select class="mt-2 w-56 text-sm text-gray-600 px-4 py-3 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary"
                                    v-model="searchcategory" @change="search">
                                    <option
                                    v-for="category in props.categories"
                                    :value="category.id"
                                    :key="category.id"
                                    >{{category.title.ar}}</option>
                                </select>
                            </div>
                            <div v-if="$page.props.locale.locale == 'en'">
                                <select class="mt-2 w-56 text-sm text-gray-600 px-4 py-3 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary"
                                    v-model="searchcategory" @change="search">
                                    <option
                                    v-for="category in props.categories"
                                    :value="category.id"
                                    :key="category.id"
                                    >{{category.title.en}}</option>
                                </select>
                            </div>
                            <!-- single category end -->
                        <!-- </div> -->
                    </div>
                    <!-- category filter end -->
                    <!-- price filter -->
                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">{{__('price')}}</h3>
                        <div class="mt-4 flex items-center">
                            <input
                                @keyup="search"
                                v-model="searchpriceone"
                                type="text"
                                class="w-full border-gray-300 focus:ring-0 focus:border-primary px-3 py-1 text-gray-600 text-sm shadow-sm rounded"
                                placeholder="min">
                            <span class="mx-3 text-gray-500">-</span>
                            <input
                                @keyup="search"
                                v-model="searchpricetwo"
                                type="text"
                                class="w-full border-gray-300 focus:ring-0 focus:border-primary px-3 py-1 text-gray-600 text-sm shadow-sm rounded"
                                placeholder="max">
                        </div>
                    </div>
                    <!-- price filter end -->
                </div>
            </div>
        </div>
        <!-- sidebar end -->

        <!-- products -->
        <div class="col-span-3">
            <!-- sorting -->
            <div class="mb-4 flex items-center">
                <!-- <div class="lg:hidden"> -->
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="bg-primary border border-primary text-white px-10 py-3 font-medium rounded uppercase hover:bg-transparent hover:text-primary transition text-sm mr-3 focus:outline-none"> {{__('Filter')}} </button>
            </div>
            <!-- sorting end -->
            <!-- product wrapper -->
            <div v-if="props.products.data.length">
                <div class="grid lg:grid-cols-2 xl:grid-cols-3 sm:grid-cols-2 gap-6 mt-12">
                    <!-- single product -->
                    <div class="group rounded bg-white shadow overflow-hidden" v-for="product in props.products.data" :key="product.id">
                        <!-- product image -->
                        <div class="relative">
                            <div v-for="img in product.mainimage" :key="img.id">
                                <img :src="'/storage/'+img.mainimage" class="w-full h-40">
                            </div>
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                <button @click="view(product.id)" class="text-white text-lg w-9 h-9 rounded-full bg-primary hover:bg-gray-800 transition flex items-center justify-center" > <i class="fas fa-search"></i> </button>
                                <button @click="addwishlist(product.id)" class="text-white text-lg w-9 h-9 rounded-full bg-primary hover:bg-gray-800 transition flex items-center justify-center" > <i class="far fa-heart"></i> </button>
                                <!-- <Link href="#"
                                    class="text-white text-lg w-9 h-9 rounded-full bg-primary hover:bg-gray-800 transition flex items-center justify-center">
                                    <i class="far fa-heart"></i>
                                </Link> -->
                            </div>
                        </div>
                        <!-- product image end -->
                        <!-- product content -->
                        <div class="pt-4 pb-3 px-4">
                            <button @click="view(product.id)">
                                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
                                    <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                        {{ product.title.en }}
                                    </div>
                                    <div v-if="$page.props.locale.locale == 'ar'">
                                        {{ product.title.ar }}
                                    </div>
                                    <div v-if="$page.props.locale.locale == 'en'">
                                        {{ product.title.en }}
                                    </div>
                                </h4>
                            </button>
                            <div class="flex items-baseline mb-1 space-x-2">
                                <template v-if="product.promotion.length">
                                    <p class="text-xl text-primary font-roboto font-semibold" v-for="prm in product.promotion" :key="prm.id"> {{__('$')}} {{prm.price}}</p>
                                    <p class="text-sm text-gray-400 font-roboto line-through"> {{__('$')}} {{ product.price }}</p>
                                </template >
                                <template v-else>
                                    <p class="text-xl text-primary font-roboto font-semibold"> {{__('$')}} {{ product.price }}</p>
                                </template>
                            </div>
                        </div>
                        <!-- product content end -->
                        <!-- product button -->
                        <button @click="addtocart(product.id)" class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition">
                            {{__('addtocart')}}
                        </button>
                        <!-- product button end -->
                    </div>
                    <!-- single product end -->
                </div>
                <br>
                    <div class="justify-center">
                        <Pagination :links="props.products.links" :prev="props.products.prev_page_url" :next="props.products.next_page_url"/>
                    </div>
            </div>
            <div class="grid lg:grid-cols-2 xl:grid-cols-3 sm:grid-cols-2 gap-6 mt-12" v-else>
                <div class="w-full">
                    <h5 class="mb-3 text-base font-semibold text-[#B45454]">
                        {{__('emptypage')}}
                    </h5>
                </div>
            </div>
            <!-- product wrapper end -->
        </div>
        <!-- products end -->
    </div>
    <!-- shop wrapper end -->
</template>
