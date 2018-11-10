<template>
    <div>
        <button v-on:click="presentCommentsModal" type="button" class="btn btn-default" data-toggle="modal" :data-target="dialogJquery" style="margin-top: -6px;" >{{text}}</button>
        <div class="modal fade" :id="dialogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">评论列表</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                           <ul class="list-unstyled">
                               <li class="media" v-for="comment in comments">
                                   <img width="24px;" class="mr-3" :src="comment.user.avatar" alt="Generic placeholder image">
                                   <div class="media-body">
                                       <h5 class="mt-0 mb-1" style="color: darkgray;">{{comment.user.name}}</h5>
                                       {{comment.body}}
                                   </div>
                               </li>
                           </ul>

                    </div>
                    <div class="modal-footer">
                        <input type="text" class="form-control" v-model="body"/>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button v-on:click="sendcomment" type="button" class="btn btn-primary">评论</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type','model','count'],
        data() {
            return {
                body:'',
                mycount: this.count,
                comments: [],
                newComment: {
                    user: {
                        name: Quorar.name,
                        avatar: Quorar.avatar
                    },
                    body:''
                }
            }
        },
        mounted() {
            this.getComments();
        },
        computed: {
          dialogs() {
              return 'comments-dialog-' + this.type + this.model;
          },
          dialogJquery() {
              return '#'+ this.dialogs
          },
            text() {
              return this.mycount
            }
        },
        methods: {
            sendcomment() {
                axios.post('/api/comment',{'type':this.type,'model':this.model,'body':this.body}).then(response => {
                    this.newComment.body = response.data.body;
                    console.log(Quorar);
                    this.comments.push(this.newComment);
                    this.body = '';
                    this.mycount ++ ;
                })
            },
            presentCommentsModal() {
                this.getComments();
                $(this.dialogJquery).on('shown.bs.modal', function () {
                });
            },
            getComments() {
                axios.get('/api/'+ this.type + '/' + this.model + '/comments').then(response => {
                    this.comments = response.data;
                })
            }
        }
    }
</script>
