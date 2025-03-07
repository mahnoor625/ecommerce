<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;


use Carbon\Carbon;



class AdminController extends Controller
{
   public function index(){
    return view('admin.index');

    }

    // Brands-----------------------------

    public function brand()
    {
        $brands= Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands',compact('brands'));
    }

    public function AddBrands()
    {  
        return view('admin.brands-add');
    }

    public function brand_edit($id)
    {
        $brand= Brand::find($id);
        return view('admin.brand_edit',compact('brand'));

    }

    public function brand_update( Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand= Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasfile('image'))
        {
            if(File::exists(public_path('uploads/brands') . '/' . $brand->image))
            {
                File::delete(public_path('uploads/brands') . '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateBrandThumbnailsImage($image, $file_name);
            $brand->image = $file_name;
        }
       
        $brand->save();
    
        return redirect()->route('admin.brands')->with('status', 'Brand has been Edit successfully!');
    }
    
    public function brand_store(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug'. $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
    
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateBrandThumbnailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
    
        return redirect()->route('admin.brands')->with('status', 'Brand has been added successfully!');
    }
    
    public function GenerateBrandThumbnailsImage($image, $imageName) {
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function brand_delete($id)
    {
    $brand = Brand::find($id);
    if(File::exists(public_path('uploads/category').'/'.$brand->image))
    {
        File::delete(public_path('uploads/category').'/'.$brand->image);
    }
    $brand->delete();
    return redirect()->route('admin.brands')->with('status','Brand has been deleted successfully!');
    }

    // categories-------------------------------

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }
       
    public function AddCategory()
    {  
        return view('admin.categories-add');
    }


    public function category_store(Request $request) {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'. $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
    
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbnailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
    
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully!');
    }

    public function GenerateCategoryThumbnailsImage($image, $imageName) {
        $destinationPath = public_path('uploads/category');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
    
   
    
    public function category_edit($id)
    {
        $categories= Category::find($id);
        return view('admin.categories_edit',compact('categories'));

    }

    
    public function Category_update( Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $categories= Category::find($request->id);
        $categories->name = $request->name;
        $categories->slug = Str::slug($request->name);
        if($request->hasfile('image'))
        {
            if(File::exists(public_path('uploads/category') . '/' . $categories->image))
            {
                File::delete(public_path('uploads/category') . '/' . $categories->image);
            }
            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbnailsImage($image, $file_name);
            $categories->image = $file_name;
        }
       
        $categories->save();
    
        return redirect()->route('admin.categories')->with('status', 'Catagory has been Edit successfully!');
    }


    public function category_delete($id)
    {
    $categories = Category::find($id);
    if(File::exists(public_path('uploads/category').'/'.$categories->image))
    {
        File::delete(public_path('uploads/category').'/'.$categories->image);
    }
    $categories->delete();
    return redirect()->route('admin.categories')->with('status','Category has been deleted successfully!');
    }


    
// Product--------------
    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function addProduct()
{
    $categories = Category::select('id', 'name')->orderBy('name')->get();
    $brands = Brand::select('id', 'name')->orderBy('name')->get();
    return view('admin.product-add', compact('categories', 'brands'));
}

public function product_store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'slug' => 'required|unique:products,slug',
        'short_description' => 'required',
        'description' => 'required',
        'regular_price' => 'required',
        'sale_price' => 'required',
        'SKU' => 'required',
        'stock_status' => 'required',
        'featured' => 'required',
        'quantity' => 'required',
        'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        'category_id' => 'required',
        'brand_id' => 'required'
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->slug = Str::slug($request->name);
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->regular_price = $request->regular_price;
    $product->sale_price = $request->sale_price;
    $product->SKU = $request->SKU;
    $product->stock_status = $request->stock_status;
    $product->featured = $request->featured;
    $product->quantity = $request->quantity;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $current_timestamp =  Carbon::now()->timestamp;
 
    if ($request->hasFile('image')) 
    {
        $image = $request->file('image');
        $imageName =  $current_timestamp . '.' . $image->extension();
        $this->GenerateProductThumbnailImage( $image,$imageName);
        $product->image = $imageName;
    }

    $gallery_arr = array();
    $gallery_images = "";
    $counter = 1;

    if ($request->hasFile('images')) 
    {
          $allowedFileExtion = ['jpg', 'png', 'jpeg'];
          $files = $request->file('images');

    foreach ($files as $file)
     {
        $gextension = $file->getClientOriginalExtension();
        $gcheck = in_array($gextension, $allowedFileExtion);

        if ($gcheck) {
            $gfileName = $current_timestamp . "-" . $counter . "." . $gextension;
            $this->GenerateProductThumbnailImage($file, $gfileName);
            array_push($gallery_arr, $gfileName);
            $counter = $counter + 1;
        }
    }
        $gallery_images = implode(',', $gallery_arr);

}

$product->images = $gallery_images;
$product->save();

return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');

}

public function GenerateProductThumbnailImage($image, $imageName)
{
    $destinationPathThumbnail = public_path('uploads/products/thumbnails');
    $destinationPath = public_path('uploads/products');

    $img = Image::read($image->path());

    $img->cover(540, 689, "top");
    $img->resize(540, 689, function($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPath . '/' . $imageName);

    $img->resize(104, 104, function($constraint) {
        $constraint->aspectRatio();
    })->save($destinationPathThumbnail . '/' . $imageName);
}

public function product_edit($id)
{
    $product = Product::find($id);
    $categories = Category::select('id', 'name')->orderBy('name')->get();
    $brands = Brand::select('id', 'name')->orderBy('name')->get();
    
    return view('admin.product-edit', compact('product', 'categories', 'brands'));
}


}