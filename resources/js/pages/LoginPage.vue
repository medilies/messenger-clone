<template>
    <div>
        <form @submit.prevent="login">
            <div>
                <label for="email"> Username: </label>
                <input
                    v-model="email"
                    type="text"
                    name="email"
                    autocomplete="email"
                />
            </div>

            <div>
                <label for="password"> Password: </label>
                <input
                    v-model="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                />
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script setup>
import { useAuthStore } from "@/Stores/AuthStore";
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
