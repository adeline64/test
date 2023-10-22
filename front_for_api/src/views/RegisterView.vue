<template>
  <div class="form-container">
    <h2>Inscription</h2>
    <form @submit.prevent="handleRegister">
      <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <div>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" v-model="form.password" required>
      </div>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();
    const form = ref({
      email: '',
      password: ''
    });

    const RegisterError = ref(null);

    const handleRegister = async () => {
      try {
        console.log('Trying to register...');

        await axios.post('http://localhost:8000/api/register', {
          email: form.value.email,
          password: form.value.password
        });
        console.log("email : ", form.value.email);
        console.log("password : ", form.value.password);
        console.log('register successful');
        router.push("/");
      } catch (error) {
        console.error('Register failed:', error);
        RegisterError.value = "L'inscription a échoué";
      }
    };

    return { form, RegisterError, handleRegister };
  },
};
</script>