<?php

namespace App\Http\Controllers\Admin;

use App\Models\NoticeType;
use Illuminate\Database\Eloquent\Model;

class NoticeTypeController extends AdminBaseController
{

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = NoticeType::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'İhbar Türleri';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'İhbar Türü Adı' => 'name',
        'Güncellenme Tarihi' => 'updated_at',
        'Eklenme Tarihi' => 'created_at'
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'İhbar Türü';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'İhbar Türleri';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.notice-type.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.notice-type.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.notice-type.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.notice-type.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.notice-type.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.notice-type.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'ihbar türünü';

    /**
     * @var string
     */
    public string $tooltipTitle = 'name';

    public function setFilter(): void
    {
        $this->filters = setFilter(['name', 'like', null]);
    }

    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [
            returnFilterFields('name', 'İhbar türü adı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'name', $placeholder = 'İhbar türü Adı', $type = 'text'),
        ]);
    }

}
