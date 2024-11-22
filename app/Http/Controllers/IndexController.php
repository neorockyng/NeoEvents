<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class IndexController extends Controller
{
    /**
     * redirect index page
     * @param  Request $request http request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showIndex(Request $request)
    {
        // Check if the user is authenticated (this is already handled by the 'auth' middleware)
        if (Auth::check()) {
            $user = Auth::user();
            
            $order = Order::where('account_id', $user->account_id)->first();
            //dd($order);
            // Check the user's role and redirect accordingly
            if ($user->role === 'User') {
                return redirect()->route('showOrderDetails', [
                    'is_embedded'     => 1, //$this->is_embedded,
                    'order_reference' => $order['order_reference'],
                ]); // Redirect 'User' role to 'showOrderTicket'
            }
        }
        return redirect()->route('showSelectOrganiser');
    }
}
