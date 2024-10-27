<template>
  <div class="contact-list">
    <h2>Contacts</h2>
    <button @click="$router.push({ name: 'contact-create' })">Add New Contact</button>
    <table v-if="contacts.length">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="contact in contacts" :key="contact.id">
          <td>{{ contact.name }}</td>
          <td>{{ contact.email }}</td>
          <td>{{ contact.phone }}</td>
          <td>
            <button @click="viewDetails(contact.id)">View</button>
            <button @click="editContact(contact.id)">Edit</button>
            <button @click="deleteContact(contact.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>No contacts found.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contacts: [], // Kullanıcıya ait kontaklar
      loading: true,
      error: null
    };
  },
  methods: {
    async fetchContacts() {
      try {
        const response = await this.$axios.get('/contacts');
        this.contacts = response.data;
      } catch (error) {
        this.error = 'Failed to load contacts.';
      } finally {
        this.loading = false;
      }
    },
    viewDetails(id) {
      this.$router.push({ name: 'contact-details', params: { id } });
    },
    editContact(id) {
      this.$router.push({ name: 'contact-edit', params: { id } });
    },
    async deleteContact(id) {
      if (confirm('Are you sure you want to delete this contact?')) {
        try {
          await this.$axios.delete(`/contacts/${id}`);
          this.contacts = this.contacts.filter(contact => contact.id !== id); // Listeden çıkar
        } catch (error) {
          this.error = 'Failed to delete contact.';
        }
      }
    }
  },
  mounted() {
    this.fetchContacts(); // Sayfa yüklendiğinde kontakları çek
  }
};
</script>


<style scoped>
.contact-list {
  max-width: 800px;
  margin: 0 auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

button {
  margin-right: 5px;
}
</style>