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
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from "@/modules/auth";
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();

const email = ref("");
const password = ref("");

function login() {
    if (email.value === "" || password.value === "") {
        return;
    }

    const message = {
        email: email.value,
        password: password.value,
    };

    axios.get("/sanctum/csrf-cookie").then(() => {
        axios
            .post("/api/sanctum/token", message, {
                headers: {
                    Accept: "application/json",
                },
            })
            .then((response) => {
                console.log(response.data);
                password.value = "";
                email.value = "";

                authStore.setAuthFromResponse(response);

                router.push("/");
            })
            .catch((err) => {
                console.log(err);

                if (err.response.status === 401) {
                    console.log(err.response.data.message);
                } else {
                    throw err;
                }
            });
    });
}
</script>
