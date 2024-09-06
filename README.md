# fileuploader

## Installation

You can install the package via Composer. If you're using the `dev-main` branch, you can require it like this:

```bash
composer require gpit/fileuploader:dev-main
```

## Basic Usage Example

```php
use gpit\fileuploader\FileUploader;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Upload a profile image.
     *
     * @param \Illuminate\Http\Request $req
     * @return array
     */
    public function profileImg(Request $req)
    {
        // Optional custom path
        $customPath = 'profile/images/';
        
        // Use FileUploader with the custom path
        $result = FileUploader::uploadFile($req, $customPath);

        if ($result[0]) {
            return ['success' => true, 'path' => $result['path']];
        } else {
            return ['success' => false, 'error' => $result['error']];
        }
    }
}

```

## Request Example

### Example Request Payload:

```json
{
    "name": "avatar.png",
    "file": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA..."
}
```

## Default Path

If no custom path is provided, the default upload path is files/. You can override this by passing a second argument to the uploadFile method:

```php
    $customPath = 'profile/images';
    FileUploader::uploadFile($request, $customPath); // Files will be uploaded to 'profile/images/'
```

If you don't pass the custom path, files will be stored in the files/ directory by default:

```php
    FileUploader::uploadFile($request); // Files will be uploaded to 'files/'
```

## Return Values

The uploadFile method returns an array with either the success status and path, or an error message in case of failure.

### On Success:

```php
    [true, 'path' => 'profile/images/avatar.png']
```

### On Failure:

```php
    [false, 'error' => 'Error message here']
```
