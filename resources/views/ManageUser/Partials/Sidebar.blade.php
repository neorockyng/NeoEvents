<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content">
        
        <h5 class="heading">@lang('basic.menu')</h5>
        <ul id="nav_event" class="topmenu">
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a href="{{route('showUserDashboard', array('user_id' => $user->id))}}">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">@lang("basic.dashboard")</span>
                </a>
            </li>
            <li class="{{ Request::is('*tickets*') ? 'active' : '' }}">
                <a href="{{route('showUserTickets', array('user_id' => $user->id))}}">
                    <span class="figure"><i class="ico-ticket"></i></span>
                    <span class="text">@lang("basic.tickets")</span>
                </a>
            </li>
            
            
        </ul>
        
    </section>
</aside>
