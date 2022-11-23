<template>
    <div>
        <form @submit.prevent="login">

            <div>
                <label for="email"> Username: </label>
                <input type="text" name="email" autocomplete="email" v-model="email">
            </div>

            <div>
                <label for="password"> Password: </label>
                <input type="password" name="password" autocomplete="current-password" v-model="password">
            </div>

            <button type="submit"> Login </button>

        </form>
    </div>
</template>

<script>
import { useAuthStore } from '@/Stores/AuthStore';
import axios from 'axios';
import { mapStores } from 'pinia';

export default {
    name: "LoginPage",

    data() {
        return {
            email: '',
            password: '',
        }
    },

    computed: {
        ...mapStores(useAuthStore)
    },

    methods: {
        async login() {
            if (this.email === '' || this.password === '') {
                return;
            }

            const message = {
                email: this.email,
                password: this.password,
            }

            await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');
            await axios.post("http://127.0.0.1:8000/api/login", message)
                .then((response) => {
                    console.log(response.data);
                    this.password = '';
                    this.email = '';

                    this.authStore.setAuthFromResponse(response);

                    this.$router.push('/');
                })
                .catch((err) => {
                    console.log(err);

                    if (err.response.status === 401) {
                        console.log(err.response.data.message);
                    } else {
                        throw err;
                    }
                });


        }
    }
}
</script>
