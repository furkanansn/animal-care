<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\DataBankCategory;
use Illuminate\Database\Eloquent\Model;

class CategoryController extends AdminBaseController
{

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = DataBankCategory::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Kategoriler';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Kategori Adı' => 'name',
        'Güncellenme Tarihi' => 'updated_at',
        'Eklenme Tarihi' => 'created_at'
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Kategori';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Kategoriler';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.category.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.category.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.category.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.category.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.category.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.category.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'kategoriyi';

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
            returnFilterFields('name', 'Kategori adı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'name', $placeholder = 'Kategori Adı', $type = 'text'),
        ]);
    }

}
