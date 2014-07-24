<h2>Introduction</h2>

<p>A comprehensive billing and API package for Stripe.</p>

<p>The package requires PHP 5.4+ and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested.</p>

<p>Have a <a href="#installation">read through the Installation Guide</a> and on how to <a href="#laravel-4">Integrate it with Laravel 4</a>.</p>

<h6>Using the API</h6>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customers()-&gt;all();

foreach ($customers as $customer)
{
    var_dump($customer['email']);
}
</code></pre>

<h6>Using a Billable Entity</h6>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscriptions = $user-&gt;subscriptions;

foreach ($subscriptions as $subscription)
{
    if ($subscription-&gt;expired())
    {
        echo 'Subscription has expired!';
    }
}
</code></pre><h2>Installation</h2>

<p>The best and easiest way to install the Stripe package is with <a href="http://getcomposer.org">Composer</a>.</p>

<h3>Preparation</h3>

<p>Open your <code>composer.json</code> file and add the following to the <code>require</code> array:</p>

<pre><code>"cartalyst/stripe": "1.0.*"
</code></pre>

<p>Add the following lines after the <code>require</code> array on your <code>composer.json</code> file:</p>

<pre><code>"repositories": [
    {
        "type": "composer",
        "url": "http://packages.cartalyst.com"
    }
]
</code></pre>

<p>Since the package is not yet marked as stable, you'll need to set the minimum stability to <code>dev</code> on your <code>composer.json</code> file:</p>

<pre><code>"minimum-stability": "dev"
</code></pre>

<blockquote>
<p><strong>Note:</strong> Make sure that after the required changes your <code>composer.json</code> file is valid by running <code>composer validate</code>.</p>
</blockquote>

<h3>Install the dependencies</h3>

<p>Run Composer to install or update the new requirement.</p>

<pre><code>php composer install
</code></pre>

<p>or</p>

<pre><code>php composer update
</code></pre>

<p>Now you are able to require the <code>vendor/autoload.php</code> file to autoload the package.</p><h2>Integration</h2>

<p>Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.</p>

<h3>Laravel 4</h3>

<p>The Stripe package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.</p>

<p>After installing the package, open your Laravel config file located at <code>app/config/app.php</code> and add the following lines.</p>

<p>In the <code>$providers</code> array add the following service provider for this package.</p>

<pre><code>'Cartalyst\Stripe\Laravel\StripeServiceProvider',
</code></pre>

<p>In the <code>$aliases</code> array add the following facade for this package.</p>

<pre><code>'Stripe' =&gt; 'Cartalyst\Stripe\Laravel\Facades\Stripe',
</code></pre>

<h4>Set the Stripe API Key</h4>

<p>Now you need to setup the Stripe API key, to do this open or create the <code>app/config/services.php</code> file, and add or update the <code>'stripe'</code> array:</p>

<pre class="prettyprint lang-php"><code>&lt;?php

return [

    'stripe' =&gt; [
        'secret' =&gt; 'your-stripe-key-here',
    ],

];
</code></pre>

<h4>Billing</h4>

<p>The Stripe package comes with billing functionality that you can attach to any entity.</p>

<p>To use this feature please follow the next steps:</p>

<h4>Migrations</h4>

<p>Now you need to migrate your database, but before doing that, you'll need to generate a migration that suits your billable table and to do this you just need to run the following command:</p>

<pre><code>php artisan stripe:migrator users
</code></pre>

<blockquote>
<p><strong>Note:</strong> Replace <code>users</code> with the billable entity table name.</p>
</blockquote>

<p>Now that the migration file is created you just need to run <code>php artisan migrate</code> to create the tables on your database.</p>

<h4>Model setup</h4>

<p>Add the <code>BillableTrait</code> to your Eloquent model and make sure the model implements the <code>BillableInterface</code>:</p>

<pre class="prettyprint lang-php"><code>use Cartalyst\Stripe\Billing\BillableTrait;
use Cartalyst\Stripe\Billing\BillableInterface;

class User extends Eloquent implements BillableInterface {

    use BillableTrait;

}
</code></pre>

<p>Open the <code>app/config/services.php</code> file and add a new <code>'model'</code> entry on the <code>'stripe'</code> array that will hold your entity model class name:</p>

<pre class="prettyprint lang-php"><code>return [

    'stripe' =&gt; [
        'secret' =&gt; 'your-stripe-key-here',
        'model'  =&gt; 'User',
    ],

];
</code></pre>

<blockquote>
<p><strong>Note:</strong> If your model is under a namespace, please provide the full namespace, ex: <code>'Acme\Models\User'</code>.</p>
</blockquote><h2>API</h2>

<p>The Stripe package comes bundled with an API connector to the Stripe REST API.</p><h3>Charges</h3>

<p>To charge a credit or a debit card, you create a new charge object. You can retrieve and refund individual charges as well as list all charges. Charges are identified by a unique ID.</p>

<h4>Create a new charge</h4>

<p>To charge a credit card, you need to create a new charge object. If your API key is in test mode, the supplied card won't actually be charged, though everything else will occur as if in live mode. (Stripe will assume that the charge would have completed successfully).</p>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>amount</td>
<td>true</td>
<td>number</td>
<td>null</td>
<td>A positive amount for the transaction.</td>
</tr>
<tr>
<td>currency</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>3-letter ISO code for currency.</td>
</tr>
<tr>
<td>customer</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a charge object.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a charge object.</td>
</tr>
<tr>
<td>capture</td>
<td>false</td>
<td>bool</td>
<td>null</td>
<td>Whether or not to immediately capture the charge.</td>
</tr>
<tr>
<td>statement_description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string to be displayed alongside your company name on your customer's credit card statement.</td>
</tr>
<tr>
<td>receipt_email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The email address to send this charge’s receipt to.</td>
</tr>
<tr>
<td>application_fee</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>An application fee to add on to this charge.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charge = Stripe::charges()-&gt;create([
    'customer' =&gt; 'cus_4EBumIjyaKooft',
    'currency' =&gt; 'USD',
    'amount'   =&gt; 50.49,
]);

echo $charge['id'];
</code></pre>

<h4>Update a charge</h4>

<p>Updates the specified charge by setting the values of the parameters passed. Any parameters not provided will be left unchanged.</p>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a charge object.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a charge object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charge = Stripe::charges()-&gt;update([
    'id'          =&gt; 'ch_4ECWMVQp5SJKEx',
    'description' =&gt; 'Payment to foo bar',
]);
</code></pre>

<h4>Capture a charge</h4>

<p>Capture the payment of an existing, uncaptured, charge. This is the second half of the two-step payment flow, where first you <a href="#create-a-new-charge">created a charge</a> with the capture option set to false.</p>

<p>Uncaptured payments expire exactly seven days after they are created. If they are not captured by that point in time, they will be marked as refunded and will no longer be capturable.</p>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>amount</td>
<td>false</td>
<td>number</td>
<td>null</td>
<td>A positive amount for the transaction.</td>
</tr>
<tr>
<td>refund_application_fee</td>
<td>false</td>
<td>bool</td>
<td>null</td>
<td>Boolean indicating whether the application fee should be refunded when refunding this charge.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a charge object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charge = Stripe::charges()-&gt;capture([
    'id' =&gt; 'ch_4ECWMVQp5SJKEx',
]);
</code></pre>

<h4>Refund a charge</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>amount</td>
<td>false</td>
<td>number</td>
<td>null</td>
<td>A positive amount for the transaction.</td>
</tr>
<tr>
<td>application_fee</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>An application fee to add on to this charge.</td>
</tr>
<tr>
<td>receipt_email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The email address to send this charge’s receipt to.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charge = Stripe::charges()-&gt;refund([
    'id' =&gt; 'ch_4ECWMVQp5SJKEx',
]);
</code></pre>

<h4>Retrieve all charges</h4>

<p>Returns a list of charges you've previously created. The charges are returned in sorted order, with the most recent charges appearing first.</p>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>created</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A filter on the list based on the object created field.</td>
</tr>
<tr>
<td>customer</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charges = Stripe::charges()-&gt;all();

foreach ($charges['data'] as $charge)
{
    var_dump($charge['id']);
}
</code></pre>

<h4>Retrieve an existing charge</h4>

<p>Retrieves the details of a charge that has been previously created. Supply the unique charge ID that was returned from a previous request, and Stripe will return the corresponding charge information. The same information is returned when creating or refunding the charge.</p>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$charge = Stripe::charges()-&gt;find([
    'id' =&gt; 'ch_4ECWMVQp5SJKEx',
]);
</code></pre><h3>Refunds</h3>

<p>Refund objects allow you to refund a charge that has previously been created but not yet refunded. Funds will be refunded to the credit or debit card that was originally charged. The fees you were originally charged are also refunded.</p>

<h4>Retrieve all refunds of a charge</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>charge</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$refunds = Stripe::refunds()-&gt;all([
    'charge' =&gt; 'ch_4ECWMVQp5SJKEx',
]);

foreach ($refunds['data'] as $refund)
{
    var_dump($refund['id']);
}
</code></pre>

<h4>Retrieve an existing refund</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>charge</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The refund unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$refund = Stripe::refunds()-&gt;find([
    'charge' =&gt; 'ch_4ECWMVQp5SJKEx',
    'id'     =&gt; 'txn_4IgdBGArAOeiQw',
]);
</code></pre>

<h4>Update an existing refund</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>charge</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The charge unique identifier.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The refund unique identifier.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a refund object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$refund = Stripe::refunds()-&gt;update([
    'charge'   =&gt; 'ch_4ECWMVQp5SJKEx',
    'id'       =&gt; 'txn_4IgdBGArAOeiQw',
    'metadata' =&gt; [
        'reason'      =&gt; 'Customer requested for the refund.',
        'refunded_by' =&gt; 'Bruno G.',
    ],
]);
</code></pre><h3>Customers</h3>

<p>Customer objects allow you to perform recurring charges and track multiple charges that are associated with the same customer. The API allows you to create, delete, and update your customers. You can retrieve individual customers as well as a list of all your customers.</p>

<h4>Create a new customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>account_balance</td>
<td>false</td>
<td>number</td>
<td>null</td>
<td>A positive amount that is the starting account balance for your customer.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>Unique card identifier (can either be an ID or a hash).</td>
</tr>
<tr>
<td>coupon</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Coupon identifier that applies a discount on all recurring charges.</td>
</tr>
<tr>
<td>plan</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Plan for the customer.</td>
</tr>
<tr>
<td>quantity</td>
<td>false</td>
<td>integer</td>
<td>null</td>
<td>Quantity you'd like to apply to the subscription you're creating.</td>
</tr>
<tr>
<td>trial_end</td>
<td>false</td>
<td>integer</td>
<td>null</td>
<td>UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string that you can attach to a customer object.</td>
</tr>
<tr>
<td>email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Customer’s email address.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A set of key/value pairs that you can attach to a customer object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::customers()-&gt;create([
    'email' =&gt; 'john.doe@example.com',
]);

echo $customer['id'];
</code></pre>

<h4>Delete a customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::customers()-&gt;destroy([
    'id' =&gt; 'cus_4EBxvk6aBPexFO',
]);
</code></pre>

<h4>Update a customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>account_balance</td>
<td>false</td>
<td>number</td>
<td>null</td>
<td>A positive amount that is the starting account balance for your customer.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>Unique card identifier (can either be an ID or a hash).</td>
</tr>
<tr>
<td>coupon</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Coupon identifier that applies a discount on all recurring charges.</td>
</tr>
<tr>
<td>plan</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Plan for the customer.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string that you can attach to a customer object.</td>
</tr>
<tr>
<td>email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Customer’s email address.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A set of key/value pairs that you can attach to a customer object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::customers()-&gt;update([
    'id'    =&gt; 'cus_4EBumIjyaKooft',
    'email' =&gt; 'jonathan@doe.com',
]);

echo $customer['email'];
</code></pre>

<h4>Retrieve all customers</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>created</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>integer</td>
<td>10</td>
<td>A limit on the number of objects to be returned. Limit can range between 1 and 100 items.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customers()-&gt;all();

foreach ($customers['data'] as $customer)
{
    var_dump($customer['id']);
}
</code></pre>

<h4>Retrieve a customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::customers()-&gt;find([
    'id' =&gt; 'cus_4EBumIjyaKooft',
]);

echo $customer['email'];
</code></pre>

<h4>Delete a customer discount</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::customers()-&gt;deleteDiscount([
    'id' =&gt; 'cus_4EBumIjyaKooft',
])-&gt;findArray();
</code></pre><h3>Cards</h3>

<p>You can store multiple cards on a customer in order to charge the customer later. You can also store multiple debit cards on a recipient in order to transfer to those cards later.</p>

<h4>Create a new card</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>card</td>
<td>true</td>
<td>string or array</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$card = Stripe::cards()-&gt;create([
    'customer' =&gt; 'cus_4DArhxP7RAFBaB',
    'card'     =&gt; [
        'number'    =&gt; '4242424242424242',
        'exp_month' =&gt; 6,
        'exp_year'  =&gt; 2015,
        'cvc'       =&gt; '314',
    ],
]);
</code></pre>

<p>Via Stripe.js plugin</p>

<pre class="prettyprint lang-php"><code>$cardToken = Input::get('stripeToken');

$card = Stripe::cards()-&gt;create([
    'customer' =&gt; 'cus_4DArhxP7RAFBaB',
    'card'     =&gt; $cardToken,
]);
</code></pre>

<h4>Update a card</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>name</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder name.</td>
</tr>
<tr>
<td>address_city</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder city.</td>
</tr>
<tr>
<td>address_line1</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder address line 1.</td>
</tr>
<tr>
<td>address_line2</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder address line 2.</td>
</tr>
<tr>
<td>address_state</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder state.</td>
</tr>
<tr>
<td>address_zip</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card holder address zip code.</td>
</tr>
<tr>
<td>exp_month</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card expiration month.</td>
</tr>
<tr>
<td>exp_year</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The card expiration year.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$card = Stripe::cards()-&gt;update([
    'id'            =&gt; 'card_4EBj4AslJlNXPs',
    'customer'      =&gt; 'cus_4DArhxP7RAFBaB',
    'name'          =&gt; 'John Doe',
    'address_line1' =&gt; 'Example Street 1',
]);
</code></pre>

<h4>Delete a card</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$card = Stripe::cards()-&gt;destroy([
    'id'       =&gt; 'card_4EBi3uAIBFnKy4',
    'customer' =&gt; 'cus_4DArhxP7RAFBaB',
]);
</code></pre>

<h4>Retrieve all cards</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$cards = Stripe::cards()-&gt;all([
    'customer' =&gt; 'cus_4DArhxP7RAFBaB',
]);

foreach ($cards['data'] as $card)
{
    var_dump($card['id']);
}
</code></pre>

<h4>Retrieve a Card</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$card = Stripe::cards()-&gt;find([
    'id'       =&gt; 'card_4DmaB3muM8SNdZ',
    'customer' =&gt; 'cus_4DArhxP7RAFBaB',
]);

echo $card['id'];
</code></pre><h3>Plans</h3>

<p>A subscription plan contains the pricing information for different products and feature levels on your site. For example, you might have a €10/month plan for basic features and a different €20/month plan for premium features.</p>

<h4>Create a new plan</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
<tr>
<td>amount</td>
<td>true</td>
<td>number</td>
<td>null</td>
<td>A positive amount for the transaction.</td>
</tr>
<tr>
<td>currency</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>3-letter ISO code for currency.</td>
</tr>
<tr>
<td>interval</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>Specifies billing frequency. Either week, month or year.</td>
</tr>
<tr>
<td>interval_count</td>
<td>false</td>
<td>int</td>
<td>1</td>
<td>The number of intervals between each subscription billing.</td>
</tr>
<tr>
<td>name</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The name of the plan.</td>
</tr>
<tr>
<td>trial_period_days</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>Specifies a trial period in (an integer number of) days.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a transfer object</td>
</tr>
<tr>
<td>statement_description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which will be displayed on the customer's bank statement.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$plan = Stripe::plans()-&gt;create([
    'id'                    =&gt; 'monthly',
    'name'                  =&gt; 'Monthly (30$)',
    'amount'                =&gt; 30.00,
    'currency'              =&gt; 'USD',
    'interval'              =&gt; 'month',
    'statement_description' =&gt; 'Monthly Subscription to Foo Bar Inc.',
]);

echo $plan['id'];
</code></pre>

<h4>Delete a plan</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$plan = Stripe::plans()-&gt;destroy([
    'id' =&gt; 'monthly',
]);
</code></pre>

<h4>Update a plan</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
<tr>
<td>name</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The name of the plan.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a transfer object</td>
</tr>
<tr>
<td>statement_description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which will be displayed on the customer's bank statement.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$plan = Stripe::plans()-&gt;update([
    'id'   =&gt; 'monthly',
    'name' =&gt; 'Monthly Subscription',
]);

echo $plan['name'];
</code></pre>

<h4>Retrieve all the existing plans</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$plans = Stripe::plans()-&gt;all();

foreach ($plans['data'] as $plan)
{
    var_dump($plan['id']);
}
</code></pre>

<h4>Retrieve an existing plan</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$plan = Stripe::plans()-&gt;find([
    'id' =&gt; 'monthly',
]);

echo $plan['name'];
</code></pre><h3>Coupons</h3>

<p>A coupon contains information about a percent-off discount you might want to apply to a customer. Coupons only apply to invoices created for recurring subscriptions and invoice items; they do not apply to one-off charges.</p>

<h4>Create a new coupon</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The coupon unique identifier.</td>
</tr>
<tr>
<td>duration</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>Specifies how long the discount will be in effect. Can be forever, once, or repeating.</td>
</tr>
<tr>
<td>amount_off</td>
<td>false</td>
<td>number</td>
<td>null</td>
<td>A positive amount representing the amount to subtract from an invoice total (required if percent_off is not passed).</td>
</tr>
<tr>
<td>currency</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>3-letter ISO code for currency.</td>
</tr>
<tr>
<td>duration_in_months</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>If duration is repeating, a positive integer that specifies the number of months the discount will be in effect.</td>
</tr>
<tr>
<td>max_redemptions</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>A positive integer specifying the number of times the coupon can be redeemed before it’s no longer valid.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a coupon object.</td>
</tr>
<tr>
<td>percent_off</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed).</td>
</tr>
<tr>
<td>redeem_by</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>Unix timestamp specifying the last time at which the coupon can be redeemed.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$coupon = Stripe::coupons()-&gt;create([
    'id'          =&gt; '50-PERCENT-OFF',
    'duration'    =&gt; 'forever',
    'percent_off' =&gt; 50,
]);

echo $coupon['id'];
</code></pre>

<h4>Delete a coupon</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The coupon unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$coupon = Stripe::coupons()-&gt;destroy([
    'id' =&gt; '50-PERCENT-OFF',
]);
</code></pre>

<h4>Retrieve all the existing coupons</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$coupons = Stripe::coupons()-&gt;all();

foreach ($coupons['data'] as $coupon)
{
    var_dump($coupon['id']);
}
</code></pre>

<h4>Retrieve an existing coupon</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The coupon unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$coupon = Stripe::coupons()-&gt;find([
    'id' =&gt; '50-PERCENT-OFF',
]);

echo $coupon['id'];
</code></pre><h3>Subscriptions</h3>

<p>Subscriptions allow you to charge a customer's card on a recurring basis. A subscription ties a customer to a particular plan.</p>

<h4>Create a subscription</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier that this subscription belongs to.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The subscription unique identifier.</td>
</tr>
<tr>
<td>plan</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
<tr>
<td>coupon</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The coupon unique identifier.</td>
</tr>
<tr>
<td>prorate</td>
<td>false</td>
<td>bool</td>
<td>true</td>
<td>Flag telling us whether to prorate switching plans during a billing cycle.</td>
</tr>
<tr>
<td>trial_end</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>The card token or an array.</td>
</tr>
<tr>
<td>quantity</td>
<td>false</td>
<td>int</td>
<td>1</td>
<td>The quantity you'd like to apply to the subscription you're creating.</td>
</tr>
<tr>
<td>application_fee_percent</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>A positive decimal (with at most two decimal places) between 1 and 100.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a subscription object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$subscription = Stripe::subscriptions()-&gt;create([
    'customer' =&gt; 'cus_4EBumIjyaKooft',
    'plan'     =&gt; 'monthly',
]);

echo $subscription['id'];
</code></pre>

<h4>Cancel a subscription</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier that this subscription belongs to.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The subscription unique identifier.</td>
</tr>
<tr>
<td>at_period_end</td>
<td>false</td>
<td>bool</td>
<td>false</td>
<td>A flag that if set to true will delay the cancellation of the subscription until the end of the current period.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$subscription = Stripe::subscriptions()-&gt;cancel([
    'customer' =&gt; 'cus_4EBumIjyaKooft',
    'id'       =&gt; 'sub_4ETjGeEPC5ai9J',
]);
</code></pre>

<p>Cancel at the end of the period</p>

<pre class="prettyprint lang-php"><code>$subscription = Stripe::subscriptions()-&gt;cancel([
    'customer'      =&gt; 'cus_4EBumIjyaKooft',
    'id'            =&gt; 'sub_4ETjGeEPC5ai9J',
    'at_period_end' =&gt; true,
]);
</code></pre>

<h4>Update a subscription</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier that this subscription belongs to.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The subscription unique identifier.</td>
</tr>
<tr>
<td>plan</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The plan unique identifier.</td>
</tr>
<tr>
<td>coupon</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The coupon unique identifier.</td>
</tr>
<tr>
<td>prorate</td>
<td>false</td>
<td>bool</td>
<td>true</td>
<td>Flag telling us whether to prorate switching plans during a billing cycle.</td>
</tr>
<tr>
<td>trial_end</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>The card token or an array.</td>
</tr>
<tr>
<td>quantity</td>
<td>false</td>
<td>int</td>
<td>1</td>
<td>The quantity you'd like to apply to the subscription you're creating.</td>
</tr>
<tr>
<td>application_fee_percent</td>
<td>false</td>
<td>int</td>
<td>null</td>
<td>A positive decimal (with at most two decimal places) between 1 and 100.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a subscription object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$subscription = Stripe::subscriptions()-&gt;update([
    'customer'      =&gt; 'cus_4EBumIjyaKooft',
    'id'            =&gt; 'sub_4EUEBlsoU7kRHX',
    'plan'          =&gt; 'monthly',
    'at_period_end' =&gt; false,
]);
</code></pre>

<h4>Retrieve all the subscriptions of a customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>ID of the customer that this subscription belongs to.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>integer</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$subscriptions = Stripe::subscriptions()-&gt;all([
    'id' =&gt; 'cus_4EBumIjyaKooft',
]);

foreach ($subscriptions['data'] as $subscription)
{
    var_dump($subscription['id']);
}
</code></pre>

<h4>Retrieve a subscription of a customer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier that this subscription belongs to.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The subscription unique identifier.</td>
</tr>
</tbody>
</table>

<pre><code>$subscription = Stripe::subscriptions()-&gt;find([
    'customer' =&gt; 'cus_4EBumIjyaKooft',
    'id'       =&gt; 'sub_4ETjGeEPC5ai9J',
]);

echo $subscription['id'];
</code></pre>

<h4>Delete a subscription discount</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>customer</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The customer unique identifier that this subscription belongs to.</td>
</tr>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The subscription unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$customer = Stripe::subscriptions()-&gt;deleteDiscount([
    'customer' =&gt; 'cus_4EBumIjyaKooft',
    'id'       =&gt; 'sub_4ETjGeEPC5ai9J',
])-&gt;findArray();
</code></pre><h3>Invoices</h3>

<p>Invoices are statements of what a customer owes for a particular billing period, including subscriptions, invoice items, and any automatic proration adjustments if necessary.</p>

<h4>Create a new invoice</h4>

<pre class="prettyprint lang-php"><code>$invoice = Stripe::invoices()-&gt;create([
    'customer' =&gt; 'cus_4EgOG1jXMEt7Ou',
]);
</code></pre>

<h4>Update an invoice</h4>

<pre class="prettyprint lang-php"><code>$invoice = Stripe::invoices()-&gt;update([
    'id'     =&gt; 'in_4EgP02zb8qxsLq',
    'closed' =&gt; true,
]);
</code></pre>

<h4>Pay an existing invoice</h4>

<pre class="prettyprint lang-php"><code>$invoice = Stripe::invoices()-&gt;pay([
    'id' =&gt; 'in_4EgP02zb8qxsLq',
]);
</code></pre>

<h4>Retrieve all the existing invoices</h4>

<pre class="prettyprint lang-php"><code>$invoices = Stripe::invoices()-&gt;all();

foreach ($invoices['data'] as $invoice)
{
    var_dump($invoice['id']);
}
</code></pre>

<h4>Retrieve an existing invoice</h4>

<pre class="prettyprint lang-php"><code>$invoice = Stripe::invoices()-&gt;find([
    'id' =&gt; 'in_4EgP02zb8qxsLq',
]);

echo $invoice['paid'];
</code></pre>

<h4>Retrieve an existing invoice line items</h4>

<pre class="prettyprint lang-php"><code>$lines = Stripe::invoices()-&gt;invoiceLineItems([
    'id' =&gt; 'in_4EgP02zb8qxsLq',
]);

foreach ($lines['data'] as $line)
{
    var_dump($line['id']);
}
</code></pre>

<h4>Retrieve the upcoming invoice</h4>

<pre class="prettyprint lang-php"><code>$invoice = Stripe::invoices()-&gt;upcomingInvoice([
    'customer' =&gt; 'cus_4EgOG1jXMEt7Ou',
]);

foreach ($invoice['lines']['data'] as $item)
{
    var_dump($item['id']);
}
</code></pre><h3>Invoice Items</h3>

<p>Sometimes you want to add a charge or credit to a customer but only actually charge the customer's card at the end of a regular billing cycle. This is useful for combining several charges to minimize per-transaction fees or having Stripe tabulate your usage-based billing totals.</p>

<h4>Create a new invoice item</h4>

<pre class="prettyprint lang-php"><code>$item = Stripe::invoiceItems()-&gt;create([
    'customer' =&gt; 'cus_4EgOG1jXMEt7Ou',
    'currency' =&gt; 'USD',
    'amount'   =&gt; 5000,
]);

echo $item['id'];
</code></pre>

<h4>Update an invoice item</h4>

<pre class="prettyprint lang-php"><code>$response = Stripe::invoiceItems()-&gt;update([
    'id'          =&gt; 'ii_4Egr3tUtHjVEnm',
    'description' =&gt; 'Candy',
    'metadata'    =&gt; [
        'foo' =&gt; 'Bar',
    ],
]);
</code></pre>

<h4>Delete an invoice item</h4>

<pre class="prettyprint lang-php"><code>$item = Stripe::invoiceItems()-&gt;destroy([
    'id' =&gt; 'ii_4Egr3tUtHjVEnm',
]);

echo $item['id'];
</code></pre>

<h4>Retrieve all invoice items</h4>

<pre class="prettyprint lang-php"><code>$items = Stripe::invoiceItems()-&gt;find();

foreach ($items['data'] as $item)
{
    var_dump($item['id']);
}
</code></pre>

<h4>Retrieve an invoice item</h4>

<pre class="prettyprint lang-php"><code>$item = Stripe::invoiceItems()-&gt;find([
    'id' =&gt; 'ii_4Egr3tUtHjVEnm',
]);

echo $item['id'];
</code></pre><h3>Tokens</h3>

<p>Often you want to be able to charge credit cards or send payments to bank accounts without having to hold sensitive card information on your own servers. Stripe.js makes this easy in the browser, but you can use the same technique in other environments with our token API.</p>

<h4>Create a card token</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>card</td>
<td>true</td>
<td>string or array</td>
<td>null</td>
<td>The card unique identifier.</td>
</tr>
<tr>
<td>customer</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A customer to create a token for.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$token = Stripe::tokens()-&gt;create([
    'card' =&gt; [
        'number'    =&gt; '4242424242424242',
        'exp_month' =&gt; 6,
        'exp_year'  =&gt; 2015,
        'cvc'       =&gt; 314,
    ],
]);

echo $token['id'];
</code></pre>

<h4>Create a bank account token</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>bank_account</td>
<td>true</td>
<td>array</td>
<td>null</td>
<td>A bank account to attach to the recipient.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$token = Stripe::tokens()-&gt;create([
    'bank_account' =&gt; [
        'country'        =&gt; 'US',
        'routing_number' =&gt; '110000000',
        'account_number' =&gt; '000123456789',
    ],
]);

echo $token['id'];
</code></pre><h3>Transfers</h3>

<p>When Stripe sends you money or you initiate a transfer to a third party recipient's bank account or debit card, a transfer object will be created. You can retrieve individual transfers as well as list all transfers.</p>

<h4>Create a new transfer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>amount</td>
<td>true</td>
<td>number</td>
<td>null</td>
<td>A positive amount for the transaction.</td>
</tr>
<tr>
<td>currency</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>3-letter ISO code for currency.</td>
</tr>
<tr>
<td>recipient</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The ID of an existing, verified recipient.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a transfer object.</td>
</tr>
<tr>
<td>statement_description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which will be displayed on the recipient's bank statement.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a transfer object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$transfer = Stripe::transfers()-&gt;create([
    'amount'    =&gt; 10.00,
    'currency'  =&gt; 'USD',
    'recipient' =&gt; 'rp_4EYxxX0LQWYDMs',
]);

echo $transfer['id'];
</code></pre>

<h4>Update a transfer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The transfer unique identifier.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a transfer object.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>[]</td>
<td>A set of key/value pairs that you can attach to a transfer object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$transfer = Stripe::transfers()-&gt;update([
    'id'          =&gt; 'tr_4EZer9REaUzJ76',
    'description' =&gt; 'Transfer to John Doe',
]);

echo $transfer['description'];
</code></pre>

<h4>Cancel a transfer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The transfer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$transfer = Stripe::transfers()-&gt;cancel([
    'id' =&gt; 'tr_4EZer9REaUzJ76',
]);
</code></pre>

<h4>Retrieve all the existing transfers</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>created</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A filter on the list based on the object created field.</td>
</tr>
<tr>
<td>date</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A filter on the list based on the object date field.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>recipient</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Only return transfers for the recipient specified by this recipient ID.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>status</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>Only return transfers that have the given status: "pending", "paid", or "failed".</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$transfers = Stripe::transfers()-&gt;all();

foreach ($transfers['data'] as $transfer)
{
    var_dump($transfer['id']);
}
</code></pre>

<h4>Retrieve an existing transfer</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The transfer unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$transfers = Stripe::transfers()-&gt;find([
    'id' =&gt; 'tr_4EZer9REaUzJ76',
]);

echo $transfer['id'];
</code></pre><h3>Recipients</h3>

<p>With recipient objects, you can transfer money from your Stripe account to a third party bank account or debit card. The API allows you to create, delete, and update your recipients. You can retrieve individual recipients as well as a list of all your recipients.</p>

<h4>Create a new recipient</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>name</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The recipient's full, legal name.</td>
</tr>
<tr>
<td>type</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>Type of the recipient: either individual or corporation.</td>
</tr>
<tr>
<td>tax_id</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The recipient's tax ID, as a string. For type individual, the full SSN; for type corporation, the full EIN.</td>
</tr>
<tr>
<td>bank_account</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A bank account to attach to the recipient.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>The card token or an array.</td>
</tr>
<tr>
<td>email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The recipient's email address.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a recipient object.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A set of key/value pairs that you can attach to a recipient object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$recipient = Stripe::recipients()-&gt;create([
    'name' =&gt; 'John Doe',
    'type' =&gt; 'individual',
]);
</code></pre>

<h4>Update a recipient</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The recipient unique identifier.</td>
</tr>
<tr>
<td>name</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The recipient's full, legal name.</td>
</tr>
<tr>
<td>tax_id</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The recipient's tax ID, as a string. For type individual, the full SSN; for type corporation, the full EIN.</td>
</tr>
<tr>
<td>bank_account</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A bank account to attach to the recipient.</td>
</tr>
<tr>
<td>card</td>
<td>false</td>
<td>string or array</td>
<td>null</td>
<td>The card token or an array.</td>
</tr>
<tr>
<td>default_card</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>ID of card to make the recipient’s new default for transfers.</td>
</tr>
<tr>
<td>email</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>The recipient's email address.</td>
</tr>
<tr>
<td>description</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>An arbitrary string which you can attach to a recipient object.</td>
</tr>
<tr>
<td>metadata</td>
<td>false</td>
<td>array</td>
<td>null</td>
<td>A set of key/value pairs that you can attach to a recipient object.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$recipient = Stripe::recipients()-&gt;update([
    'id'   =&gt; 'rp_4EYRyEYthf2Doc',
    'name' =&gt; 'John Doe Inc.',
]);
</code></pre>

<h4>Delete a recipient</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The recipient unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$recipient = Stripe::recipients()-&gt;destroy([
    'id' =&gt; 'rp_4EYRyEYthf2Doc',
]);
</code></pre>

<h4>Retrieve all the recipients</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>verified</td>
<td>false</td>
<td>bool</td>
<td>null</td>
<td>Only return recipients that are verified or unverified.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$recipients = Stripe::recipients()-&gt;all();

foreach ($recipients['data'] as $recipient)
{
    var_dump($recipient['id']);
}
</code></pre>

<h4>Retrieve a recipient</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The recipient unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$recipient = Stripe::recipients()-&gt;find([
    'id' =&gt; '50-PERCENT-OFF',
]);

echo $recipient['id'];
</code></pre><h3>Account</h3>

<p>This is an object representing your Stripe account. You can retrieve it to see properties on the account like its current e-mail address or if the account is enabled yet to make live charges.</p>

<p>Retrieve information about your Stripe account.</p>

<pre class="prettyprint lang-php"><code>$account = Stripe::account()-&gt;details();

echo $account['email'];
</code></pre><h3>Balance</h3>

<p>This is an object representing your Stripe balance. You can retrieve it to see the balance currently on your Stripe account.</p>

<p>You can also retrieve a list of the balance history, which contains a full list of transactions that have ever contributed to the balance (charges, refunds, transfers, and so on).</p>

<h4>Retrieve account balance</h4>

<pre class="prettyprint lang-php"><code>$balance = Stripe::balance()-&gt;current();

echo $balance['pending']['amount'];
</code></pre>

<h4>Retrieve all the balance history</h4>

<pre class="prettyprint lang-php"><code>$history = Stripe::balance()-&gt;all();

foreach ($history['data'] as $balance)
{
    var_dump($balance['id']);
}
</code></pre>

<h4>Retrieve a balance history</h4>

<pre class="prettyprint lang-php"><code>$balance = Stripe::balance()-&gt;history([
    'id' =&gt; 'txn_4EI2Pu1gPR27yT',
]);

echo $balance['amount'];
</code></pre><h3>Events</h3>

<p>Events are our way of letting you know about something interesting that has just happened in your account. When an interesting event occurs, we create a new event object. For example, when a charge succeeds we create a charge.succeeded event; or, when an invoice can't be paid we create an invoice.payment_failed event. Note that many API requests may cause multiple events to be created. For example, if you create a new subscription for a customer, you will receive both a customer.subscription.created event and a charge.succeeded event.</p>

<h4>Retrieve all the events</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>created</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A filter on the list based on the object created field.</td>
</tr>
<tr>
<td>ending_before</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>limit</td>
<td>false</td>
<td>int</td>
<td>10</td>
<td>A limit on the number of objects to be returned.</td>
</tr>
<tr>
<td>starting_after</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A cursor to be used in pagination.</td>
</tr>
<tr>
<td>type</td>
<td>false</td>
<td>string</td>
<td>null</td>
<td>A string containing a specific event name, or group of events using * as a wildcard.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$events = Stripe::events()-&gt;all();

foreach ($events['data'] as $event)
{
    var_dump($event);
}
</code></pre>

<h4>Retrieve an event</h4>

<table>
<thead>
<tr>
<th>Key</th>
<th>Required</th>
<th>Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>id</td>
<td>true</td>
<td>string</td>
<td>null</td>
<td>The event unique identifier.</td>
</tr>
</tbody>
</table>

<pre class="prettyprint lang-php"><code>$event = Stripe::events()-&gt;find([
    'id' =&gt; 'evt_4ECnKrmXyNn8IM',
]);

echo $event['type'];
</code></pre><h3>Pagination</h3>

<p>Handling pagination on APIs is very hard and instead of manually handling the pagination, the Stripe package comes with a resource iterator which handles all of this for you, automatically!</p>

<p>Here is an example of grabbing all the customers:</p>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customersIterator();

foreach ($customers as $customer)
{
    var_dump($customer['id']);
}
</code></pre>

<p>You can still pass any API argument as you would with any normal API method:</p>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customersIterator([
    'created' =&gt; 123456789,
]);

foreach ($customers as $customer)
{
    var_dump($customer['id']);
}
</code></pre>

<h4>Set results limit</h4>

<p>If you have the need to lock the number of results, you can achieve this by using the <code>-&gt;setLimit(:amount);</code> method:</p>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customersIterator();
$customers-&gt;setLimit(30);

foreach ($customers as $customer)
{
    var_dump($customer['id']);
}
</code></pre>

<p>In this example, it will only return 30 results.</p>

<h4>Set results per page</h4>

<p>Setting a number of results per page is very easy and very similar to the results limit "locking", you just need to use the <code>-&gt;setPageSize(:amount);</code> method:</p>

<pre class="prettyprint lang-php"><code>$customers = Stripe::customersIterator();
$customers-&gt;setPageSize(50);

foreach ($customers as $customer)
{
    var_dump($customer['id']);
}
</code></pre>

<blockquote>
<p><strong>Note:</strong> The max results per page that Stripe allows is 100.</p>
</blockquote><h3>Handling Exceptions</h3>

<p>The Stripe API throws two kinds of exceptions:</p>

<h4>Guzzle Exceptions</h4>

<p>These exceptions will be thrown since Guzzle will automatically validate all the arguments you provide according to the manifest file rules.</p>

<p>If an argument is invalid, Guzzle will throw a <code>Guzzle\Service\Exception\ValidationException</code> exception,</p>

<pre class="prettyprint lang-php"><code>try
{
    $customer = Stripe::customers()-&gt;find([
        // We should pass in the id argument here..
    ]);
}
catch (Guzzle\Service\Exception\ValidationException $e)
{
    $errors = $e-&gt;getErrors();
}
</code></pre>

<h4>Stripe API Exceptions</h4>

<p>Here is the full list of all the exceptions that the Stripe API throws with a brief description:</p>

<table>
<thead>
<tr>
<th>Exception</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>Cartalyst\Stripe\Api\Exception\BadRequestException</td>
<td>This exception will be thrown when the data sent through the request is mal formed.</td>
</tr>
<tr>
<td>Cartalyst\Stripe\Api\Exception\UnauthorizedException</td>
<td>This exception will be thrown if your Stripe API Key is incorrect.</td>
</tr>
<tr>
<td>Cartalyst\Stripe\Api\Exception\RequestFailedException</td>
<td>This exception will be thrown whenever the request fails for some reason.</td>
</tr>
<tr>
<td>Cartalyst\Stripe\Api\Exception\CardErrorException</td>
<td>This exception will be thrown whenever the credit card is invalid.</td>
</tr>
<tr>
<td>Cartalyst\Stripe\Api\Exception\NotFoundException</td>
<td>This exception will be thrown whenever a request results on a 404.</td>
</tr>
<tr>
<td>Cartalyst\Stripe\Api\Exception\ServerErrorException</td>
<td>This exception will be thrown whenever Stripe does something wrong.</td>
</tr>
</tbody>
</table>

<h4>Usage</h4>

<pre class="prettyprint lang-php"><code>try
{
    $customer = Stripe::customers()-&gt;find([
        'id' =&gt; 'foobar',
    ]);

    echo $customer['email'];
}
catch (Cartalyst\Stripe\Api\Exception\NotFoundException $e)
{
    // Get the error message returned by Stripe
    $message = $e-&gt;getMessage();

    // Get the error type returned by Stripe
    $type = $e-&gt;getErrorType();

    // Get the status code
    $code = $e-&gt;getCode();

    // Get the request response, if required to get more information
    $response = $e-&gt;getResponse();
}
</code></pre><h2>Billable Entities</h2>

<p>In this section we'll show how you can use the entity billing feature.</p>

<blockquote>
<p><strong>Note:</strong> A User model will be used for the following examples.</p>
</blockquote>

<h4>Determine if the entity is ready to be billed</h4>

<p>If you require to determine if the entity is ready to be billed, you can use the <code>isBillable()</code> method.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ( ! $user-&gt;isBillable())
{
    echo "User is not ready to be billed!";
}
</code></pre>

<h4>Apply a coupon on the entity</h4>

<pre class="prettyprint lang-php"><code>$coupon = Input::get('coupon');

$user = User::find(1);

$user-&gt;applyCoupon($coupon);
</code></pre>

<h4>Check if the entity has any active subscription</h4>

<p>Determine if the entity has any active subscription.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ($user-&gt;isSubscribed())
{
    //
}
</code></pre>

<h4>Check if the entity has any active credit card</h4>

<p>Determine if the entity has any active credit card.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ($user-&gt;hasActiveCard())
{
    //
}
</code></pre>

<h4>Sync data from Stripe</h4>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<p>This will sync up the cards, charges, invoices + invoice items and subscriptions.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user-&gt;syncWithStripe();
</code></pre><h3>Credit Cards</h3>

<h4>Retrieve all the attached cards</h4>

<p>Listing the attached cards from an entity is very easy.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$cards = $user-&gt;cards;
</code></pre>

<h4>Attaching credit cards</h4>

<p>Attach a new credit card to the entity.</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;card()
    -&gt;create($token);
</code></pre>

<p>Attach a new credit card to the entity and make it the default credit card.</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;card()
    -&gt;makeDefault()
    -&gt;create($token);
</code></pre>

<h4>Updating credit cards</h4>

<p>Update a credit card.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$attributes = [
    'name' =&gt; 'John Doe',
];

$user
    -&gt;card(10)
    -&gt;update($attributes);
</code></pre>

<p>Make an existing credit card the default credit card.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;card(10)
    -&gt;setDefault();
</code></pre>

<h4>Deleting credit cards</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;card(10)
    -&gt;delete();
</code></pre>

<h4>Get the entity default Credit Card</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$card = $user-&gt;getDefaultCard();

echo $card-&gt;last_four;
</code></pre>

<h4>Update the entity default Credit Card</h4>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user-&gt;updateDefaultCard($token);
</code></pre>

<h4>Check if the entity has any active card</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ( ! $user-&gt;hasActiveCard())
{
echo "User doesn't have any active credit card!";
}
</code></pre>

<h5>Sync data from Stripe</h5>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;card()
    -&gt;syncWithStripe();
</code></pre>

<blockquote>
<p><strong>Note:</strong> You can pass a card id <code>integer</code> or a <code>Cartalyst\Stripe\Billing\Models\IlluminateCard</code> object through the <code>card()</code> method.</p>
</blockquote><h3>Charges</h3>

<h4>Retrieve all the charges</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$charges = $user-&gt;charges;
</code></pre>

<h5>Retrieve an existing charge</h5>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$charge = $user-&gt;charges-&gt;find(10);

echo $charge['amount'];
</code></pre>

<h5>Creating charges</h5>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$amount = 150.95;

$user
    -&gt;charge()
    -&gt;create($amount, [
        'description' =&gt; 'Purchased Book!',
    ]);
</code></pre>

<p>Creating a charge with a new credit card.</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$amount = 150.95;

$user
    -&gt;charge()
    -&gt;setToken($token)
    -&gt;create($amount, [
        'description' =&gt; 'Purchased Book!',
    ]);
</code></pre>

<p>Creating a charge to be captured later.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$amount = 150.95;

$user
    -&gt;charge()
    -&gt;disableCapture()
    -&gt;create($amount, [
        'description' =&gt; 'Purchased Book!',
    ]);
</code></pre>

<p>Capturing a charge.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;charge(10)
    -&gt;capture();
</code></pre>

<h5>Refund charges</h5>

<p>Do a full refund</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;charge(10)
    -&gt;refund();
</code></pre>

<p>Do a partial refund</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$amount = 50.00;

$user
    -&gt;charge(10)
    -&gt;refund($amount);
</code></pre>

<h5>Sync data from Stripe</h5>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;charge()
    -&gt;syncWithStripe();
</code></pre>

<blockquote>
<p><strong>Note:</strong> You can pass a charge id <code>integer</code> or a <code>Cartalyst\Stripe\Billing\Models\IlluminateCharge</code> object through the <code>charge()</code> method.</p>
</blockquote><h3>Invoices</h3>

<h4>Retrieve all the invoices</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$invoices = $user-&gt;invoices;
</code></pre>

<h4>Retrieve an existing invoice</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$invoice = $user-&gt;invoices-&gt;find(10);

$items = $invoice-&gt;items;

echo $invoice['total'];
</code></pre>

<h4>Invoice metadata</h4>

<p>Sometimes you might need to store additional information that is relevant to an invoice, like an order id or even the billing information of a customer.</p>

<p>With the Stripe package storing this kind of information is a breeze, here's how you do it:</p>

<p>First you need to grab the invoice you want to attach metadata:</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$invoice = $user-&gt;invoice-&gt;find(10);
</code></pre>

<h5>Get metadata</h5>

<pre class="prettyprint lang-php"><code>$metadata = $invoice-&gt;metadata;

echo $metadata-&gt;name;
</code></pre>

<h5>Set metadata</h5>

<p>Now you can attach metadata to this invoice</p>

<pre class="prettyprint lang-php"><code>$invoice-&gt;metadata()-&gt;create([
    'name'    =&gt; 'John Doe',
    'address' =&gt; 'John Doe Industries',
]);
</code></pre>

<h4>Update the metadata</h4>

<pre class="prettyprint lang-php"><code>$invoice-&gt;metadata-&gt;update([
    'name' =&gt; 'Johnathan Doe',
]);
</code></pre>

<h4>Delete the metadata</h4>

<pre class="prettyprint lang-php"><code>$invoice-&gt;metadata-&gt;delete();
</code></pre>

<blockquote>
<p><strong>Note:</strong> The metadata table columns are configurable through the migration, but keep in mind that you might require to extend the invoice metadata model to include your own column names on the <code>$fillable</code> property.</p>
</blockquote>

<h4>Sync data from Stripe</h4>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;invoice()
    -&gt;syncWithStripe();
</code></pre>

<blockquote>
<p><strong>Note:</strong> You can pass a invoice id <code>integer</code> or a <code>Cartalyst\Stripe\Billing\Models\IlluminateInvoice</code> object through the <code>invoice()</code> method.</p>
</blockquote><h3>Subscriptions</h3>

<h4>List all the user subscriptions</h4>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscriptions = $user-&gt;subscriptions;
</code></pre>

<h4>Creating subscriptions</h4>

<p>Subscribing an entity to a plan</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;setToken($token)
    -&gt;create();
</code></pre>

<p>Subscribing an entity to a plan and apply a coupon to this new subscription</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$coupon = Input::get('coupon');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;withCoupon($coupon)
    -&gt;setToken($token)
    -&gt;create();
</code></pre>

<p>Create a trial subscription</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;trialFor(Carbon::now()-&gt;addDays(14))
    -&gt;setToken($token)
    -&gt;create();
</code></pre>

<h4>Cancelling subscriptions</h4>

<p>Cancel a Subscription using its <code>id</code></p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;cancel();
</code></pre>

<p>Cancelling a subscription by passing a <code>Cartalyst\Stripe\Subscription\IlluminateSubscription</code> object.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscription = $user-&gt;subscriptions()-&gt;where('stripe_id', 'sub_48w0VyQzcNWCe3')-&gt;first();

$user
    -&gt;subscription($subscription)
    -&gt;cancel();
</code></pre>

<p>Cancel a subscription at the End of the Period</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;cancelAtEndOfPeriod();
</code></pre>

<h4>Updating subscriptions</h4>

<p>Apply a trial period on a subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;setTrialPeriod(Carbon::now()-&gt;addDays(14))
</code></pre>

<p>Removing the trial period from a subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;removeTrialPeriod()
</code></pre>

<p>Apply a coupon to an existing subscription</p>

<pre class="prettyprint lang-php"><code>$coupon = Input::get('coupon');

$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;applyCoupon($coupon);
</code></pre>

<p>Remove a coupon from an existing subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;removeCoupon();
</code></pre>

<h4>Resuming subscriptions</h4>

<p>Resume a canceled subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;resume();
</code></pre>

<p>Resume a canceled subscription and remove its trial period</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;skipTrial()
    -&gt;resume();
</code></pre>

<p>Resume a canceled subscription and change its trial period end date</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(10)
    -&gt;trialFor(Carbon::now()-&gt;addDays(14))
    -&gt;resume()
</code></pre>

<h4>Checking a Subscription Status</h4>

<p>First, we need to grab the subscription:</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscription = $user-&gt;subscriptions-&gt;find(10);
</code></pre>

<p>To determine if the subscription is on the trial period, you may use the <code>onTrialPeriod()</code> method:</p>

<pre class="prettyprint lang-php"><code>if ($subscription-&gt;onTrialPeriod())
{
    //
}
</code></pre>

<p>To determine if the subscription is marked as canceled, you may use the <code>canceled</code> method:</p>

<pre class="prettyprint lang-php"><code>if ($subscription-&gt;canceled())
{
    //
}
</code></pre>

<p>To determine if the subscription has expired, you may use the <code>expired</code> method:</p>

<pre class="prettyprint lang-php"><code>if ($subscription-&gt;expired())
{
    //
}
</code></pre>

<p>You may also determine if a subscription, is still on their "grace period" until the subscription fully expires. For example, if a user cancels a subscription on March 5th that was scheduled to end on March 10th, the user is on their "grace period" until March 10th.</p>

<pre class="prettyprint lang-php"><code>if ($subscription-&gt;onGracePeriod())
{
    //
}
</code></pre>

<h4>Sync data from Stripe</h4>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;syncWithStripe();
</code></pre>

<blockquote>
<p><strong>Note:</strong> You can pass a subscription id <code>integer</code> or a <code>Cartalyst\Stripe\Billing\Models\IlluminateSubscription</code> object through the <code>subscription()</code> method.</p>
</blockquote><h3>Extending Models</h3>

<p>Extending the default models is very easy, we provide handy methods you can utilise with your Entity model.</p>

<p>Firstly you create your model(s) and this model needs to extend the model you want to "override", here how to do it:</p>

<pre class="prettyprint lang-php"><code>&lt;?php

use Cartalyst\Stripe\Billing\Models\IlluminateCard;

class Card extends IlluminateCard {

    // you can apply any new methods/logic here

}
</code></pre>

<blockquote>
<p><strong>Note:</strong> Please use the list below for a complete list of models namespace paths.</p>
</blockquote>

<h3>Models list</h3>

<table>
<thead>
<tr>
<th>Model Name</th>
<th>Model full namespace path</th>
</tr>
</thead>
<tbody>
<tr>
<td>Card</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateCard</td>
</tr>
<tr>
<td>Charge</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateCharge</td>
</tr>
<tr>
<td>ChargeRefund</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund</td>
</tr>
<tr>
<td>Invoice</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateInvoice</td>
</tr>
<tr>
<td>InvoiceItem</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem</td>
</tr>
<tr>
<td>InvoiceMetadata</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateInvoiceMetadata</td>
</tr>
<tr>
<td>Subscription</td>
<td>Cartalyst\Stripe\Billing\Models\IlluminateSubscription</td>
</tr>
</tbody>
</table>

<h3>Set the models</h3>

<p>Now that you've the model(s) created, it's time to set them, this is recommended to be done the earlier as you can on your application.</p>

<p>This can be done for example on the <code>app/filters.php</code>, this is to ensure you only require to apply this change once per request!</p>

<h5>Change the Card model</h5>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setCardModel('Acme\Models\Card');
</code></pre>

<h4>Change the Charge model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setChargeModel('Acme\Models\Charge');
</code></pre>

<h4>Change the Charge Refunds model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setChargeRefundModel('Acme\Models\ChargeRefund');
</code></pre>

<h4>Change the Invoice model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setInvoiceModel('Acme\Models\Invoice');
</code></pre>

<h4>Change the Invoice Items model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setInvoiceItemModel('Acme\Models\InvoiceItem');
</code></pre>

<h4>Change the Invoice Metadata model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setInvoiceMetadataModel('Acme\Models\InvoiceMetadata');
</code></pre>

<h4>Change the Subscription model</h4>

<pre class="prettyprint lang-php"><code>app('User')-&gt;setSubscriptionModel('Acme\Models\Subscription');
</code></pre>

<blockquote>
<p><strong>Note:</strong> The <code>User</code> model we're using for these examples, is the model you've applied the Billable Trait!</p>
</blockquote><h3>Events</h3>

<p>On this section we have a list of all the events fired by the Stripe package that you can listen for.</p>

<table>
<thead>
<tr>
<th>Event</th>
<th>Parameters</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>cartalyst.stripe.card.created</td>
<td>$entity, $card</td>
<td>Event fired when a new credit card is attached to an entity.</td>
</tr>
<tr>
<td>cartalyst.stripe.card.updated</td>
<td>$entity, $card</td>
<td>Event fired when an existing credit card is updated.</td>
</tr>
<tr>
<td>cartalyst.stripe.card.deleted</td>
<td>$entity, $card</td>
<td>Event fired when an existing credit card is deleted.</td>
</tr>
<tr>
<td>cartalyst.stripe.charge.created</td>
<td>$entity, $charge</td>
<td>Event fired when a new charge is created.</td>
</tr>
<tr>
<td>cartalyst.stripe.charge.updated</td>
<td>$entity, $charge</td>
<td>Event fired when an existing charge is updated.</td>
</tr>
<tr>
<td>cartalyst.stripe.charge.refunded</td>
<td>$entity, $charge</td>
<td>Event fired when an existing charge is refunded.</td>
</tr>
<tr>
<td>cartalyst.stripe.charge.captured</td>
<td>$entity, $charge</td>
<td>Event fired when an existing charge is captured.</td>
</tr>
<tr>
<td>cartalyst.stripe.subscription.created</td>
<td>$entity, $subscription</td>
<td>Event fired when a new subscription is attached to an entity.</td>
</tr>
<tr>
<td>cartalyst.stripe.subscription.updated</td>
<td>$entity, $subscription</td>
<td>Event fired when an existing subscription is updated.</td>
</tr>
<tr>
<td>cartalyst.stripe.subscription.canceled</td>
<td>$entity, $subscription</td>
<td>Event fired when an existing subscription is canceled.</td>
</tr>
<tr>
<td>cartalyst.stripe.subscription.resumed</td>
<td>$entity, $subscription</td>
<td>Event fired when an existing subscription is resumed.</td>
</tr>
</tbody>
</table>

<h4>Examples</h4>

<p>Whenever a new subscription is attached to an entity.</p>

<pre class="prettyprint lang-php"><code>Event::listen('cartalyst.stripe.subscription.created', function($entity, $subscription)
{
    // Apply your own logic here
});
</code></pre>

<p>Whenever an existing subscription is canceled.</p>

<pre class="prettyprint lang-php"><code>Event::listen('cartalyst.stripe.subscription.canceled', function($entity, $subscription)
{
    // Apply your own logic here
});
</code></pre>

<p>Whenever an existing subscription is resumed.</p>

<pre class="prettyprint lang-php"><code>Event::listen('cartalyst.stripe.subscription.resumed', function($entity, $subscription)
{
    // Apply your own logic here
});
</code></pre><h2>Webhooks</h2>

<p>Listening to Stripe notification events (Webhooks) is incredible easy and you can listen to any notification that Stripe sends.</p>

<h4>Setup</h4>

<p>First create a new controller somewhere inside your application that extends our <code>Cartalyst\Stripe\WebhookController</code> controller.</p>

<pre class="prettyprint lang-php"><code>&lt;?php

class WebhookController extends Cartalyst\Stripe\WebhookController {

}
</code></pre>

<p>Now you need to register a <code>post</code> route that points to your controller:</p>

<pre class="prettyprint lang-php"><code>Route::post('webhook/stripe', 'WebhookController@handleWebhook');
</code></pre>

<blockquote>
<p><strong>Note:</strong> The route URI <code>webhook/stripe</code> is just for the example, you can choose to use a different one.</p>
</blockquote>

<h4>Handling events</h4>

<p>Now you just need to create the notification event handlers inside your controller, we have a few examples prepared below:</p>

<pre class="prettyprint lang-php"><code>&lt;?php

use Carbon\Carbon;

class WebhookController extends Cartalyst\Stripe\WebhookController {

    /**
     * Handles a successful payment.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeSucceeded($payload)
    {
        $charge = $this-&gt;handlePayment($payload);

        // apply your own logic here if required

        return $this-&gt;sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles a failed payment.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeFailed($payload)
    {
        $charge = $this-&gt;handlePayment($payload);

        // apply your own logic here if required

        return $this-&gt;sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles a payment refund.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeRefunded($payload)
    {
        $charge = $this-&gt;handlePayment($payload);

        // apply your own logic here if required

        return $this-&gt;sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles the payment event.
     *
     * @param  array  $charge
     * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
     */
    protected function handlePayment($charge)
    {
        $entity = $this-&gt;getBillable($charge['customer']);

        $entity-&gt;charge()-&gt;syncWithStripe();

        return $entity-&gt;charges()-&gt;whereStripeId($charge['id'])-&gt;first();
    }

}
</code></pre>

<blockquote>
<p><strong>Note 1:</strong> The examples above are merely for demonstration, you can apply your own logic for each event notification, we're just showing the power of the synchronization methods the Stripe package has to offer :)</p>

<p><strong>Note 2:</strong> Please refer to the list below for all the events that Stripe sends and to know which controller method name you need to use.</p>
</blockquote>

<h4>Types of Events</h4>

<table>
<thead>
<tr>
<th>Stripe Event Name</th>
<th>Controller Method Name</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td>account.updated</td>
<td>handleAccountUpdated</td>
<td>Occurs whenever an account status or property has changed.</td>
</tr>
<tr>
<td>account.application.deauthorized</td>
<td>handleAccountApplicationDeauthorized</td>
<td>Occurs whenever a user deauthorizes an application. Sent to the related application only.</td>
</tr>
<tr>
<td>application_fee.created</td>
<td>handleApplicationFeeCreated</td>
<td>Occurs whenever an application fee is created on a charge.</td>
</tr>
<tr>
<td>application_fee.refunded</td>
<td>handleBalanceAvailable</td>
<td>Occurs whenever your Stripe balance has been updated (e.g. when a charge collected is available to be paid out). By default, Stripe will automatically transfer any funds in your balance to your bank account on a daily basis.</td>
</tr>
<tr>
<td>charge.succeeded</td>
<td>handleChargeSucceeded</td>
<td>Occurs whenever a new charge is created and is successful.</td>
</tr>
<tr>
<td>charge.failed</td>
<td>handleChargeFailed</td>
<td>Occurs whenever a failed charge attempt occurs.</td>
</tr>
<tr>
<td>charge.refunded</td>
<td>handleChargeRefunded</td>
<td>Occurs whenever a charge is refunded, including partial refunds.</td>
</tr>
<tr>
<td>charge.captured</td>
<td>handleChargeCaptured</td>
<td>Occurs whenever a previously uncaptured charge is captured.</td>
</tr>
<tr>
<td>charge.updated</td>
<td>handleChargeUpdated</td>
<td>Occurs whenever a charge description or metadata is updated.</td>
</tr>
<tr>
<td>charge.dispute.created</td>
<td>handleChargeDisputeCreated</td>
<td>Occurs whenever a customer disputes a charge with their bank (chargeback).</td>
</tr>
<tr>
<td>charge.dispute.updated</td>
<td>handleChargeDisputeUpdated</td>
<td>Occurs when the dispute is updated (usually with evidence).</td>
</tr>
<tr>
<td>charge.dispute.closed</td>
<td>handleChargeDisputeClosed</td>
<td>Occurs when the dispute is resolved and the dispute status changes to won or lost.</td>
</tr>
<tr>
<td>customer.created</td>
<td>handleCustomerCreated</td>
<td>Occurs whenever a new customer is created.</td>
</tr>
<tr>
<td>customer.updated</td>
<td>handleCustomerUpdated</td>
<td>Occurs whenever any property of a customer changes.</td>
</tr>
<tr>
<td>customer.deleted</td>
<td>handleCustomerDeleted</td>
<td>Occurs whenever a customer is deleted.</td>
</tr>
<tr>
<td>customer.card.created</td>
<td>handleCustomerCardCreated</td>
<td>Occurs whenever a new card is created for the customer.</td>
</tr>
<tr>
<td>customer.card.updated</td>
<td>handleCustomerCardUpdated</td>
<td>Occurs whenever a card's details are changed.</td>
</tr>
<tr>
<td>customer.card.deleted</td>
<td>handleCustomerCardDeleted</td>
<td>Occurs whenever a card is removed from a customer.</td>
</tr>
<tr>
<td>customer.subscription.created</td>
<td>handleCustomerSubscriptionCreated</td>
<td>Occurs whenever a customer with no subscription is signed up for a plan.</td>
</tr>
<tr>
<td>customer.subscription.updated</td>
<td>handleCustomerSubscriptionUpdated</td>
<td>Occurs whenever a subscription changes. Examples would include switching from one plan to another, or switching status from trial to active.</td>
</tr>
<tr>
<td>customer.subscription.deleted</td>
<td>handleCustomerSubscriptionDeleted</td>
<td>Occurs whenever a customer ends their subscription.</td>
</tr>
<tr>
<td>customer.subscription.trial<em>will</em>end</td>
<td>handleCustomerSubscriptionTrialWillEnd</td>
<td>Occurs three days before the trial period of a subscription is scheduled to end.</td>
</tr>
<tr>
<td>customer.discount.created</td>
<td>handleCustomerDiscountCreated</td>
<td>Occurs whenever a coupon is attached to a customer.</td>
</tr>
<tr>
<td>customer.discount.updated</td>
<td>handleCustomerDiscountUpdated</td>
<td>Occurs whenever a customer is switched from one coupon to another.</td>
</tr>
<tr>
<td>customer.discount.deleted</td>
<td>handleCustomerDiscountDeleted</td>
<td>Occurs whenever a customer's discount is removed.</td>
</tr>
<tr>
<td>invoice.created</td>
<td>handleInvoiceCreated</td>
<td>Occurs whenever a new invoice is created. If you are using webhooks, Stripe will wait one hour after they have all succeeded to attempt to pay the invoice; the only exception here is on the first invoice, which gets created and paid immediately when you subscribe a customer to a plan. If your webhooks do not all respond successfully, Stripe will continue retrying the webhooks every hour and will not attempt to pay the invoice. After 3 days, Stripe will attempt to pay the invoice regardless of whether or not your webhooks have succeeded. See how to respond to a webhook.</td>
</tr>
<tr>
<td>invoice.updated</td>
<td>handleInvoiceUpdated</td>
<td>Occurs whenever an invoice changes (for example, the amount could change).</td>
</tr>
<tr>
<td>invoice.payment_succeeded</td>
<td>handleInvoicePaymentSucceeded</td>
<td>Occurs whenever an invoice attempts to be paid, and the payment succeeds.</td>
</tr>
<tr>
<td>invoice.payment_failed</td>
<td>handleInvoicePaymentFailed</td>
<td>Occurs whenever an invoice attempts to be paid, and the payment fails. This can occur either due to a declined payment, or because the customer has no active card. A particular case of note is that if a customer with no active card reaches the end of its free trial, an invoice.payment_failed notification will occur.</td>
</tr>
<tr>
<td>invoiceitem.created</td>
<td>handleInvoiceitemCreated</td>
<td>Occurs whenever an invoice item is created.</td>
</tr>
<tr>
<td>invoiceitem.updated</td>
<td>handleInvoiceitemUpdated</td>
<td>Occurs whenever an invoice item is updated.</td>
</tr>
<tr>
<td>invoiceitem.deleted</td>
<td>handleInvoiceitemDeleted</td>
<td>Occurs whenever an invoice item is deleted.</td>
</tr>
<tr>
<td>plan.created</td>
<td>handlePlanCreated</td>
<td>Occurs whenever a plan is created.</td>
</tr>
<tr>
<td>plan.updated</td>
<td>handlePlanUpdated</td>
<td>Occurs whenever a plan is updated.</td>
</tr>
<tr>
<td>plan.deleted</td>
<td>handlePlanDeleted</td>
<td>Occurs whenever a plan is deleted.</td>
</tr>
<tr>
<td>coupon.created</td>
<td>handleCouponCreated</td>
<td>Occurs whenever a coupon is created.</td>
</tr>
<tr>
<td>coupon.deleted</td>
<td>handleCouponDeleted</td>
<td>Occurs whenever a coupon is deleted.</td>
</tr>
<tr>
<td>transfer.created</td>
<td>handleTransferCreated</td>
<td>Occurs whenever a new transfer is created.</td>
</tr>
<tr>
<td>transfer.updated</td>
<td>handleTransferUpdated</td>
<td>Occurs whenever the description or metadata of a transfer is updated.</td>
</tr>
<tr>
<td>transfer.paid</td>
<td>handleTransferPaid</td>
<td>Occurs whenever a sent transfer is expected to be available in the destination bank account. If the transfer failed, a transfer.failed webhook will additionally be sent at a later time.</td>
</tr>
<tr>
<td>transfer.failed</td>
<td>handleTransferFailed</td>
<td>Occurs whenever Stripe attempts to send a transfer and that transfer fails.</td>
</tr>
</tbody>
</table>