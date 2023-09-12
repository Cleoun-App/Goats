<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Utils\ResponseFormatter;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Validation\Rules\File;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    public function getCategories()
    {
        try {

            $categories = Category::all();

            return ResponseFormatter::success($categories, "Data berhasil di dapatkan");

        } catch (\Throwable $th) {

            return ResponseFormatter::error($th->getMessage(), "Terjadi Kesalahan!");
        }
    }

    public function getAllServices($count)
    {
        try {

            $request = request();

            $services = Service::where('status', "=", 'public')
                ->where("name", "LIKE", "%" . $request->search . "%")
                ->paginate($count);

            return ResponseFormatter::success($services, "Data berhasil di dapatkan");

        } catch (\Throwable $th) {

            return ResponseFormatter::error($th->getMessage(), "Terjadi Kesalahan!");
        }
    }
    
    public function getPopularServices($take)
    {
        try {

            $products = Service::leftJoin('orders', 'services.id', '=', 'orders.service_id')
            ->select('services.*', DB::raw('COUNT(orders.service_id) as total_order'))
            ->groupBy('services.id')
            ->where('services.status', '=', 'public')
            ->orderByDesc('total_order')
            ->take($take)
            ->get();

            return ResponseFormatter::success($products, 'Layanan dengan populer berhasil didapatkan');

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }
    
    public function getHighRatedService($take)
    {
        try {

            $products = Service::leftJoin('ratings', 'services.id', '=', 'ratings.model_id')
            ->select('services.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'))
            ->groupBy('services.id')
            ->where('status', '=', 'public')
            ->orderByDesc('average_rating')
            ->take($take)
            ->get();

            return ResponseFormatter::success($products, 'Layanan dengan rating terbaik berhasil didapatkan');

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function getServiceById($id)
    {
        try {

            $services = Service::with('user')->findOrFail($id);

            return ResponseFormatter::success($services, "Data berhasil di dapatkan");

        } catch (\Throwable $th) {

            return ResponseFormatter::error($th->getMessage(), "Terjadi Kesalahan!");
        }
    }

    public function getPartnerServices($username)
    {
        try {

            $user = get_user($username);

            $status = request()?->status ?? 'all';

            if(($user instanceof User) === false) {
                throw new \Exception('Pengguna tidak ditemukan!');
            }

            $services = match($status) {
                'all' => $user->services(),
                'public' => $user->services()->where('status', 'public'),
                'private' => $user->services()->where('status', 'private'),
                'blocked' => $user->services()->where('status', 'blocked'),
                'x_blocked' => $user->services()->where('status' ,'!=', 'blocked'),
            };

            return ResponseFormatter::success($services->paginate(10), "Data berhasil di dapatkan");

        } catch (\Throwable $th) {

            return ResponseFormatter::error($th->getMessage(), "Terdapat kesalahan!!");
        }
    }

    public function addService()
    {
        try {
            $request = request();

            [$user, $category] = $this->validateRef($request);

            $this->validateReq($request);

            $service = new Service();

            $service->name = $request->name;
            $service->slug = md5($request->name . now());
            $service->images = $this->storeImages($request, $user);
            $service->desc = $request->desc;
            $service->user()->associate($user);
            $service->category()->associate($category);
            $service->status = $request->status;
            $service->tags = $request->tags;

            $service->price = $request->price;

            $service->save();

            return ResponseFormatter::success($service, 'Layanan berhasil di buat');

        } catch(ValidationException $e) {

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function updateService(Request $request)
    {
        try {
            [$user, $category] = $this->validateRef($request);

            $this->validateReq($request);

            $service = $user->services()->find($request->id);

            if($service instanceof Service == false) {
                throw new \Exception('Layanan mitra tidak ditemukan!');
            }

            $storage = $user->get_storage();

            foreach($service->images as $img) {
                FacadesFile::delete($storage . DIRECTORY_SEPARATOR . $img);
            }

            $service->name = $request->name;
            $service->images = $this->storeImages($request, $user);
            $service->desc = $request->desc;
            $service->user()->associate($user);
            $service->category()->associate($category);
            $service->status = $request->status;

            $service->price = $request->price;

            $service->save();

            return ResponseFormatter::success($service, 'Layanan berhasil diupdate');

        } catch(ValidationException $e) {

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function deleteService(Request $request)
    {
        try {
            $user = User::where('username', $request->username)->first();

            if(($user instanceof User) === false) {
                throw new \Exception('Pengguna tidak ditemukan!');
            }

            $service = $user->services()->find($request->id);

            if(($service instanceof Service) === false) {
                throw new \Exception('Layanan mitra tidak ditemukan!');
            }

            $service->delete();

            return ResponseFormatter::success($service, "Layanan mitra berhasil berhasil dihapus!");

        } catch (\Throwable $th) {
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    private function validateRef(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if(($user instanceof User) === false) {
            throw new \Exception('Pengguna tidak ditemukan!');
        }

        if(!$user->hasRole('partner')) {
            throw new \Exception('Pengguna bukan mitra');
        }

        $category = Category::find($request->category);

        if(($category instanceof Category) === false) {
            throw new \Exception('Kategori tidak ditemukan!');
        }

        return [$user, $category];
    }

    private function validateReq(Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:public,private'],
            'images' => ['required', 'array'],
            'images.*' => ['
                image',
                'mimes:jpeg,jpg,png,webp',
                File::image()->min(24)->max(5 * 1024),
            ],
            'name' => ['required', 'min:4', 'max:240'],
            'desc' => ['required', 'min:4', 'max:1200'],
            'price' => ['required', 'numeric', 'max:90000000'],
            'tags' => ['nullable', 'array'],
            'category' => ['required', 'integer']
        ]);
    }

    private function storeImages(Request $request, User $user)
    {
        $storage = $user->get_storage();

        $_images = [];

        foreach($request->images ?? [] as $image) {

            $filename = md5($request->name . "-" . uniqid() . '-' . time()) . ".jpg";

            $user_folder = $storage . DIRECTORY_SEPARATOR . "sv_images" . DIRECTORY_SEPARATOR ;

            if(!FacadesFile::exists($user_folder)) {
                FacadesFile::makeDirectory($user_folder);
            }


            Image::make($image)->save("$user_folder$filename", 80, 'jpg');

            $_images[] = "sv_images" . DIRECTORY_SEPARATOR . $filename;

        }

        return $_images;
    }

}
