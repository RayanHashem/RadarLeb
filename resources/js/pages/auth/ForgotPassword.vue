<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/forgot-password');
};
</script>

<template>
    <Head title="Forgot password" />
    <section id="sign-in" class="w-100">
        <div class="d-flex align-items-center flex-column h-100 p-3-5">
            <!-- Flag container, centered above the form -->
            <div class="d-flex gap-4 flex-column w-100 align-items-center">
                <img src="assets/imgs/Flag_of_Lebanon.png" class="flag" alt="Flag of Lebanon" />
            </div>
            <!-- Form container with custom styling defined in app.css -->
            <div class="form-container d-flex flex-column gap-5">
                <form @submit.prevent="submit">
                    <!-- Status message -->
                    <div v-if="status" class="mb-3 text-center" style="color: #4ade80; font-size: 0.9em;">
                        {{ status }}
                    </div>

                    <!-- Email Input -->
                    <input
                        type="email"
                        class="form-control mb-3 custom-input"
                        placeholder="Email"
                        id="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                    />
                    <InputError :message="form.errors.email" />

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-4 w-100">
                        <button
                            class="btn btn-custom-1 btn-custom"
                            style="background-color:rgb(102, 175, 219);"
                            type="submit"
                            :tabindex="2"
                            :disabled="form.processing"
                        >
                            <span v-if="!form.processing">Send Reset Link</span>
                            <span v-else>Sending...</span>
                        </button>
                    </div>

                    <!-- Horizontal rule with shadow -->
                    <hr style="height:2px;border-width:0;color:gray;background-color:white;opacity:1; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.42), 0 6px 20px 0 rgba(0, 0, 0, 0.84); width: 80%; margin: 20px auto;">
                    
                    <!-- Back to Login button -->
                    <div class="d-flex justify-content-center mt-3 w-100">
                        <Link
                            href="/login"
                            class="btn btn-custom-1 btn-custom"
                            style="background-color:rgb(102, 175, 219); color: white;"
                            :tabindex="3"
                        >
                            Back to Login
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

