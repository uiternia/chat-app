<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref , onMounted } from "vue";
import { Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import Echo from 'laravel-echo';

const props = defineProps({
  messages: Array,
})

const form = useForm({
  user_name: null,
  message: null,
  user_identifier: 'test',
})

const submit = () => {
  form.post(route('messages.store'))
}

</script>

<template>

  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        chat 確認
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="my-4 p-4 rounded-lg bg-blue-200">
              <div v-for="message in messages" :key="message.id">
              <ul>ユーザー名: {{message.user_name}} /メッセージ: {{message.message}} /投稿時間: {{message.created_at}}</ul>
              </div>
       </div>
            <form @submit.prevent="submit" class="my-4 py-2 px-4 rounded-lg bg-gray-300 text-sm flex flex-col md:flex-row flex-grow">
              <input type="hidden" name="user_identifier" v-model="form.user_identifier">
              <input class="py-1 px-2 rounded text-center flex-initial" type="text" v-model="form.user_name" name="user_name"
                placeholder="UserName" maxlength="20">
              <input class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded flex-auto" type="text" name="message" v-model="form.message"
                placeholder="Input message." maxlength="200">
              <button class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded text-center bg-gray-500 text-white"
                type="submit">Send</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
<script>
export default {
  mounted() {
    Echo.channel('chat')
    .listen('MessageCreated' ,(e) => {
      this.getMessages();
    });
  },
  methods: {
    getMessages() {
      this.$inertia.get('/messages');
    }
  }
}
</script>