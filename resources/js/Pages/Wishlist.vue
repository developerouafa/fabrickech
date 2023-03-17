<script setup>
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';
import Pagination from './Pagination.vue';

const props = defineProps({
        wishlists: {
            type: Object,
            default: () => ({}),
        },
        mainimage: {
            type: Object,
            default: () => ({}),
        },
        products: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Object,
            default: () => ({}),
        }
    });

    // deleteonewishlist
    const formdeleteonewishlist = useForm({
        id: props.wishlists.id
    });
    function deleteonewishlist(id){
        formdeleteonewishlist.get(route('deleteonewishlist', id),
                {
                    onSuccess: (page) => {
                        useSwallSuccess("Delete Success")
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

    // View
        const formview = useForm({
            id: props.products.id
        });
        function view(id) {
            formview.get(route('view.product', id));
        }
</script>

<template>
    <Head title="Wish List" />

    <ProfileLayout>
        <!-- account content -->
        <div v-if="props.wishlists.data">
            <div class="col-span-9 mt-6 lg:mt-0 space-y-4">
                <!-- single wishlist -->
                <div v-for="wishlist in props.wishlists.data" :key="wishlist.id"
                    class="flex items-center md:justify-between gap-4 md:gap-6 p-4 border border-gray-200 rounded flex-wrap md:flex-nowrap">
                    <!-- cart image -->
                    <div class="w-28 flex-shrink-0" @click="view(wishlist.product_id)" style="cursor: pointer;">
                        <div v-for="img in props.mainimage" :key="img.id">
                            <div v-if="img.product_id == wishlist.product_id">
                                <img :src="'/storage/'+img.mainimage" class="w-full">
                            </div>
                        </div>
                    </div>
                    <!-- cart image end -->
                    <!-- cart content -->
                    <div class="md:w-1/3 w-full" @click="view(wishlist.product_id)" style="cursor: pointer;">
                        <h2 class="text-gray-800 mb-1 xl:text-xl textl-lg font-medium uppercase">
                            <div v-for="product in props.products" :key="product.id">
                                <div v-if="product.id == wishlist.product_id">
                                    <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                        {{ product.title.en }}
                                    </div>
                                    <div v-if="$page.props.locale.locale == 'ar'">
                                        {{ product.title.ar }}
                                    </div>
                                    <div v-if="$page.props.locale.locale == 'en'">
                                        {{ product.title.en }}
                                    </div>
                                </div>
                            </div>
                        </h2>
                        <div v-for="product in props.products" :key="product.id">
                            <div v-if="product.id == wishlist.product_id">
                                <div class="flex text-gray-500 text-sm" v-for="stc in product.stockproduct" :key="stc.id">
                                    {{__('Availability')}}:
                                    <div v-if="stc.stock == '0'">
                                        <span class="text-green-600">{{__('instock')}}</span>
                                    </div>
                                    <div v-if="stc.stock == '1'">
                                        <span class="text-red-600">{{__('outofstock')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- cart content end -->
                    <div class="text-primary text-lg font-semibold" @click="view(wishlist.product_id)" style="cursor: pointer;">
                        <div v-for="product in props.products" :key="product.id">
                            <div v-if="product.id == wishlist.product_id">
                                <template v-if="product.promotion.length">
                                    <p class="text-xl text-primary font-roboto font-semibold" v-for="prm in product.promotion" :key="prm.id"> {{__('$')}} {{prm.price}}</p>
                                    <p class="text-sm text-gray-400 font-roboto line-through"> {{__('$')}} {{ product.price }}</p>
                                </template >
                                <template v-else>
                                    <p class="text-xl text-primary font-roboto font-semibold"> {{__('$')}} {{ product.price }}</p>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div v-for="product in props.products" :key="product.id">
                        <div v-if="product.id == wishlist.product_id">
                            <div v-for="product in props.products" :key="product.id">
                                <div v-if="product.id == wishlist.product_id">
                                    <div v-for="stc in product.stockproduct" :key="stc.id">
                                        <div v-if="stc.stock == '0'">
                                            <button @click="addtocart(product.id)" class="ml-auto md:ml-0 block px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">
                                                {{(__('addtocart'))}}
                                            </button>
                                        </div>
                                        <div v-if="stc.stock == '1'">
                                            <button class="ml-auto md:ml-0 block px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded
                                                uppercase font-roboto font-medium cursor-not-allowed bg-opacity-80">
                                                {{(__('addtocart'))}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button @click="deleteonewishlist(wishlist.id)" class="text-gray-600 hover:text-primary cursor-pointer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <!-- single wishlist end -->
            </div>
            <br>
                <Pagination :links="props.wishlists.links" :prev="props.wishlists.prev_page_url" :next="props.wishlists.next_page_url"/>
        </div>
        <div class="col-span-9 mt-6 lg:mt-0 space-y-4" v-else>
            <div class="w-full">
                <h5 class="mb-3 text-base font-semibold text-[#B45454]">
                    {{__('emptypage')}}
                </h5>
            </div>
        </div>
        <!-- account content end -->
    </ProfileLayout>

</template>
