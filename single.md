<h1>Introduction</h1>

<p>A comprehensive billing package for Stripe.</p>

<p>The package requires PHP 5.4+ and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested.</p>

<p>Have a <a href="#installation">read through the Installation Guide</a> and on how to <a href="#laravel-4">Integrate it with Laravel 4</a>.</p>

<h3>Quick Example</h3>

<p>..</p><h1>Installation</h1>

<p>The best and easiest way to install the Stripe package is with <a href="http://getcomposer.org">Composer</a>.</p>

<blockquote>
<p><strong>Note:</strong> You will need to have an active Cartalyst subscription to install the package!</p>
</blockquote>

<h2>Preparation</h2>

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

<blockquote>
<p><strong>Note:</strong> Make sure that after the required changes your <code>composer.json</code> file is valid by running <code>composer validate</code>.</p>
</blockquote>

<h2>Install the dependencies</h2>

<p>Run Composer to install or update the new requirement.</p>

<pre><code>php composer install
</code></pre>

<p>or</p>

<pre><code>php composer update
</code></pre>

<p>Now you are able to require the <code>vendor/autoload.php</code> file to autoload the package.</p><h1>Integration</h1>

<h2>Laravel 4</h2>

<h3>Migrations</h3>

<p>Just run the following command</p>

<pre class="prettyprint lang-php"><code>php artisan migrate --package=cartalyst/stripe
</code></pre>

<h3>Model setup</h3>

<p>Add the BillableTrait to your model:</p>

<pre class="prettyprint lang-php"><code>use Cartalyst\Stripe\BillableTrait;
use Cartalyst\Stripe\BillableInterface;

class User extends Eloquent implements BillableInterface {

    use BillableTrait;

}
</code></pre>

<h3>Set the Stripe Key</h3>

<p>First and recommended option is to add the stripe key into the <code>app/config/services.php</code> file, just follow the example</p>

<pre class="prettyprint lang-php"><code>&lt;?php

return [

    'stripe' =&gt; [
        'secret' =&gt; 'your-stripe-key-here',
    ],

];
</code></pre>

<blockquote>
<p><strong>Note:</strong> If you don't have this file, just create it.</p>
</blockquote>

<p>Second option is to use the model and setup your Stripe key:</p>

<pre class="prettyprint lang-php"><code>User::setStripeKey('your-stripe-key');
</code></pre><h1>Usage</h1>

<p>In this section we'll show how you can use the Stripe package with your model.</p>

<p>We'll use a User model for the following examples.</p>

<h3>Apply a coupon to the user</h3>

<pre class="prettyprint lang-php"><code>$coupon = Input::get('coupon');

$user = User::find(1);

$user-&gt;applyCoupon($coupon);
</code></pre>

<h3>Update the user Default Credit Card</h3>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user-&gt;updateDefaultCard($token);
</code></pre>

<h3>Check if the user has any active subscription</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ($user-&gt;isSubscribed())
{
    //
}
</code></pre>

<h3>Check if the user has any active credit card</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

if ($user-&gt;hasActiveCard())
{
    //
}
</code></pre><h2>Credit Cards</h2>

<h3>Listing the attached cards</h3>

<p>Listing the attached cards from an user is very easy.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$cards = $user-&gt;cards;
</code></pre>

<h3>Attaching credit cards</h3>

<p>Attach a new credit card to the user.</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;card()
    -&gt;create($token);
</code></pre>

<p>Attach a new credit card to the user and make it the default credit card.</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;card()
    -&gt;makeDefault()
    -&gt;create($token);
</code></pre>

<h3>Updating credit cards</h3>

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

<h3>Deleting credit cards</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;card(10)
    -&gt;delete();
</code></pre>

<h3>Sync data from Stripe</h3>

<p>Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;card()
    -&gt;syncWithStripe();
</code></pre>

<blockquote>
<p><strong>Note:</strong> You can pass a card id <code>integer</code> or a <code>Cartalyst\Stripe\Card\IlluminateCard</code> object through the <code>card()</code> method.</p>
</blockquote><h2>Charges</h2>

<h3>Listing the charges</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$charges = $user-&gt;charges;
</code></pre>

<h3>Creating charges</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$amount = 150.95;

$user
    -&gt;charge()
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

<p>Capturing a charge.</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;charge(10)
    -&gt;capture();
</code></pre>

<h3>Refund charges</h3>

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

<blockquote>
<p><strong>Note:</strong> You can pass a charge id <code>integer</code> or a <code>Cartalyst\Stripe\Charge\IlluminateCharge</code> object through the <code>charge()</code> method.</p>
</blockquote><h2>Subscriptions</h2>

<h3>List all the user subscriptions</h3>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscriptions = $user-&gt;subscriptions;
</code></pre>

<h3>Creating subscriptions</h3>

<p>Subscribing a user to a plan</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;create($token);
</code></pre>

<p>Subscribing a user to a plan and apply a coupon to this new subscription</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$coupon = Input::get('coupon');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;withCoupon($coupon)
    -&gt;create($token);
</code></pre>

<p>Create a trial subscription</p>

<pre class="prettyprint lang-php"><code>$token = Input::get('stripeToken');

$user = User::find(1);

$user
    -&gt;subscription()
    -&gt;onPlan('monthly')
    -&gt;trialFor(Carbon::now()-&gt;addDays(14))
    -&gt;create($token);
</code></pre>

<h3>Cancelling subscriptions</h3>

<p>Cancel a Subscription using its <code>id</code></p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
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
    -&gt;subscription(3)
    -&gt;cancelAtEndOfPeriod();
</code></pre>

<h3>Updating subscriptions</h3>

<p>Apply a trial period on a subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;setTrialPeriod(Carbon::now()-&gt;addDays(14))
</code></pre>

<p>Removing the trial period from a subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;removeTrialPeriod()
</code></pre>

<p>Apply a coupon to an existing subscription</p>

<pre class="prettyprint lang-php"><code>$coupon = Input::get('coupon');

$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;applyCoupon($coupon);
</code></pre>

<p>Remove a coupon from an existing subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;removeCoupon();
</code></pre>

<h3>Resuming subscriptions</h3>

<p>Resume a canceled subscription</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;resume();
</code></pre>

<p>Resume a canceled subscription and remove its trial period</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;skipTrial()
    -&gt;resume();
</code></pre>

<p>Resume a canceled subscription and change its trial period end date</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$user
    -&gt;subscription(3)
    -&gt;trialFor(Carbon::now()-&gt;addDays(14))
    -&gt;resume()
</code></pre>

<h3>Checking a Subscription Status</h3>

<p>First, we need to grab the subscription:</p>

<pre class="prettyprint lang-php"><code>$user = User::find(1);

$subscription = $user-&gt;subscriptions-&gt;find(3);
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

<blockquote>
<p><strong>Note:</strong> You can pass a subscription id <code>integer</code> or a <code>Cartalyst\Stripe\Subscription\IlluminateSubscription</code> object through the <code>subscription()</code> method.</p>
</blockquote>