<?php

namespace App\Http\Controllers;

use App\Exceptions\InvoiceException;
use App\Service\Invoice\InvoiceManager;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $invoices = resolve(InvoiceManager::class)->getAll();
        return response()->json($invoices);
    }

    public function store(Request $request)
    {
        try
        {
           $response = resolve(InvoiceManager::class)->create($request);

        }
        catch (HttpResponseException $exception) {
        }
        catch(InvoiceException $exception)
        {

        }
        catch(Exception $exception)
        {

        }
        
        
    }

    
}
