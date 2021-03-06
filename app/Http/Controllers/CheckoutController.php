<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Base\Controller;
use App\Helpers\Response;
use App\Models\User;
use App\Models\UserBillingDetail;

class CheckoutController extends Controller
{
    public function updateBillingDetail()
    {
        $validator = Validator::make(request()->all(), [
          'firstname' => 'required',
          'lastname' => 'required',
          'email' => 'required|email',
          'phone' => 'required',
          'country' => 'required',
          'region' => 'required',
          'city' => 'required',
          'street' => 'required',
          'postcode' => 'required',
        ]);

        if (!Auth::check()) {
            $user = new User();
            $user->firstname = 'Guest';
            $user->lastname = 'Guest';
            $user->password = 'Guest';
            $user->save();
            $billing_detail = new UserBillingDetail();
        } else {
            $user = Auth::user();
            $billing_detail = $user->billing_detail;

            if (!isset($billing_detail)) {
                $billing_detail = new UserBillingDetail();
            }
        }

        $billing_detail->user_id = $user->id;
        $billing_detail->forceFill(request()->only([
          'firstname',
          'lastname',
          'email',
          'company',
          'company_vat',
          'phone',
          'building',
          'street',
          'postcode',
          'country',
          'region',
          'city'
        ]));

        $billing_detail->save();

        Auth::login($user);

        $user->billing_detail;

        if ($validator->fails()) {
            return Response::build($validator->errors()->first(), 500);
        }

        return Response::build($user);
    }
}
