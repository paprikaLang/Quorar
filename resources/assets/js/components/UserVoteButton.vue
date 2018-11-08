<template>
    <button
            class="btn"
            v-bind:class="{'btn-primary': voted}"
            v-on:click="vote"
            style="height: 15px; line-height:6px; margin-left: 1px; border:none;"
    >{{voted_count}}
    </button>
</template>

<script>
    export default {
        props: ['answer','count'],
        mounted() {
            //请求数据在mounted, /api路由负责获取数据库的值,不参与MVC
            axios.get('/api/answer/'+ this.answer + '/votes/users').then(response => {
                this.voted = response.data.voted;
            })
        },
        data() {
            return {
                voted: false,
                voted_count: this.count //数据单向流动，子组件不能修改传递进来的props数据
            }
        },
        methods: {
            vote() {
                axios.post('/api/answer/vote',{'answer':this.answer}).then(response => {
                    this.voted = response.data.voted;
                    this.voted ? (this.voted_count ++) : (this.voted_count --);
                })
            }
        }
    }
</script>
