<template>
    <div class="register">
        <h2>Register</h2>
        <div v-if="error" class="error-message">
            {{ error }}
        </div>
        <div v-if="validationErrors" class="validation-errors">
            <ul>
                <li v-for="(error, field) in validationErrors" :key="field">
                    {{ error[0] }}
                </li>
            </ul>
        </div>
        <form @submit.prevent="handleRegister">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name" required :disabled="loading">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="form.email" required :disabled="loading">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="form.password" required :disabled="loading">
            </div>
            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" v-model="form.password_confirmation" required
                    :disabled="loading">
            </div>
            <div v-if="!passwordsMatch" class="password-error">
                Passwords do not match
            </div>
            <button type="submit" :disabled="loading || !passwordsMatch">
                {{ loading ? 'Registering...' : 'Register' }}
            </button>
        </form>
    </div>
</template>

<script>

export default {
    name: 'Register',
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            loading: false,
            error: null,
            validationErrors: null
        }
    },
    computed: {
        passwordsMatch() {
            return this.form.password === this.form.password_confirmation;
        }
    },
    methods: {
        async handleRegister() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;
            try {
                const response = await this.$axios.post('/register', this.form);
                console.log(response.data);

                this.$router.push({ name: 'login' });
            } catch (error) {
                if (error.response?.data?.errors) {
                    this.validationErrors = error.response.data.errors;
                } else {
                    this.error = error.response?.data?.message || 'Registration failed';
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>
.register {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.error-message,
.password-error {
    color: red;
    margin-bottom: 15px;
    padding: 10px;
    background-color: rgba(255, 0, 0, 0.1);
    border-radius: 4px;
}

.validation-errors {
    color: red;
    margin-bottom: 15px;
}

.validation-errors ul {
    margin: 0;
    padding-left: 20px;
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