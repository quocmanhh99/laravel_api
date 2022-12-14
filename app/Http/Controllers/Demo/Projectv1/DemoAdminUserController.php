<?php

namespace App\Http\Controllers\Demo\Projectv1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Demo\DemoDistrict;
use App\Models\Demo\DemoProvince;
use App\Models\Demo\DemoWard;
use App\Models\Demo\Package\DemoPost;
use App\Models\Demo\Role\DemoRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DemoAdminUserController extends Controller
{
    public $users;

    public function visits()
    {
        return visits($this);
    }
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
        $this->middleware('ActivityByUser');

        $this->users = new User();
    }

    public function GetDistricts($province_id)
    {
        $district = DemoDistrict::where('province_id', $province_id)
            ->orderBy('name', 'DESC')
            ->get();
        return json_encode($district);
    }

    public function userOnlineStatus()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }

    public function userLoadMore(Request $request){

        $posts =  DemoWard::paginate(10);
        $data = '';

        if (!$posts->isEmpty()) {
            if ($request->ajax()) {
                foreach ($posts as $post) {
                    $data.='<li>'.$post->id.' <strong>'.$post->name.'</strong> : '.$post->district_id.'</li>';
                }
                return $data;
            }
        }

        return view('demo.projectv1.user.loadmore');
    }

    public function GetWards($dsistrict_id)
    {
        $ward = DemoWard::where('district_id', $dsistrict_id)
            ->orderBy('name', 'DESC')
            ->get();
        return json_encode($ward);
    }

    public function list(Request $request)
    {
        $user = new User();
        visits($user)->increment(1);
        $status = $request->status;
        $filters = [];
        $keywords = '';
        $list_act = [
            'delete' => 'X??a t???m th???i',
        ];
        if ($status == 'trash') {
            $list_act = [
                'restore' => 'Kh??i ph???c',
                'forceDelete' => 'X??a v??nh vi???n',
            ];
            // X??? l?? logic s???p x??p:
            $sortBy = $request->input('sort-by');
            $sortType = $request->input('sort-type');
            $allowSort = ['asc', 'desc'];

            if (!empty($sortType) && in_array($sortType, $allowSort)) {
                if ($sortType == 'desc') {
                    $sortType = 'asc';
                } else {
                    $sortType = 'desc';
                }
            } else {
                $sortType = 'asc';
            }
            $sortArr = [
                'sortBy' => $sortBy,
                'sortType' => $sortType,
            ];
            $users = $this->users->getOnlyTrashed($sortArr);
        } else {
            $keyword = '';
            if (!empty($request->keywords)) {
                $keywords = $request->keywords;
            }

            if ($request->keyword) {
                $keyword = $request->keyword;
            }

            if (!empty($request->status)) {
                $status = $request->status;
                if ($status == 'active') {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $filters[] = ['users.status', '=', $status];
            }
            if (!empty($request->group_id)) {
                $groupId = $request->group_id;
                $filters[] = ['users.group_id', '=', $groupId];
            }
            // dd($keyword );
            // X??? l?? logic s???p x??p:
            $sortBy = $request->input('sort-by');
            $sortType = $request->input('sort-type');
            $allowSort = ['asc', 'desc'];

            if (!empty($sortType) && in_array($sortType, $allowSort)) {
                if ($sortType == 'desc') {
                    $sortType = 'asc';
                } else {
                    $sortType = 'desc';
                }
            } else {
                $sortType = 'asc';
            }

            $sortArr = [
                'sortBy' => $sortBy,
                'sortType' => $sortType,
            ];

            $users = $this->users->getAllUsers(
                $keyword,
                $keywords,
                $filters,
                $sortArr
            );
            // $users = $this->users->getAllUsers($keyword,$keywords,$filters);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $visit = visits($user)->count();
        $count = [$count_user_active, $count_user_trash];

        return view(
            'demo.projectv1.user.list',
            compact('users', 'count', 'list_act', 'visit', 'sortType')
        );
    }

    public function add()
    {
        // $user =  new User;
        // visits($user)->increment(1);
        // $visit = visits($user)->count();
        $country = Country::all();
        $provinces = DemoProvince::all();
        $roles = DemoRole::get();
        $wards = DemoWard::all();
        $districts = DemoDistrict::all();
        return view(
            'demo.projectv1.user.add',
            compact('provinces', 'roles', 'country', 'wards', 'districts')
        );
    }

    public function edit($id)
    {
        // $this->authorize('sua-thanh-vien');
        $user = User::findOrFail($id);
        $roles = DemoRole::get();
        visits($user)->increment(1);
        $visit = visits($user)->count();
        return view(
            'demo.projectv1.user.edit',
            compact('user', 'roles', 'visit')
        );
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required',
            ],
            [
                'required' => ':attribute kh??ng ???????c ????? tr???ng',
                'max' => ':attribute c?? ????? d??i t???i ??a :max k?? t???',
                'min' => ':attribute c?? ????? d??i ??t nh???t :min k?? t???',
                'confirmed' => 'X??c nh???n m???t kh???u kh??ng th??nh c??ng',
            ],
            [
                'name' => 'T??n ng?????i d??ng',
                'password' => 'M???t kh???u',
                'role_id' => 'Ch???n vai tr??',
            ]
        );

        User::findOrFail($id)->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $notification = [
            'message' => 'B???n ???? s???a th??nh vi??n th??nh c??ng',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('projectv1.user.list')
            ->with($notification);
    }

    public function store(Request $request)
    {
        // return $request->role;
        $user = new User();
        visits($user)->increment(1);
        $visit = visits($user)->count();
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required',
            ],
            [
                'required' => ':attribute kh??ng ???????c ????? tr???ng',
                'max' => ':attribute c?? ????? d??i t???i ??a :max k?? t???',
                'min' => ':attribute c?? ????? d??i ??t nh???t :min k?? t???',
                'confirmed' => 'X??c nh???n m???t kh???u kh??ng th??nh c??ng',
            ],
            [
                'name' => 'T??n ng?????i d??ng',
                'email' => 'Email',
                'password' => 'M???t kh???u',
                'role_id' => 'Ch???n vai tr??',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $notification = [
            'message' => 'B???n ???? th??m th??nh vi??n th??nh c??ng',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('projectv1.user.list')
            ->with($notification);
    }

    public function action(Request $request)
    {
        $list_check = $request->list_check;

        if ($list_check) {
            // Ki???m tra xem th??? bi???n $list_check c?? t???n t???i hay kh??ng ?
            // N???u n?? c?? t???n t???i th?? ch??ng ta c???n ph???i duy???t trong m???ng $list_check n??y v?? ch??ng ta ki???m tra xem th??? id c???a ng?????i ??ang ????ng nh???p n?? c?? = 1 id n??o ???y ??? trong $list_check n??y hay kh??ng ? n??u nh?? = th?? ch??ng ta ph???i unset c??i ph???n t??? ???y ra kh???i m???ng
            // => Ch??ng ta lo???i b??? c??i vi???c lo???i b??? l??n ch??nh b???n th??n m??nh
            // V?? sau khi ch??ng ta lo???i b??? id c???a ng?????i ??ang ????ng nh???p t???c l?? trong m???ng $list_check t???n t???i nh???ng id c???a th??nh vi??n kh??c m?? ko c?? id c???a ng?????i ??ang ????ng nh???p
            // Ch??ng ta ki???m tra xem th??? l?? bi???n $list_check c?? c??n kh??c r???ng hay kh??ng ?
            // n???u c?? kh??c r???ng (t???c l?? n?? c?? gi?? tr??? trong bi???n)
            foreach ($list_check as $k => $v) {
                if (Auth::id() == $v) {
                    unset($list_check[$k]);
                    // 7
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    $notification = [
                        'message' => 'B???n ???? x??a t???m th???i th??nh c??ng',
                        'alert-type' => 'success',
                    ];
                    return redirect()
                        ->route('projectv1.user.list')
                        ->with($notification);
                }

                if ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    $notification = [
                        'message' => 'B???n ???? kh??i ph???c th??nh c??ng',
                        'alert-type' => 'success',
                    ];
                    return redirect()
                        ->route('projectv1.user.list')
                        ->with($notification);
                }

                if ($act == 'forceDelete') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    $notification = [
                        'message' => 'B???n ???? x??a v??nh vi???n th??nh c??ng',
                        'alert-type' => 'success',
                    ];
                    return redirect()
                        ->route('projectv1.user.list')
                        ->with($notification);
                }
            }

            $notification = [
                'message' => 'B???n kh??ng th??? thao t??c tr??n t??i kho???n c???a m??nh',
                'alert-type' => 'error',
            ];
            return redirect()
                ->route('projectv1.user.list')
                ->with($notification);
        } else {
            $notification = [
                'message' => 'B???n c???n ch???n ph???n t??? c???n th???c thi',
                'alert-type' => 'error',
            ];
            return redirect()
                ->route('projectv1.user.list')
                ->with($notification);
        }
    }

    public function delete($id)
    {
        $this->authorize('xoa-thanh-vien');
        if (Auth::id() != $id) {
            $user = User::findOrFail($id)->delete();
            $notification = [
                'message' => '???? x??a th??nh vi??n th??nh c??ng',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('projectv1.user.list')
                ->with($notification);
        } else {
            $notification = [
                'message' => 'B???n kh??ng th??? t??? x??a m??nh ra kh???i h??? th???ng',
                'alert-type' => 'error',
            ];
            return redirect()
                ->route('projectv1.user.list')
                ->with($notification);
        }
    }
}
