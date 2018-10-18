<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\MsheetCreateRequest;
use App\Mbook;
use App\Msection;
use App\Msheet;


class MsheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Mbook $mbook, Msection $msection)
    {
        $msheets = Msheet::ofSection($msection->id)->ordered()->paginate(20);

        return view('msheets.index', compact('mbook', 'msection', 'msheets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Mbook $mbook, Msection $msection)
    {
        // TODO: problema con colores en crear/editar

        return view('msheets.create', compact('mbook', 'msection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MsheetCreateRequest $request, Mbook $mbook, Msection $msection)
    {
        // TODO: VERIFICAR QUE NO PERMITA EDITAR UNA PÁGINA NO PROPIO DESDE URL
        // IGUAL OTROS VERBOS

        $input = $request->all();

        $sheet = new Msheet();
        $sheet->fill($input);
        $sheet->msection_id = $msection->id;
        $sheet->order = $sheet->getMaxOrder() + 1;
        $sheet->save();

        return redirect()
            ->route('mbooks.msections.msheets.index', [$mbook, $msection])
            ->with('success', '¡Página creada exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        // TODO: revisar que pasa si se ve una página del listado 
        // de secciones paginado en >1

        // TODO: improve headers

        // TODO: problems with main menu bar options

        // TODO: view mbooks

        // TODO: awesome font icons

        $msheets = Msheet::ofSection($msection->id)->ordered()->paginate(20);

        return view('msheets.show', compact('mbook', 'msection', 'msheet', 'msheets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        if($msheet->foreground == null | $msheet->background == null)
        {
            $msheet->customize = 'n';

            $msheet->foreground = $msheet->foreground ?: "#000000";
            $msheet->background = $msheet->background ?: "#ffffff";
        }
        else
            $msheet->customize = 'y';

        return view('msheets.edit', compact('mbook', 'msection', 'msheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MsheetCreateRequest $request, Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        $input = $request->all();

        $msheet->fill($input)->save();

        return redirect()
            ->route('mbooks.msections.msheets.index', [$mbook, $msection])
            ->with('success', '¡Página editada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        $msheet->delete();

        Msheet::reindex($msection);

        return redirect()
            ->route('mbooks.msections.msheets.index', [$mbook, $msection])
            ->with('success', '¡Página removida exitosamente!');
    }

    public function moveUp(Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        $msheet->moveUp();

        return redirect()->back();
    }

    public function moveDown(Mbook $mbook, Msection $msection, Msheet $msheet)
    {
        $msheet->moveDown();

        return redirect()->back();
    }
}