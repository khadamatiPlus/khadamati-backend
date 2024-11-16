<?php

namespace App\Domains\Delivery\Http\Transformers;

use App\Domains\Delivery\Models\CashoutTransaction;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 4/26/2022
 * Class: CashoutTransactionTransformer.php
 */
class CashoutTransactionTransformer
{

    /**
     * @param CashoutTransaction $cashoutTransaction
     * @return array
     */
    public function transform(CashoutTransaction $cashoutTransaction)
    {
        return [
            'id' => $cashoutTransaction->id,
            'branch_name' => $cashoutTransaction->merchantBranch->name,
            'total_revenue' => floatval(numberFormatPrecision($cashoutTransaction->total_cashed_out)),
            'captain_name' => !empty($cashoutTransaction->captain_id)?$cashoutTransaction->captain->captain->first_name.' '.$cashoutTransaction->captain->captain->last_name:'',
            'transaction_date' => $cashoutTransaction->created_at,
            'orders_count' => $cashoutTransaction->cashoutTransactionsOrders()->count()
        ];
    }
}
