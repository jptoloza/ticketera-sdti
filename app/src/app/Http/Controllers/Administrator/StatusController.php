<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use App\Models\Status;
use App\Http\Helpers\Jquery;
use Illuminate\Http\Request;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class StatusController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('administrator.status.index', [
            'title'   => 'Estados',
            'ajaxGet' => Jquery::ajaxGet('url', '/admin/status')
        ]);
    }

    /**
     * 
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $status = Status::select('id', 'status', 'global_key', 'active')->orderBy('id')->get();
        $data = [];

        foreach ($status as $statu) {
            $link   = '
                <a href="/admin/status/edit/' . $statu->id . '" title="Editar"><span class="uc-icon">edit</span></a>&nbsp;&nbsp;
                <a href="/admin/status/delete/' . $statu->id . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>&nbsp;&nbsp';
            $data[] = [
                $link,
                $statu->active == 1 ? 'Sí' : 'No',
                $statu->global_key,
                $statu->status,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.status.add', [
            'title'   => 'Estados',
            'ajaxAdd' => Jquery::ajaxPost('actionForm', '/admin/status')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'              => ['required'],
                'global_key'        => ['required'],
                'active'            => 'required',
            ], [
                'name'              => 'Nombre no es válido.',
                'global_key'        => 'Global Key no es válido.',
                'active'            => 'Activo no es válido.',
            ]);

            $name     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $global_key = mb_convert_case($request->input('global_key'), MB_CASE_UPPER);
            $status = Status::where('status', $name)
                ->orWhere('global_key', $global_key)->first();
            if ($status) {
                throw new Exception('Estado registrado anteriormente.');
            }
            $status = new Status();
            $status->status     = $name;
            $status->global_key = $global_key;
            $status->active     = (int) $request->input('active') == 1 ? true : false;
            $status->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'ADD|OK|STATUS:' . $status->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $status
            ], 201);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = Status::find($id);
        if (!$status) {
            abort(404);
        }
        return view('administrator.status.edit', [
            'title'   => 'Estados',
            'status' => $status,
            'ajaxUpdate' => Jquery::ajaxPost('actionForm', '/admin/status')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id'            => ['required'],
                'name'          => ['required'],
                'global_key'    => ['required'],
                'active'        => 'required',
            ], [
                'id'            => 'ID no es válido',
                'name'          => 'Nombre no es válido.',
                'global_key'    => 'Global Key no es válido.',
                'active'        => 'ctivo no es válido.',
            ]);

            $name     = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $global_key = mb_convert_case($request->input('global_key'), MB_CASE_UPPER);
            $status = Status::find($request->input('id'));
            if (!$status) {
                throw new Exception('Estado no registrado.');
            }
            $statusArray = Status::where('status',$name)
                ->orWhere('global_key',$global_key);
            if ($statusArray->count() > 0) {
                foreach ($statusArray->get() as $uustatus) {
                    $uustatus = (object)$uustatus;
                    if ($uustatus->id != $status->id) {
                        throw new Exception('Estado registrado anteriormente.');
                    }
                }
            }
            $status->status     = $name;
            $status->global_key = $global_key;
            $status->active     = (int) $request->input('active') == 1 ? true : false;
            $status->save();

            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|STATUS:' . $status->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $status
            ], 201);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request, $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }

    /**
     * 
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $status = Status::find($id);
            if (!$status) {
                throw new Exception('Status no existe.');
            }
            $status->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|STATUS:' . $id . '|' . json_encode($status->toArray()));
            return response()->json([
                'success'   => 'ok',
                'data'      => $status
            ], 200);
        } catch (ValidationException $e) {
            return $this->responseErrorValidattion($request, $e->errors());
        } catch (Exception $e) {
            $message = $e->getMessage();
            $message = LoggerHelper::add($request,  $message);
            return response()->json([
                'success'   => 'error',
                'message'   => $message,
            ], 400);
        }
    }
}
