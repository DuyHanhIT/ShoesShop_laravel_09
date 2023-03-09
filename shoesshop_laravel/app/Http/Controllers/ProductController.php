<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            foreach ($products as $product) {
                $brand = Brand::find($product->brandId);
                $product->brandName = $brand->brandName;
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $products,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detail($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find product',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $brand = Brand::find($product->brandId);
            $product->brandName = $brand->brandName;
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request)
    {
        try {
            $findProduct = Product::where('name', $request->name)->first();
            if ($findProduct) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Product name is already',
                    'data' => null,
                ], Response::HTTP_NOT_IMPLEMENTED);
            }
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'brandId' => $request->brandId,
                'categoryId' => $request->categoryId,
                'price' => $request->price,
                'rate' => 0,
                'productNew' => true,
                'purchase' => 0,
                'stock' => 0,
                'active' => true,
                'image' => $request->image,
                'createdDate' => now()->format('Y-m-d H:i:s'),
                'dateUpdated' => now()->format('Y-m-d H:i:s'),
                'updateBy' => $request->updateBy,
            ]);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $findProduct = Product::find($id);
            if (!$findProduct) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find product',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $findProduct->name = $request->name ?? $findProduct->name;
            $findProduct->description = $request->description ?? $findProduct->description;
            $findProduct->brandId = $request->brandId ?? $findProduct->brandId;
            $findProduct->categoryId = $request->categoryId ?? $findProduct->categoryId;
            $findProduct->price = $request->price ?? $findProduct->price;
            $findProduct->rate = $request->rate ?? $findProduct->rate;
            $findProduct->productNew = $request->productNew ?? $findProduct->productNew;
            $findProduct->purchase = $request->purchase ?? $findProduct->purchase;
            $findProduct->stock = $request->stock ?? $findProduct->stock;
            $findProduct->active = $request->active ?? $findProduct->active;
            $findProduct->image = $request->image ?? $findProduct->image;
            $findProduct->dateUpdated = $request->dateUpdated ?? $findProduct->dateUpdated;
            $findProduct->updateBy = $request->updateBy ?? $findProduct->updateBy;
            $findProduct->save();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $findProduct,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
