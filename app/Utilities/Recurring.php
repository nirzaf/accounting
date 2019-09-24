<?php

namespace App\Utilities;

use Date;

class Recurring
{

    public static function reflect(&$items, $type, $issued_date_field, $status)
    {
        foreach ($items as $key => $item) {
            if (($item->getTable() == 'bill_payments') || ($item->getTable() == 'invoice_payments')) {
                $i  = $item->$type;
                $i->category_id = $item->category_id;

                $item = $i;
            }

            if (($status == 'upcoming') && (($type == 'revenue') || ($type == 'payment'))) {
                $items->forget($key);
            }

            if (!$item->recurring || !empty($item->parent_id)) {
                continue;
            }

            foreach ($item->recurring->schedule() as $recurr) {
                $issued = Date::parse($item->$issued_date_field);
                $start = $recurr->getStart();

                if ($issued->format('Y') != $start->format('Y')) {
                    continue;
                }

                if (($issued->format('Y-m') == $start->format('Y-m')) && ($issued->format('d') >= $start->format('d'))) {
                    continue;
                }

                $clone = clone $item;

                $start_date = Date::parse($start->format('Y-m-d'));

                if (($type == 'invoice') || ($type == 'bill')) {
                    // Days between invoiced/billed and due date
                    $diff_days = Date::parse($clone->due_at)->diffInDays(Date::parse($clone->invoiced_at));

                    $clone->due_at = $start_date->addDays($diff_days)->format('Y-m-d');
                }

                $clone->parent_id = $item->id;
                $clone->created_at = $start_date->format('Y-m-d');
                $clone->$issued_date_field = $start_date->format('Y-m-d');

                $items->push($clone);
            }
        }
    }
}