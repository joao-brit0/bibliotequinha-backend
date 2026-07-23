<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'subtitle', 'publication_year', 'publisher_id', 'theme_id', 'isbn', 'quantity', 'number_of_pages', 'cutter_code', 'description', 'authors'])]

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
}
