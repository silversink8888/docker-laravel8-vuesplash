<template>
  <div class="bg-gray-500 lg:bg-gray-700">

  <header class="container mx-auto text-white ">

    <div class="flex justify-between  items-center">
      <RouterLink class="navbar__brand" to="/">
        <h1 class="text-4xl font-semibold md:text-xl">Vuesplash</h1>
      </RouterLink>

      <!-- ハンバーガーメニュー  PCでは非表示-->
      <div class="md:hidden">
        <button @click="isOpen = !isOpen">
          <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
          </svg>                       
        </button>
      </div>

    </div>

      
      <div :class="isOpen ? 'block' : 'hidden'" class="md:block">

        <ul class="md:flex md:justify-around">
          <li class="border-b"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">Vuesplashとは</a></li>
          <li class="border-b"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">機能一覧</a></li>
          <li class="border-b"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">お知らせ</a></li>
          <li class="border-b"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">お問い合わせ</a></li>


          <li>
            <div v-if="isLogin" class="my-8 text-center md:my-4">
                <button class="px-6 py-2 text-black bg-red-500 hover:bg-red-700 rounded-full" @click="showForm = ! showForm">
                  <i class="icon ion-md-add"></i>
                  Submit a photo
                </button>
            </div>

            <div>
                <span v-if="isLogin" class="navbar__item">
                  {{ username }} でログイン中
                </span>

                <div v-else class="navbar__item">
                  <RouterLink class="button button--link" to="/login">
                    Login / Register
                  </RouterLink>
                </div>

                <div>
                  <PhotoForm v-model="showForm"/>
                </div>

            </div>

          </li>

        </ul>
      </div>




  </header>
  </div>
</template>


<script>
import PhotoForm from './PhotoForm.vue'

export default {

  components: {
    PhotoForm
  },
  data () {
    return {
      showForm: false,
      isOpen: false,
    }
  },

  computed:  {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username (){
      return this.$store.getters['auth/username']
    }
    
  },
}
</script>