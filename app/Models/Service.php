<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'special_information', 'service_category_id', 'address', 'is_published', 'price'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function medias()
    {
        return $this->hasMany(ServiceMedia::class)->withTrashed();
    }

    public function logs()
    {
        return $this->hasMany(ServiceLog::class);
    }

    // Static search function
    public static function search($query)
    {
        return self::with(['category', 'medias']) // Eager load related models
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('special_information', 'LIKE', "%{$query}%")
            ->orWhere('price', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('medias', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            });
    }

    // Scope untuk pencarian dengan fleksibilitas kata kunci status publikasi
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('special_information', 'like', "%{$keyword}%")
                    ->orWhere('price', 'like', "%{$keyword}%")
                    // Menambahkan kondisi pencarian untuk status publikasi
                    ->orWhere(function ($q2) use ($keyword) {
                        // Pencarian untuk "Dipublikasikan" (case-insensitive)
                        if (
                            stripos($keyword, 'dipublikasikan') !== false ||
                            stripos($keyword, 'publik') !== false ||
                            stripos($keyword, 'dipub') !== false ||
                            stripos($keyword, 'publis') !== false ||
                            stripos($keyword, 'publikasi') !== false
                        ) {
                            $q2->where('is_published', 1);
                        }
                        // Pencarian untuk "Belum Dipublikasikan" (case-insensitive)
                        elseif (
                            stripos($keyword, 'belum') !== false ||
                            stripos($keyword, 'belum dipublikasi') !== false ||
                            stripos($keyword, 'tidak dipub') !== false ||
                            stripos($keyword, 'belum dipub') !== false ||
                            stripos($keyword, 'belum dip') !== false ||
                            stripos($keyword, 'tidak publikasi') !== false
                        ) {
                            $q2->where('is_published', 0);
                        }
                    });
            });
        }
        return $query;
    }

}
