<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'subtitle', 'cover_image', 'publication_year', 'publisher_id', 'theme_id', 'isbn', 'quantity', 'number_of_pages', 'cutter_code', 'description', 'authors'])]

class Book extends Model
{
    //
    use HasFactory;

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    protected $appends = ['cover_url'];
    
    // ... seu $fillable e métodos de relacionamento ...

    // 2. Crie o Accessor
    protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->cover_image) {
                    return null;
                }
                
                return asset('storage/' . $this->cover_image);
            }
        );
    }
}
