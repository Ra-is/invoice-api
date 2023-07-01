<?php

namespace App\Service\Invoice;

use App\Exceptions\InvoiceException;
use App\Service\Item\ItemRepository;
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
        $data = [
            'issue_date'=>$request->issue_date,
            'due_date'=>$request->due_date,
            'customer_id'=>$request->customer_id,
        ];
        try
        {
            
            $items = $request->items;
            if(count($items))
            {
                foreach ($items as $itemData) {
                    $item = resolve(ItemRepository::class)->get($itemData['item_id']);
                    if ($item->available_quantity < $itemData['quantity']) {
                        throw new InvoiceException('Insufficient quantity for item');
                    }
                    $item->sell($itemData['quantity']);
                }

                
                $invoice = resolve(InvoiceRepository::class)->createInvoice($data);
                foreach ($items as $itemData) {
                    $invoice->items()->create($itemData);
                }

                return $invoice;
            }
            else
            {
                throw new InvoiceException('No Items found in the payload');
            }

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
