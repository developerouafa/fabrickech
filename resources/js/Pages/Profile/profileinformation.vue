<template>
    <ProfileLayout>
            <form @submit.prevent="submit" autocomplete="off">
                <h3 class="text-lg font-medium capitalize mb-4">
                    Profile Information
                </h3>
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                First Name
                            </label>
                            <input type="text" placeholder="First Name" value="" class="input-box" required>
                            <!-- <div
                                v-if="form.errors.firstname"
                                style="color:red">
                                    {{ form.errors.firstname }}
                            </div> -->
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                Last Name
                            </label>
                            <input type="text" class="input-box" value="Doe">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                Gender
                            </label>
                            <select class="input-box">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-600 mb-2 block">
                                Phone Number
                            </label>
                            <input type="text" class="input-box" value="+123 456 789">
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">
                        Save change
                    </button>
                </div>
            </form>
    </ProfileLayout>
</template>
<script setup>
    import ProfileLayout from '@/Layouts/ProfileLayout.vue';
    import { useForm } from "@inertiajs/vue3";
    import { useSwallSuccess, useSwallErreur } from '@/Composables/alert';

    const props = defineProps({
        profileinformation: {
            type: Object,
            default: () => ({}),
        },
    });

    const form = useForm({
        id: props.profileinformation.id,
        firstname: props.profileinformation.firstname
    });

    const submit = () => {
        form.put(route("profile.profileinformation", props.profileinformation.id),
                {
                    onSuccess: (response) => {
                        useSwallSuccess("Mise a jour avec succ")
                    },
                    onerror: (error) => {
                        useSwallErreur("Erreur")
                    }
                });
    };
</script>
