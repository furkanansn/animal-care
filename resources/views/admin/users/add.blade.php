@extends('admin._layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Ekle</h5>
                    {{html()->form('POST', $postRoute)->open()}}
                    <div class="row justify-content-center">
                        <div class="form-group col-md-4">
                            {!! html()->text('name')->placeholder('İsim')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->email('email')->placeholder('E-Posta')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->password('password')->placeholder('Parola')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->text('phone_number')->placeholder('Telefon numarası, örn: +905051231211')->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->select('sector_id')->placeholder('Sektör Seçin')
                                ->class('form-control')->required(true)->options(\App\Models\Sector::all()->pluck('name', 'id')) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->select('sehir_key')->placeholder('Şehir Seçin')
                                ->class('form-control')->required(true)->options(\App\Models\Sehir::all()->pluck('sehir_title', 'sehir_key')) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!!
                                html()->select('ilce_key')->placeholder('İlçe Seçin')
                                ->class('form-control')->required(true)
                            !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->select('district_id')->placeholder('Mahalle Seçin')
                                ->class('form-control')->required(true) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! html()->hidden('is_personal')
                                ->class('form-control')->required(true)->value(0) !!}
                        </div>
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
@endsection
