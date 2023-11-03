<?php

namespace App\Http\Traits;

trait FilterData {

    public bool $isApi = false;

    /**
     * @param array $gQuery
     * @return mixed
     */
    public function filteredData(array $gQuery): mixed
    {
        $model = $this->model::query();
        if ( ! array_key_exists('qt', $gQuery)) {
            $gQuery['qt'] = 0;
        }
        $qt = $gQuery['qt'] ? 'orWhere' : 'where';
        unset($gQuery['qt']);
        foreach ($gQuery as $key => $q) {
            if (array_key_exists($key, $this->filters) && ! is_null($q)) {
                $oneQuery = $this->filters[$key];
                if ($oneQuery['type'] === 'like') {
                    $model->$qt($oneQuery['field'], 'LIKE', "%$q%");
                } elseif ($oneQuery['type'] === 'exact') {
                    $model->$qt($oneQuery['field'], $q);
                } elseif ($oneQuery['type'] === 'custom') {
                    $oneQuery['closure']($model, $q);
                }
            }
        }
        if ($this->isApi) {
            return $model->with($this->with)->orderByDesc('id')->get();
        }
        return $model->with($this->with)->orderByDesc('id')->paginate(15, ['*'], 'sayfa');
    }

    /**
     * @return void
     */
    public function setFilter(): void
    {
        $this->filters = setFilter(['name', 'like', null]);
    }

    /**
     *
     */
    public function setHtmlFilter(): void
    {
        $this->htmlFilters = [];
    }

}
