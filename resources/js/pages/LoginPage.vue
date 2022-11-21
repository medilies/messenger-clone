<template>
    <div>
        <form @submit.prevent="login">
            <div>
                <label for="email"> Username: </label>
                <input type="text" name="email" v-model="email" autocomplete="email">
            </div>

            <div>
                <label for="password"> Password: </label>
                <input type="password" name="password" v-model="password" autocomplete="current-password">
            </div>

            <button type="submit"> Login </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        login() {
            if (this.email === '' || this.password === '') {
                return;
            }

            const message = {
                email: this.email,
                password: this.password,
            }

            axios.post("/api/login", message)
                .then((response) => {
                    console.log(response.data);
                    this.password = '';
                    this.email = '';

                    sessionStorage.setItem('BearerToken', JSON.stringify(response.data.token));

                    sessionStorage.setItem('user', JSON.stringify(response.data.user));

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
