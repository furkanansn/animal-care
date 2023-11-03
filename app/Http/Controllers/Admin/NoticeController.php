<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ilce;
use App\Models\Notice;
use App\Models\Sehir;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoticeController extends AdminBaseController
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
    public string $model = Notice::class;

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = 'İhbarlar';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [
        'Başlık' => 'title',
        'İçerik' => 'content',
        'Görüntülenme Sayısı' => 'view_count',
        'Yönlendirilen Kişi' => [
            'forward' => 'name'
        ],
        'İhbar Yapan Kişi' => [
            'user' => 'name'
        ],
        'İhbarı Yapılan Hayvan' => [
            'animal' => 'name'
        ],
        'İhbar Fotoğrafı' => 'image'
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
    public string $singularName = 'İhbar';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = 'İhbarlar';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = 'web.notice.index';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = 'web.notice.create';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = 'web.notice.store';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = 'web.notice.edit';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = 'web.notice.update';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = 'web.notice.destroy';

    /**
     * @var array|string[]
     */
    public array $with = ['user', 'animal', 'district'];

    /**
     * @var string
     */
    public string $tooltipName = 'ihbarı';

    /**
     * @var string
     */
    public string $tooltipTitle = 'title';

    public bool $canAdminAddData = false;

    public function setFilter(): void
    {
        $this->filters = setFilter(['title', 'like', null], ['user_id', 'exact', null], ['sehir_key', 'exact', null], ['ilce_key', 'exact', null]);
    }

    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [
            returnFilterFields('title', 'Başlık', 'text'),
            returnFilterFields('user_id', 'Kullanıcıya Göre', 'select', multipleToOneArray(User::all(['id', 'name'])->toArray())),
            returnFilterFields('sehir_key', 'Şehire Göre', 'select', multipleToOneArray(Sehir::all(['sehir_key', 'sehir_title'])->toArray())),
            returnFilterFields('ilce_key', 'İlçeye Göre', 'select', multipleToOneArray(Ilce::all(['ilce_key', 'ilce_title'])->toArray()))
        ];
    }

    /**
     * @param Request $request
     * @param string $data
     * @return JsonResponse
     */
    public function updateAjax(Request $request, string $data): JsonResponse
    {
        $data = explode('-', $data);
        $noticeId = $data[0];

        $notice = Notice::findOrFail($noticeId);

        if (!$data[1]) $data[1] = null;

        $notice->update([
            'forward_who' => $data[1],
            'noticed_time' => $data[1] ? time() : null
        ]);

        if ( ! $data[1]) {
            return $this->sendSuccess(['msg' => 'İhbar boşa çıkarıldı!']);
        }

        $who = $notice->forward->name;

        $userFcmToken = $notice->user?->fcm_token;

        if ( ! is_null($userFcmToken)) {
            sendNotification([$userFcmToken], 'İhbarınız yönlendirildi!', "İhbarınız yöneticiler tarafından $who adlı belediyeye yönlendirildi!");
        }
        return $this->sendSuccess(['msg' => "İhbar $who adlı belediyeye yönlendirildi!"]);
    }

    public function setInputs(Model $model): void
    {
        $inputs = setInput($model);
        $this->inputs = collect([
            $inputs('')
        ]);
    }
}
