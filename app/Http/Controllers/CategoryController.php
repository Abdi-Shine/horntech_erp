<?php

namespace App\Http\Controllers;
use App\Models\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->withCount(['products', 'children as sub_cat_count']);

        if ($request->search) {
            /** @disregard P0406 */
            $query->where(function(\Illuminate\Database\Eloquent\Builder $q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $categories = $query->paginate(10)->withQueryString();

        $stats = Category::selectRaw('COUNT(*) as total, SUM(status = "active") as active, SUM(status = "inactive") as inactive')->first();
        $totalCategories    = $stats->total;
        $activeCategories   = $stats->active;
        $inactiveCategories = $stats->inactive;
        $totalProducts      = Product::query()->count();

        // Used for parent category dropdown when creating a new category
        $parentCategories = Category::query()->whereNull('parent_id')->orderBy('name')->get();

        return view('frontend.product.category', compact(
            'categories', 'totalCategories', 'activeCategories', 'inactiveCategories', 'totalProducts', 'parentCategories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:categories,code',
        ]);

        $code = $request->code ?: 'CAT-' . strtoupper(Str::random(6));

        // Let's generate a random icon class and color for new categories if not provided
        $icons = ['bi-laptop', 'bi-phone', 'bi-keyboard', 'bi-tv', 'bi-headphones', 'bi-camera', 'bi-controller', 'bi-smartwatch', 'bi-box', 'bi-tag', 'bi-bag', 'bi-basket'];
        $colors = ['text-blue-500 bg-blue-50', 'text-green-500 bg-green-50', 'text-teal-500 bg-teal-50', 'text-yellow-500 bg-yellow-50', 'text-purple-500 bg-purple-50', 'text-emerald-500 bg-emerald-50', 'text-orange-500 bg-orange-50', 'text-rose-500 bg-rose-50', 'text-indigo-500 bg-indigo-50'];

        $iconClass = $request->icon_class ?? $icons[array_rand($icons)];
        $iconColor = $request->icon_color ?? $colors[array_rand($colors)];

        $category = Category::query()->create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? 'active',
            'icon_class' => $iconClass,
            'icon_color' => $iconColor,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => $category
            ]);
        }

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function update(Request $request, $id)
    {
        $category = Category::query()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:categories,code,' . $id,
        ]);

        $code = $request->code ?: ($category->code ?: 'CAT-' . strtoupper(Str::random(6)));

        $category->update([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::query()->findOrFail($id);
        
        // Prevent deleting if it has products or sub-categories
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category because it has products associated with it.');
        }

        if ($category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category because it has sub-categories.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
