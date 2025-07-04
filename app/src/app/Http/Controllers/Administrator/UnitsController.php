<?php

namespace App\Http\Controllers\Administrator;

use \Exception;
use App\Models\Unit;
use App\Http\Helpers\Jquery;
use Illuminate\Http\Request;
use App\Http\Helpers\UtilHelper;
use App\Http\Helpers\LoggerHelper;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UnitsController extends Controller
{
    use ResponseTrait;

    /**
     * 
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('administrator.units.index', [
            'title'   => 'Unidades',
            'ajaxGet' => Jquery::ajaxGet('url', '/admin/units')
        ]);
    }

    /**
     * 
     * Summary of get
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $status = Unit::select('id', 'code', 'unit', 'active', 'validate')->orderBy('id')->get();
        $data = [];
        foreach ($status as $statu) {
            $link   = '
                <a href="/admin/units/edit/' . $statu->id . '" title="Editar"><span class="uc-icon">edit</span></a>&nbsp;&nbsp;
                <a href="/admin/units/delete/' . $statu->id . '" class="btnDelete" title="Eleminar"><i class="uc-icon">delete</i></a>&nbsp;&nbsp';
            $data[] = [
                $link,
                $statu->active == 1 ? 'Sí' : 'No',
                $statu->validate == 1 ? 'Sí' : 'No',
                $statu->code,
                UtilHelper::ucTexto($statu->unit),
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     * 
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('administrator.units.add', [
            'title'   => 'Unidades',
            'ajaxAdd' => Jquery::ajaxPost('actionForm', '/admin/units')
        ]);
    }

    /**
     * 
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|string|UnitsController|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'      => ['required'],
                'validate'  => 'required',
                'active'    => 'required',
            ], [
                'name'      => 'Nombre no es válido.',
                'validate'  => 'Validado no es válido.',
                'active'    => 'Activo no es válido.',
            ]);
            $code   = $request->input('code') ?? 0;
            $name   = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $unit = Unit::where('unit', $name)->first();
            if ($unit) {
                throw new Exception('Unidad registrada anteriormente.');
            }
            $unit = Unit::withTrashed()->where('unit', $name)->first();
            if ($unit) {
                $unit->restore();
            } else {
                $unit = new Unit();
                $unit->unit     = $name;
                $unit->code     = $code;
                $unit->validate = (int) $request->input('validate') == 1 ? true : false;
                $unit->active   = (int) $request->input('active') == 1 ? true : false;
                $unit->save();
            }
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'ADD|OK|UNIT:' . $unit->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $unit
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
     * Summary of edit
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            abort(404);
        }
        return view('administrator.units.edit', [
            'title'   => 'Unidades',
            'unit' => $unit,
            'ajaxUpdate' => Jquery::ajaxPost('actionForm', '/admin/units')
        ]);
    }

    /**
     * 
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return bool|mixed|string|UnitsController|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id'        => ['required'],
                'name'      => ['required'],
                'validate'  => 'required',
                'active'    => 'required',
            ], [
                'id'        => 'ID no es válido',
                'name'      => 'Nombre no es válido.',
                'validate'  => 'Validado no es válido.',
                'active'    => 'Activo no es válido.',
            ]);
            $code   = $request->input('code') ?? 0;
            $name   = mb_convert_case($request->input('name'), MB_CASE_UPPER);
            $unit = Unit::find($request->input('id'));
            if (!$unit) {
                throw new Exception('Unidad no registrado.');
            }
            $unitsArray = Unit::where('unit', $name);
            if ($unitsArray->count() > 0) {
                foreach ($unitsArray->get() as $uuunits) {
                    $uuunits = (object)$uuunits;
                    if ($uuunits->id != $unit->id) {
                        throw new Exception('Unidad registrado anteriormente.');
                    }
                }
            }
            $unit->unit     = $name;
            $unit->code     = $code;
            $unit->validate = (int) $request->input('validate') == 1 ? true : false;
            $unit->active     = (int) $request->input('active') == 1 ? true : false;
            $unit->save();
            Session::flash('message', 'Datos guardados!');
            LoggerHelper::add($request,  'UPDATE|OK|UNIT:' . $unit->id);
            return response()->json([
                'success'   => 'ok',
                'data'      => $unit
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
     * Summary of destroy
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @throws \Exception
     * @return bool|mixed|string|UnitsController|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                throw new Exception('Unidad no existe.');
            }
            $unit->delete();
            Session::flash('message', 'Datos eliminados!');
            LoggerHelper::add($request, 'DELETE|OK|UNIT:' . $id . '|' . json_encode($unit->toArray()));
            return response()->json([
                'success'   => 'ok',
                'data'      => $unit
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
