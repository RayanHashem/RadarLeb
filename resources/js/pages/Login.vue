<script setup lang="ts">
/// <reference path="../../../ziggy.d.ts" />
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    phone_number: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <section id="sign-in" class="w-100">
        <!-- The d-flex align-items-center flex-column h-100 p-3-5 ensures content is centered vertically and horizontally -->
        <div class="d-flex align-items-center flex-column h-100 p-3-5">
            <!-- Flag container, centered above the form -->
            <div class="d-flex gap-4 flex-column w-100 align-items-center">
                <img src="assets/imgs/Flag_of_Lebanon.png" class="flag" alt="Flag of Lebanon" />
            </div>
            <!-- Form container with custom styling defined in app.css -->
            <div class="form-container d-flex flex-column gap-5">
                <form @submit.prevent="submit">
                    <!-- Phone Number Input -->
                    <input
                        type="text"
                        class="form-control mb-3 custom-input"
                        placeholder="Phone Number"
                        id="phone_number"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="username"
                        v-model="form.phone_number"
                    />
                    <InputError :message="form.errors.phone_number" />

                    <!-- Password Input -->
                    <input
                        type="password"
                        class="form-control mb-3 custom-input"
                        placeholder="Password"
                        id="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                    />
                    <InputError :message="form.errors.password" />

                    <!-- Buttons and Forgot Password link, centered -->
                    <!-- Changed from flex-column to flex-row for side-by-side buttons -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-4 w-100">
                        <!-- Sign Up button (darker style) -->
                        <Link
                            as="button"
                            :href="route('register')"
                            class="btn btn-custom-2 btn-custom"
                            style="font-weight: normal;
                                   background-color: #e4787e;"
                            :tabindex="5"
                        >
                            Sign up
                        </Link>
                        <!-- Sign In button (blue gradient style) -->
                        <button
                            class="btn btn-custom-1 btn-custom"
                            style="background-color:rgb(102, 175, 219);"
                            type="submit"
                            :tabindex="4"
                            :disabled="form.processing"
                        >
                            <span v-if="!form.processing">Sign in</span>
                            <!-- Show loading spinner if form is processing -->
                            <LoaderCircle v-else class="animate-spin" />
                        </button>
                    </div>

                    <!-- Horizontal rule with shadow -->
                    <hr style="height:2px;border-width:0;color:gray;background-color:white;opacity:1; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.42), 0 6px 20px 0 rgba(0, 0, 0, 0.84); width: 80%; margin: 20px auto;">
                    <!-- Forgot Password button -->
                    <div class="d-flex justify-content-center align-items-center mt-3 w-100">
                        <Link
                            as="button"
                            type="button"
                            href="/forgot-password"
                            class="btn btn-custom-2 btn-custom"
                            style="font-weight: normal; background-color: #6c757d; color: white;"
                            :tabindex="6"
                        >
                            Forgot Password?
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

