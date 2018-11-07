<template>
    <button
            class="btn btn-primary pull-left"
            v-bind:class="{'btn-success': followed}"
            v-text="text"
            v-on:click="follow"
    >
    </button>
</template>

<script>
    export default {
        props: ['user'],
        mounted() {
            //请求数据在mounted, /api路由负责获取数据库的值,不参与MVC
            axios.get('/api/user/followers/'+ this.user).then(response => {
                this.followed = response.data.followed;
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注':'关注他'
            }
        },
        methods: {
            follow() {
                axios.post('/api/user/follow',{'user':this.user}).then(response => {
                    this.followed = response.data.followed;
                    console.log(response.data.count);
                })
            }
        }
    }
</script>
