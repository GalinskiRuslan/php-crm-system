<?

namespace App\Actions;

use Illuminate\Support\Facades\Storage;



class StorageOperations
{
    public function saveFile($file, $directory, $name = null)
    {
        $path = $file->store($directory, 'public');
    }
}
