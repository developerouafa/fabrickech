<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';

    const props = defineProps({
        carts: {
            type: Object,
            default: () => ({}),
        },
        cartTotalQuantity: {
            type: Object,
            default: () => ({}),
        },
        subTotal: {
            type: Object,
            default: () => ({}),
        },
        total: {
            type: Object,
            default: () => ({}),
        },
        count: {
            type: Object,
            default: () => ({}),
        },
        mainimage: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Object,
            default: () => ({}),
        }
    });

    // View
    const formview = useForm({
        id: props.carts.id
    });

    // View
    function view(id) {
        formview.get(route('view.product', id));
    }

    // deleteoneproduct
    const formdeleteoneproduct = useForm({
            id: props.carts.id
        });
    function deleteoneproduct(id){
        formdeleteoneproduct.get(route('deleteoneproduct', id),
                {
                    onSuccess: (page) => {
                        useSwallSuccess("Delete Success")
                    },
                    onerror: (errors) => {
                        useSwallErreur("Erreur")
                    }
                });
    }

    const ChangeQuantity = (event)=>{
        var quantity = document.getElementById("quantity").value;
        var price = parseFloat(document.getElementById("price").value);
        var tlt = price * quantity;
        document.getElementById("total").value = tlt;
    }

    const submit = (id, quantity) => {
        const formupdatequantity = useForm({
            id: id,
            quantity: quantity,
        });
        console.log('quantity : ', formupdatequantity.id);
        console.log('quantity : ', formupdatequantity.quantity);
        formupdatequantity.post(route("updatequantity"),
            {
                onSuccess: (page) => {
                    useSwallSuccess("Update Success")
                },
                onerror: (errors) => {
                    useSwallErreur("Erreur")
                }
            });
    };
</script>

<template>
    <Head title="Cart"/>

    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center">
        <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
            <i class="fas fa-home"></i>
        </Link>
        <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
        <p class="text-gray-600 font-medium uppercase">{{__('shoppingcart')}} hitest hitest</p>
    </div>
    <!-- breadcrum end -->

    <!-- cart wrapper -->
    <div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4">
        <!-- product cart -->
        <div class="xl:col-span-9 lg:col-span-8">
            <!-- cart title -->
            <div class="bg-gray-200 py-2 pl-12 pr-20 xl:pr-28 mb-4 md:flex">
                <p class="text-gray-600 text-center ml-auto mr-16 xl:mr-24">{{__('product')}} ({{count}}) </p>
                <p class="text-gray-600 text-center ml-auto mr-16 xl:mr-24">{{__('quantity')}} ({{cartTotalQuantity}}) </p>
                <p class="text-gray-600 text-center ml-auto mr-16 xl:mr-24">{{__('total')}} $({{ subTotal }})</p>
                <p class="text-primary text-center ml-auto mr-16 xl:mr-24">
                    <Link :href="route('clearall')" :active="route().current('clearall')">
                        {{__('clearcart')}}
                    </Link>
                </p>
            </div>
            <!-- cart title end -->

            <!-- shipping carts -->
            <div class="space-y-4">
                <!-- single cart -->
                    <div v-if="props.carts">
                        <div v-for="cart in props.carts" :key="cart.id"
                            class="flex items-center md:justify-between gap-4 md:gap-6 p-4 border border-gray-200 rounded flex-wrap md:flex-nowrap">
                                <!-- cart image -->
                                <div class="w-32 flex-shrink-0" @click="view(cart.associatedModel.id)" style="cursor: pointer;">
                                <div v-for="img in props.mainimage" :key="img.id">
                                        <div v-if="img.product_id == cart.associatedModel.id">
                                            <img :src="'storage/'+img.mainimage" class="w-full">
                                        </div>
                                </div>
                                </div>
                                <!-- cart image end -->
                                <!-- cart content -->
                                <div class="md:w-1/3 w-full" @click="view(cart.associatedModel.id)" style="cursor: pointer;">
                                    <h2 class="text-gray-800 mb-3 xl:text-xl textl-lg font-medium uppercase">
                                        <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                            {{ cart.associatedModel.title.en }}
                                        </div>
                                        <div v-if="$page.props.locale.locale == 'ar'">
                                            {{ cart.associatedModel.title.ar }}
                                        </div>
                                        <div v-if="$page.props.locale.locale == 'en'">
                                            {{ cart.associatedModel.title.en }}
                                        </div>
                                    </h2>
                                <div v-if="cart.attributes.promotion">
                                        <p class="text-xl text-primary font-roboto font-semibold border-none hover:border-none"> {{__('$')}} {{cart.attributes.promotion.price}}</p>
                                        <p class="text-sm text-gray-400 font-roboto line-through border-none hover:border-none"> {{__('$')}} {{ cart.associatedModel.price }}</p>
                                </div>
                                <div v-else>
                                        <p class="text-xl text-primary font-roboto font-semibold"> {{__('$')}} {{ cart.associatedModel.price }}</p>
                                </div>
                                </div>
                                <!-- cart content end -->
                                <!-- cart quantity -->
                                    <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 rounded-r-md">
                                        <input type="number" v-model="cart.quantity">
                                        <button type="submit" class="bg-sky-500 text-black"  @click="submit(cart.id, cart.quantity)" > {{__('update')}} </button>
                                    </div>
                                <!-- cart quantity end -->
                                <div class="ml-auto md:ml-0">
                                    <div v-if="cart.attributes.promotion">
                                        <p class="text-primary text-lg font-semibold border-none hover:border-none"> {{__('$')}} {{ cart.attributes.promotion.price * cart.quantity }}</p>
                                </div>
                                <div v-else>
                                        <p class="text-primary text-lg font-semibold border-none hover:border-none"> {{__('$')}} {{ cart.associatedModel.price * cart.quantity }}</p>
                                </div>
                                </div>
                                <div class="text-gray-600 hover:text-primary cursor-pointer">
                                    <button @click="deleteoneproduct(cart.id)"> <i class="fas fa-trash"></i> </button>
                                </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="w-full">
                            <h5 class="mb-3 text-base font-semibold text-[#B45454]">
                                {{__('emptypage')}}
                            </h5>
                        </div>
                    </div>
                <!-- single cart end -->
            </div>
            <!-- shipping carts end -->
        </div>
        <!-- product cart end -->
        <!-- order summary -->
        <div class="xl:col-span-3 lg:col-span-4 border border-gray-200 px-4 py-4 rounded mt-6 lg:mt-0">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">{{__('ordersummry')}}</h4>
            <div class="space-y-1 text-gray-600 pb-3 border-b border-gray-200">
                <div class="flex justify-between font-medium">
                    <p>{{__('Subtotal')}}</p>
                    <p> ${{ subTotal }}</p>
                </div>
                <div class="flex justify-between">
                    <p>{{__('Delivery')}}</p>
                    <p>{{__('Free')}}</p>
                </div>
                <div class="flex justify-between">
                    <p>{{__('Tax')}}</p>
                    <p>{{__('Free')}}</p>
                </div>
            </div>
            <div class="flex justify-between my-3 text-gray-800 font-semibold uppercase">
                <h4>{{__('total')}}</h4>
                <h4>${{ total }}</h4>
            </div>

            <!-- checkout -->
            <Link :href="route('checkout')" :active="route().current('checkout')" class="bg-primary border border-primary text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
             hover:text-primary transition text-sm w-full block text-center">
                {{__('Processtocheckout')}}
            </Link>
            <!-- checkout end -->
        </div>
        <!-- order summary end -->
    </div>
    <!-- cart wrapper end -->
</template>
