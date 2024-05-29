<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicationController extends Controller
{
    public function index()
    {

        return PublicationResource::collection(Publication::paginate(10));
    }

    public function show(Request $request, $id)
    {
        try {
            $fields = $request->input('fields', null);
            $publication = Publication::findOrFail($id);
            return new PublicationResource($publication, $fields);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при поиске: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        {
            try {
                $data = $request->validate([
                    'title' => ['required', 'max:200'],
                    'description' => ['required', 'max:1000'],
                    'photos' => ['required', 'array', 'max:3'],
                    'photos.*' => ['url'],
                    'price' => ['required', 'numeric'],
                ]);

                $publication = Publication::create($data);

                return response()->json([
                    'id' => $publication->id,
                    'status' => 'success',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create publication.',
                    'error' => $e->getMessage(),
                ], 422);
            }

        }
    }
}
