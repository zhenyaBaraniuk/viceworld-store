<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaResource;
use App\Models\Media;
use App\Models\MediaFolder;
use App\Traits\MediaBrowser;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileManager extends Page
{
    use MediaBrowser;

    protected static string $resource = MediaResource::class;

    protected string $view = 'filament.resources.media.pages.file-manager';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newFolder')
                ->schema([
                    TextInput::make('name')->required(),
                ])
                ->action(fn (array $data) => $this->createFolder($data['name'])),

            Action::make('upload')
                ->schema([
                    FileUpload::make('files')
                        ->multiple()
                        ->acceptedFileTypes(['video/*', 'image/*'])
                        ->disk('public')
                        ->directory('media')
                        ->storeFileNamesIn('original_names')
                        ->moveFiles(),
                ])
                ->action(fn (array $data) => $this->uploadFile($data)),

            Action::make('delete')
                ->requiresConfirmation()
                ->modalHeading('Delete file')
                ->modalDescription('Are you sure you want to delete this file?')
                ->color('danger')
                ->modalSubmitActionLabel('Delete')
                ->action(function (): void {
                    if ($this->selectedFolderId) {
                        $this->deleteFolder($this->selectedFolderId);
                    } elseif ($this->selectedFileId) {
                        $this->deleteFile($this->selectedFileId);
                    }
                }),
        ];
    }

    public function createFolder(string $name): void
    {
        MediaFolder::query()->create([
            'name' => $name,
            'parent_id' => $this->currentFolderId,
        ]);
    }

    public function uploadFile(array $data)
    {
        foreach ($data['files'] as $filepath) {
            $disk = Storage::disk('public');
            $originalName = $data['original_names'][$filepath];

            Media::query()->create([
                'folder_id' => $this->currentFolderId,
                'collection_name' => 'default',
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name' => $filepath,
                'mime_type' => $disk->mimeType($filepath),
                'size' => $disk->size($filepath),
                'disk' => 'public',
                'conversions_disk' => config('filesystems.default'),
                'model_type' => null,
                'model_id' => null,
                'manipulations' => [],
                'custom_properties' => [],
                'generated_conversions' => [],
                'responsive_images' => [],
            ]);
        }
    }

    public function renameFile(string $id, string $name): void
    {
        if (blank($name)) {
            Notification::make()
                ->title('File name cannot be empty')
                ->danger()
                ->send();

            return;
        }

        if (strlen($name) > 255) {
            Notification::make()
                ->title('File name is too long')
                ->danger()
                ->send();

            return;
        }

        $file = Media::query()->findOrFail($id);

        $file->update([
            'name' => $name,
        ]);

        Notification::make()
            ->title('File name successfully renamed')
            ->success()
            ->send();
    }

    public function deleteFile(string $id)
    {
        $file = Media::query()->findOrFail($id);

        Storage::disk($file->disk)->delete($file->file_name);
        DB::table('media')->where('id', '=', $id)->delete();

        Notification::make()
            ->title('File successfully deleted')
            ->success()
            ->send();
    }

    public function deleteFolder(string $id)
    {
        $this->deleteFolderRecursive($id);

        Notification::make()
            ->title('Folder successfully deleted')
            ->success()
            ->send();
    }

    public function downloadFile(string $id): ?StreamedResponse
    {
        $file = Media::query()->find($id);

        if (! $file) {
            Notification::make()
                ->title('File not found')
                ->danger()
                ->send();

            return null;
        }

        return Storage::disk($file->disk)->download($file->file_name, $file->name);
    }

    private function deleteFolderRecursive(string $id): void
    {
        $folder = MediaFolder::with(['media', 'children'])->findOrFail($id);

        foreach ($folder->media as $media) {
            $this->deleteFile($media->id);
        }

        foreach ($folder->children as $child) {
            $this->deleteFolderRecursive($child->id);
        }

        DB::table('media_folders')->where('id', '=', $id)->delete();
    }
}
