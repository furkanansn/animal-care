<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1>{{$pageTitle}} </h1>
            </div>
            @if($canAdd)
                <div class="col-6 text-right">
                    <h1>
                        @if( ! str_ends_with(request()->path(), 'ekle') || ! strpos(request()->url(), 'duzenle'))
                            <a href="{{route($createRoute)}}" class="btn btn-danger">Yeni {{mb_strtolower($singularName)}} ekle</a>
                        @else
                            <a href="{{route($indexRoute)}}" class="btn btn-primary">{{$singularName}} Listesi</a>
                        @endif
                    </h1>
                </div>
            @endif
            <div class="col-12">
                <div class="separator mb-5">
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</main>
