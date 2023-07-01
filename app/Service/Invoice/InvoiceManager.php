<?php

namespace App\Service\Invoice;

use App\Exceptions\InvoiceException;
use Exception;

class InvoiceManager
{
    public function getAll()
    {
        return resolve(InvoiceRepository::class)->getAllInvoice();
    }

    public function get($id)
    {
        $invoice = resolve(InvoiceRepository::class)->getSingle($id);
        if($invoice)
        {
            return $invoice;
        }
        else
        {
            throw new InvoiceException('No invoice found');
        }
    }

    public function create($request)
    {
        $data = [];

        try
        {
            return resolve(InvoiceRepository::class)->createInvoice($data);
        }
        catch(InvoiceException $invoiceException)
        {
            throw $invoiceException;
        }
        catch(Exception $exception)
        {
            throw $exception;
        }
    }

    public function update($request, $id)
    {
        $data = [];

        try
        {
            return resolve(InvoiceRepository::class)->createInvoice($data);
        }
        catch(InvoiceException $invoiceException)
        {
            throw $invoiceException;
        }
        catch(Exception $exception)
        {
            throw $exception;
        }
    }

    public function delete($id)
    {
        return resolve(InvoiceRepository::class)->deleteInvoice($id);
    }
}
