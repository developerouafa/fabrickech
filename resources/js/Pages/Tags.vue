<script setup>
import Pagination from './Pagination.vue';

const props = defineProps({
        post_tags: {
            type: Object,
            default: () => ({}),
        },
        categories: {
            type: Object,
            default: () => ({}),
        },
    });
</script>

<template>
    <Head title="About Us"/>

    <!-- breadcrum -->
    <div class="container py-4 flex justify-between">
        <div class="flex gap-3 items-center">
            <Link :href="route('posts')" :active="route().current('posts')" class="text-primary text-base">
                {{__('Back')}}
            </Link>
            <span class="text-sm text-gray-400"><i class="fas fa-chevron-right"></i></span>
            <p class="text-gray-600 font-medium"> About Us</p>
        </div>
    </div>
    <!-- breadcrum end -->

    <div v-if="props.post_tags.data.length">
        <!-- ====== Services Section Start -->
        <div v-for="posttag in props.post_tags.data" :key="posttag.id">
            <section class="overflow-hidden pt-4 pb-12 lg:pt-[120px] lg:pb-[90px]">
            <div class="container mx-auto">
                <div class="-mx-4 flex flex-wrap items-center justify-between">
                <div class="w-full px-4 lg:w-6/12">
                    <div class="-mx-3 items-center sm:-mx-4">
                    <div class="w-full px-3 sm:px-4 xl:w-full">
                        <div class="relative z-10 my-4">
                        <img
                            :src="'/storage/'+posttag.post.image"
                            alt=""
                            class="w-full rounded-2xl"
                        />
                        <span class="absolute -right-7 -bottom-7 z-[-1]">
                            <svg
                            width="134"
                            height="106"
                            viewBox="0 0 134 106"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <circle
                                cx="1.66667"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 1.66667 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 16.3333 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 31 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 45.6667 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3334"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 60.3334 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 88.6667 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 117.667 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 74.6667 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 103 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="104"
                                r="1.66667"
                                transform="rotate(-90 132 104)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="89.3333"
                                r="1.66667"
                                transform="rotate(-90 1.66667 89.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="89.3333"
                                r="1.66667"
                                transform="rotate(-90 16.3333 89.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="89.3333"
                                r="1.66667"
                                transform="rotate(-90 31 89.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="89.3333"
                                r="1.66667"
                                transform="rotate(-90 45.6667 89.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 60.3333 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 88.6667 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 117.667 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 74.6667 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 103 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="89.3338"
                                r="1.66667"
                                transform="rotate(-90 132 89.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="74.6673"
                                r="1.66667"
                                transform="rotate(-90 1.66667 74.6673)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="31.0003"
                                r="1.66667"
                                transform="rotate(-90 1.66667 31.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 16.3333 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="31.0003"
                                r="1.66667"
                                transform="rotate(-90 16.3333 31.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 31 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="31.0003"
                                r="1.66667"
                                transform="rotate(-90 31 31.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 45.6667 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="31.0003"
                                r="1.66667"
                                transform="rotate(-90 45.6667 31.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 60.3333 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 60.3333 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 88.6667 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 88.6667 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 117.667 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 117.667 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 74.6667 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 74.6667 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 103 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 103 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="74.6668"
                                r="1.66667"
                                transform="rotate(-90 132 74.6668)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="30.9998"
                                r="1.66667"
                                transform="rotate(-90 132 30.9998)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 1.66667 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 1.66667 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 16.3333 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 16.3333 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 31 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 31 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 45.6667 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 45.6667 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 60.3333 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 60.3333 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 88.6667 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 88.6667 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 117.667 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 117.667 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 74.6667 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 74.6667 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 103 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 103 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="60.0003"
                                r="1.66667"
                                transform="rotate(-90 132 60.0003)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="16.3333"
                                r="1.66667"
                                transform="rotate(-90 132 16.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="45.3333"
                                r="1.66667"
                                transform="rotate(-90 1.66667 45.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="1.66667"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 1.66667 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="45.3333"
                                r="1.66667"
                                transform="rotate(-90 16.3333 45.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="16.3333"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 16.3333 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="45.3333"
                                r="1.66667"
                                transform="rotate(-90 31 45.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="31"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 31 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="45.3333"
                                r="1.66667"
                                transform="rotate(-90 45.6667 45.3333)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="45.6667"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 45.6667 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 60.3333 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="60.3333"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 60.3333 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 88.6667 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="88.6667"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 88.6667 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 117.667 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="117.667"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 117.667 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 74.6667 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="74.6667"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 74.6667 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 103 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="103"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 103 1.66683)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="45.3338"
                                r="1.66667"
                                transform="rotate(-90 132 45.3338)"
                                fill="#FD5067"
                            />
                            <circle
                                cx="132"
                                cy="1.66683"
                                r="1.66667"
                                transform="rotate(-90 132 1.66683)"
                                fill="#FD5067"
                            />
                            </svg>
                        </span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="w-full px-4 lg:w-1/2 xl:w-5/12">
                    <div class="mt-10 lg:mt-0">
                        <h2 class="mb-8 text-3xl font-bold text-dark sm:text-4xl">
                            <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                {{ posttag.post.title.en }}
                            </div>
                            <div v-if="$page.props.locale.locale == 'ar'">
                                {{ posttag.post.title.ar }}
                            </div>
                            <div v-if="$page.props.locale.locale == 'en'">
                                {{ posttag.post.title.en }}
                            </div>
                        </h2>
                        <div class="mb-8 text-base text-body-color">
                            <div v-if="$page.props.locale.locale != 'ar' && $page.props.locale.locale != 'en' ">
                                {{ posttag.post.body.en }}
                            </div>
                            <div v-if="$page.props.locale.locale == 'ar'">
                                {{ posttag.post.body.ar }}
                            </div>
                            <div v-if="$page.props.locale.locale == 'en'">
                                {{ posttag.post.body.en }}
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </section>
        </div>
        <!-- ====== Services Section End -->
            <div class="pl-40 pr-40 pt-4 pb-4">
                <Pagination :links="props.post_tags.links" :prev="props.post_tags.prev_page_url" :next="props.post_tags.next_page_url"/>
            </div>
    </div>
    <div v-else class="overflow-hidden pt-4 pb-12 mx-36 lg:pt-[120px] lg:pb-[90px]">
        <div class="w-full">
            <h5 class="mb-3 text-base font-semibold text-[#B45454]">
                {{__('emptypage')}}
            </h5>
        </div>
    </div>
</template>
