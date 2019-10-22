<template>
    <div>
        <file-uploader @uploaded="attachToPosts"></file-uploader>
        <div class="flex flex-wrap -ml-6">
            <div class="w-1/3 mb-12" v-for="post of posts">
                <div class="px-6">
                    <div class="image--header flex align-center">
                        <div @click="deletePost(post.id)" class="ml-auto">
                            <i class="fas fa-trash block p-3 cursor-pointer text-gray-800 text-lg"></i>
                        </div>
                    </div>
                    <img class="image" :src="post.path" alt="">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FileUploader from "../components/FileUploader";

    export default {
        components: {FileUploader},
        props: ['data'],

        data () {
            return {
                posts: []
            }
        },

        created () {
            this.posts = this.data;
        },

        methods: {
            attachToPosts (post) {
                this.posts.unshift(post);
            },
            deletePost (id) {
                axios.delete('/posts/' + id).then(response => {
                    this.posts = this.posts.filter(post => {
                        return post.id != id;
                    })
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
