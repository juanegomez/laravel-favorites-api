<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\Favorite\FavoriteService;
use App\Http\Requests\Favorite\SaveFavoriteRequest;
use App\Http\Resources\Favorite\SaveFavoriteResource;
use App\Http\Requests\Favorite\FavoritesRequest;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Requests\Favorite\DeleteFavoriteRequest;   

class FavoriteController extends Controller
{
    protected $favoriteService;
    
    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FavoritesRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $filters = [
            'user_id' => Auth::id(),
            'search' => $validated['search'] ?? null,
            'name' => $validated['name'] ?? null,
            'description' => $validated['description'] ?? null
        ];

        $perPage = $validated['per_page'] ?? 15;

        $favorites = $this->favoriteService->getFilteredFavorites($filters, $perPage);

        return response()->json([
            'status' => 1,
            'message' => 'Favoritos obtenidos exitosamente',
            'data' => FavoriteResource::collection($favorites->items()),
            'meta' => [
                'current_page' => $favorites->currentPage(),
                'last_page' => $favorites->lastPage(),
                'per_page' => $favorites->perPage(),
                'total' => $favorites->total(),
                'prev' => $favorites->previousPageUrl(),
                'next' => $favorites->nextPageUrl()
            ]
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveFavoriteRequest $request)
    {
        try {
            $validated = $request->validated();
            $favorite = $this->favoriteService->createUserFavorite($validated, Auth::id());

            return response()->json([
                'status' => 1,
                'message' => 'Item favorito agregado correctamente',
                'data' => new SaveFavoriteResource($favorite)   
            ])->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error al agregar el item favorito: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteFavoriteRequest $request, string $api_id)
    {
        try {
            $validated = $request->validated();
            
            $result = $this->favoriteService->destroyFavorite((int)$api_id, Auth::id());

            return response()->json([
                'status' => true,
                'message' => 'Favorito eliminado correctamente',
                'data' => $result
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error al eliminar el favorito: ' . $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

    /**
     * Get all favorite API IDs for the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFavoriteIds()
    {
        try {
            $apiIds = $this->favoriteService->getFavoriteApiIds(Auth::id());

            return response()->json([
                'status' => 1,
                'message' => 'Favorite API IDs retrieved successfully',
                'data' => $apiIds
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error retrieving favorite API IDs: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
