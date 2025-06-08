<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    protected $routerRepository;
    protected $controller_name;

    public function __construct(RouterRepository $routerRepository)
    {
        $this->routerRepository = $routerRepository;
    }

    // Current Language
    public function currentLanguage()
    {
        return 1;
    }

    // Payload Router
    public function payloadRouter($model, string $canonical): array
    {
        return [
            'canonical' => $canonical,
            'module_id' => $model->id,
            'controllers' => 'App\Http\Controllers\Frontend\\' . $this->controller_name,
        ];
    }

    // Create Router
    public function createRouter($model, string $canonical): void
    {
        $payload_router = $this->payloadRouter($model, $canonical);
        // dd($payload_router);
        $this->routerRepository->create($payload_router);
    }

    // Update Router
    public function updateRouter($model, string $canonical): void
    {
        $payload_router = $this->payloadRouter($model, $canonical);
        $condition = [
            ['module_id', '=', $model->id],
            ['controllers', '=', 'App\Http\Controllers\Frontend\\' . $this->controller_name],
        ];

        $this->routerRepository->updateByWhere($condition, $payload_router);
    }
}