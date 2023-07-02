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
                    // if it exist we replace the item with the new 'available quantity
                   if(isset($availableItem[$itemId]))
                   {
                    $newItem = array_merge([
                        'available_quantity' => $availableItem[$itemId]
                    ],$itemData);
                    
                    $invoice->items()->create($newItem);
                   }
                   else
                   {
                    // this is the first time creating an order with that quantity
                    // we set a default available quantity left to 6 after creating the item
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
        $updated_invoice = [
            'issue_date'=>$request->issue_date,
            'due_date'=>$request->due_date,
            'customer_id'=>$request->customer_id,
        ];

        try
        {
            // let us check if item has data for us to update
            // let us check if the invoice exist

            $invoice = resolve(InvoiceRepository::class)->getSingle($id);
            if($invoice == null)
            {
                throw new InvoiceException("There is no invoice with an id of $id"); 
            }
            $items = $request->items;
            // let us check if there are items then we update it with the new list
            if (isset($items) && count($items)) {

                foreach ($items as $itemData) {
                  
                   $item = $invoice->items()->where('id', $itemData['id'])->where('invoice_item_id', $itemData['invoice_item_id'])->first();

                   if (!$item) {
                    $invoice_item_id =  $itemData['invoice_item_id'];
                    throw new InvoiceException("No item found with this id $invoice_item_id");
                   }

                   // getting the last available quantity value to make sure we dont over sell since an invoice can have at least one item
                   
                    $last_item = resolve(ItemRepository::class)->get($itemData['invoice_item_id']);
                    $originalQuantity = $last_item->available_quantity;
                    $newQuantity = $itemData['quantity'];
                    // let us check if the new quanity we want to update to is greater that remaining available quantity
                    if ($newQuantity > 0 && $newQuantity <= $originalQuantity) {
                         // let us update the available quantity also to prevent over selling
                        $last_item->sell($itemData['quantity']);
                        // let us update the item with the new item
                        $item->update($itemData);
                    } else {
                        throw new InvoiceException('Insufficient quantity for item');
                    }

                }
            }

            // let us update the invoice part also
            $invoice = resolve(InvoiceRepository::class)->updateInvoice($updated_invoice,$id);

            return $invoice;
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
