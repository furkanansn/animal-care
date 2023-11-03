<div class="menu">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                @foreach(config('bipati_menu.menu') as $val)
                    <li>
                        <a href="{{$val['link']}}">
                            <i class="iconsminds-{{$val['icon']}}"></i>
                            <span>{{$val['name']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sub-menu">
        <div class="scroll">
            @foreach(config('bipati_menu.submenu') as $key => $value)
                <ul class="list-unstyled" data-link="{{$key}}">
                    @foreach($value as $sub)
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#{{Str::slug($sub['title'])}}-collapse" aria-expanded="true"
                               aria-controls="collapseForms" class="rotate-arrow-icon opacity-50"><i
                                    class="simple-icon-arrow-down"></i> <span class="d-inline-block">{{$sub['title']}}</span></a>
                            <div id="{{Str::slug($sub['title'])}}-collapse" class="collapse {{isShouldShow($sub['sub']) ? 'show': null}}">
                                <ul class="list-unstyled inner-level-menu" style="display: none;">
                                    @foreach($sub['sub'] as $subMenu)
                                        <li class="{{route('web.'.$subMenu['route']) === url()->current() ? 'active' : null}}">
                                            <a href="{{route('web.'.$subMenu['route'])}}">
                                                <i class="{{$sub['icon']}}"></i>
                                                <span
                                                    class="d-inline-block">{{$subMenu['title']}}</span></a></li>
                                    @endforeach
                                    <i class="iconmind"></i>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</div>
