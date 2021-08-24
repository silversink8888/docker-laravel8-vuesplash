<template>

<div class="flex flex-wrap">
    <!-- 画像 -->
    <div class='w-full md:w-1/2'>
      <div
        v-if="photo"
        class="m-5"
      >
        <img :src="photo.url" alt="" class="">
      </div>
    </div>

    <!-- コメント等 -->
    <div class='w-full md:w-1/2 '>

      <div class="border m-2">

        <figcaption>Posted by {{ photo.owner.name }}</figcaption>

        <div class="">
          <button
            class="h-15 w-10 hover:bg-red-800"
            :class="{ 'h-15 w-10 bg-red-500': photo.liked_by_user }"
            title="Like photo"
            @click="onLikeClick"
          >

          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>{{ photo.likes_count }}
          
          </button>

          <a
            :href="`/photos/${photo.id}/download`"
            class="button"
            title="Download photo"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd" />
            </svg>
            Download
          </a>

        </div>
        
        <h2 class="">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
          </svg>Comments
        </h2>

        <div >

          <ul v-if="photo.comments.length > 0" class="overflow-y-scroll h-60 bg-gray-100 ">
            
            <li
              v-for="comment in photo.comments"
              :key="comment.content"
              class="border-b"
            >
              <p class="">
                {{ comment.content }}
              </p>

              <p class="">
                By {{ comment.author.name }}
              </p>
              
            </li>
          </ul>
          <p v-else>No comments yet.</p>

        </div>



        <form v-if="isLogin" @submit.prevent="addComment" class="form">
          <div v-if="commentErrors" class="text-red-500 font-bold">
            <ul v-if="commentErrors.content">
              <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
            </ul>
          </div>

          <textarea class="mt-5 w-full border-2" v-model="commentContent"></textarea>
          <div class="">
            <button type="submit" class="bg-black hover:bg-gray-500 text-white w-full h-15 p-2 ">submit comment</button>
          </div>
        </form>

      </div>


    </div>

</div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      photo: null,
      fullWidth: false,
      commentContent: '',
      commentErrors: null
    }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    }
  },
  methods: {
    async fetchPhoto () {
      const response = await axios.get(`/api/photos/${this.id}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photo = response.data
    //  alert(this.photo.id);
    },
    async addComment () {
      const response = await axios.post(`/api/photos/${this.id}/comments`, {
        content: this.commentContent
      })

      // バリデーションエラー
      if (response.status === UNPROCESSABLE_ENTITY) {
        this.commentErrors = response.data.errors
        return false
      }

      this.commentContent = ''
      // エラーメッセージをクリア
      this.commentErrors = null

      // その他のエラー
      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photo.comments = [
        response.data,
        ...this.photo.comments
      ]
    },
    onLikeClick () {
      if (! this.isLogin) {
        alert('いいね機能を使うにはログインしてください。')
        return false
      }

      if (this.photo.liked_by_user) {
        this.unlike()
      } else {
        this.like()
      }
    },
    async like () {
      const response = await axios.put(`/api/photos/${this.id}/like`)

    //  alert(response.status);
    //  alert(this.photo.id);

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photo.likes_count = this.photo.likes_count + 1
      this.photo.liked_by_user = true
    },

    async unlike () {
      const response = await axios.delete(`/api/photos/${this.id}/like`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.photo.likes_count = this.photo.likes_count - 1
      this.photo.liked_by_user = false
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPhoto()
      },
      immediate: true
    }
  }
}
</script>
