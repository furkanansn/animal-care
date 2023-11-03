@extends('admin._layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Bağış {{isset($method) ? 'Güncelle' : 'Ekle'}}</h5>
                    {{html()->form('POST', $postRoute)->open()}}
                    <div class="row justify-content-center">
                        <div class="form-group col-md-4">
                            {!! html()->select('user_id')->value(isset($data) ? $data->user_id : null)->options(\App\Models\User::all()->pluck('name', 'id'))->placeholder('Kullanıcı')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->number('money_count')->value(isset($data) ? $data->money_count : null)->placeholder('Tutar')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->select('animal_type_id')->value(isset($data) ? $data->animal_type_id : null)->options(\App\Models\AnimalKind::all()->pluck('name', 'id'))->placeholder('Hayvan Türü')->class('form-control')->required(true) !!}
                        </div>
                        @if (! isset($data))
                            <div class="form-group col-md-4">
                                {!! html()->select('sehir_key')->placeholder('Şehir Seçin')->value(isset($data) ? $data->sehir_key : null)
                                    ->class('form-control')->required(true)->options(\App\Models\Sehir::all()->pluck('sehir_title', 'sehir_key')) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!!
                                    html()->select('ilce_key')->placeholder('İlçe Seçin')->value(isset($data) ? $data->ilce_key : null)
                                    ->class('form-control')->required(true)
                                !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! html()->select('district_id')->placeholder('Mahalle Seçin')->value(isset($data) ? $data->district_id : null)
                                    ->class('form-control')->required(true) !!}
                            </div>
                        @endif
                        <div class="form-group col-md-12">
                            {!! html()->select('is_donated')
                                ->options(['Bağış Yapılmadı', 'Bağış Yapıldı'])
                            ->class('form-control')->required(true)->value(isset($data) ? $data->is_donated : null) !!}
                        </div>
                        <div class="col-md-12 mt-3 text-center">
                            {{ html()->button(isset($method) ? 'Güncelle' : 'Ekle')->type('submit')->class('btn btn-success') }}
                        </div>
                    </div>
                    {{html()->form()->close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
    <script>
        $(() => {
            const sehir = document.querySelector('#sehir_key')
            const ilceQuery = document.querySelector('#ilce_key')
            const ilce = $('#ilce_key')
            const district = $('#district_id')

            sehir.addEventListener('change', async e => {
                let key = e.target.value
                const url = '{{route('api.cities.ilce', ['id' => 34])}}'
                const nextUrl = url.replace('34', key)
                const data = await fetch(nextUrl).then(res => res.json())
                ilce.find('option').remove().end()
                ilce.attr('readonly', false)
                district.find('option').remove().end()
                const name = $("#sehir_key option:selected").text();
                ilce.append($('<option>', {value: 0, text: `${name} için ilçe seçin`}))
                data.data.data.forEach(data => {
                    ilce.append($('<option>', {value: data.ilce_key, text: data.ilce_title}));
                })
            })

            ilceQuery.addEventListener('change', async function (e) {
                let key = e.target.value
                const url = '{{route('api.cities.mahalle', ['id' => 34])}}'
                const nextUrl = url.replace('34', key)
                const data = await fetch(nextUrl).then(res => res.json())
                district.find('option').remove().end()
                const name = $("#ilce_key option:selected").text();
                district.append($('<option>', {value: 0, text: `${name} için mahalle seçin`, selected: true}))
                data.data.data.forEach(data => {
                    district.append($('<option>', {value: data.mahalle_key, text: data.mahalle_title}));
                })
            })
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
