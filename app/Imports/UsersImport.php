<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $email = $row['email'] ?? $row['Email'] ?? null;
                $name = $row['name'] ?? $row['Name'] ?? null;
                $role = $row['role'] ?? $row['Role'] ?? 'user';
                $password = $row['password'] ?? $row['Password'] ?? 'password123';

                if (!$email || !$name) {
                    $this->errors[] = "Baris dengan data tidak lengkap di-skip: " . json_encode($row);
                    continue;
                }

                $existingUser = User::where('email', $email)->first();

                if ($existingUser) {
                    $existingUser->update([
                        'name' => $name,
                        'role' => $role,
                    ]);
                } else {
                    User::create([
                        'name'     => $name,
                        'email'    => $email,
                        'password' => Hash::make($password),
                        'role'     => $role,
                    ]);
                }
            } catch (\Exception $e) {
                $this->errors[] = "Error pada baris: " . json_encode($row) . " - " . $e->getMessage();
                continue;
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.email' => 'required|email',
            '*.name' => 'required|string|max:255',
            '*.role' => 'nullable|in:admin,user',
            '*.password' => 'nullable|string|min:6',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.email.required' => 'Email wajib diisi',
            '*.email.email' => 'Format email tidak valid',
            '*.name.required' => 'Nama wajib diisi',
            '*.role.in' => 'Role harus admin atau user',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
