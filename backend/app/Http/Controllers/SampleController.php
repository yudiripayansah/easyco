<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Sample;
use App\Models\Submission;

class SampleController extends Controller
{
  public function list(Request $request)
  {
    $offset = 0;
    $page = 1;
    $perPage = '~';
    $sortDir = 'DESC';
    $sortBy = 'updated_at';
    $search = null;
    $total = 0;
    $totalPage = 1;
    $type = null;
    $category = null;
    $id_user = null;
    if ($request->page) {
      $page = $request->page;
    }
    if ($request->perPage) {
      $perPage = $request->perPage;
    }
    if ($request->sortDir) {
      $sortDir = $request->sortDir;
    }
    if ($request->sortBy) {
      $sortBy = $request->sortBy;
    }
    if ($request->search) {
      $search = $request->search;
    }
    if ($page > 1) {
      $offset = ($page - 1) * $perPage;
    }
    $listData = Sample::select('promo.*')->orderBy($sortBy, $sortDir);
    if ($perPage != '~') {
      $listData->skip($offset)->take($perPage);
    }
    if ($search != null) {
      $listData->whereRaw('(promo.title LIKE "%'.$search.'%")');
    }

    $listData = $listData->get();
    foreach($listData as $ld){
      $useCount = 'used count diubah datanya disini';
      $ld->used_count = $useCount;
    }
    if ($search || $id_user || $type) {
      $total = Sample::orderBy($sortBy, $sortDir);
      if ($search) {
        $total->whereRaw('(promo.title LIKE "%'.$search.'%")');
      }
      $total = $total->count();
    } else {
      $total = Sample::all()->count();
    }
    if ($perPage != '~') {
      $totalPage = ceil($total / $perPage);
    }
    $res = array(
      'status' => true,
      'data' => $listData,
      'page' => $page,
      'perPage' => $perPage,
      'sortDir' => $sortDir,
      'sortBy' => $sortBy,
      'search' => $search,
      'total' => $total,
      'totalPage' => $totalPage,
      'msg' => 'List data available'
    );
    return response()->json($res, 200);
  }
  public function get(Request $request)
  {
    if ($request->id) {
      $getData = Sample::find($request->id);
      if ($getData) {
        $res = array(
        'status' => true,
        'data' => $getData,
        'msg' => 'Data available'
        );
      } else {
        $res = array(
        'status' => false,
        'msg' => 'Data not found'
        );
      }
    } else {
      $res = array(
        'status' => false,
        'msg' => 'No data selected'
      );
    }
    return response()->json($res, 200);
  }
  public function create(Request $request)
  {
    $dataCreate = $request->all();
    $image = $request->image;
    DB::beginTransaction();
    if ($image) {
      $imageName = time() . '-promo.png';
      $imagePath = 'promo/' . $imageName;
      Storage::disk('public')->put($imagePath, file_get_contents($image));
      $dataCreate['image'] = Storage::disk('public')->url($imagePath);
    }
    $validate = Sample::validate($dataCreate);
    if ($validate['status']) {
      try {
        $dc = Sample::create($dataCreate);
        $promo = Sample::find($dc->id);
        $res = array(
          'status' => true,
          'data' => $promo,
          'msg' => 'Data successfully created'
        );
        DB::commit();
      } catch (Exception $e) {
        DB::rollback();
        $res = array(
          'status' => false,
          'data' => $dataCreate,
          'msg' => 'Failed to create data'
        );
      }
    } else {
      $res = array(
        'status' => false,
        'data' => $dataCreate,
        'msg' => 'Validation failed',
        'errors' => $validate['error']
      );
    }
    return response()->json($res, 200);
  }
  public function update(Request $request)
  {
    $notif = null;
    $updateData = Sample::find($request->id);
    $image = $request->image;
    $validate = Sample::validate($request->all());
    $updateData->title = $request->title;
    $updateData->desc = $request->desc;
    if (basename($image) != basename($updateData->image)) {
      $imageName = time() . '-promo.png';
      $imagePath = 'promo/' . $imageName;
      Storage::disk('public')->put($imagePath, file_get_contents($image));
      $updateData->image = Storage::disk('public')->url($imagePath);
    }
    $updateData->code = $request->code;
    $updateData->value = $request->value;
    $updateData->allocation = $request->allocation;
    $updateData->max_per_user = $request->max_per_user;
    DB::beginTransaction();
    if ($validate['status']) {
      try {
        $updateData->save();
        $res = array(
          'status' => true,
          'msg' => 'Data Successfully Saved',
          'notif' => $notif
        );
        DB::commit();
      } catch (Exception $e) {
        $res = array(
          'status' => false,
          'msg' => 'Failed to Save Data'
        );
        DB::rollback();
      }
    } else {
      $res = $validate;
    }
    return response()->json($res, 200);
  }
  public function delete(Request $request)
  {
    $id = $request->id;
    if ($id) {
      $delData = Sample::find($id);
      try {
        $delData->forceDelete();
        $res = array(
          'status' => true,
          'msg' => 'Data successfully deleted'
        );
      } catch (Exception $e) {
        $res = array(
          'status' => false,
          'msg' => 'Failed to delete Data'
        );
      }
    } else {
      $res = array(
        'status' => false,
        'msg' => 'No data selected'
      );
    }
    return response()->json($res, 200);
  }
}
