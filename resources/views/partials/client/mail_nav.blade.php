<!-- BEGIN SIDEBAR -->
<div class="page-sidebar mini mini-mobile" id="main-menu" data-inner-menu="1">
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrappers">
        <!-- BEGIN MINI-PROFILE -->
        <div class="user-info-wrapper">
            <div class="profile-wrapper">
                <img src="http://localhost:8000/assets/img/profiles/avatar.jpg"  alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" width="69" height="69" />
            </div>
            <div class="user-info">
                <div class="greeting">Welcome</div>
                <div class="username">John <span class="semi-bold">Smith</span></div>
                <div class="status">Status<a href="#"><div class="status-icon green"></div>Online</a></div>
            </div>
        </div>
        <!-- END MINI-PROFILE -->

        <!-- BEGIN MINI-WIGETS -->

        <!-- END MINI-WIGETS -->

        <!-- BEGIN SIDEBAR MENU -->
       @include('partials.school.nav')
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>

    <div class="inner-menu nav-collapse">
        <div id="inner-menu">
            <div class="inner-wrapper" >
                <a href="{{ url('/'.$school->username.'/client/mail/send/'.$client->id) }}" class="btn btn-block btn-primary" ><span class="bold">COMPOSE</span></a>
            </div>
            <div class="inner-menu-content">
                <p class="menu-title">FOLDER <span class="pull-right"><i class="icon-refresh"></i></span></p>
            </div>
            <ul class="big-items">
                <li class={{ ($title == "Inbox")? "active": "" }}><span class="badge badge-important">2</span><a href="{{ url('/'.$school->username.'/client/mail/'.$client->id) }}" > Inbox</a></li>
                <li class={{ ($title == "Sent")? "active": "" }}><a href="{{ url('/'.$school->username.'/client/mail/sent/'.$client->id) }}">Sent</a></li>
                <li class={{ ($title == "Trash")? "active": "" }}><a href="{{ url('/'.$school->username.'/client/mail/'.$client->id.'/trash/') }}">Trash</a></li>
            </ul>
            <ul class="small-items">
                <li class=""><a href="#" > Home</a></li>
                <li><span class="badge badge-important">2</span><a href="#"> Work</a></li>
            </ul>
            <div class="inner-wrapper" >
                <p class="menu-title">QUICK VIEW</p>
            </div>
            <ul class="small-items">
                <li class=""><a href="#"> Documents</a></li>
                <li class=""><span class=" badge badge-disable ">203</span><a href="#"> Images</a></li>
                <li class=""><a href="#"> Flagged</a></li>
            </ul>
        </div>
    </div>
</div>
<a href="#" class="scrollup">Scroll</a>
<!-- END SIDEBAR -->