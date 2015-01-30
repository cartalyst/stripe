## Installation

Cartalyst packages utilize [Composer](http://getcomposer.org), for more information on how to install Composer please read the [Composer Documentation](https://getcomposer.org/doc/00-intro.md).

### Preparation

Open your `composer.json` file and add the following to the `require` array:

	"cartalyst/stripe": "0.2.*@dev"
	
> **Note:** This version is still under development and it's not tagged, use carefully!

Add the following lines after the `require` array on your `composer.json` file:

	"repositories": [
		{
			"type": "composer",
			"url": "https://packages.cartalyst.com"
		}
	]

> **Note:** Make sure that after the required changes your `composer.json` file is valid by running `composer validate`.

### Install the dependencies

Run Composer to install or update the new requirement.

	php composer install

or

	php composer update

Now you are able to require the `vendor/autoload.php` file to autoload the package.
