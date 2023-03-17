<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';
    import { useSwallSuccess, useSwallErreur } from '../Composables/alert.js';

    const props = defineProps({
            carts: {
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
            },
            cartTotalQuantity: String,
            subTotal: String,
            total: String,
        });

        const form = useForm({
            fullname: '',
            region: '',
            streetaddress: '',
            town: '',
            city: '',
            zipcode: '',
            phone: '',
            carts: props.products,
            cartTotalQuantity: props.cartTotalQuantity,
            subTotal: props.subTotal,
            total: props.total,
        });

        const submit = () => {
            form.post(route("addorder"),
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

    <Head title="Checkout"/>

    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center">
        <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
            <i class="fas fa-home"></i>
        </Link>
        <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
        <p class="text-gray-600 font-medium uppercase">{{__('Checkout')}}</p>
    </div>
    <!-- breadcrum end -->

    <!-- checkout wrapper -->
    <div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4">
        <!-- checkout form -->
        <div class="lg:col-span-8 border border-gray-200 px-4 py-4 rounded">
            <form @submit.prevent="submit" autocomplete="off">
                <h3 class="text-lg font-medium capitalize mb-4">
                    {{__('Checkout')}}
                </h3>
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                               {{ __('Full Name') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.fullname" class="input-box" placeholder="Full Name" />
                            <div v-if="form.errors.fullname" style="color: red" > {{ form.errors.fullname }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Region') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.region" class="input-box" placeholder="Region" />
                            <div v-if="form.errors.region" style="color: red" > {{ form.errors.region }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Street Address') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.streetaddress" class="input-box" placeholder="Street Address" />
                            <div v-if="form.errors.streetaddress" style="color: red" > {{ form.errors.streetaddress }} </div>
                        </div>                        
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Town') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.town" class="input-box" placeholder="Town" />
                            <div v-if="form.errors.town" style="color: red" > {{ form.errors.town }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('City') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.city" class="input-box" placeholder="City" />
                            <div v-if="form.errors.city" style="color: red" > {{ form.errors.city }} </div>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                {{ __('Zip Code') }} <span class="text-primary">*</span>
                            </label>
                            <input type="text" v-model="form.zipcode" class="input-box" placeholder="Zip Code" />
                            <div v-if="form.errors.zipcode" style="color: red" > {{ form.errors.zipcode }} </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('Phone Number') }} <span class="text-primary">*</span>
                        </label>
                        <input type="text" v-model="form.phone" class="input-box" placeholder="Phone" />
                        <div v-if="form.errors.phone" style="color: red" > {{ form.errors.phone }} </div>
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
            <div class="flex justify-between border-b border-gray-200 mt-1">
                <h4 class="text-gray-800 font-medium my-3 uppercase">{{__('Subtotal')}}</h4>
                <h4 class="text-gray-800 font-medium my-3 uppercase"> {{__('$')}} {{ subTotal }}</h4>
            </div>
            <div class="flex justify-between border-b border-gray-200">
                <h4 class="text-gray-800 font-medium my-3 uppercase">{{__('Shipping')}}</h4>
                <h4 class="text-gray-800 font-medium my-3 uppercase">{{__('free')}}</h4>
            </div>
            <div class="flex justify-between">
                <h4 class="text-gray-800 font-semibold my-3 uppercase">{{__('total')}}</h4>
                <h4 class="text-gray-800 font-semibold my-3 uppercase"> {{__('$')}} {{ total }}</h4>
            </div>
        </div>
        <!-- order summary end -->
    </div>
    <!-- checkout wrapper end -->
</template>
