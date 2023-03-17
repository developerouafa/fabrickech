<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';

    const props = defineProps({
        categories: {
            type: Object,
            default: () => ({}),
        },
        products: {
            type: Object,
            default: () => ({}),
        }
    });

    // View Product By category
        const submit = (idbycategory) => {
	            const formshopbycategory = useForm({
	                idbycategory: idbycategory,
	            });
	            formshopbycategory.get(route("shopbycategory"));
        };

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

    // Subcribe
    const formsubscribe = useForm({
        email: ''
    });

    const submitSubscribe = () => {
        formsubscribe.post(route("subscribe"),{
            onSuccess: (response) => {
                formsubscribe.reset()
                useSwallSuccess("Subscribe Success")
            },
            onerror: (error) => {
                useSwallErreur("Erreur")
            }
        });
    };
</script>

<template>
    <Head title="Home" />

    <!-- banner -->
    <div class="bg-cover bg-no-repeat bg-center py-36 relative" style="background-image: url('/images/banner-bg.jpg')" v-if="$page.props.locale.locale != 'en' || $page.props.locale.locale == 'en' || $page.props.locale.locale == 'ar'" dir="ltr">
        <div class="container">
            <!-- banner content -->
            <h1 class="xl:text-6xl md:text-5xl text-4xl text-gray-800 font-medium mb-4">
                {{__('bestcollectionfor')}} <br class="hidden sm:block"> {{__('couturesofa')}}
            </h1>
            <!-- banner button -->
            <div class="mt-12">
                <Link :href="route('shop')" :active="route().current('shop')" class="bg-primary border border-primary text-white px-8 py-3 font-medium rounded-md uppercase hover:bg-transparent
               hover:text-primary transition">
                    {{__('shopnow')}}
                </Link>
            </div>
            <!-- banner button end -->
            <!-- banner content end -->
        </div>
    </div>
    <!-- banner end -->

    <!-- categories -->
    <div class="container py-16">
        <h2 class="text-2xl md:text-3xl font-medium text-gray-800 uppercase mb-6">{{__('SHOPBYCATEGORY')}}</h2>
        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-3">
            <!-- single category -->
            <div v-for="category in props.categories" :key="category.id">
                <div class="relative group rounded-sm overflow-hidden" @click="submit(category.id)">
                    <img :src="'/storage/'+category.image" class="w-full h-64">
                    <a href="#" class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 flex items-center justify-center text-xl text-white
                        font-roboto font-medium tracking-wide transition">
                        <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                            {{ category.title.en }}
                        </div>
                        <div v-if="$page.props.locale.locale == 'ar'">
                            {{ category.title.ar }}
                        </div>
                        <div v-if="$page.props.locale.locale == 'en'">
                            {{ category.title.en }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- categories end -->

    <!-- top new arrival -->
    <div class="container pb-16">
        <h2 class="text-2xl md:text-3xl font-medium text-gray-800 uppercase mb-6">{{__('topnewarrial')}}</h2>
        <!-- product wrapper -->
        <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-6">
            <!-- single product -->
                <div class="group rounded bg-white shadow overflow-hidden" v-for="product in props.products" :key="product.id">
                    <!-- product image -->
                    <div class="relative">
                        <div v-for="img in product.mainimage" :key="img.id">
                            <img :src="'/storage/'+img.mainimage" class="w-full h-40">
                        </div>
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <button @click="view(product.id)" class="text-white text-lg w-9 h-9 rounded-full bg-primary hover:bg-gray-800 transition flex items-center justify-center" > <i class="fas fa-search"></i> </button>
                            <button @click="addwishlist(product.id)" class="text-white text-lg w-9 h-9 rounded-full bg-primary hover:bg-gray-800 transition flex items-center justify-center" > <i class="far fa-heart"></i> </button>
                        </div>
                    </div>
                    <!-- product image end -->
                    <!-- product content -->
                    <div class="pt-4 pb-3 px-4">
                        <button @click="view(product.id)">
                            <h4 class="font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
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
                        {{ __('addtocart') }}
                    </button>
                    <!-- product button end -->
                </div>
            <!-- single product end -->
        </div>
        <!-- product wrapper end -->
    </div>
    <!-- top new arrival end -->

    <!-- ad section -->
    <div class="container pb-4" v-if="$page.props.locale.locale == 'ar'" dir="ltr">
        <div class="rounded-lg shadow-lg my-20 flex flex-row">
            <div class="lg:w-3/5 w-full bg-gradient-to-r from-black to-orange-200 lg:from-black lg:via-orange-200 lg:to-transparent rounded-lg text-gray-100 p-12">
                <div class="lg:w-1/2">
                    <h3 class="text-2xl font-extrabold mb-4">{{__('subscribeto')}}</h3>
                    <p class="mb-4 leading-relaxed">{{__('desctosubsc')}}</p>
                    <form @submit.prevent="submitSubscribe" autocomplete="off">
                        <div>
                            <input type="email" v-model="formsubscribe.email" placeholder="Enter email address" class="bg-gray-600 text-gray-200 placeholder-gray-400 px-4 py-3 w-full rounded-lg focus:outline-none mb-4" />
                            <div v-if="formsubscribe.errors.email" style="color: red" > {{ formsubscribe.errors.email }} </div>
                            <button type="submit" class="bg-red-600 py-3 rounded-lg w-full">{{__('subscribe')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="lg:w-2/5 w-full lg:flex lg:flex-row hidden">
                <img src="/assets/img/brand/favicon.png" class="h-96" />
            </div>
        </div>
    </div>
    <!-- ad section end -->
</template>
