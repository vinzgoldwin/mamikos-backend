<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;
use App\Kost;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::all();
    }

/* allow user with email password authentication to search kost
that have been added and hide avail_room_count from customer,
it need email and password value for authentication the user is customer or not */

    public function show_kost(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $customer = Customer::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        $kosan = Kost::all();

        if ($customer->customer_id !== null) {
            return $kosan->makeHidden('avail_room_count');
        } else {
            return 'not authenticate';
        }
    }

/*Search kost by city attribute form kosts table
information of kost hasnt avail_room_count (still hidden)*/

    public function filter_city(Request $request, Kost $kost)
    {

        if ($request->has('city')) {

            $kosan = $kost->where('city', $request->input('city'))->get();
            return $kosan->makeHidden('avail_room_count');
        } else {
            return Kost::all();
        }
    }

/*Search kost by kost_name attribute from kosts table
information of kost hasnt avail room (still hidden)*/

    public function filter_name(Request $request, Kost $kost)
    {
        if ($request->has('kost_name')) {
            $kosan = $kost->where('kost_name', $request->input('kost_name'))->get();
            return $kosan->makeHidden('avail_room_count');
        } else {
            return Kost::all();
        }
    }

/*Search kost by price attribute from kosts table
information of kost hasnt avail_room_count (still hidden) */

    public function filter_price(Request $request, Kost $kost)
    {
        if ($request->has('price')) {
            $kosan =  $kost->where('price', $request->input('price'))->get();
            return $kosan->makeHidden('avail_room_count');
        } else {
            return Kost::all();
        }
    }

/*Sort the list of kost based on price using sortBy Descending
sort(from highest price to lowest), we can use Ascending sort too if we want,
the kost wont show its avail_room_count,
it need email and password value for authentication to determine customer or not
*/

    public function sort_price(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        $kosan = Kost::all();
        $kosan = $kosan->sortBy('price', SORT_DESC, true);

        if ($customer->customer_id !== null) {
            return $kosan->makeHidden('avail_room_count');
        } else {
            return 'not authenticate';
        }
    }

//Show User profile of customer, i havent enought time to make the authentication

    public function show($id)
    {
        return Customer::where('Customer_id', $id)->first();
    }

/*create a new customer, we need to determine the status
is regular/premium to determine the number of credit customer has.
we dont need to input the credit our own */

    public function store(Request $request)
    {
        $customer = new Customer;

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => ['required', 'regex:(regular|premium)']
        ]);
        if ($validatedData['status'] == 'regular') {
            $customer->credit =  20;
        } elseif ($validatedData['status'] == 'premium') {
            $customer->credit =  40;
        }

        $customer->name = $validatedData['name'];
        $customer->email = $validatedData['email'];
        $customer->password = $validatedData['password'];
        $customer->status = $validatedData['status'];
        $customer->save();

        return $customer;
    }

/* here is the main feature, the function is to check avail_room_count of a kost they want to see
first the function need authentication using email and password value to check customer or not,
then it will check if the credit of a customer is >= 5 or not, if the credit >= 5, then function will
reduce the credit of a user by 5 and the information of kost will appear and show avail_room_count too,
if the credist < 5, then it will return 'your credit isn't enough */

    public function show_kost_room(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        if ($customer['credit'] >= 5) {
            $customer->decrement('credit', 5);
            return [
                Kost::where('kost_id', $id)->first(),
                'your credit has been charged by 5!'
            ];
        } else {
            return 'your credit is not enough';
        }
    }


    public function update(Request $request, $id)
    {
        $customer = Customer::where('Customer_id', $id)->first();
        $customer->update($request->all());

        return $customer;
    }

    public function delete(Request $request, $id)
    {
        $customer = Customer::where('customer_id', $id)->first();
        $customer->delete();

        return 204;
    }
}
