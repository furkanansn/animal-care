<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Sehir;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class EventController extends AdminBaseController
{
    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = Event::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'Etkinlikler';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Başlık' => 'title',
        'İçerik' => 'content',
        'Tarih' => 'event_date',
        'Şehir' => [
            'city' => 'sehir_title'
        ]
    ];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = 'Etkinlik';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'Etkinlikler';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.event.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.event.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.event.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.event.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.event.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.event.destroy';

    /**
     * @var string
     */
    public string $tooltipName = 'etkinliği';

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
            returnFilterFields('title', 'Event adı', 'text'),
        ];
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs($name = 'title', $placeholder = 'Etkinlik Başlığı', $type = 'text'),
            $inputs($name = 'content', $placeholder = 'İçerik', $type = 'textarea'),
            $inputs($name = 'event_date', $placeholder = 'Etkinlik Tarihi (Örn: 12:00)', $type = 'date'),
            $inputs($name = 'location', $placeholder = 'Şehir', $type = 'select', false, true, Sehir::all()->pluck('sehir_title', 'sehir_key')),
            $inputs($name = 'images[]', $placeholder = 'Galeri', $type = 'file'),
        ]);
    }
}
