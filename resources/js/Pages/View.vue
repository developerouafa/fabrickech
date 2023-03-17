<script>
    let mainImg = document.getElementById('main-img')
    let imgBars = document.getElementsByClassName('single-img')

    for(let imgBar of imgBars){
        imgBar.addEventListener('click', function(){
            clearActive()
            let imgPath = this.getAttribute('src')
            mainImg.setAttribute('src', imgPath)
            this.classList.add('border-primary')
        })
    }

    function clearActive(){
        for(let imgBar of imgBars){
            imgBar.classList.remove('border-primary')
        }
    }
</script>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';

const quantity = ref(1);

const props = defineProps({
        productview: {
            type: Object,
            default: () => ({}),
        },
        maincolor: {
            type: Object,
            default: () => ({}),
        },
        color: {
            type: Object,
            default: () => ({}),
        },
        promotion: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Object,
            default: () => ({}),
        },
    });

    const form = useForm({
        quantity: quantity.value,
        product_id: props.productview.id,
        promotion: props.promotion
    });

    const submit = () => {
        form.post(route("addcartandquantity"),{
            onSuccess: (response) => {
                useSwallSuccess("Success")
            },
            onerror: (error) => {
                useSwallErreur("Erreur")
            }
        });
    };

    // Wishlist
        const formWishlist = useForm({
            id: props.productview.id
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

        const formorder = useForm({
            fullname: '',
            country: '',
            region: '',
            streetaddress: '',
            town: '',
            city: '',
            zipcode: '',
            phone: '',
            quantity: quantity.value,
            products: props.productview,
            price: props.productview.price
        });

        const submitt = () => {
            formorder.post(route("addoneorder"),
                {
                    onSuccess: (page) => {
                        useSwallSuccess("Order Add Success")
                    },
                    onerror: (errors) => {
                        useSwallErreur("Erreur")
                    }
                });
        };
</script>

<template>
    <Head title="View" />

    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center">
        <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
            <i class="fas fa-home"></i>
        </Link>
        <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
        <Link :href="route('shop')" :active="route().current('shop')" class="text-primary text-base">
            {{__('shop')}}
        </Link>
        <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
        <div class="text-gray-600 font-medium uppercase">
            <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                {{ productview.title.en }}
            </div>
            <div v-if="$page.props.locale.locale == 'ar'">
                {{ productview.title.ar }}
            </div>
            <div v-if="$page.props.locale.locale == 'en'">
                {{ productview.title.en }}
            </div>
        </div>
    </div>
    <!-- breadcrum end -->

    <div class="container">
        <a href="#checkout" class="text-primary text-base">
            {{__('gettheproduct')}}
        </a>
    </div>

    <!-- product view -->
    <div class="container pt-4 pb-6 grid lg:grid-cols-2 gap-6">
        <!-- product image -->
        <div>
            <div v-for="img in productview.mainimage" :key="img.id" >
                <img id="main-img" :src="'/storage/'+img.mainimage">
            </div>

            <div class="grid grid-cols-5 gap-4 mt-4">
                <div v-for="img in productview.mainimage" :key="img.id" >
                    <img :src="'/storage/'+img.mainimage" class="single-img w-full cursor-pointer border">
                </div>
                <div v-for="img in productview.image" :key="img.id" >
                    <img :src="'/storage/'+img.multimg" class="single-img w-full cursor-pointer border">
                </div>
            </div>
        </div>
        <!-- product image end -->
        <!-- product content -->
        <div>
            <h2 class="md:text-3xl text-2xl font-medium uppercase mb-2">
                <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                    {{ productview.title.en }}
                </div>
                <div v-if="$page.props.locale.locale == 'ar'">
                    {{ productview.title.ar }}
                </div>
                <div v-if="$page.props.locale.locale == 'en'">
                    {{ productview.title.en }}
                </div>
            </h2>
            <div class="space-y-2">
                <div class="flex text-gray-500 text-sm" v-for="stc in props.productview.stockproduct" :key="stc.id">
                    <div v-if="stc.stock == '0'">
                        <p class="text-gray-800 font-semibold space-x-2">
                            <span>{{__('Availability')}} : </span>
                            <span class="text-green-600"> {{__('instock')}}</span>
                        </p>
                    </div>
                    <div v-if="stc.stock == '1'">
                        <span>{{__('Availability')}} : </span>
                        <span class="text-red-600"> {{__('outofstock')}}</span>
                    </div>
                </div>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">{{__('Category')}}: </span>
                        <span class="text-gray-600" v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                            {{ props.productview.category.title.en }}
                        </span>
                        <span class="text-gray-600" v-if="$page.props.locale.locale == 'ar'">
                            {{ props.productview.category.title.ar }}
                        </span>
                        <span class="text-gray-600" v-if="$page.props.locale.locale == 'en'">
                            {{ props.productview.category.title.en }}
                        </span>
                </p>
                <p class="space-x-3 mx-28">
                        <span class="text-gray-800 font-semibold" v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                            - {{ props.productview.subcategories.title.en }}
                        </span>
                        <span class="text-gray-800 font-semibold" v-if="$page.props.locale.locale == 'ar'">
                            - {{ props.productview.subcategories.title.ar }}
                        </span>
                        <span class="text-gray-800 font-semibold" v-if="$page.props.locale.locale == 'en'">
                            - {{ props.productview.subcategories.title.en }}
                        </span>
                </p>
            </div>
            <div class="mt-4 flex items-baseline gap-3">
                <div v-if="props.productview.promotion.length">
                    <span class="text-primary font-semibold text-xl" v-for="prm in props.productview.promotion" :key="prm.id"> {{__('$')}} {{prm.price}}</span>
                    <span class="text-gray-500 text-base line-through"> {{__('$')}} {{ props.productview.price }}</span>
                </div >
                <div v-else>
                    <p class="text-xl text-primary font-roboto font-semibold"> {{__('$')}} {{ props.productview.price }}</p>
                </div>
            </div>
            <div class="mt-4 text-gray-600">
                <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                    {{ props.productview.description.en }}
                </div>
                <div v-if="$page.props.locale.locale == 'ar'">
                    {{ props.productview.description.ar }}
                </div>
                <div v-if="$page.props.locale.locale == 'en'">
                    {{ props.productview.description.en }}
                </div>
            </div>
            <!-- size -->
            <div class="mt-4">
                <h3 class="text-base text-gray-800 mb-1">{{__('size')}}</h3>
                <div class="flex items-center gap-2">
                    <!-- single size -->
                    <div class="size-selector">
                        <p class="text-gray-800 font-semibold space-x-2">
                            <span>{{__('height')}}: </span>
                            <span class="text-green-600" v-for="prm in props.productview.size" :key="prm.id">{{ prm.height }}</span>
                            <span>{{__('width')}}: </span>
                            <span class="text-green-600" v-for="prm in props.productview.size" :key="prm.id">{{ prm.width }}</span>
                        </p>
                    </div>
                    <!-- single size end -->
                </div>
            </div>
            <!-- size end -->
            <!-- color -->
            <div class="mt-4">
                <h3 class="text-base text-gray-800 mb-1">{{__('color')}}</h3>
                <div class="flex items-center gap-2">
                    <!-- single color -->
                    <div class="color-selector">
                        <input v-for="clrmain in props.maincolor" :key="clrmain.id" type="color" :value="clrmain.product_color.color" disabled/>
                        <input v-for="clr in props.color" :key="clr.id" type="color" :value="clr.product_color.color" disabled/>
                    </div>
                </div>
            </div>
            <!-- color end -->
            <form @submit.prevent="submit" autocomplete="off">
                <!-- quantity -->
                <div class="mt-4">
                    <h3 class="text-base text-gray-800 mb-1">{{__('quantity')}}</h3>
                    <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                        <input type="number" name="quantity" v-model="form.quantity" min="1">
                        <input type="hidden" name="product_id" v-model="form.product_id">
                        <input type="hidden" v-model="form.promotion" name="promotion">
                    </div>
                </div>
                <!-- quantity end -->
                <!-- add to cart button -->
                <div class="flex gap-3 border-b border-gray-200 pb-5 mt-6">
                    <button type="submit" class="bg-primary border border-primary text-white px-8 py-2 font-medium rounded uppercase
                        hover:bg-transparent hover:text-primary transition text-sm flex items-center">
                        <span class="mr-2 ml-2"><i class="fas fa-shopping-bag"></i></span> {{__('addtocart')}}</button>
                    <a @click="addwishlist(props.productview.id)" href="#" class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase
                        hover:bg-transparent hover:text-primary transition text-sm">
                        <span class="mr-2 ml-2"><i class="far fa-heart"></i></span> {{__('wishlist')}}
                    </a>
                </div>
                <!-- add to cart button end -->
            </form>
        </div>
        <!-- product content end -->
    </div>
    <!-- product view end -->

    <!-- product details and review -->
    <div class="container pb-16">
        <!-- detail buttons -->
        <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium">
            {{__('ProductDetails')}}
        </h3>
        <!-- details button end -->

        <!-- details content -->
        <div class="lg:w-4/5 xl:w-3/5 pt-6">
            <div class="space-y-3 text-gray-600">
                    <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                        {{ props.productview.description.en }}
                    </div>
                    <div v-if="$page.props.locale.locale == 'ar'">
                        {{ props.productview.description.ar }}
                    </div>
                    <div v-if="$page.props.locale.locale == 'en'">
                        {{ props.productview.description.en }}
                    </div>
            </div>
            <!-- details table -->
            <table class="table-auto border-collapse w-full text-left text-gray-600 text-sm mt-6">
                <tr>
                    <th class="py-2 px-4 border border-gray-300 w-40 font-medium">{{__('color')}}</th>
                    <td class="py-2 px-4 border border-gray-300">
                        <input v-for="clrmain in props.maincolor" :key="clrmain.id" type="color" :value="clrmain.product_color.color" disabled/>
                        <input v-for="clr in props.color" :key="clr.id" type="color" :value="clr.product_color.color" disabled/>
                    </td>
                </tr>
                <tr>
                    <th class="py-2 px-4 border border-gray-300 w-40 font-medium">{{__('height')}}</th>
                    <td class="py-2 px-4 border border-gray-300" v-for="prm in props.productview.size" :key="prm.id">{{prm.height}}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 border border-gray-300 w-40 font-medium">{{__('width')}}</th>
                    <td class="py-2 px-4 border border-gray-300" v-for="prm in props.productview.size" :key="prm.id">{{prm.width}}</td>
                </tr>
            </table>
            <!-- details table -->
        </div>
        <!-- details content end -->
    </div>
    <!-- product details and review end -->

    <!-- checkout wrapper -->
    <div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4" id="checkout">
        <!-- checkout form -->
        <div class="lg:col-span-8 border border-gray-200 px-4 py-4 rounded">
            <form @submit.prevent="submitt" autocomplete="off">
                <h3 class="text-lg font-medium capitalize mb-4">
                    {{__('Checkout')}}
                </h3>
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                               {{ __('Full Name') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.fullname" class="input-box" placeholder="Full Name" />
                            <div v-if="formorder.errors.fullname" style="color: red" > {{ formorder.errors.fullname }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Region') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.region" class="input-box" placeholder="Region" />
                            <div v-if="formorder.errors.region" style="color: red" > {{ formorder.errors.region }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Street Address') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.streetaddress" class="input-box" placeholder="Street Address" />
                            <div v-if="formorder.errors.streetaddress" style="color: red" > {{ formorder.errors.streetaddress }} </div>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Town') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.town" class="input-box" placeholder="Town" />
                            <div v-if="formorder.errors.town" style="color: red" > {{ formorder.errors.town }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('City') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.city" class="input-box" placeholder="City" />
                            <div v-if="formorder.errors.city" style="color: red" > {{ formorder.errors.city }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Zip Code') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.zipcode" class="input-box" placeholder="Zip Code" />
                            <div v-if="formorder.errors.zipcode" style="color: red" > {{ formorder.errors.zipcode }} </div>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Phone Number') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="formorder.phone" class="input-box" placeholder="Phone" />
                            <div v-if="formorder.errors.phone" style="color: red" > {{ formorder.errors.phone }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('quantity') }} <span class="text-primary">*</span>
                            </label>
                            <input type="number" name="quantity" class="input-box" v-model="formorder.quantity" min="1">
                            <input type="hidden" name="product_id" v-model="formorder.product_id">
                        </div>
                    </div>
                </div>


                <!-- checkout -->
                    <button type="submit" class="mt-6 bg-primary border border-primary text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
                hover:text-primary transition text-sm w-full block text-center"> {{ __('Place order') }} </button>
                <!-- checkout end -->
            </form>
        </div>
        <!-- checkout form end -->

        <!-- order summary -->
        <div class="lg:col-span-4 border border-gray-200 px-4 py-4 rounded mt-6 lg:mt-0">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">{{__('ordersummry')}}</h4>
            <div class="flex justify-between border-b border-gray-200">
                <h4 class="text-gray-800 font-medium my-3 uppercase">{{__('Shipping')}}</h4>
                <h4 class="text-gray-800 font-medium my-3 uppercase">{{__('free')}}</h4>
            </div>
            <div class="flex justify-between">
                <h4 class="text-gray-800 font-semibold my-3 uppercase">{{__('total')}}</h4>
                <h4 class="text-gray-800 font-semibold my-3 uppercase"> {{__('$')}} {{ props.productview.price *  formorder.quantity}}</h4>
            </div>
        </div>
        <!-- order summary end -->
    </div>
    <!-- checkout wrapper end -->
</template>
