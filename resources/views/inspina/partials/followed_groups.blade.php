                        <div class="ibox float-e-margins">
                            <div class="ibox-title blue-skin" style="color: #ffffff;" data-toggle="tooltip" data-placement="bottom" title="This are the groups you are currently part of.">
                                <i class="fa fa-group"></i> My Groups
                            </div>
                            <div class="ibox-content">
                                <div class="file-manager">

                                    <ul class="folder-list" style="padding: 0">
                                    @if($user->followedGroups()->count() != 0)
                                    @foreach($user->followedGroups() as $group)
                                        <li><a href="{{$group->username}}"><i class="fa fa-group"></i> {{ $group->name }}

                                        <i class="badge badge-default pull-right">{{ $group->followersCount() }}</i>

                                        </a></li>
                                    @endforeach
                                    @else
                                        <h3 align="center">Follow New Groups :)</h3>
                                        <li><a href=""> </a></li>
                                    @endif
                                        <li class="text-center" ><a href="{{url('/groups/all')}}" style="color: #0000cc"><i class="fa fa-info-circle"></i> Join New Group</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>