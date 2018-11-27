<li class="notifications {{ $notification->unread() ? 'unread' :' ' }}" style="padding: 2px 10px;">
    <a href="#" style="text-decoration: none; color: #FF0A5A;">
        {{ $notification->data['name'] }}</a> 关注了你. <span class="pull-right" style="color: #787878">{{$notification->created_at->format('m-d H:i')}}</span>
</li>