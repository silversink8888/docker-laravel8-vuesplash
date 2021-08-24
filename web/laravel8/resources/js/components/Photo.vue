<template>
  <div class="m-2 bg-red-100">
    
    <RouterLink
      class=""
      :to="`/photos/${item.id}`"
      :title="`View the photo by ${item.owner.name}`"
    >
      <div class="">

        <img
          class="w-full rounded h-56"
          :src="item.url"
          :alt="`Photo by ${item.owner.name}`"
        >

        <ul class="md:flex md:justify-around">
          <li class="m-2">
              {{ item.owner.name }}
          </li>

          <!-- いいね　ボタン -->
          <li class="m-2">
            <button
              class="bg-red-100"
              :class="{ 'bg-red-500': item.liked_by_user }"
              title="Like photo"
              @click.prevent="like"
            >
              <i class="">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </i>
              {{ item.likes_count }}
            </button>
          </li>

          <!-- Download　ボタン -->
          <li class="m-2">
            <a
              class=""
              title="Download photo"
              @click.stop
              
              :href="`/photos/${item.id}/download`"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd" />
              </svg>
            </a>
          </li>

        </ul>





      </div>

    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    like () {
      this.$emit('like', {
        id: this.item.id,
        liked: this.item.liked_by_user
      })
    }
  }
}
</script>
