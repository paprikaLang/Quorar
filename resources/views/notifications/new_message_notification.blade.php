<li class="notifications {{ $notification->unread() ? 'unread' :' ' }}" style="padding: 2px 10px;">
    <a href="#" style="text-decoration: none; color: #FF0A5A;">
        {{ $notification->data['name'] }}</a> 给你发了一条
    <a href="{{ $notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/inbox/'.$notification->data['dialog'] : '/inbox/'.$notification->data['dialog']}}" style="text-decoration: none; color: #FF0A5A;">
        私信 </a> .
    <span class="pull-right" style="color: #787878">{{$notification->created_at->format('m-d H:i')}}</span>
</li>