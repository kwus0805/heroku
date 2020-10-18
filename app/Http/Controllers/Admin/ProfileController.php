<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile; #課題15-5

use App\ProfileHistory; #lalavel_18課題
use Carbon\carbon; #lalavel_18課題

class ProfileController extends Controller
{
    //php＿09　課題5を追記
    public function add()
    {
      return view('admin.profile.create');
    }
    public function create(Request $request)
    {
      //Validation　を行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除
      unset($form['_token']);

      // データベースに保存
      $profile->fill($form);
      $profile->save();

      return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
      //lalavel_17_課題1
      $profile = Profile::find($request->id);
      if(empty($profile)) {
        abort(404);
      }
      return view('admin.profile.edit',['profile_form' => $profile]);
    }
    public function update(Request $request)
    {
      $this->validate($request, Profile::$rules);
      $profile = Profile::find($request->id);
      $profile_form = $request->all();

        unset($profile_form['_token']);
        unset($profile_form['remove']);

        $profile->fill($profile_form)->save();

        //　--以下を追記(lalavel_18 課題)
        $p_history = new ProfileHistory;
        $p_history->profile_id = $profile->id;
        $p_history->edited_at = Carbon::now();
        $p_history->save();
        // ここまで--


        return redirect()->action('Admin\ProfileController@edit', ['id' => $profile->id]);
      }

      public function delete(Request $request)
      {
        $profile = Profile::find($request->id);
        $profile->delete();
        return redirect('admin/profile/');
      }

      // lalavel_18課題　追記
      public function index(Request $request)
      {
        $cond_name = $request->cond_name;
        $cond_gender = $request->cond_gender;

        if ($cond_name != '') {
          // 名前が検索されたら検索結果を取得する
          $p_posts = Profile::where('name', $cond_name)->get();
        } elseif ($cond_gender !='') {
          // 性別が検索されたら検索結果を取得する
          $p_posts = Profile::where('gender' ,$cond_gender)->get();
        } else{
          //上記以外の場合は全てのプロフィールを取得する
          $p_posts = Profile::all();
        }
        return view('admin.profile.index', ['posts' => $p_posts, 'cond_name' => $cond_name, 'cond_gender' => $cond_gender]);
      }

}
