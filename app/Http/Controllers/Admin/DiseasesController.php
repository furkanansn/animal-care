<?php

namespace App\Http\Controllers\Admin;

use App\Models\Disease;
use Illuminate\Database\Eloquent\Model;

class DiseasesController extends AdminBaseController
{

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = Disease::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Hastalıklar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Hastalık Adı' => 'name',
        'Güncellenme Tarihi' => 'updated_at',
        'Eklenme Tarihi' => 'created_at'
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Hastalık';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Hastalıklar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.disease.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.disease.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.disease.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.disease.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.disease.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.disease.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'hastalığı';

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
            returnFilterFields('name', 'Hastalık adı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'name', $placeholder = 'Hastalık Adı', $type = 'text'),
        ]);
    }

}
