<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends MyBaseController
{
    /**
     * Show the User dashboard
     *
     * @param $iser_id
     * @return mixed
     */
    public function showDashboard($user_id)
    {
        $user = User::findOrFail($user_id);

        // Fetch all orders for the user's account
        $orders = Order::where('account_id', $user->account_id)
            ->with(['event', 'attendees']) // Include related data
            ->get();

        // Calculate ticket count across all orders
        $ticketCount = $orders->sum(fn($order) => $order->attendees->count());

        // Get upcoming unique events
        $upcomingEvents = $orders->pluck('event')
            ->filter(fn($event) => $event && Carbon::parse($event->start_date)->isFuture())
            ->unique('id');

        $data = [
            'user' => $user,
            'orders' => $orders,
            'ticketCount' => $ticketCount,
            'orderCount' => $orders->count(),
            'upcomingEvents' => $upcomingEvents,
        ];

        return view('ManageUser.Dashboard', $data);
    }



    /**
     * Redirect to user dashboard
     * @param  Integer|false $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToDashboard($user_id = false) {
        return redirect()->action(
            'UserDashboardController@showDashboard', ['user_id' => $user_id]
        );
    }
    /**
     * Show user ticket(s)
     * @param Request $request
     * @param $user_id
     * @return mixed
     */

public function showTickets(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        // Get all orders for the user
        $orders = Order::where('account_id', $user->account_id)->pluck('id');

        // Fetch tickets (order items) and related events for upcoming events
        $orderItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->where('orders.account_id', $user->account_id)
            ->where('events.start_date', '>', Carbon::now())
            ->select(
                'order_items.id as ticket_id',
                'order_items.title as ticket_title',
                'order_items.quantity',
                'order_items.unit_price',
                'events.id as event_id',
                'events.title as event_title',
                'events.start_date',
                'events.venue_name',
                'orders.order_reference'
            )
            ->get();

        // Group tickets by event
        $events = $orderItems->groupBy('event_id');

        $data = [
            'user' => $user,
            'events' => $events,
            'css' => file_get_contents(public_path('assets/stylesheet/ticket.css')),
        ];

        // Return view
        return view('ManageUser.Tickets', $data);
    }

}
