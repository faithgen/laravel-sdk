<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Services\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use FaithGen\SDK\Http\Resources\Module as ModuleResource;

class ModuleController extends Controller
{
    /**
     * @var ModuleService
     */
    private ModuleService $moduleService;

    /**
     * ModuleController constructor.
     *
     * Injects the module service into the controller.
     *
     * @param ModuleService $moduleService
     */
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * Fetches the modules this ministry is subscribed to
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $modules = $this->moduleService->getModel()->get();
        ModuleResource::wrap('modules');
        return ModuleResource::collection($modules);
    }
}
