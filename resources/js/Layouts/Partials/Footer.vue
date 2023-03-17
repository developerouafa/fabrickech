<template>
    <footer class="bg-white pt-4 pb-12 border-t border-gray-100">
                <div class="container flex items-center justify-between">
                    <div class="space-y-8 xl:col-span-1">
                        <!-- logo -->
                            <Link :href="route('welcome')" :active="route().current('welcome')" class="w-18">
                                <img class="w-14" src="/assets/img/brand/favicon.png" alt="Company name">
                            </Link>
                        <!-- logo end -->
                    </div>
                    <div>
                        <p class="text-gray-500">{{__('footer')}}</p>
                    </div>
                </div>
    </footer>
</template>

<script>
export default {

}
</script>
