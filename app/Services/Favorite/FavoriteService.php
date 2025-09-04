<?php

namespace App\Services\Favorite;

use App\Models\Favorite;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Filters\FavoriteFilter;

class FavoriteService
{
    protected $favoriteFilter;

    public function __construct(FavoriteFilter $favoriteFilter)
    {
        $this->favoriteFilter = $favoriteFilter;
    }

    /**
     * Get filtered and paginated favorites for a specific user
     *
     * @param array $filters
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilteredFavorites(array $filters = [], int $userId, int $perPage = 15): LengthAwarePaginator
    {
        $query = Favorite::where('user_id', $userId);
        
        // Aplicar filtros adicionales
        $query = $this->favoriteFilter->apply($query, $filters);
        
        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Create or update a favorite
     *
     * @param array $data
     * @param int $userId
     * @return Favorite
     */
    public function createUserFavorite(array $data, int $userId): Favorite
    {
        try {
            // Buscar si ya existe un favorito con el mismo user_id y api_id
            $favorite = Favorite::updateOrCreate(
                [
                    'user_id' => $userId,
                    'api_id' => $data['api_id']
                ],
                [
                    'name' => $data['name'],
                    'image' => $data['image'] ?? null,
                    'description' => $data['description'] ?? null,
                ]
            );

            return $favorite;
        } catch (\Throwable $th) {
            Log::error('Error creating/updating favorite: ' . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Delete a favorite by API ID and user ID
     *
     * @param int $apiId
     * @param int $userId
     * @return array
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function destroyFavorite(int $apiId, int $userId): array
    {
        try {
            $favorite = Favorite::where('user_id', $userId)
                ->where('api_id', $apiId)
                ->firstOrFail();

            $deletedId = $favorite->id;
            $favorite->delete();

            return [
                'id' => $deletedId,
                'api_id' => $apiId,
                'message' => 'Favorito eliminado correctamente'
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException(
                'El favorito solicitado no existe.'
            );
        } catch (\Exception $e) {
            Log::error('Error al eliminar el favorito: ' . $e->getMessage());
            throw new \Exception('Ocurrió un error al intentar eliminar el favorito.');
        }
    }

    /**
     * Get all favorite API IDs for a user
     *
     * @param int $userId
     * @return array
     */
    public function getFavoriteApiIds(int $userId): array
    {
        return Favorite::where('user_id', $userId)
            ->pluck('api_id')
            ->toArray();
    }
}
