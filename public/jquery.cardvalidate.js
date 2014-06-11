;(function($, window, document, undefined) {

	'use strict';

	/**
	 * Default settings
	 *
	 * @var array
	 */
	var defaults = {
		errorClass : 'text-danger',
		errorElement : null,
		tokenInputName : 'stripeToken',
	};

	function CardValidate(form, options) {

		// Extend the default options with the provided options
		this.opt = $.extend({}, defaults, options);

		// Cache the form selector
		this.$form = form;

		// Initialize Card Validator
		this.initializer();
	}

	CardValidate.prototype = {

		initializer : function()
		{
			var self = this;
		},

		validate : function()
		{
			var self = this;

			// Hide all the other errors
			var cardErrors = self.$form.find(self.opt.errorElement).addClass(self.opt.errorClass).text('');

			// Disable the submit button to prevent repeated clicks
			self.disableButton();

			// Process the card
			Stripe.createToken(self.$form, function(status, response)
			{
				// Card is invalid
				if (response.error)
				{
					// All the valid error codes
					var errorCodes = [
						// Card codes
						'card_declined', 'incorrect_number', 'invalid_number',

						// CVC Codes
						'incorrect_cvc', 'invalid_cvc',

						// Expired codes
						'invalid_expiry_month', 'invalid_expiry_year',

						// General codes
						'incorrect_zip', 'processing_error',
					];

					// See if the error code is valid
					if ($.inArray(response.error.code, errorCodes) >= 0)
					{
						cardErrors.text(response.error.message);
					}
					else
					{
						cardErrors.text('There was a problem validating your card.');
					}

					// Enable the subscribe button
					self.enableButton();
				}

				// Card is valid
				else if (status === 200 && response.used)
				{
					cardErrors.text('The token is invalid, or has already been used!');

					// Enable the subscribe button
					self.disableButton();
				}
				else
				{
					// Prepare the hidden input
					var input = $('<input type="hidden" name="' + self.opt.tokenInputName + '" />');

					// Insert the token into the form so it gets submitted to the server
					self.$form.append(input.val(response.id));

					// Submit the form
					self.$form.get(0).submit();
				}
			});
		},

		enableButton : function()
		{
			this.$form.find(':submit').prop('disabled', false);
		},

		disableButton : function()
		{
			this.$form.find(':submit').prop('disabled', true);
		}

	};

	$.CardValidate = function(form, options) {

		return new CardValidate(form, options);

	};

})(jQuery, window, document);
