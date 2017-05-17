<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //获取所有诗词信息
    public function getPoetryInfo()
    {
    	$users = DB::table('poetries')->get();

    	$arr = ['result'=>0, 'msg'=>'唐诗信息', 'data'=>$users];

        return $arr;
    }

    //获取诗人信息
    public function getPoetInfo()
    {
    	$poets = DB::table('poets')->get();

    	$arr = ['result'=>0, 'msg'=>'诗人信息', 'data'=>$poets];

        return $arr;
    }

    //根据id获取诗人信息
    public function getPoetById(Request $request)
    {
    	$id = $request->get('id');

    	if($id=='random'){
    		$id = rand(1,1000);
    	}

    	$poetry = DB::table('poets')->where(array('id'=>$id))->get();

    	$arr = ['result'=>0, 'msg'=>'诗人详细信息', 'data'=>$poetry];

    	return $arr;

    }

    //根据id获取诗词信息
    public function getPoetryById(Request $request)
    {
    	$id = $request->get('id');

    	$maxid = DB::table('poetries')->max('id');

    	if($id=='random'){
    		$id = rand(1,$maxid);
    	}

    	if($id>$maxid){
    		$id = 1;
    	}
    	
		$poetry = DB::table('poetries')->where(array('id'=>$id))->get();

    	$arr = ['result'=>0, 'msg'=>'诗词详细信息', 'data'=>$poetry];

    	return $arr;
    }

	public function getPoetryByPoetid(Request $request)
	{
		$poetid = $request->get('poetid');

		$poetries = DB::table('poetries')->where(array('poet_id'=>$poetid))->get();

		$arr  = ['result'=>0, 'msg'=>'诗人相关诗词', 'data'=>$poetries];

		return $arr;
	}


	public function search(Request $request)
	{
		$keyword = $request->get('keyword');
		if(empty($keyword)){
			return ['result'=>1, 'msg'=>'请输入关键词', 'data'=>''];
		}
		$arr = array();
		$poets = DB::table('poets')->where('name','like','%'.$keyword.'%')->get();
		foreach($poets as $k=>$v){
			$arr[] = $v->id;
		}
		
		$poetries = DB::table('poetries')->whereIn('poet_id',$arr)->orwhere('content','like','%'.$keyword.'%')->get();

		$arr = ['result'=>0, 'msg'=>'诗词', 'data'=>$poetries];
		
        return $arr;
	}
}
