<?php

namespace App\Http\Controllers;

use App\Exceptions\InvoiceException;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use App\Service\Invoice\InvoiceManager;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CustomerInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = resolve(InvoiceManager::class)->getAll();
        
        if(count($invoices))
        {
            $response = [
                'message' => 'Retrieve',
                'data'=>$invoices
            ];
            $request->merge($response);
            return new SuccessResponse($request);
        }
        else
        {
            return new ErrorResponse('No Invoice Created');
        }
        
    }

    public function get(Request $request, $id)
    {

        try
        {
            $invoice = resolve(InvoiceManager::class)->get($id);
            $response = [
                'message' => 'Retrieve',
                'data'=>$invoice
            ];
            $request->merge($response);
            return new SuccessResponse($request);
        }
        catch(InvoiceException $exception)
        {
            return new ErrorResponse($exception->getMessage());
        }
        catch(Exception $exception)
        {
            report($exception);
            return new ErrorResponse('Something went wrong');
        } 

    }

    public function create(CreateInvoiceRequest $request)
    {
        try
        {
           $response = resolve(InvoiceManager::class)->create($request);
           $request->merge(['message' => 'Created','data' => $response]);
           return new SuccessResponse($request);
        }
        catch (HttpResponseException $exception) {
            return new FailResponse($exception);
        }
        catch(InvoiceException $exception)
        {
            report($exception);
            return new ErrorResponse($exception->getMessage());
        }
        catch(Exception $exception)
        {
            report($exception);
            return new ErrorResponse('Something went wrong');
        }
    }

    public function update(UpdateInvoiceRequest $request, $id)
    {
        try
        {
           $response = resolve(InvoiceManager::class)->update($request, $id);
           $request->merge(
            [
                'message' => 'Updated',
                'data' => $response
            ]
        );
           return new SuccessResponse($request);
        }
        catch (HttpResponseException $exception) {
            return new FailResponse($exception);
        }
        catch(InvoiceException $exception)
        {
            report($exception);
            return new ErrorResponse('Could not update invoice');
        }
        catch(Exception $exception)
        {
            report($exception);
            return new ErrorResponse('Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        try
        {
            $invoice = resolve(InvoiceManager::class)->delete($id);
            $response = [
                'message' => 'Deleted'
            ];
            $request->merge($response);
            return new SuccessResponse($request);
        }
        catch(InvoiceException $exception)
        {
            return new ErrorResponse($exception->getMessage());
        }
        catch(Exception $exception)
        {
            report($exception);
            return new ErrorResponse('Something went wrong');
        } 

    }
}
