<template>
  <div class="row m-0">
    <div
      class="info col-sm-12 col-md-6 d-flex align-items-center justify-content-center flex-column text-white"
    >
      <img
        class="img-fluid"
        src="@/assets/img/IconLogin.svg"
        alt="login image"
      />
      <h1 class="mb-5">Task Manager</h1>
    </div>
    <div class="login-form col-sm-12 col-md-6 d-flex align-items-center">
      <form class="row g-3 container mx-5 p-5" @submit.prevent="login">
        <div class="col-12">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            v-model="email"
            required
          />
          <div v-if="!emailValid" class="invalid-feedback">
            Please enter a valid email address.
          </div>
        </div>
        <div class="col-12">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            v-model="password"
            required
          />
          <div v-if="!passwordValid" class="invalid-feedback">
            Please enter a password.
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary" :disabled="!formValid">
            Sign in
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  computed: {
    emailValid() {
      // Use a regular expression to validate email format
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(this.email);
    },
    passwordValid() {
      return this.password.length > 0;
    },
    formValid() {
      return this.emailValid && this.passwordValid;
    },
  },
  methods: {
    async login() {
      try {
        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/auth/login`,
          {
            email_address: this.email,
            password: this.password,
          }
        );
        localStorage.setItem("access_token", response.data.access_token);
        localStorage.setItem("id", response.data.user.id);
        this.$router.push("/");
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
.container {
  padding: 10px !important;
}
.info {
  background-color: #35495e;
  height: 30vh;
}
input:invalid {
  border-color: #dc3545;
}
input:valid {
  border-color: #28a745;
}
.invalid-feedback {
  color: #dc3545;
  font-size: 80%;
}

@media (min-width: 768px) {
  .info {
    height: 100vh;
  }
}
</style>
