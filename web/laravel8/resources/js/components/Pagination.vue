<template>
  <div class="">
    <ul class="md:flex md:justify-around">
      <li class="">
        <RouterLink
          v-if="! isFirstPage"
          :to="`/?page=${currentPage - 1}`"
        >
          <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            &laquo;  Prev
          </button>
        </RouterLink>        
      </li>

      <li class="">
        currentPage : {{ currentPage }}
      </li>

      <li class="">
        <RouterLink
          v-if="! isLastPage"
          :to="`/?page=${currentPage + 1}`"
          >
          <button class=" bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Next &raquo;
          </button>      
        </RouterLink>
      </li>
    </ul>


    


  </div>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    }
  },
  computed: {
    isFirstPage () {
      return this.currentPage === 1
    },
    isLastPage () {
      return this.currentPage === this.lastPage
    }
  }
}
</script>