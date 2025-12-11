<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\ExemploRequest as StoreRequest;
use App\Http\Requests\Update\ExemploRequest as UpdateRequest;
use App\Models\Exemplo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExemploController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $ativo = $request->has('ativo') && $request->input('ativo') !== ''
            ? filter_var($request->input('ativo'), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE)
            : null;

        $exemplos = Exemplo::query()
            ->when($search !== '', function ($query) use ($search) {
                $like = "%{$search}%";
                $query->where(function ($q) use ($like) {
                    $q->where('nome', 'like', $like)
                        ->orWhere('descricao', 'like', $like);
                });
            })
            ->when($ativo !== null, fn($query) => $query->where('ativo', $ativo))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('exemplos/Index', [
            'exemplos' => $exemplos,
            'filters' => [
                'search' => $search,
                'ativo' => $request->input('ativo'),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('exemplos/Create');
    }

    public function store(StoreRequest $request)
    {
        $exemplo = Exemplo::create($request->validated());

        return redirect()
            ->route('exemplos.edit', $exemplo)
            ->with('success', 'Exemplo criado com sucesso.');
    }

    public function edit(Exemplo $exemplo)
    {
        return Inertia::render('exemplos/Edit', [
            'exemplo' => $exemplo,
        ]);
    }

    public function update(UpdateRequest $request, Exemplo $exemplo)
    {
        $exemplo->update($request->validated());

        return back()->with('success', 'Exemplo atualizado com sucesso.');
    }

    public function destroy(Exemplo $exemplo)
    {
        $exemplo->delete();

        return redirect()
            ->route('exemplos.index')
            ->with('success', 'Exemplo removido com sucesso.');
    }
}
