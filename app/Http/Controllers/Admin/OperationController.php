<?php

namespace App\Http\Controllers\Admin;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;

class OperationController extends AdminBaseController
{

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = Operation::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Ameliyatlar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Ameliyat Adı' => 'name',
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Ameliyat';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Ameliyatlar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.operation.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.operation.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.operation.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.operation.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.operation.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.operation.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'Ameliyatı';

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
            returnFilterFields('name', 'Ameliyat adı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'name', $placeholder = 'Ameliyat Adı', $type = 'text'),
        ]);
    }

}
