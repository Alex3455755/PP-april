<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение
    protected $fillable = [
        'name',
        'rate',
        'type'
    ];

    // Отношение к заявкам (один колледж может быть во многих заявках)
    public function requests()
    {
        return $this->hasMany(Request::class, 'college_id');
    }

    // Скоуп для фильтрации только ВУЗов
    public function scopeUniversities($query)
    {
        return $query->where('type', 'ВУЗ');
    }

    // Скоуп для фильтрации только колледжей (СПО)
    public function scopeColleges($query)
    {
        return $query->where('type', 'СПО');
    }

    // Аксессор для получения типа на русском
    public function getTypeTextAttribute(): string
    {
        return $this->type === 'ВУЗ' ? 'Высшее учебное заведение' : 'Среднее профессиональное образование';
    }

    // Аксессор для форматированного рейтинга
    public function getFormattedRateAttribute(): string
    {
        if (!$this->rate) {
            return 'Нет в рейтинге';
        }
        return $this->rate . ' место';
    }
}