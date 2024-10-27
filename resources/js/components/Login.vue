<template>
    <div class="login">
        <h2>Login</h2>
        <div v-if="error" class="error-message">
            {{ error }}
        </div>
        <form @submit.prevent="handleLogin">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="form.email" required :disabled="loading">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="form.password" required :disabled="loading">
            </div>
            <button type="submit" :disabled="loading">
                {{ loading ? 'Logging in...' : 'Login' }}
            </button>
        </form>
    </div>
</template>

<script>

export default {
    name: 'Login',
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            loading: false,
            error: null
        }
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.error = null;
            try {
                await this.$axios.get('/sanctum/csrf-cookie');

                const response = await this.$axios.post('/login', this.form);
                console.log(response.data); // Başarılı giriş yanıtını burada işleyebilirsiniz
                // Giriş başarılıysa kullanıcıyı yönlendirebilir veya durumu güncelleyebilirsiniz.
                this.$router.push({ name: 'contact-list' });
            } catch (error) {
                this.error = error.response?.data?.message || 'Login failed';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>
.login {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.error-message {
    color: red;
    margin-bottom: 15px;
    padding: 10px;
    background-color: rgba(255, 0, 0, 0.1);
    border-radius: 4px;
}

div {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

label {
    font-weight: bold;
}

input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

input:disabled {
    background-color: #f5f5f5;
}

button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

button:hover:not(:disabled) {
    background-color: #45a049;
}
</style>