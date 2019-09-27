#### Create a file

To upload a file to Stripe, you’ll need to send a request of type `multipart/form-data`.

The request should contain the file you would like to upload, as well as the parameters for creating a file.

##### Arguments

<table>
    <thead>
        <th>Key</th>
        <th>Required</th>
        <th>Type</th>
        <th>Default</th>
        <th>Description</th>
    </thead>
    <tbody>
        <tr>
            <td>$file</td>
            <td>require</td>
            <td>string</td>
            <td>null</td>
            <td>The file to upload. This is the path to a file on your local storage.</td>
        </tr>
        <tr>
            <td>$purpose</td>
            <td>require</td>
            <td>string</td>
            <td>null</td>
            <td>The purpose of the uploaded file. Possible values are `business_icon`, `business_logo`, `customer_signature`, `dispute_evidence`, `identity_document`, `pci_document`, or `tax_document_user_upload.</td>
        </tr>
        <tr>
            <td>file_link_data</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Optional parameters to automatically create a file link for the newly created file.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$filePath = realpath(__DIR__.'/../files/verify-account.jpg');

$purpose = 'identity_document';

$file = $stripe->files()->create($filePath, $purpose);

echo $file['id'];
```
