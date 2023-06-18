<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UserMention extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'users';

    /**
     * @return string
     */
    public function searchable(): string
    {
        return 'users_mentions';
    }

    /**
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'value' => $this->username,
            'label' => $this->name . ' (@' . $this->username . ')'
        ];
    }
}
