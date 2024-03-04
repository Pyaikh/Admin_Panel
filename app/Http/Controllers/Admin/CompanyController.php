<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @OA\Info(
 *      title="Car Rental API",
 *      version="1.0.0",
 *      description="API for managing cars and companies in a car rental system"
 * )
 */

/**
 * @OA\Tag(
 *     name="Cars",
 *     description="API endpoints for managing cars"
 * )
 */
class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/companies",
     *     summary="Get all companies",
     *     tags={"Companies"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Company")
     *         )
     *     )
     * )
     */
    public function index(): Collection|array
    {
        return Company::with('cars')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/admin/companies",
     *     summary="Create a new company",
     *     tags={"Companies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Company ABC")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Company created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     )
     * )
     */
    public function create(Request $request)
    {
        return Company::create(['name' => $request->input('name')]);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/companies/{id}",
     *     summary="Update a company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the company",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Company ABC")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
     *     )
     * )
     */
    public function update(Request $request, int $id)
    {
        $company = Company::find($id);

        if ($company) {
            $company->update(['name' => $request->input('name')]);
            return response()->json($company);
        } else {
            return response()->json(['error' => 'Company not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/companies/{id}",
     *     summary="Delete a company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the company",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found"
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $company = Company::find($id);

        if ($company) {
            $company->delete();
            return response()->json(['message' => 'Company deleted successfully']);
        } else {
            return response()->json(['error' => 'Company not found'], 404);
        }
    }
}
