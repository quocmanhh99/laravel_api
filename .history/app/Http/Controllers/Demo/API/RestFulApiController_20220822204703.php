<?php

namespace App\Http\Controllers\Demo\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Demo\Api\RestFulApiResource;
use App\Models\Demo\Product\DemoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestFulApiController extends Controller
{
    public function show()
    {
        $data = DemoProduct::orderBy('product_name', 'desc')->get();
        $products = RestFulApiResource::collection($data);
        return response()->json([
            'data' => $products,
            'status_code' => 200,
            'message' => 'Hiển thị dữ liệu thành công'
        ]);
    }

    public function detail($id)
    {
        $data = DemoProduct::where('product_id', $id)->first();
        $product = new RestFulApiResource($data);
        if ($data) {
            return response()->json([
                'data' => $product,
                'status_code' => 200,
                'message' => 'Hiển thị dữ liệu thành công'
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status_code' => 404,
                'message' => 'Data not found'
            ]);
        }
    }

    function sortProduct(Request $request){
        // return $request->sortName;
        $sortName = $request->sortName;
        $by =  $request->by;
        if($sortName == 'product_name'){
            if($by == 'desc'){
                $by = 'asc';
                $products = DemoProduct::orderBy('product_name', $by)->get();
            }else{
                $by = 'desc';
                $products = DemoProduct::orderBy('product_name', $by)->get();
            }
        }
        return response()->json([
            'data' => $products,
            'status_code' => 200,
            'message' => 'Hiển thị dữ liệu thành công',
            'by' => $by
        ]);
    }

    public function showProduct(Request $request)
    {
        return view('demo.restfulapi.product.show');
    }

    public function productAjax(Request $request)
    {
        if()
        $products = DemoProduct::orderBy('product_name', 'desc')->get();
        return view('demo.restfulapi.product.ajax', compact('products'))->render();

    }

    public function addProduct(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'product_name' => 'required||min:3|unique:products',
                'product_status' => 'required'
            ],
            [
                'product_name.required' => 'Tên sản phẩm không được để trống',
                'product_name.unique' => 'Tên sản phẩm đã được sử dụng',
                'product_name.min' => 'Tên sản phẩm  quá ít :min ký tự',
                'product_status.required' => 'Trạng thái bắt buộc phải chọn',
            ]
        );
        if ($validate->fails()) {
            $hasError = $validate;
            $errs = $hasError->getMessageBag()->toArray();
            $errors = [];
            foreach ( $validate->errors()->all() as $err) {
                $errors[] = $err;
            }
            return response()->json([
                'data' => $errs,
                'errors' => $errors,
                'status_code' => 405,
                'message' => 'Lỗi thêm sản phẩm !'
            ]);
        } else {
            $data = $request->only('product_name', 'product_status');
            $product = DemoProduct::create($data);
            if ($product) {
                return response()->json([
                    'data' => $product,
                    'status_code' => 200,
                    'message' => 'Thêm mới sản phẩm thành công'
                ]);
            } else {
                return response()->json([
                    'data' => null,
                    'status_code' => 404,
                    'message' => 'Thêm mới sản phẩm không thành công'
                ]);
            }
        }
    }

    public function deleteProduct($id)
    {
        $product = DemoProduct::where('product_id', $id);
        if ($product->delete()) {
            return $this->apiResponse($product, true, 200, 'Xóa sản phẩm thành công');
        } else {
            return $this->apiResponse(null, false, 404, 'Xóa sản phẩm không thành công');
        }
    }

    public function apiResponse($data, $status, $code, $message = null)
    {
        return response()->json([
            'data' => $data,
            'status_code' => $data == null ? 404 : $code,
            'status' => $status,
            'message' => $data == null && $message == null  ? 'Không tìm thấy dữ liệu' : $message
        ]);
    }

    public function updateProduct(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'product_name' => 'required||min:5',
                'product_status' => 'required',
                'product_code' => 'required',
            ],
            [
                'product_name.required' => 'Tên sản phẩm không được để trống',
                'product_name.unique' => 'Tên sản phẩm đã được sử dụng',
                'product_status.required' => 'Trạng thái bắt buộc phải chọn',
                'product_code.required' => 'Mã sản phẩm không được để trống',
                'product_name.min' => 'Tên sản phẩm phải có độ dài :min ký tự trở lên !',
            ]
        );
        if ($validate->fails()) {
            $errors = $validate->errors();
            return response()->json([
                'errors' => $errors,
                'status_code' => 405,
                'message' => 'Sửa sản phẩm không thành công'
            ]);

        }else{
            $product   =   DemoProduct::where('product_id', $request->product_id)->update(
                [
                    'product_name' => $request->product_name,
                    'product_code' => $request->product_code
                ]
            );
        }


        return response()->json(['success' => true]);
    }
}
