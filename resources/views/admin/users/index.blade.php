@extends('admin._layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="jumbotron">
                        <h1 class="display-4">{{$pageTitle}} için filtreler
                            @if(count($data) > 0)
                                <h6>(Toplam {{count($data)}} {{mb_strtolower($singularName)}} bulundu)</h6>
                            @else
                                <h6 class="text-danger">(Aranan kriterlere uygun {{mb_strtolower($singularName)}} bulunamadı)</h6>
                            @endif
                        </h1>
                        @if(request()->fullUrl() !== route($indexRoute))
                            <button id="reset-form" class="btn btn-outline-danger offset-6">Temizle</button>
                        @endif
                        <hr class="my-4">
                        <form id="form" action="{{route($indexRoute)}}" class="col-md-12" method="GET">
                            <div class="row">
                                @foreach(filterGenerator($filters)->chunk(4) as $filter)
                                    @foreach($filter as $val)
                                        <div class="col-md-{{12 / count($filter)}}">
                                            <div class="form-group">
                                                {!! $val !!}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                                <div class="col-md-6 offset-6">
                                    <button type="submit" class="btn btn-outline-secondary">Filtrele</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4 data-table-rows data-tables-hide-filter">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    @foreach($tableTitle as $key => $title)
                        <th class="text-center" scope="col">{{$key}}</th>
                    @endforeach
                    <th scope="col">İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <th class="text-center" scope="row">{{$d->id}}</th>
                        @foreach($tableTitle as $title)
                            @if(!is_array($title))
                                @if ($title === 'image')
                                    <td class="text-center"><img height="100" width="100" src="{{route('show.photo').'?path='.$d->$title}}"/></td>
                                @else
                                    <td @if(strlen($d->$title) > 100) data-toggle="tooltip"
                                        data-placement="top" data-original-title="Bu veri kırpıldı. Devamını görmek için gözata basın." @endif
                                        class="text-center">{!! isBool($d->$title) !!}</td>
                                @endif
                            @else
                                <td data-toggle="tooltip" class="text-center" data-placement="top"
                                    data-original-title="{{$d->address}}">
                                    @foreach($title as $key => $val)
                                        @if($key === 'forward')
                                            @php
                                                $forwards = \App\Models\User::where('is_personal', 0)->get();
                                            @endphp
                                            @if(!count($forwards))
                                                Herhangi bir belediye kayıtlı değil!
                                            @else
                                            <select name="forward" id="forward" class="form-control">
                                                <option value="{{$d->id}}-0">Belediye seçin</option>
                                                @foreach($forwards as $forward)
                                                    <option
                                                        @if ($forward->id === $d->forward_who)
                                                            selected
                                                        @endif
                                                        value="{{$d->id}}-{{$forward->id}}">{{$forward->name}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        @else
                                        {{ $d?->$key?->$val ?? '-'}}
                                            @if( ! $loop->last) /
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            @endif
                        @endforeach
                        <td>
                            <a href="{{route($destroy, ['id' => $d->id])}}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top"
                               data-original-title="{{$d[$tooltipTitle]}} adlı {{mb_strtolower($tooltip)}} sil"><i
                                    class="simple-icon-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-12 text-center">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
    <script>
        $(() => {
            const select = document.getElementsByName('forward')
            select.forEach(sel => {
                sel.addEventListener('change', async e => {
                    const val = e.target.value
                    const url = '{{route('web.update.ajax', ['data' => 'hakan'])}}'
                    const lastUrl = url.replace('hakan', val)
                    console.log(lastUrl)
                    if (val) {
                        const response = await fetch(lastUrl, {
                            headers : {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }

                        }).then(r => r.json())

                        if (response.error) {
                            var msg = 'İhbar yönlendirilemedi!'
                        } else {
                            var msg = response.data.msg
                        }

                        iziToast.show({
                            title: 'Sistem Bildirimi',
                            message: msg,
                            position: 'topRight',
                            progressBar: false
                        });

                    }

                })
            })
            const btn = document.querySelector('#reset-form')
            if (btn) {
            btn.addEventListener('click', (e) => {
                    location.href = "{{route($indexRoute)}}"
                })
            }
        })
    </script>
    @if(session()->has('alert'))
        <script>
            iziToast.{{session()->get('alert')['type']}}({
                title: 'Sistem Bildirimi',
                message: '{{session()->get('alert')['msg']}}',
                position: 'topRight',
                progressBar: false
            });
        </script>
    @endif
@endsection
