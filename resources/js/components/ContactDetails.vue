<template>
  <div class="contact-details">
    <h2>Contact Details</h2>
    <div v-if="currentContact">
      <p><strong>Name:</strong> {{ currentContact.name }}</p>
      <p><strong>Email:</strong> {{ currentContact.email }}</p>
      <p><strong>Phone:</strong> {{ currentContact.phone }}</p>
      <p><strong>Address:</strong> {{ currentContact.address }}</p>
    </div>
    <div v-else>
      Loading...
    </div>
    <button @click="goBack">Back to List</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentContact: null, // Şu an görüntülenen contact
      loading: true,
      error: null
    };
  },
  methods: {
    async fetchContact() {
      const id = this.$route.params.id; // Route parametresinden id alınır

      try {
        const response = await this.$axios.get(`/contacts/${id}`);
        this.currentContact = response.data;
      } catch (error) {
        this.error = 'Failed to load contact details.';
      } finally {
        this.loading = false;
      }
    },
    goBack() {
      this.$router.push({ name: 'contact-list' });
    }
  },
  mounted() {
    this.fetchContact(); // Sayfa yüklendiğinde contact detayını çek
  }
};
</script>