<template>
    <div v-show="value" 
        class="absolute right-3 bg-white border-radius md:w-2/5 w-4/5 shadow max-h-96 max-w-96 overflow-scroll ">
        <!--
        <h2 class="title">Submit a photo/</h2>
        -->

        <div v-show="loading" class="border-1-green mt-1 p-5">
            <Loader>Sending your photo...</Loader>
        </div>

        <form v-show="! loading" class="form" @submit.prevent="submit">

            <div class="" v-if="errors">
                <ul class="text-red-500">
                    <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            <!--
            <input class="form__item" type="file" @change="onFileChange">
            -->
            <label
                class="w-64 flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                <span class="mt-2 text-base leading-normal">Select a file</span>
                <input type='file' class="hidden" @change="onFileChange"/>
            </label>

            <output class="" v-if="preview">
                <img :src="preview" alt="">
            </output>


            <div class="">
                <button type="submit" class="hover:bg-gray-300 w-full bg-black text-white p-2 m-2">
                    Submit
                </button>
            </div>




        </form>
    </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'

export default {
    components: {
        Loader
    },

    props: {
        value: {
            type: Boolean,
            required: true
        }
    },

    data () {
        return {
            loading: false,
            preview: null,
            photo: null,
            errors: null
        }
    },

    methods: {
        // フォームでファイルが選択されたら実行される
        onFileChange (event) {
            // 何も選択されていなかったら処理中断
            if (event.target.files.length === 0) {
                this.reset()
                return false
            }
            // ファイルが画像ではなかったら処理中断
            if (! event.target.files[0].type.match('image.*')) {
                this.reset()
                return false
            }

            // FileReaderクラスのインスタンスを取得
            const reader = new FileReader()

            reader.onload = e => {
                // previewに読み込み結果（データURL）を代入する
                // previewに値が入ると<output>につけたv-ifがtrueと判定される
                // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
                // 結果として画像が表示される
                this.preview = e.target.result
            }

            // ファイルを読み込む
            // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
            reader.readAsDataURL(event.target.files[0])

            this.photo = event.target.files[0]

        },

        // 入力欄の値とプレビュー表示をクリアするメソッド
        reset () {
            this.preview = ''
            this.photo = null
            //this.$el はコンポーネントそのものの DOM 要素を指します
            this.$el.querySelector('input[type="file"]').value = null
        },

        async submit () {

            this.loading = true

            const formData = new FormData()
            formData.append('photo', this.photo)
            const response = await axios.post('/api/photos', formData)

            this.loading = false

           // alert('UNPROCESSABLE_ENTITY : ' + UNPROCESSABLE_ENTITY);

            if (response.status === UNPROCESSABLE_ENTITY) {
                this.errors = response.data.errors
                return false
            }

            this.reset()
            this.$emit('input',false)

           // alert('CREATED  : ' + CREATED);
           // alert('response.status  : ' + response.status);
            //
            if (response.status !== CREATED) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            // メッセージ登録
            this.$store.commit('message/setContent',{
                content: '写真が投稿されました！',
                timeout: 6000
            })

            this.$router.push(`/photos/${response.data.id}`)
        }
    } 
}
</script>