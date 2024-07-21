<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all()->sortBy('created_at');

        $accumulatedTotals = $labels = [];
        $total = 0;

        foreach ($transactions as $transaction) {
            $transaction['type'] == 'income' ? $total += $transaction->amount : $total -= $transaction->amount;
            $accumulatedTotals[] = $total;
            $labels[] = $transaction['id'];
        }
    
        return view('welcome', [
            'transactions' => $transactions,
            'labels' => $labels,
            'amounts' => $accumulatedTotals
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['transaction-amount'] = (float)str_replace(',', '.', $request['transaction-amount']);

        $validatedData = $request->validate([
            'transaction-description' => 'required|string|max:255',
            'transaction-amount' => 'required|numeric',
            'transaction-type' => 'required|in:income,outcome',
        ]);

        DB::beginTransaction();

        try {

            $transaction = Transaction::create([
                'description' => $request['transaction-description'],
                'amount' => $request['transaction-amount'],
                'type' => $request['transaction-type'],
                'date' => Carbon::now()->format('Y-m-d'),

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        DB::commit();

        return redirect()->back()->with('success', 'Transaction added successfully!');
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
        //
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
        //
    }
}
