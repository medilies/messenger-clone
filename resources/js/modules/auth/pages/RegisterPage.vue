<template>
    <div class="grid h-full">
        <div class="place-self-center p-8 bg-slate-700 rounded-md">
            <form @submit.prevent="login">
                <div class="grid grid-cols-2 gap-4 items-center">
                    <label for="email" class="text-white"> Email </label>

                    <input
                        v-model="email"
                        type="text"
                        name="email"
                        autocomplete="email"
                        class="rounded-md"
                    />

                    <label for="password" class="text-white"> Password </label>

                    <input
                        v-model="password"
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        class="rounded-md"
                    />

                    <button
                        type="submit"
                        class="col-span-2 px-8 py-2 bg-slate-800 text-gray-100 rounded-md hover:bg-slate-900 hover:text-white"
                    >
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "@/modules/auth";
import { ref } from "vue";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

const email = ref("");
const password = ref("");
</script>
