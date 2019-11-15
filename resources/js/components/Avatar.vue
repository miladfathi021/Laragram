<template>
    <div class="relative rounded-full" style="width: 150px; height: 150px">
        <img :src="avatarSrc" :alt="user.name" @mouseover="visible = true" class="rounded-full" style="width: 150px; height: 150px">
        <input type="file" name="avatar" class="hidden" id="avatar" @change="uploadAvatar">
        <span
            @mouseleave="visible = false"
            @click="openForm"
            v-if="visible"
            class="absolute text-white inline-flex bg-indigo-700 cursor-pointer shadow-lg text-2xl rounded-full w-full h-full items-center justify-center top-0" style="background-color: rgba(0,0,0,.5);">
            <i class="la la-plus-circle"></i>
        </span>
    </div>

</template>

<script>
    export default {
        name: "Avatar",
        props: ['user'],

        data () {
            return {
                person: null,
                visible: false
            }
        },

        created() {
            this.person = this.user;
        },

        computed: {
            avatarSrc () {
                return this.person.avatar ? '/storage/' + this.person.avatar : '/images/avatar.svg'
            }
        },
        methods: {
            openForm () {
                document.getElementById('avatar').click();
            },
            uploadAvatar (e) {
                let formData = new FormData();

                formData.append('avatar', e.target.files[0]);

                axios.post('/users/' + this.user.id + '/avatars', formData).then(res => {
                    if (res.data.status == 201) {
                        this.person.avatar = res.data.user.avatar;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
