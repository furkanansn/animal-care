<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>BiPati Giriş Ekranı</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{asset('')}}font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="{{asset('')}}font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="{{asset('')}}css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('')}}css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="{{asset('')}}css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="{{asset('')}}css/main.css" />
</head>

<body class="background show-spinner no-footer">
<div class="fixed-background"></div>
<main>
    <div class="container">
        <div class="row h-100">
            <div class="col-12 col-md-10 mx-auto my-auto">
                <div class="card auth-card">
                    <div class="position-relative image-side ">

                        <p class=" text-white h2">SİHİRLER AYRINTILARIN İÇİNDEDİR</p>

                        <p class="white mb-0">
                            Lütfen giriş yapın.
                        </p>
                    </div>
                    <form action="{{route('web.login.operation')}}" method="post" class="col-12">
                        <div class="form-side">
                            <a href="javascript:void(0)">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Giriş</h6>
                            @if($errors->any())
                                <script>
                                    alert("{{$errors->first()}}")
                                </script>
                            @endif
                            <form>
                                <label class="form-group has-float-label mb-4">
                                    <input name="email" oninvalid="this.setCustomValidity('Lütfen geçerli bir e-posta adresi giriniz.')" type="email" class="form-control" />
                                    <span>E-posta</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="password" type="password" placeholder="" />
                                    <span>Parola</span>
                                </label>
                                @csrf
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">GİRİŞ YAP</button>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{asset('')}}js/vendor/jquery-3.3.1.min.js"></script>
<script src="{{asset('')}}js/vendor/bootstrap.bundle.min.js"></script>
<script src="{{asset('')}}js/dore.script.js"></script>
<script src="{{asset('')}}js/scripts.js"></script>
</body>

</html>
