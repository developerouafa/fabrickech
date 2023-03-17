<template>
    <div class="ml-4 text-white lg:text-gray-700 mr-4">
        <!-- <inertia-link :href="route('language', [selectable_locale])">
            <Icon class="w-5 h-5" :name="selectable_locale" />
        </inertia-link> -->
        <Link :href="route('language', 'ar')">{{__('ar')}}</Link>
            <br>
        <Link :href="route('language', 'en')">{{__('en')}}</Link>
    </div>
</template>

<script>
import Icon from './Icon.vue'
export default {
    name: "LanguageSelector",
    components: {
        Icon,
    },

    computed: {
        selectable_locale() {
            if(this.$page.locale == 'ar') {
                return 'en';
            }
            return 'ar'
        }
    },
}
</script>

<style scoped>

</style>
