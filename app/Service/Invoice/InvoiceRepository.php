<?php

namespace App\Service\Invoice;

use App\Models\Invoice;

class InvoiceRepository
{
    public function getAllInvoice()
    {
       return Invoice::with(['customer','items'])->get();
    }

    public function exist($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice)
        {
            return $invoice;
        }
        return null;
    }

    public function getSingle($id)
    {
        $invoice = Invoice::where('id',$id)->with(['customer','items'])->first();
        if($invoice)
        {
            return $invoice;
        }
        return null;
    }

    public function createInvoice($data)
    {
        return Invoice::create($data);
    }

    public function updateInvoice($data, $id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice)
        {
            $invoice->update($data);
            return $invoice;
        }
        return null;
    }

    public function deleteInvoice($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice)
        {
            $invoice->delete();
            return 1;
        }
        return null;
    }
}
