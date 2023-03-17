<template>
<!-- @if(Session::get('locale') === 'en') dir="ltr" @elseif(Session::get('locale') === 'ar') dir="rtl" @endif -->
    <div v-if="$page.props.locale.locale == 'ar'" dir="rtl" >
        <Headertop/>

        <Header/>

        <navbar/>

        <div class="content-wrapper">
            <slot/>
        </div>

        <Footer/>
    </div>

    <div v-if="$page.props.locale.locale == 'en'" dir="ltr" >
        <Headertop/>

        <Header/>

        <navbar/>

        <div class="content-wrapper">
            <slot/>
        </div>

        <Footer/>
    </div>

    <div v-if="$page.props.locale.locale != 'en' && $page.props.locale.locale != 'ar'" dir="ltr">
        <Headertop/>

        <Header/>

        <navbar/>

        <div class="content-wrapper">
            <slot/>
        </div>

        <Footer/>
    </div>
</template>

<script setup>
import Headertop from './Partials/Headertop.vue';
import Header from './Partials/Header.vue';
import navbar from './Partials/navbar.vue';
import Footer from '@/Layouts/Partials/Footer.vue';
</script>
