<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from "vue";
import { Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';

const fileName = ref("")
const url = ref("")
const imageShow = ref(false)

const form = useForm({
    file: null,
})

const props = defineProps({
  urlo: Object,
})

const fileSelected = (e) => {
    if (e.target.files.length === 0) {
        url.value = null
        imageShow.value = false
        return false
    }
    fileName.value = e.target.files[0]
    url.value = URL.createObjectURL(fileName.value)
    imageShow.value = true
}

const submit = () => {
    form.post(route('image.store'))
}

</script>

<template>

    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              s3アップロード/Mailhog
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <input class="input-file" type="file" @input="form.file = $event.target.files[0]"
                                @change="fileSelected" accept="image/png, image/jpeg" />
                            <div v-if="imageShow" class="file-size">
                                <img class="image" :src="url" alt="">
                            </div>
                            <button type="submit">s3へ保存</button>
                        </form>
                    </div>
                    <img :src="urlo" alt="">
                     <Link :href="route('mail.store')">メールの保存/queue確認 :8025</Link>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

.label {
  margin-bottom: 10px;
  color: rgb(76, 5, 5);
}

.image {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.input-file {
  margin-bottom: 4px;
}

.file-size {
  height: 200px;
  width: 300px;
}

.form-content {
  margin-top: 20px;
  margin-bottom: 10px;
  color: rgb(76, 5, 5);
}

.input-calorie {
  height: 2rem;
  padding: 0 16px;
  border-radius: 4px;
  border: none;
  box-shadow: 0 0 0 1px #ccc inset;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

.input-calorie:focus {
  outline: 0;
  box-shadow: 0 0 0 2px rgb(33, 150, 243) inset;
}

.input-content {
  border-radius: 4px;
  border: none;
  box-shadow: 0 0 0 1px #ccc inset;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

.input-content:focus {
  outline: 0;
  box-shadow: 0 0 0 2px rgb(33, 150, 243) inset;
}
</style>
