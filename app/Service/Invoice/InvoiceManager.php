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
                $itemQuantities = [];
                $availableItem = [];
                foreach ($items as $itemData) {
                    $itemId = $itemData['invoice_item_id'];
                    
                    if (!isset($itemQuantities[$itemId])) {
                        $itemQuantities[$itemId] = 0;
                    }
                    $itemQuantities[$itemId] += $itemData['quantity'];
                    //return $itemQuantities[$itemId];

                    $item = resolve(ItemRepository::class)->get($itemData['invoice_item_id']);

                    // let us check if the item we want to create already exist in the system
                    if($item)
                    {
                        if ($item->available_quantity < $itemQuantities[$itemId]) {
                            throw new InvoiceException('Insufficient quantity for item');
                        }
                        $item->sell($itemData['quantity']);

                        $availableItem[$itemId] = $item->available_quantity;

                    }
                    
                }

                
                $invoice = resolve(InvoiceRepository::class)->createInvoice($data);
                foreach ($items as $itemData) {
                    
                    $itemId = $itemData['invoice_item_id'];
                    
                    // let us check if the item already exist
                    // if it exist we replace the item with the new value 
                   if(isset($availableItem[$itemId]))
                   {
                    $newItem = array_merge([
                        'available_quantity' => $availableItem[$itemId]
                    ],$itemData);
                    
                    $invoice->items()->create($newItem);
                   }
                   else
                   {
                    $newItem = array_merge([
                            'available_quantity' => 6
                        ],$itemData);

                        $invoice->items()->create($newItem);
                   }
                   
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
        $deleted =  resolve(InvoiceRepository::class)->deleteInvoice($id);
        if($deleted)
        {
            return true;
        }
        else
        {
            throw new InvoiceException("Could not delete this id: $id");
        }
    }
}
