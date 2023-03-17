<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProfileLayout from '@/Layouts/ProfileLayout.vue';
import DeleteUserForm from './DeleteUserForm.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

    defineProps({
        status: String,
        categories: {
            type: Object,
            default: () => ({}),
        }
    });

</script>

<template>
    <Head title="Change Password"/>

    <ProfileLayout>
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">{{__('changepassword')}}</h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{__('ensureyour')}}
                </p>
            </header>

            <form @submit.prevent="updatePassword">
                <div class="space-y-4 max-w-sm">
                    <div>
                        <label for="current_password" class="text-gray-600 mb-2 block">
                            {{ __('currentpassword') }}
                        </label>
                        <div class="relative">
                            <span class="absolute right-3 top-3 text-sm text-gray-500 cursor-pointer">
                                <i class="far fa-eye-slash"></i>
                            </span>
                            <input
                            id="current_password"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            type="password" class="input-box" placeholder="enter current password" autocomplete="current-password">
                            <InputError :message="form.errors.current_password" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">
                            {{__('newpassword')}}
                        </label>
                        <div class="relative">
                            <span class="absolute right-3 top-3 text-sm text-gray-500 cursor-pointer">
                                <i class="far fa-eye-slash"></i>
                            </span>
                            <input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            class="input-box"
                            placeholder="enter new password">
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="text-gray-600 mb-2 block">
                            {{__('confirmpassword')}}
                        </label>
                        <div class="relative">
                            <span class="absolute right-3 top-3 text-sm text-gray-500 cursor-pointer">
                                <i class="far fa-eye-slash"></i>
                            </span>
                            <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            class="input-box" placeholder="enter confirm password">
                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <Button class="px-6 py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium" :disabled="form.processing">{{__('savechnage')}}</Button>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-md text-black border-neutral-900">{{ __('saved')}}</p>
                    </Transition>
                </div>
            </form>
        </section>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DeleteUserForm class="max-w-xl" />
        </div>
    </ProfileLayout>
</template>
