<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import {Link, useForm} from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
                    <!-- Full Name Input -->
                    <input
                        v-model="form.name"
                        class="form-control mb-3 custom-input"
                        placeholder="Full Name"
                        id="name"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        type="text"
                    />
                    <InputError :message="form.errors.name" variant="material" />

                    <!-- Email Input -->
                    <input
                        v-model="form.email"
                        class="form-control mb-3 custom-input"
                        placeholder="Email"
                        id="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        type="email"
                    />
                    <InputError :message="form.errors.email" variant="material" />

                    <!-- Phone Number Input -->
                    <input
                        v-model="form.phone_number"
                        class="form-control mb-3 custom-input"
                        placeholder="Phone Number"
                        id="phone_number"
                        required
                        :tabindex="3"
                        autocomplete="tel"
                        type="tel"
                    />
                    <InputError :message="form.errors.phone_number" variant="material" />

                    <!-- Password Input -->
                    <input
                        v-model="form.password"
                        class="form-control mb-3 custom-input"
                        placeholder="Password"
                        id="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        type="password"
                    />
                    <InputError :message="form.errors.password" variant="material" />

                    <!-- Confirm Password Input -->
                    <input
                        v-model="form.password_confirmation"
                        class="form-control mb-3 custom-input"
                        placeholder="Confirm Password"
                        id="password_confirmation"
                        required
                        :tabindex="5"
                        autocomplete="new-password"
                        type="password"
                    />

                    <!-- Buttons, centered and side-by-side -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-4 w-100">
                        <!-- Sign Up button (blue gradient style) -->
                        <button class="btn btn-custom-1 btn-custom"  style="font-weight: normal;
                                   background-color: #e4787e;" type="submit" :disabled="form.processing" :tabindex="6">
                            Sign up
                        </button>
                        <!-- Sign In button (darker style) -->
                        <Link
                            as="button"
                            :href="route('login')"
                            class="btn btn-custom-2 btn-custom"
                            :tabindex="5"
                            style="background-color:rgb(102, 175, 219);"
                        >
                            Sign in
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

