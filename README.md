Laravel Paypal
=============

Laravel Paypal is a bridge for Laravel 5 using the [PHP SDK for PayPal RESTful APIs Package](https://github.com/paypal/PayPal-PHP-SDK).This package is inspired by [https://github.com/vinkla/vimeo](https://github.com/vinkla/vimeo).

## Installation
Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require sger/laravel-paypal
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Sger\Paypal\PaypalServiceProvider::class
```

```php
'Paypal' => Sger\Paypal\Facades\Paypal::class
```

## Configuration

```bash
php artisan vendor:publish
```

This will create a `config/paypal.php` file in your app which contains two type of connection 'sandbox' and 'live'.

## Usage

In your routes.php create for example:

```php
Route::resource('payments', 'PaymentsController');
```

next in your controller in your store method add the following code:

```php
$payer = new Payer;
$payer->setPaymentMethod("paypal");

$item1 = new Item();
$item1->setName('test')
	->setCurrency('EUR')
	->setQuantity(1)
	->setPrice(10);

$itemList = new ItemList();
$itemList->setItems(array($item1));

$amount = new Amount();
$amount->setCurrency('EUR')
	->setTotal(10);

$transaction = new Transaction();
$transaction->setAmount($amount)
	->setItemList($itemList)
	->setDescription("Payment description")
	->setInvoiceNumber(uniqid());

$baseUrl = \URL::to('/');

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/execute-payment?success=true")
->setCancelUrl("$baseUrl/execute-payment?success=false");

$payment = new Payment();

$payment->setIntent("sale")
	->setPayer($payer)
	->setRedirectUrls($redirectUrls)
	->setTransactions(array($transaction));

try {
	$payment->create(\Paypal::connection('sandbox'));
} catch (\PPConnectionException $ex) {
	return  "Exception: " . $ex->getMessage() . PHP_EOL;
	exit(1);
}

$approvalUrl = $payment->getApprovalLink();
var_dump($approvalUrl);
```

## License

Laravel Paypal is licensed under [The MIT License (MIT)](LICENSE).
