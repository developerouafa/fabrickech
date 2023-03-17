<template>
    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center">
        <Link :href="route('welcome')" :active="route().current('welcome')" class="text-primary text-base">
            <i class="fas fa-home"></i>
        </Link>
        <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
        <p class="text-gray-600 font-medium uppercase">{{__('myaccount')}}</p>
    </div>
    <!-- breadcrum end -->

    <!-- account wrapper -->
    <div class="container lg:grid grid-cols-12 items-start gap-6 pt-4 pb-16">
        <!-- sidebar -->
        <div class="col-span-3">
            <!-- profile links -->
            <div class="mt-6 bg-white shadow rounded p-4 divide-y divide-gray-200 space-y-4 text-gray-600">
                <!-- single link -->
                <div class="space-y-1 pl-8">
                    <Link :href="route('profile.manageaccount')" :active="route().current('profile.manageaccount')" class="relative text-base font-medium capitalize hover:text-primary transition block">
                        {{__('manageaccount')}}
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="far fa-address-card"></i>
                        </span>
                    </Link>
                    <Link :href="route('profile.changepassword')" :active="route().current('profile.changepassword')" class="hover:text-primary transition capitalize block">
                        {{__('changepassword')}}
                    </Link>
                </div>
                <!-- single link end -->
                <!-- single link -->
                <div class="pl-8 pt-4">
                    <Link :href="route('wishlist')" :active="route().current('wishlist')"
                        class="relative medium capitalize text-gray-800 font-medium hover:text-primary transition block">
                        {{__('wishlist')}}
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="far fa-heart"></i>
                        </span>
                    </Link>
                </div>
                <!-- single link end -->
                <!-- single link -->
                <div class="pl-8 pt-4">
                    <Link :href="route('logout')" as="button" class="relative medium capitalize text-gray-800 font-medium hover:text-primary transition block">
                        {{__('Logout')}}
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                    </Link>
                </div>
                <!-- single link end -->
            </div>
            <!-- profile links end -->
        </div>
        <!-- sidebar end -->

        <!-- account content -->
        <div class="col-span-9 shadow rounded px-6 pt-5 pb-7 mt-6 lg:mt-0">
            <slot/>
        </div>
        <!-- account content end -->
    </div>
    <!-- account wrapper end -->
</template>

<script setup>

</script>
