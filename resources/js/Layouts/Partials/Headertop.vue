<template>
    <div class="p-4" style="color: rgb(255, 255, 255); background-color: #FD3D57;">
        <div class="container">
            <div class="fr-view">
                <p style="text-align: center;">
                    <strong>{{ __('delivery') }}</strong>
                </p>
                <div style="text-align: center;" v-if="$page.props.locale.locale == 'ar'">
                    <strong>وَإِذَا رَأَوْا تِجَارَةً أَوْ لَهْوًا انفَضُّوا إِلَيْهَا وَتَرَكُوكَ قَائِمًا ۚ قُلْ مَا عِندَ اللَّهِ خَيْرٌ مِّنَ اللَّهْوِ وَمِنَ التِّجَارَةِ ۚ وَاللَّهُ خَيْرُ الرَّازِقِينَ</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
