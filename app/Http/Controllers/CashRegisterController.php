<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->cashRegisters()->open()->exists()) {
            return back()->with('error', 'Já existe um caixa aberto para este usuário.');
        }

        $data = $request->validate([
            'opening_balance' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $user->cashRegisters()->create([
            'opening_balance' => $data['opening_balance'],
            'notes' => $data['notes'] ?? null,
            'opened_at' => now(),
        ]);

        return back()->with('success', 'Caixa aberto com sucesso.');
    }

    public function close(Request $request)
    {
        $user = $request->user();
        $register = $user->cashRegisters()->open()->latest()->first();

        if (! $register) {
            return back()->with('error', 'Nenhum caixa aberto encontrado.');
        }

        $data = $request->validate([
            'closing_balance' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $register->update([
            'closing_balance' => $data['closing_balance'],
            'notes' => $data['notes'] ?? $register->notes,
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Caixa fechado com sucesso.');
    }
}
