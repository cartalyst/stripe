## Recipients

### Create a new recipient

Key          | Required | Type            | Default | Description
------------ | -------- | --------------- | ------- | --------------------------
name         | true     | string          | null    | The recipient's full, legal name.
type         | true     | string          | null    | Type of the recipient: either individual or corporation.
tax_id       | false    | string          | null    | The recipient's tax ID, as a string. For type individual, the full SSN; for type corporation, the full EIN.
bank_account | false    | array           | null    | A bank account to attach to the recipient.
card         | false    | string or array | null    | The card token or an array.
email        | false    | string          | null    | The recipient's email address.
description  | false    | string          | null    | An arbitrary string which you can attach to a recipient object.
metadata     | false    | array           | null    | A set of key/value pairs that you can attach to a recipient object.

```php
$recipient = Stripe::recipients()->create([
	'name' => 'John Doe',
	'type' => 'individual',
]);
```

### Update a recipient

Key          | Required | Type            | Default | Description
------------ | -------- | --------------- | ------- | --------------------------
id           | true     | string          | null    | The recipient unique identifier.
name         | false    | string          | null    | The recipient's full, legal name.
tax_id       | false    | string          | null    | The recipient's tax ID, as a string. For type individual, the full SSN; for type corporation, the full EIN.
bank_account | false    | array           | null    | A bank account to attach to the recipient.
card         | false    | string or array | null    | The card token or an array.
default_card | false    | string          | null    | ID of card to make the recipient’s new default for transfers.
email        | false    | string          | null    | The recipient's email address.
description  | false    | string          | null    | An arbitrary string which you can attach to a recipient object.
metadata     | false    | array           | null    | A set of key/value pairs that you can attach to a recipient object.

```php
$recipient = Stripe::recipients()->update([
	'id'   => 'rp_4EYRyEYthf2Doc',
	'name' => 'John Doe Inc.',
]);
```

### Delete a recipient

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The recipient unique identifier.

```php
$recipient = Stripe::recipients()->delete([
	'id' => 'rp_4EYRyEYthf2Doc',
]);
```

### Retrieve all the recipients

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.
verified       | false    | bool   | null    | Only return recipients that are verified or unverified.

```php
$recipients = Stripe::recipients()->all();

foreach ($recipients['data'] as $recipient)
{
	var_dump($recipient['id']);
}
```

### Retrieve a recipient

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The recipient unique identifier.

```php
$recipient = Stripe::recipients()->find([
	'id' => '50-PERCENT-OFF',
]);

echo $recipient['id'];
```
