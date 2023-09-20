<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BaseService
{
    protected $model;

    public function __construct($model = null)
   {
       $this->model = $model;
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $attributes
     * @return mixed|null $model
     */
    public function create(array $attributes)
    {
        $model = $this->model;

        $model->fill($attributes);
        $model->save();
        $model->refresh();

        return $model;
    }

    /**
     * Find the specified resource in storage.
     *
     * @param int $id
     * @return mixed $model
     */
    public function find(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function update(array $attributes, int $id)
    {
        $model = $this->find($id);
        $model->update($attributes);
        $model->refresh();

        return $model;
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param array $ids
     * @return mixed
     */
    public function massDestroy(array $ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Prepare validated data with nullable fields.
     *
     * @param array $validated
     * @param array $nullableFields
     * @return array
     */
    protected function prepareUpdateValidated(array $validated, array $nullableFields): array
    {
        foreach ($nullableFields as $nullableField) {
            if (!isset($validated[$nullableField])) {
                $validated[$nullableField] = null;
            }
        }

        return $validated;
    }

    /**
     * Prepare validated data with nullable fields.
     *
     * @param Model $mainModel
     * @param Model $model
     * @param string $thumbDir
     * @param string $mainDir
     * @param bool $firstMain
     * @param int|string $key
     * @param mixed $photoInfo
     * @return void
     */
    public function storeCompressionPhoto(Model $mainModel, Model $model, string $thumbDir, string $mainDir, ?bool $firstMain, int|string $key, mixed $photoInfo): void
    {
        $faker = mt_rand(1, 99999999);
        $photoFileName = $mainModel->id . '-' . $faker . '.' . $photoInfo['photo']->extension();
        $thumb_path = 'storage/' . $thumbDir . '/';
        $path = 'storage/' . $mainDir . '/';

        if (!file_exists(public_path($thumb_path))) {
            Storage::disk('public')->makeDirectory($thumbDir . '/');
        }

        if (Image::make($photoInfo['photo'])->filesize() <= 100000) {

        }
        if (array_key_exists('rotate', $photoInfo)) {
            $photo = Image::make($photoInfo['photo'])->heighten(750, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->rotate($photoInfo['rotate']);

            if (Image::make($photoInfo['photo'])->filesize() <= 100000) {
                $photo->save(public_path($path).$photoFileName);
            } else {
                $photo->save(public_path($path).$photoFileName, 50);
            }

            if (Image::make($photoInfo['photo'])->width() <= 450 && Image::make($photoInfo['photo'])->height() > 250) {
                $thumbPhoto = Image::make($photoInfo['photo'])->heighten(500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->rotate($photoInfo['rotate']);
            } else {
                $thumbPhoto = Image::make($photoInfo['photo'])->widen(450, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->rotate($photoInfo['rotate']);
            }

            $thumbPhoto->save(public_path($thumb_path).$photoFileName);
        } else {
            $photo = Image::make($photoInfo['photo'])->heighten(750, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (Image::make($photoInfo['photo'])->filesize() <= 100000) {
                $photo->save(public_path($path).$photoFileName);
            } else {
                $photo->save(public_path($path).$photoFileName, 50);
            }

            if (Image::make($photoInfo['photo'])->width() <= 450 && Image::make($photoInfo['photo'])->height() > 250) {
                $thumbPhoto = Image::make($photoInfo['photo'])->heighten(500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $thumbPhoto = Image::make($photoInfo['photo'])->widen(450, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $thumbPhoto->save(public_path($thumb_path).$photoFileName);
        }

        $photoModel = new $model();
        $photoModel->url = $path . $photoFileName . '?version=' . time();
        $photoModel->thumb_url = $thumb_path . $photoFileName . '?version=' . time();

        if ($firstMain && $key === 0) {
            $photoModel->is_main = true;
        } else {
            $photoModel->is_main = $photoInfo['is_main'] ?? false;
        }

        $photoModel->description = $photoInfo['description'] ?? null;

        match (get_class($this->model)) {
            'App\Models\Advert' => $photoModel->advert()->associate($mainModel),
            'App\Models\TradeInAdvert' => $photoModel->tradeInAdvert()->associate($mainModel),
            'App\Models\AgencyApartment' => $photoModel->agencyApartment()->associate($mainModel),
        };

        $photoModel->save();
    }

    /**
     * Prepare validated data with nullable fields.
     *
     * @param Model $advertId
     * @param Model $photoModel
     * @param mixed $rotate
     * @return \string[][]
     */
    public function updateRotationPhoto(Model $photoModel, mixed $rotate): Model
    {
        match (get_class($this->model)) {
            'App\Models\AdvertPhoto' => $advert = $photoModel->advert,
            'App\Models\AgencyApartmentPhoto' => $advert = $photoModel->agencyApartment,
        };

        $mainDir = explode('/', $photoModel->url)[1];
        $thumbDir = explode('/', $photoModel->thumb_url)[1];

        if (Str::contains($photoModel->url, '?') && Str::contains($photoModel->thumb_url, '?')) {
            $photo = explode('?', $photoModel->url)[0];
            $mainPhotoUrl = public_path($photo);
            $thumbPhoto = explode('?', $photoModel->thumb_url)[0];
            $thumbPhotoUrl = public_path($thumbPhoto);
        } else {
            $mainPhotoUrl = public_path($photoModel->url);
            $thumbPhotoUrl = public_path($photoModel->thumb_url);
        }

        $thumb_path = 'storage/' . $thumbDir . '/';
        $path = 'storage/' . $mainDir . '/';

        $photoFile = explode('/', $photoModel->url)[2];
        $fullPhotoNameFile = explode('?', $photoFile);
        $photoNameFile = explode('.', $fullPhotoNameFile[0]);
        $photoName = $photoNameFile[0];
        $extension = $photoNameFile[1];

        if (file_exists($mainPhotoUrl) && file_exists($thumbPhotoUrl)) {
            $mainFile = file_get_contents($mainPhotoUrl);
            $thumbFile = file_get_contents($thumbPhotoUrl);
            $photoFileName = $photoName . '.' . $extension;

            Image::make($mainFile)->rotate($rotate)->save(public_path($path) . $photoFileName, 50);

            if (Image::make($thumbFile)->width() <= 450 && Image::make($thumbFile)->height() > 250) {
                Image::make($thumbFile)->heighten(500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->rotate($rotate)->save(public_path($thumb_path) . $photoFileName);
            } else {
                Image::make($thumbFile)->widen(450, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->rotate($rotate)->save(public_path($thumb_path) . $photoFileName);
            }
            $photoModel->url = $path . $photoFileName . '?version=' . time();
            $photoModel->thumb_url = $thumb_path . $photoFileName . '?version=' . time();
            $photoModel->save();
        }

        return $advert;
    }
}
