<template>
  <div class="contact-form">
    <h2>{{ isEditing ? 'Edit Contact' : 'Create Contact' }}</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="form.name" required>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <div>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" v-model="form.phone" required>
      </div>
      <div>
        <label for="address">Address:</label>
        <textarea id="address" v-model="form.address"></textarea>
      </div>
      <button type="submit">{{ isEditing ? 'Update' : 'Create' }}</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        address: ''
      },
      isEditing: false,
      loading: false,
      error: null
    };
  },
  methods: {
    async submitForm() {
      this.loading = true;
      try {
        const id = this.$route.params.id;
        if (this.isEditing) {
          await this.$axios.put(`/contacts/${id}`, this.form);
          alert('Contact updated successfully');
        } else {
          await this.$axios.post('/contacts', this.form);
          alert('Contact created successfully');
        }
        this.$router.push({ name: 'contact-list' });
      } catch (error) {
        this.error = this.isEditing ? 'Failed to update contact.' : 'Failed to create contact.';
      } finally {
        this.loading = false;
      }
    },
    async fetchContact() {
      const id = this.$route.params.id;
      try {
        const response = await this.$axios.get(`/contacts/${id}`);
        this.form = response.data;
      } catch (error) {
        this.error = 'Failed to load contact details.';
      }
    }
  },
  mounted() {
    const id = this.$route.params.id;
    this.isEditing = !!id;
    if (this.isEditing) {
      this.fetchContact();
    }
  }
};
</script>