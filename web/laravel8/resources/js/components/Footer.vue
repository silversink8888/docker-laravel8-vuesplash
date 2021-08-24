<template>
  <div class=" container mt-50 mx-auto bg-gray-300 text-white p-6 ">
    <button v-if="isLogin" 
      class="my-2 px-4 py-2
      border-2 border-blue-500 rounded-md
      bg-gradient-to-b from-blue-600 to-blue-400
      hover:from-blue-500 hover:to-blue-300 
      text-white shadow-lg"

    @click="logout">
      Logout/
    </button>
    
    <RouterLink v-else 
      class="my-2 px-4 py-2
      border-2 border-blue-500 rounded-md
      bg-gradient-to-b from-blue-600 to-blue-400
      hover:from-blue-500 hover:to-blue-300 
      text-white shadow-lg"
      
    to="/login">
      Login / Register 
    </RouterLink>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex' 

export default {
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')

      if (this.apiStatus) {
        this.$router.push('/login')
      }
    }
  },

  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus      
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    }),

//    isLogin () {
//      return this.$store.getters['auth/check']
//    }
  },
}
</script>