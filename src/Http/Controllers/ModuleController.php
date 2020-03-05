<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Http\Requests\AddModulesRequest;
use FaithGen\SDK\Http\Resources\Module as ModuleResource;
use FaithGen\SDK\Services\ModuleService;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Traits\APIResponses;

class ModuleController extends Controller
{
    use APIResponses;
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

    public function addModules(AddModulesRequest $request)
    {
        $this->moduleService->invalidateModules();

        if ($this->moduleService->addModules($request->modules))
            return $this->successResponse('Modules updated successfully');
    }
}
