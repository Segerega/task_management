<?php


namespace App\Http\Controllers;

use App\Contracts\CrudServiceInterface;
use App\Http\Requests\BaseAdminRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Abstract base controller class for common CRUD operations.
 */
abstract class BaseController extends Controller
{
    /**
     * The service instance.
     *
     * @var CrudServiceInterface
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param CrudServiceInterface $service
     */
    public function __construct(CrudServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of resources.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $items = $this->service->getAll();
        return response()->json($items);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $item = $this->service->getById($id);
        return response()->json($item);
    }

}
