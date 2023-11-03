<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Ilce;
use App\Models\Notice;
use App\Models\Sehir;
use App\Models\User;
use Illuminate\Http\Request;

class AnimalController extends AdminBaseController
{
    /**
     * İlgili controller listeleme view'i.
     *
     * @var string
     */
    public string $list = 'admin.users.index';

    /**
     * İlgili controller veri ekleme/güncelleme view'i.
     *
     * @var string
     */
    public string $create = '';

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = Animal::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Hayvanlar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Hayvan Adı' => 'name',
        'Hayvan Türü' => 'kind',
        'Hayvan Cinsi' => 'type',
        'Hayvan Sahibi' => [
            'user' => 'name'
        ],
        'Fotoğraf' => 'image'
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
    public string $singularName = 'Hayvan';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Hayvanlar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.animal.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.animal.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.animal.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.animal.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.animal.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.animal.destroy';

    /**
     * @var array|string[]
     */
    public array $with = [];

    /**
     * @var string
     */
    public string $tooltipName = 'hayvanı';

    /**
     * @var string
     */
    public string $tooltipTitle = 'name';

    public bool $canAdminAddData = false;

    public function setFilter(): void
    {
        $this->filters = setFilter(['name', 'like', null]);
    }

    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [
            returnFilterFields('name', 'Hayvan Adına Göre', 'text'),
        ];
    }
}
