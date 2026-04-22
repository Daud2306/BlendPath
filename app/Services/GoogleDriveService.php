<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Exception;

class GoogleDriveService
{
    protected Drive $driveService;
    protected ?string $folderId;

    public function __construct()
    {
        $credentialsPath = storage_path(env('GOOGLE_DRIVE_CREDENTIALS_PATH', 'google-drive/credentials.json'));

        if (!file_exists($credentialsPath)) {
            throw new Exception("Google Drive credentials file not found at: {$credentialsPath}");
        }

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Drive::DRIVE_FILE);
        $this->driveService = new Drive($client);
        $this->folderId = env('GOOGLE_DRIVE_FOLDER_ID') ?: null;
    }

    public function uploadFile(string $filePath, string $fileName, string $mimeType): array
    {
        $file = new Drive\DriveFile([
            'name'    => $fileName,
            'parents' => $this->folderId ? [$this->folderId] : [],
        ]);

        $result = $this->driveService->files->create($file, [
            'data'       => file_get_contents($filePath),
            'mimeType'   => $mimeType,
            'uploadType' => 'multipart',
            'fields'     => 'id,webViewLink',
        ]);

        return [
            'file_id'       => $result->getId(),
            'web_view_link' => $result->getWebViewLink()
                ?? 'https://drive.google.com/file/d/' . $result->getId() . '/view',
        ];
    }

    public function deleteFile(string $fileId): void
    {
        $this->driveService->files->delete($fileId);
    }
}
