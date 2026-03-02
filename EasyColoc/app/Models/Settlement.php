<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $table = 'settlement';

    protected $fillable = [
        'amount',
        'payed',
        'payer_id',
        'receiver_id',
        'colocation_id',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    protected $casts = [
        'payed' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public static function recalculateForColocation($colocationId)
    {
        $colocation = Colocation::with(['members', 'expenses'])->findOrFail($colocationId);
        $members = $colocation->members;
        
        if ($members->count() <= 1) {
            self::where('colocation_id', $colocationId)->delete();
            return;
        }

        // calcule du  balance
        $balances = [];
        foreach ($members as $member) {
            $balances[$member->id] = 0;
        }

        foreach ($colocation->expenses as $expense) {
            $payerId = $expense->user_id;
            $amount = $expense->amount;
            
            // division du amount sur les membres
            $others = $members->where('id', '!=', $payerId);
            if ($others->count() > 0) {
                $share = $amount / $others->count();
                foreach ($others as $other) {
                    $balances[$other->id] -= $share;
                    $balances[$payerId] += $share;
                }
            }
        }

        // delete existing unpaid settlements
        self::where('colocation_id', $colocationId)->where('payed', false)->delete();

        // spliting into debtors and creditors
        $debtors = [];
        $creditors = [];

        foreach ($balances as $userId => $balance) {
            if ($balance < -0.01) {
                $debtors[] = ['id' => $userId, 'amount' => abs($balance)];
            } elseif ($balance > 0.01) {
                $creditors[] = ['id' => $userId, 'amount' => $balance];
            }
        }

        // Match debtors with creditors
        $i = 0; $j = 0;
        while ($i < count($debtors) && $j < count($creditors)) {
            $debtor = &$debtors[$i];
            $creditor = &$creditors[$j];

            $amount = min($debtor['amount'], $creditor['amount']);

            if ($amount > 0.01) {
                self::create([
                    'payer_id' => $debtor['id'],
                    'receiver_id' => $creditor['id'],
                    'amount' => $amount,
                    'colocation_id' => $colocationId,
                    'payed' => false,
                ]);
            }

            $debtor['amount'] -= $amount;
            $creditor['amount'] -= $amount;

            if ($debtor['amount'] < 0.01) $i++;
            if ($creditor['amount'] < 0.01) $j++;
        }
    }
}
