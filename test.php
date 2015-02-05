<?php

require 'vendor/autoload.php';

putenv('STRIPE_API_KEY=sk_test_HLg0zBxJ8f6yuqhQZrkRlssY');

try
{
    $stripe = new Cartalyst\Stripe\Stripe;

    var_dump($stripe->customers()->find('cus_5Q1deWMlLJnD7U__')->json());
}
//catch (Cartalyst\Stripe\Exception\NotFoundException $e)
catch (Exception $e)
{
    var_dump($e->getMessage());
    #var_dump('Oppps, looks like the customer does not exist.');
}

die;



$stripe = new Cartalyst\Stripe\Stripe;


die;

$card = $stripe->card('cus_5Q1deWMlLJnD7U', 'card_15FBaVJvzVWl1WTeJ45KgaYT');

var_dump($card);die;

$cards = $stripe->cards()->all(['customer' => 'cus_5Q1deWMlLJnD7U']);

foreach ($cards['data'] as $card)
{
    var_dump($card['id']);die;
}

die;

#var_dump($stripe->customers()->find(['id' => 'poop']));die;

foreach ($stripe->customersIterator() as $customer)
{
	var_dump($customer['id']);die;
}

foreach($stripe->customers()->all() as $customer)
{
	var_dump($customer['id']);die;
}


// use Cartalyst\Stripe\Stripe;

// $stripe = Stripe::make();

// $charge = $stripe->charges()->find([
// 	'customer' => 'cus_5Q1deWMlLJnD7U',
// 	'id' => 'ch_15GKZCJvzVWl1WTeMwuOD0St',
// 	'expand' => [
// 		#'invoice',
// 	],
// ])->toArray();##

// var_dump($charge);die;

// #var_dump($stripe->customers()->all());die;

// foreach ($stripe->customersIterator() as $customer) {
//     var_dump($customer);die;
// }
