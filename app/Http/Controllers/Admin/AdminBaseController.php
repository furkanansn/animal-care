<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class AdminBaseController extends Controller
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
    public string $create = 'admin.users.edit';

    /**
     * İlgili controller model'i
     *
     * @var string
     */
    public string $model = '';

    /**
     * Anlık sayfa başlığı.
     *
     * @var string
     */
    public string $pageTitle = '';

    /**
     * Tablo başlıkları
     *
     * @var array
     */
    public array $listTitle = [];

    /**
     * Modelden çekilecek sütunlar
     *
     * @var array
     */
    public array $modelTitle = [];

    /**
     * İlgili veri, tekil adı.
     *
     * @var string
     */
    public string $singularName = '';

    /**
     * İlgili veri, çoklu adı.
     *
     * @var string
     */
    public string $pluralName = '';

    /**
     * İlgili controller'in listeleme için route adı.
     *
     * @var string
     */
    public string $listRouteName = '';

    /**
     * İlgili controller'in veri ekleme formu için route adı.
     *
     * @var string
     */
    public string $createRouteName = '';

    /**
     * İlgili controller'in veri ekleme için route adı.
     *
     * @var string
     */
    public string $storeRouteName = '';

    /**
     * İlgili controller'in veri güncelleme formu için route adı.
     *
     * @var string
     */
    public string $editRouteName = '';

    /**
     * İlgili controller'in veri güncelleme için route adı
     *
     * @var string
     */
    public string $updateRouteName = '';

    /**
     * İlgili controller'in veri silme için route adı.
     *
     * @var string
     */
    public string $destroyRouteName = '';

    /**
     * @var array
     */
    public array $filters = [];

    /**
     * @var array
     */
    public array $with = [];

    /**
     * @var array
     */
    public array $htmlFilters = [];

    /**
     * @var string
     */
    public string $tooltipName = '';

    /**
     * @var string
     */
    public string $tooltipTitle = '';

    /**
     * İlgili controllerde veriler için input değerleri.
     *
     * @var Collection
     */
    public Collection $inputs;

    /**
     * @var bool
     */
    public bool $canAdminAddData = true;

    /**
     * @var int
     */
    public int $col = 4;

    public function __construct()
    {
        $this->setHtmlFilter();
        $this->setFilter();
        $this->sharedView();
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data = $this->filteredData($request->query());
        return response()->view($this->list, ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $model = new $this->model;
        $this->setInputs($model);
        return response()->view($this->create, [
            'postRoute' => route($this->createRouteName),
            'inputs' => $this->inputs,
            'col' => $this->col
        ]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $input = $request->except('_token', 'images[]');
        $data = $this->model::create($input);
        $alert = setFlashData("$this->singularName başarıyla eklendi!");

        if (!$data) {
            $alert = setFlashData("$this->singularName eklenemedi!", false);
        }

        $files = $request->allFiles();
        $this->uploadPhotos($files, $data);

        session()->flash('alert', $alert);
        return redirect()->route($this->listRouteName);
    }

    /**
     * @param array $files
     * @param Model|null $model
     */
    protected function uploadPhotos(array $files, ?Model $model): void
    {
        if ($model && count($files) > 0) {
            foreach ($files['images'] as $file) {
                if ($file instanceof UploadedFile) {
                    $name = time() . '-' . $file->getClientOriginalName();
                    $path = "images/events/$name";

                    \Storage::disk('s3')->put($path, file_get_contents($file));

                    $table = removeLastLetter($model->getTable()) . '_id';

                    Gallery::create([
                        'photo'  => $path,
                        $table   => $model->id
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $data = $this->model::findOrFail($id);

        return \response()->view($this->create, compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $data = $this->model::findOrFail($id);
        $this->setInputs($data);

        return \response()->view($this->create, [
            'postRoute' => route($this->updateRouteName, ['id' => $data->id]),
            'inputs' => $this->inputs,
            'col' => $this->col
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {

        $input = $request->except('_token');
        $model = $this->model::findOrFail($id);

        $model->update($input);

        session()->flash('alert', setFlashData("$this->singularName başarıyla güncellendi!"));

        return redirect()->route($this->editRouteName, ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {

        $this->model::destroy($id);
        session()->flash('alert', setFlashData("$this->singularName başarıyla silindi!"));

        return redirect()->route($this->listRouteName);

    }


    /**
     * @param Model $model
     */
    public function setInputs(Model $model): void
    {
        //TODO:: Inputları ayarla.
    }

    /**
     * Kod tekrarının engellemek için, her view'e belli başlı aynı veriyi gönderir.
     */
    public function sharedView(): void
    {

        \View::share('pageTitle', $this->pageTitle);
        \View::share('tableTitle', $this->listTitle);
        \View::share('filters', $this->htmlFilters);
        \View::share('indexRoute', $this->listRouteName);
        \View::share('tooltip', $this->tooltipName);
        \View::share('tooltipTitle', $this->tooltipTitle);
        \View::share('destroy', $this->destroyRouteName);
        \View::share('singularName', $this->singularName);
        \View::share('createRoute', $this->createRouteName);
        \View::share('canAdd', $this->canAdminAddData);
        \View::share('list', []);

    }

}
