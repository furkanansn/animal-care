@extends('admin._layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Ekle</h5>
                    {{html()->form('POST', $postRoute)->acceptsFiles()->open()}}
                    <div class="row justify-content-center">
                        @foreach($inputs->chunk($col) as $chunk)
                            @foreach($chunk as $input)
                                <div class="form-group col-md-{{12 / count($chunk)}}">
                                    {!! $input !!}
                                </div>
                            @endforeach
                        @endforeach
                        <div class="col-md-12 mt-3 text-center">
                            {{ html()->button('Kaydet')->type('submit')->class('btn btn-success') }}
                        </div>
                    </div>
                    {{html()->form()->close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@section('customJs')--}}
{{--    <script>--}}
{{--        $(() => {--}}
{{--            const sehir = document.querySelector('#sehir_key')--}}
{{--            const ilceQuery = document.querySelector('#ilce_key')--}}
{{--            const ilce = $('#ilce_key')--}}
{{--            const district = $('#district_id')--}}

{{--            sehir.addEventListener('change', async e => {--}}
{{--                let key = e.target.value--}}
{{--                const url = '{{route('api.cities.ilce', ['id' => 34])}}'--}}
{{--                const nextUrl = url.replace('34', key)--}}
{{--                const data = await fetch(nextUrl).then(res => res.json())--}}
{{--                ilce.find('option').remove().end()--}}
{{--                ilce.attr('readonly', false)--}}
{{--                district.find('option').remove().end()--}}
{{--                const name = $("#sehir_key option:selected").text();--}}
{{--                ilce.append($('<option>', {value: 0, text: `${name} için ilçe seçin`}))--}}
{{--                data.data.data.forEach(data => {--}}
{{--                    ilce.append($('<option>', {value:data.ilce_key, text:data.ilce_title}));--}}
{{--                })--}}
{{--            })--}}

{{--            ilceQuery.addEventListener('change', async function (e) {--}}
{{--                let key = e.target.value--}}
{{--                const url = '{{route('api.cities.mahalle', ['id' => 34])}}'--}}
{{--                const nextUrl = url.replace('34', key)--}}
{{--                const data = await fetch(nextUrl).then(res => res.json())--}}
{{--                district.find('option').remove().end()--}}
{{--                const name = $("#ilce_key option:selected").text();--}}
{{--                district.append($('<option>', {value: 0, text: `${name} için mahalle seçin`, selected: true}))--}}
{{--                data.data.data.forEach(data => {--}}
{{--                    district.append($('<option>', {value:data.mahalle_key, text:data.mahalle_title}));--}}
{{--                })--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
