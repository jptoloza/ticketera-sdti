<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Jquery;
use App\Http\Helpers\Util;
use App\Models\Status;


class StatusController extends Controller
{
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

    public function get()
    {
        $status = Status::select(
            'status.id',
            'status.status',
            'status.active',
        )->get();

        $data = [];

        foreach ($status as $statu) {
            $link   = '
                <a href="/admin/status/edit/' . $statu->id . '" title="Editar"><span class="uc-icon">edit</span></a>&nbsp;&nbsp;
                <a href="/admin/status/delete/' . $statu->id . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>&nbsp;&nbsp'; 
            $data[] = [
                $link,
                $statu->active == 1 ? 'Sí' : 'No',
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

    public function editForm($id)
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    {
        try {
            $status = Status::find($id);
            if (!$status) {
                throw new Exception('Usuario no existe.');
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
}
