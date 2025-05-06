<?php

namespace App\Services\Interfaces;

/**
 * Interface PostServiceInterface
 * @package App\Services\Interfaces
 */
interface PostServiceInterface
{
    public function paginate($request);
    public function create($request);
    public function update($id, $request);
    public function destroy($id);
}
