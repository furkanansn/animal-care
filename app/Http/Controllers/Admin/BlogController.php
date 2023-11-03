<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\DataBank;
use App\Models\DataBankCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BlogController extends AdminBaseController
{
    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = DataBank::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Yazılar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Başlık' => 'title',
        'İçerik' => 'content',
        'Görüntülenme Sayısı' => 'show_count'
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Blog';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Bloglar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.blog.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.blog.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.blog.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.blog.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.blog.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.blog.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'blog yazısını';

    /**
     * @var string
     */
    public string $tooltipTitle = 'title';

    public function setFilter(): void
    {
        $this->filters = setFilter(['title', 'like', null]);
    }

    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [
            returnFilterFields('title', 'Blog başlığı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'title', $placeholder = 'Blog Başlığı', $type = 'text'),
            $inputs($name = 'content', $placeholder = 'İçerik', $type = 'textarea'),
            $inputs($name = 'category_id', $placeholder = 'Kategori', $type = 'select', false, true, DataBankCategory::all()->pluck('name', 'id')),
        ]);
    }
}
