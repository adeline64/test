<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const form = ref({
    email: '',
    password: ''
})

const loginError = ref(null);

const handleLogin = async () => {
    try {
        console.log('Trying to log in...');
        await axios.post('http://localhost:8000/api/login', {
            email: form.value.email,
            password:form.value.password,
        });
        console.log('Login successful!');
        router.push("/");
    } catch (error) {
        console.error('Login failed:', error);
        loginError.value = "La connexion a échoué"
    }
    
}

</script>
<template>
 <div class="row col-6">      

        <h1 class="my-5">Login</h1>
        <form @submit.prevent="handleLogin">
            
            <div class="form-outline mb-4">
                <input type="email" class="form-control" id="email" v-model="form.email">

                <label class="form-label" for="email">Email address</label>
            </div>

            
            <div class="form-outline mb-4">
                <input type="password" id="password" v-model="form.password" class="form-control"/>
                <label class="form-label" for="password">Password</label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

            <div class="text-center">
                <p v-if="loginError" class="text-danger"> La connexion a échoué</p>
                <p>Not a member? <a href="">Register</a></p>
            </div>
        </form>
    </div>
</template>

<style>
.products {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 50px;
}
</style>