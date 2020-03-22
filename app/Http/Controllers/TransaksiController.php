<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\User;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransaksiController extends Controller
{
    public function index(){
    	$data = Transaksi::all();
    	return $data;
    }

    public function store(Request $request){
    	try{
    		if(! $user = JWTAuth::parseToken()->authenticate()){
    			return response()->json(['user_not_found'], 404);
    		}

    		$user = User::where('id', $user['id'])->first();
    		if ($user->saldo < $request->input('jumlah')) {
				return response()->json(['saldo tidak cukup'], 400);
			} else {
				$data = new Transaksi();
	    		$data->username = $user['username'];
	    		$data->jenis =$request->input('jenis');
	    		$data->nama_transaksi =$request->input('nama_transaksi');
	    		$data->jumlah = $request->input('jumlah');
	    		$data->save();

	    		$user = User::where('id', $user['id'])->first();

				if ($request->jenis=='kredit') {
    				$user->saldo = $user->saldo - $request->input('jumlah');
	    			$user->save();
	    		}else if ($request->jenis=='debit') {
	    			$user->saldo = $user->saldo + $request->input('jumlah');
	    			$user->save();
	    		}
			}

    		

    		

    		return response()->json(compact('data', 'user'));
    	} catch(\Exception $e){
    		return "coba";
    	}

    }

    public function update(Request $request){
    	    	//
    		if(! $akun = JWTAuth::parseToken()->authenticate()){
    			return response()->json(['user_not_found'], 404);
    		}

    		$user = User::where('id', $akun['id'])->first();

    		$data = new Transaksi();
    		$data->username = $user->username;
    		$data->jenis =$request->input('jenis');

    		$data->nama_transaksi =$request->input('nama_transaksi');
    		$data->jumlah = $request->input('jumlah');
    		$data->save();
    		$user->saldo = $user->saldo + $request->input('jumlah');
    		$user->save();

    		return response()->json(compact('data', 'user'));
    	}
    	//  catch(\Exception $e){
    	// 	return "coba-coba";
    	// }

    
}
