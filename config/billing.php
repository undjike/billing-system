<?php

return [
    /*
     * Whether the bill statuses should be set automatically.
     */
    'auto_bill_status' => true,

    /*
     * Maximum unpaid bills to keep.
     * NOTE: Default is set to 0 meaning that no unpaid bills can be keep.
     */
    'max_unpaid_bills' => 0,

    /*
     * Exception to throw when maximum unpaid bills is reached.
     * NOTE: Default is `402`, means that the error will be thrown through `abort(402)`
     */
    'max_unpaid_bills_exception' => 402
];
