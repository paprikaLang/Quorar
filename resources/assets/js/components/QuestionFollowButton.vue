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
        props: ['question'],
        mounted() {
            //请求数据在mounted, /api路由负责获取数据库的值,不参与MVC
            axios.post('/api/question/follower',{'question':this.question}).then(response => {
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
                return this.followed ? '已关注':'关注问题'
            }
        },
        methods: {
            follow() {
                axios.post('/api/question/follow',{'question':this.question}).then(response => {
                    this.followed = response.data.followed;
                    console.log(response.data.count);
                })
            }
        }
    }
</script>
