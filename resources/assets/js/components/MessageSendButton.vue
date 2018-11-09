<template>
    <div>
        <button v-on:click="presentModal" type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@poster">发送私信</button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea v-model="msgbody" class="form-control" id="message-text" v-if="!status"></textarea>
                                <div class="alert alert-success" v-if="status">
                                    <strong>私信发送成功</strong>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button v-on:click="send" type="button" class="btn btn-primary">发送</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                name: '',
                msgbody:'',
                status: false
            }
        },
        mounted() {
            axios.get('/api/user/send/'+ this.user).then(response => {
                this.name = response.data.name;
            })
        },
        methods: {
            send() {
                axios.post('/api/message/store',{'user':this.user,'body':this.msgbody}).then(response => {
                    this.status = response.data.status;
                    setTimeout(function () {
                        $('#exampleModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    },2000);

                })
            },
            presentModal() {
                const name = this.name;
                this.status = false;
                this.msgbody = '';
                $('#exampleModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget); // Button that triggered the modal
                    const recipient = button.data('whatever'); // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    const modal = $(this);
                    modal.find('.modal-title').text('私信 to ' + name);
                    modal.find('.modal-body input').val('@'+name);
                })
            }
        }
    }
</script>
