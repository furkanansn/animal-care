<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sehir;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends AdminBaseController
{

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = User::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Kullanıcılar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'İsim' => 'name',
        'E-posta' => 'email',
        'Telefon Numarası' => 'phone_number',
        'Adres' => [
            'district' => 'mahalle_title',
            'county' => 'ilce_title',
            'city' => 'sehir_title'
        ],
        'Son Hareket Tarihi' => 'last_activity',
        'Son Giriş Tarihi' => 'last_login_time',
        'Kullanıcı Türü' => 'is_personal_string',
        'Onay Durumu' => 'is_approved'
    ];

    /**
     * Modelden çekilecek sütunlar
     *
     * @var array
     */
    public array $modelTitle = [
        'name',
        'email',
        'phone_number',
        'district_id'
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Kullanıcı';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Kullanıcılar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.user.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.user.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.user.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.user.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.user.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.user.destroy';

    /**
     * @var array|string[]
     */
    public array $with = ['county', 'city', 'district'];

    /**
     * @var string
     */
    public string $tooltipName = 'kullanıcıyı';

    /**
     * @var string
     */
    public string $tooltipTitle = 'name';

    public bool $canAdminAddData = true;

    public int $col = 3;

    public string $create = 'admin.users.add';

    public function setFilter(): void
    {
        $this->filters = setFilter(['name', 'like', null], ['is_personal', 'exact', null], ['is_approved', 'exact', null]);
    }

    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [
            returnFilterFields('name', 'İsim', 'text', null),
            returnFilterFields('is_personal', 'Kullanıcı Türü', 'select', ['0' => 'Kurumsal', 1 => 'Bireysel']),
            returnFilterFields('is_approved', 'Kullanıcı Onay Durumu', 'select', ['0' => 'Onaylanmamış', 1 => 'Onaylanmış'])
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'name', $placeholder = 'İsim', $type = 'text'),
            $inputs($name = 'email', $placeholder = 'E-Posta', $type = 'email'),
            $inputs('password', 'Parola', 'password'),
            $inputs('phone_number', 'Telefon Numarası (Örn:+905055112333)', 'text'),
            $inputs('sehir_key', 'Şehir Seçin', 'select', false, true, Sehir::all()->pluck('sehir_title', 'sehir_key')),
            $inputs('ilce_key', 'İlçe Seçin', 'select', true, true),
            $inputs('district_id', 'Mahalle Seçin', 'select', false, true),
            $inputs('is_personal', 'Kurumsal mi', 'hidden', true, true, 0),
        ]);
    }

}
