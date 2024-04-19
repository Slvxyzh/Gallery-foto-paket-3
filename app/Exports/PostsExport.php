<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PostsExport implements FromCollection, WithHeadings, WithEvents
{
    protected $posts;

    public function __construct(Collection $posts)
    {
        $this->posts = $posts;
    }

    public function collection()
    {
        return $this->posts;
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama',
            'Cover',
            'Album',
            'Tanggal Dibuat',
            'Like',
            'Komentar'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menentukan kolom untuk gambar
                $column = 'C';

                // Menentukan ukuran kolom
                $event->sheet->getColumnDimension($column)->setWidth(25); // Atur lebar kolom

                // Mendapatkan index baris mulai untuk menyisipkan gambar
                $startRow = 2;

                // Menyisipkan gambar ke dalam setiap baris
                foreach ($this->posts as $key => $post) {
                    // Memeriksa apakah properti 'cover' tersedia dalam elemen array
                    if (isset($post['cover'])) {
                        $event->sheet->getRowDimension($startRow + $key)->setRowHeight(100); // Atur tinggi baris
                        // Ganti path gambar sesuai dengan struktur data Anda
                        $imagePath = public_path('images/' . $post['cover']); // Path gambar

                        // Memastikan path gambar benar
                        if (file_exists($imagePath)) {
                            // Memasukkan gambar ke dalam file Excel
                            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                            $drawing->setPath($imagePath);
                            $drawing->setCoordinates($column . ($startRow + $key)); // Kolom dan baris untuk gambar
                            $drawing->setWidth(100); // Mengatur lebar gambar
                            $drawing->setHeight(100); // Mengatur tinggi gambar
                            $drawing->setWorksheet($event->sheet->getDelegate());
                        }
                    }
                }
            }
        ];
    }
}
