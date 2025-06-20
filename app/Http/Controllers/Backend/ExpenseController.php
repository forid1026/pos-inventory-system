<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::get();
        $heads = ExpenseHead::where('status', 'active')->get();
        return view('admin.expense.expense_list', compact('expenses', 'heads'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $expense = new Expense();
            $expense->amount = $request->amount;
            $expense->head_id = $request->head_id;
            $expense->date = $request->date;
            $expense->description = $request->description;
            $expense->save();

            DB::commit();

            return redirect()->route('expense.index')->with('success', 'Expense created successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            Log::error('Error creating expense: ' . $th->getMessage());
            return redirect()->route('expense.index')->with('error', 'Failed to create expense.');
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::findOrFail($request->id);
            $expense->amount = $request->amount;
            $expense->head_id = $request->head_id;
            $expense->date = $request->date;
            $expense->description = $request->description;
            $expense->save();

            DB::commit();

            return redirect()->route('expense.index')->with('success', 'Expense updated successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            Log::error('Error updating expense: ' . $th->getMessage());
            return redirect()->route('expense.index')->with('error', 'Failed to update expense.');
        }
    }
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $expense = Expense::findOrFail($request->id);
            $expense->delete();

            DB::commit();

            return redirect()->route('expense.index')->with('success', 'Expense deleted successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            Log::error('Error deleting expense: ' . $th->getMessage());
            return redirect()->route('expense.index')->with('error', 'Failed to delete expense.');
        }
    }
    public function bulkDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->ids;
            if (!$ids || count($ids) === 0) {       
                return redirect()->route('expense.index')->with('error', 'No expenses selected for deletion.');
            }
            foreach ($ids as $id) {
                $expense = Expense::findOrFail($id);
                $expense->delete();
            }
            DB::commit();
            return redirect()->route('expense.index')->with('success', 'Expenses deleted successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            Log::error('Error bulk deleting expenses: ' . $th->getMessage());
            return redirect()->route('expense.index')->with('error', 'Bulk delete failed. Please try again!');
        }
    }


    // Expense Head Methods
    public function ExpenseHeadIndex()
    {
        $expense_heads = ExpenseHead::all(); 
        return view('admin.expense.head.head_list', compact('expense_heads'));
    }
    public function ExpenseHeadStore(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $expense_head = new ExpenseHead();
            $expense_head->name = $request->name;
            $expense_head->status = $request->status;
            $expense_head->save();

            DB::commit();

            return redirect()->route('expense.head.index')->with('success', 'Expense head created successfully.');
        } catch (Exception $th) {
            DB::rollBack();

            Log::error('Error creating expense head: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Expense head creation failed. Please try again!');
        }
    }
    public function ExpenseHeadUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $expense_head = ExpenseHead::findOrFail(request()->id);
            $expense_head->name = $request->name;
            $expense_head->status = $request->status;
            $expense_head->save();

            DB::commit();

            return redirect()->route('expense.head.index')->with('success', 'Expense head updated successfully.');
        } catch (Exception $th) {
            DB::rollBack();

            Log::error('Error updating expense head: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Expense head update failed. Please try again!');
        }
    }

    public function ExpenseHeadDestroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $expense_head = ExpenseHead::findOrFail($request->id);
            $expense_head->delete();

            DB::commit();

            return redirect()->route('expense.head.index')->with('success', 'Expense head deleted successfully.');
        } catch (Exception $th) {
            DB::rollBack();

            Log::error('Error deleting expense head: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Expense head deletion failed. Please try again!');
        }
    }
    public function ExpenseHeadBulkDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->ids;
            if (!$ids || count($ids) === 0) {       
                return redirect()->route('expense.head.index')->with('error', 'No expense head selected for deletion.');
            }
            foreach ($ids as $id) {
                $expense_head = ExpenseHead::findOrFail($id);
                $expense_head->delete();
            }
            DB::commit();
            return redirect()->route('expense.head.index')->with('success', 'Expense heads deleted successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            Log::error('Error bulk deleting expense heads: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Bulk delete failed. Please try again!');
        }
    }


}
