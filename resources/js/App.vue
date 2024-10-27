<template>
    <div id="app">
        <nav class="navbar" v-if="isReady">
            <div class="nav-brand">Contact Manager</div>
            <div class="nav-items">
                <template v-if="hasUser">
                    <router-link to="/contacts" class="nav-link">Contacts</router-link>
                    <a href="#" @click.prevent="handleLogout" class="nav-link">Logout</a>
                </template>
                <template v-else>
                    <router-link to="/login" class="nav-link">Login</router-link>
                    <router-link to="/register" class="nav-link">Register</router-link>
                </template>
            </div>
        </nav>

        <main>
            <router-view v-if="isReady"></router-view>
        </main>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: null,
            isReady: true,
        };
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get('/user');
                this.user = response.data;
            } catch (error) {
                this.user = null; // Kullanıcı bilgisi alınamazsa boş bırak
            }
        },
        async handleLogout() {
            try {
                await axios.post('/logout');
                this.user = null;
                this.$router.push('/login'); // Çıkış sonrası login sayfasına yönlendir
                alert('Logout successful');
            } catch (error) {
                alert('Failed to logout');
            }
        }
    },
    computed: {
        hasUser () {
            return !!this.user;
        },
    },
    mounted() {
        this.fetchUser(); // Uygulama yüklendiğinde kullanıcı bilgilerini al
    }
};
</script>

<style>
#app {
    font-family: Arial, sans-serif;
}

.navbar {
    padding: 1rem;
    background-color: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav-brand {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}

.nav-items {
    display: flex;
    gap: 1rem;
}

.nav-link {
    color: #666;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.2s;
}

.nav-link:hover {
    background-color: #e9ecef;
    color: #333;
}

.router-link-active {
    color: #007bff;
    font-weight: bold;
}

main {
    padding: 0 1rem;
    max-width: 1200px;
    margin: 0 auto;
}
</style>
