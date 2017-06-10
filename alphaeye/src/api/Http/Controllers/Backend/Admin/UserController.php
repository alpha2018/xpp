<?php

namespace Api\Http\Controllers\Backend\Admin;

use Api\Exceptions\BadRequestHttpException;
use Api\Exceptions\ErrorException;
use Api\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Api\Models\User;
use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

/**
 * 用户管理
 * 
 * @author Neo
 *        
 */
class UserController extends ApiController
{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 获取用户管理主页
     */
    public function Index(Request $request)
    {
        return view('admin.user.index');
    }

    /**
     * 管理端获取用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo()
    {
//        return ['success'=>false];
        throw new BadRequestHttpException('asd');
        return apiResponse(['user_info'=>['username'=>123]]);
    }

    /**
     * 管理端获取用户列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $userList = User::paginate(1)->toArray();

        return apiResponse(['user_list'=>$userList]);
    }

    public function all()
    {
        return response()->json(User::all());
    }

    /**
     * 编辑用户角色关系
     */
    public function editUserRole(Request $request)
    {
        $id = $request->input('id');
        $roles = Role::all()->toArray();
        $user = User::find($id);
        $user['roles'] = $user->roles;
        $user['roles_id'] = [];
        if (! empty($user['roles'])) {
            foreach ($user['roles'] as $aRoles) {
                $rolesId[] = $aRoles->pivot->role_id; // 与用户关联的角色ids
            }
        }
        if (! empty($rolesId)) {
            $user['roles_id'] = $rolesId;
        }
        $user = $user->toArray();
        return $this->_view('admin.user.edit', [
            'user' => $user
        ])->with('roles', $roles);
    }

    /**
     * 保存用户角色关系
     */
    public function storeUserRole(Request $request)
    {
        $params = $request->input();
        DB::beginTransaction();
        try {
            DB::table('role_user')->where('user_id', $params['user_id'])->delete();
            DB::table('role_user')->insert($params);
        } catch (\Exception $e) {
            DB::rollback();
            return LogManagement::error($e->getMessage(), $e->getFile(), $e->getLine());
        }
        DB::commit();
        
        return response()->json([
            'code' => 200,
            'msg' => '操作成功'
        ]);
    }

    /**
     * 获取新建用户页面
     */
    public function Create()
    {
        return view(view_path('Admin.User.create'));
    }

    /**
     */
    public function Show($id)
    {
        $user = $this->user->find($id);
        
        return response()->json($user,200) ;
    }

    /**
     * 获取编辑用户页面
     */
    public function Edit(Request $request,$id)
    {
        $id = $request->input('id') ? : $id;

        $user = User::find($id);

        return view('admin.user.edit')->with(compact('user'));

        return response()->json(['success'=>true,'data'=>$user]);

        $user = User::findOrFail($request->input('id'))->toArray(); // 根据主键取出一条数据或抛出异常
        $user['is_show'] = false;
        return $this->_view('admin.user.create', [
            'user' => $user
        ]);
    }

    /**
     * 保存用户数据
     */
    public function Store(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');


        dd(User::create(['email'=>$email,'password'=>$password]));


        $user = $this->user->create($email,$password);

        
        return response()->json([
            'code' => 200,
            'msg' => '新增成功',
            'user' => $user
        ]);
    }

    /**
     * 更新用户数据
     */
    public function Update(Request $request,$id)
    {

        $id = $request->input('id') ? : $id;

        $params = $request->only(['name']);


        $user = User::find($id)->update($params);

        return redirect()->route('user.index')->withFlashSuccess(trans('alerts.backend.users.updated'));

        return response()->json([
            'success' => true,
            'msg' => '更新成功'
        ]);
    }

    /**
     * 删除用户数据
     */
    public function Destroy($id)
    {

        $user = User::find($id);

        if(empty($user)){
            return response()->json(['success'=>true,'msg'=>'用户不存在']);
        }

        return redirect()->route('user.index')->withFlashSuccess(trans('alerts.backend.users.deleted'));

        if(!$user->delete($id)){
            return response()->json(['success'=>false]);
        }

        return response()->json(['success'=>true]);
    }

    /**
     * 获取重设密码页面
     */
    public function resetPassword(Request $request)
    {

        return response()->json(['success'=>true, 'data'=>User::find($request->input('id'))]);


        return $this->_view('admin.user.reset', [
            'id' => $request->input('id')
        ]);
    }

    /**
     * 保存密码
     */
    public function updatePassword(Request $request)
    {

        $id = $request->input('id');

        $password = $request->input('password');

        $ret = User::find($id)->update(['password'=>Hash::make($password)]);

        if(!$ret){
            return response()->json([
                'success' => false,

            ]);
        }
        return response()->json([
            'success' => true,

        ]);

    }
}