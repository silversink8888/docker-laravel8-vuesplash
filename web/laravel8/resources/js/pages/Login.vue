<template>

  <div class="container bg-gray-100 mx-auto ">

  <div class="flex flex-wrap">
    <div class="w-full">

      <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" 
            v-on:click="toggleTabs(1)" v-bind:class="{'text-indigo-600 bg-white': openTab !== 1, 
            'text-white bg-gray-500': openTab === 1}">
            Login
          </a>
        </li>

        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" 
          v-on:click="toggleTabs(2)" v-bind:class="{'text-indigo-600 bg-white': openTab !== 2, 
          'text-white bg-gray-500': openTab === 2}">
            Register
          </a>
        </li>

      </ul>
      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
        <div class="px-4 py-5 flex-auto">
          <div class="tab-content tab-space">
            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">

              <form class="grid grid-cols-1 gap-6 m-6" @submit.prevent="login">
              
                <div v-if="loginErrors" class="errors">
                  <ul v-if="loginErrors.email">
                    <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                  </ul>
                  <ul v-if="loginErrors.password">
                    <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                  </ul>
                </div>

                <label class="block" for="login-email">Email</label>
                <input 
                  type="text" 
                  class="text-xl p-3 border rounded" 
                  placeholder="example@example.com"
                  id="login-email" 
                  v-model="loginForm.email"
                >

                <label for="login-password">Password</label>
                <input 
                  type="password" 
                  class="text-xl p-3 border rounded" 
                  id="login-password" 
                  v-model="loginForm.password"
                >
                
                <div class="">
                  <button type="submit" 
                  class="mb-3 text-xl w-4/12 bg-black text-white py-2 rounded hover:opacity-75">login</button>
                </div>
              </form>

            </div>

            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">

              <form class="grid grid-cols-1 gap-6 m-6" @submit.prevent="register">

                <div v-if="registerErrors" class="errors">
                  <ul v-if="registerErrors.name">
                    <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                  </ul>
                  <ul v-if="registerErrors.email">
                    <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                  </ul>
                  <ul v-if="registerErrors.password">
                    <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                  </ul>
                </div>

                <label class="block" for="username">Name</label>
                <input 
                  type="text" 
                  class="text-xl p-3 border rounded" 
                  placeholder="example"
                  id="username" 
                  v-model="registerForm.name"
                >

                <label for="email">Email</label>
                <input 
                  type="text" 
                  class="text-xl p-3 border rounded" 
                  placeholder="you@gmail.com"
                  id="email" 
                  v-model="registerForm.email"
                >

                <label for="password">Password</label>
                <input 
                  type="password" 
                  class="text-xl p-3 border rounded" 
                  id="password" 
                  v-model="registerForm.password"
                >

                <label for="password-confirmation">Password (confirm)</label>
                <input 
                  type="password" 
                  class="text-xl p-3 border rounded" 
                  id="password-confirmation" 
                  v-model="registerForm.password_confirmation"
                >

                <div class="">
                  <button type="submit" class="mb-3 text-xl w-4/12 bg-black text-white py-2 rounded hover:opacity-75">register</button>
                </div>

              </form>

            </div>



          </div>
        </div>
      </div>
    </div>
  </div>

<!--

    <ul class="tab">
      <li
        class="tab__item"
        :class="{'tab__item--active': tab === 1 }"
        @click="tab = 1"
      >Login</li>
      <li
        class="tab__item"
        :class="{'tab__item--active': tab === 2 }"
        @click="tab = 2"
      >Register</li>
    </ul>

    <div class="panel" v-show="tab === 1">

    </div>

    <div class="panel" v-show="tab === 2">

    </div>
-->

  </div>


</template>

<script>
import { mapState } from 'vuex'

export default {
  data () {
    return {
      tab: 1,
      openTab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    toggleTabs: function(tabNumber){
      this.openTab = tabNumber
    },

    async login () {
      // authストアのloginアクションを呼び出す
      await this.$store.dispatch('auth/login', this.loginForm)

      if(this.apiStatus){
        // トップページに
        this.$router.push('/')
      }

    },

    async register () {
      // authストアのresigterアクションを呼び出す
      await this.$store.dispatch('auth/register', this.registerForm)

      if (this.apiStatus) {
        // トップページに
        this.$router.push('/')
      }

    },

    clearError () {
      this.$store.commit('auth/setLoginErrorMessages', null)
      this.$store.commit('auth/setRegisterErrorMessages', null)
    }  
  },

  created () {
    this.clearError()
  },  
  computed: {
  ...mapState({
    apiStatus: state => state.auth.apiStatus,
    loginErrors: state => state.auth.loginErrorMessages,
    registerErrors: state => state.auth.registerErrorMessages
  })
  },

  plugins: [
    require('@tailwindcss/forms'),
  ],

}
</script>
