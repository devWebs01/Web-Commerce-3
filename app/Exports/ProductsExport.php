<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Category ID',
            'Category Name',
            'Image URL',
            'Title',
            'Capital',
            'Price',
            'Weight',
            'Description',
        ];
    }

    public function collection()
    {
        return Product::with('category')
            ->get()
            ->map(function ($product) {
                return [
                    $product->category_id,
                    $product->category->name ?? 'N/A',
                    $product->image,
                    $product->title,
                    $product->capital,
                    $product->price,
                    $product->weight,
                    $product->description,
                ];
            });
    }
}
