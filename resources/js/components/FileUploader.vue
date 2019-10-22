<template>
    <div class="file-uploader">
        <label class="block w-full h-32 flex text-center items-center justify-center px-4">
            <div class="text-6xl border-dashed w-full relative h-24">
                <p class="text-white absolute">+</p>
            </div>
            <input @change="change" type="file" class="hidden">
        </label>
        <div class="flex items-center">
            <button @click="send" class="btn btn-primary my-4 text-white shadow-md">Create Post</button>
            <span class="feedback feedback--invalid ml-6" v-if="errors.has('image')">{{ errors.get('image') }}</span>
        </div>
    </div>
</template>

<script>
    class Errors
    {
        constructor () {
            this.errors = {};
        }

        record(errors) {
            this.errors = errors;
        }

        has (key) {
            return key in this.errors;
        }

        get (key) {
            return this.errors[key][0];
        }
    }

    export default {
        data () {
            return {
                image: '',
                errors: new Errors()
            }
        },
        methods: {
            change(e) {
                this.image = e.target.files[0];
            },
            send() {
                let data = new FormData();
                data.append('image', this.image);

                axios.post('/posts', data).then(response => {
                    this.$emit('uploaded', response.data);
                    this.errors = new Errors();
                    this.image = '';
                }).catch(error => {
                    this.errors.record(error.response.data.errors);
                });
            }
        }
    }
</script>

<style scoped>

</style>
