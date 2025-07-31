<?php

namespace Src\Customers\Service;
use App\Facades\ImageServiceFacade;
use Src\Customers\Models\Customer;

class CustomerServices
{
    public function avatar($data, $customer)
    {
        $path = config('src.Customers.customer.avatar_path');
            $image = ImageServiceFacade::base64Save(
                file: $data->avatar, 
                path: $path, 
                disk: getStorageDisk('public'));

        return Customer::updateOrCreate(
                ['id' => $customer->id],
                ['avatar' => $image]
            );
    }
}