<script>

import axios from 'axios';

export default {
  async mounted() {
    try {
      await axios.post('/logout'); // Effectuez une requête pour déconnecter l'utilisateur côté backend.
      alert('Déconnexion réussie'); // Affichez une notification de succès.
      this.$router.push('/'); // Redirigez l'utilisateur vers la page d'accueil ou une autre page.
    } catch (error) {
      console.error('Erreur lors de la déconnexion', error);
      alert('Erreur lors de la déconnexion'); // Affichez une notification d'erreur, si nécessaire.
      this.$router.push('/');
    }
  },
};
</script>
